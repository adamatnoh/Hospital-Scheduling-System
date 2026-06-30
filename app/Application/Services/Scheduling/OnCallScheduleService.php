<?php

namespace App\Application\Services\Scheduling;

use App\Domain\Applications\Enums\ApplicationStatus;
use App\Models\Assign;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class OnCallScheduleService
{
    private const MAX_ASSIGNMENTS_PER_MONTH = 6;
    private const SCHEDULE_DAYS = 30;
    private const DOCTORS_PER_DAY = 2;

    public function generate(string $department): Collection
    {
        $leaveUserIds = User::query()
            ->whereHas('leaveApplications', fn ($q) => $q
                ->where('department', $department)
                ->where('status', ApplicationStatus::Approved->value))
            ->pluck('id');

        $onCallApplications = User::query()
            ->where('department', $department)
            ->whereHas('onCallApplications', fn ($q) => $q
                ->where('status', ApplicationStatus::Approved->value))
            ->with(['onCallApplications' => fn ($q) => $q
                ->where('status', ApplicationStatus::Approved->value)])
            ->get()
            ->flatMap(fn ($user) => $user->onCallApplications);

        $availableDoctors = User::query()
            ->where('department', $department)
            ->whereNotIn('id', $leaveUserIds)
            ->get();

        Assign::query()->where('department', $department)->delete();

        $usedDates = [];
        $onCallDates = [];

        foreach ($onCallApplications as $onCall) {
            $startDate = Carbon::parse($onCall->start_date)->startOfDay();
            $user = User::find($onCall->user_id);

            if (! $user) {
                continue;
            }

            Assign::create([
                'title' => $user->name,
                'user_id' => $user->id,
                'department' => $department,
                'start_date' => $startDate,
                'end_date' => $startDate,
            ]);

            $dateKey = $startDate->toDateString();
            $usedDates[$dateKey][] = $user->id;
            $onCallDates[] = $dateKey;
        }

        $startDate = Carbon::now()->startOfDay();
        $endDate = $startDate->copy()->addDays(self::SCHEDULE_DAYS);

        while ($startDate <= $endDate) {
            $currentDate = $startDate->toDateString();
            $doctorsNeeded = in_array($currentDate, $onCallDates, true)
                ? 1
                : self::DOCTORS_PER_DAY;

            $requestedDoctor = $onCallApplications
                ->first(fn ($app) => Carbon::parse($app->start_date)->toDateString() === $currentDate);

            $assignedDoctors = [];

            if ($requestedDoctor) {
                $assignedDoctors[] = $requestedDoctor->user_id;
            }

            $eligibleDoctors = $availableDoctors->reject(function ($doctor) use ($usedDates, $currentDate, $assignedDoctors) {
                if (in_array($doctor->id, $assignedDoctors, true)) {
                    return true;
                }

                $monthlyCount = collect($usedDates)
                    ->flatten()
                    ->filter(fn ($id) => $id === $doctor->id)
                    ->count();

                return $monthlyCount >= self::MAX_ASSIGNMENTS_PER_MONTH
                    || in_array($doctor->id, $usedDates[$currentDate] ?? [], true);
            });

            while (count($assignedDoctors) < $doctorsNeeded && $eligibleDoctors->isNotEmpty()) {
                $doctor = $eligibleDoctors->random();
                $assignedDoctors[] = $doctor->id;
                $eligibleDoctors = $eligibleDoctors->reject(fn ($d) => $d->id === $doctor->id);
            }

            foreach ($assignedDoctors as $doctorId) {
                $doctor = User::find($doctorId);
                if (! $doctor) {
                    continue;
                }

                Assign::create([
                    'title' => $doctor->name,
                    'user_id' => $doctor->id,
                    'department' => $department,
                    'start_date' => $startDate,
                    'end_date' => $startDate,
                ]);

                $usedDates[$currentDate][] = $doctorId;
            }

            $startDate->addDay();
        }

        return $this->getEvents($department);
    }

    public function getEvents(?string $department = null): Collection
    {
        return Assign::query()
            ->when($department, fn ($q) => $q->where('department', $department))
            ->get()
            ->map(fn (Assign $schedule) => [
                'id' => $schedule->id,
                'title' => 'Dr '.$schedule->title,
                'start' => $schedule->start_date,
                'end' => $schedule->end_date,
                'allDay' => true,
            ]);
    }
}
