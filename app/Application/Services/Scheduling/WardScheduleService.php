<?php

namespace App\Application\Services\Scheduling;

use App\Domain\Applications\Enums\ApplicationStatus;
use App\Models\AssignWard;
use App\Models\User;
use App\Models\Wards;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class WardScheduleService
{
    public function generate(string $department): Collection
    {
        $doctors = User::query()->where('department', $department)->get();
        $wards = Wards::query()->where('department', $department)->get();

        if ($wards->isEmpty() || $doctors->isEmpty()) {
            return collect();
        }

        $approvedLeave = User::query()
            ->where('department', $department)
            ->whereHas('leaveApplications', fn ($q) => $q
                ->where('status', ApplicationStatus::Approved->value))
            ->with(['leaveApplications' => fn ($q) => $q
                ->where('status', ApplicationStatus::Approved->value)])
            ->get()
            ->flatMap(fn ($user) => $user->leaveApplications->map(fn ($leave) => [
                'name' => $user->name,
                'date' => Carbon::parse($leave->start_date)->toDateString(),
            ]));

        AssignWard::query()->where('department', $department)->delete();

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $wardIndex = 0;

        foreach ($doctors as $doctor) {
            $currentDate = $startDate->copy();

            while ($currentDate <= $endDate) {
                $onLeave = $approvedLeave->contains(fn ($leave) => $leave['name'] === $doctor->name
                    && $leave['date'] === $currentDate->toDateString());

                if ($onLeave) {
                    $currentDate->addDay();
                    continue;
                }

                $ward = $wards[$wardIndex % $wards->count()];
                $wardIndex++;
                $assignmentEndDate = $currentDate->copy()->addWeeks(2)->subDay();

                if ($assignmentEndDate > $endDate) {
                    $assignmentEndDate = $endDate->copy();
                }

                AssignWard::create([
                    'name' => $doctor->name,
                    'user_id' => $doctor->id,
                    'department' => $doctor->department,
                    'ward' => $ward->name,
                    'ward_id' => $ward->id,
                    'start_date' => $currentDate,
                    'end_date' => $assignmentEndDate,
                ]);

                $currentDate = $assignmentEndDate->copy()->addDay();
            }
        }

        return $this->getEvents($department);
    }

    public function getEvents(?string $department = null): Collection
    {
        $wardColors = [];
        $colorIndex = 1;

        return AssignWard::query()
            ->when($department, fn ($q) => $q->where('department', $department))
            ->get()
            ->map(function (AssignWard $schedule) use (&$wardColors, &$colorIndex) {
                if (! array_key_exists($schedule->ward, $wardColors)) {
                    $wardColors[$schedule->ward] = '#'.substr(md5((string) $colorIndex), 0, 6);
                    $colorIndex++;
                }

                return [
                    'id' => $schedule->id,
                    'title' => 'Dr '.$schedule->name."\n".$schedule->ward,
                    'start' => $schedule->start_date,
                    'end' => $schedule->end_date,
                    'allDay' => true,
                    'backgroundColor' => $wardColors[$schedule->ward],
                ];
            });
    }
}
