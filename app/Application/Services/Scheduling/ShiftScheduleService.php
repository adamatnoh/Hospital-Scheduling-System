<?php

namespace App\Application\Services\Scheduling;

use App\Domain\Applications\Enums\ApplicationStatus;
use App\Domain\Scheduling\Enums\ShiftType;
use App\Models\AssignShift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ShiftScheduleService
{
    public function generate(string $department): Collection
    {
        $doctors = User::query()->where('department', $department)->get();

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

        AssignShift::query()->where('department', $department)->delete();

        $shiftCounts = array_fill_keys(
            array_map(fn (ShiftType $s) => $s->value, ShiftType::cases()),
            0
        );

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        foreach ($doctors as $doctor) {
            $currentDate = $startDate->copy();

            while ($currentDate <= $endDate) {
                $onLeave = $approvedLeave->contains(fn ($leave) => $leave['name'] === $doctor->name
                    && $leave['date'] === $currentDate->toDateString());

                if ($onLeave || ! $currentDate->isWeekday()) {
                    $currentDate->addDay();
                    continue;
                }

                $minCount = min($shiftCounts);
                $eligibleShifts = array_keys(array_filter($shiftCounts, fn ($c) => $c === $minCount));
                $shift = $eligibleShifts[array_rand($eligibleShifts)];
                $shiftCounts[$shift]++;

                AssignShift::create([
                    'name' => $doctor->name,
                    'user_id' => $doctor->id,
                    'department' => $doctor->department,
                    'shift' => $shift,
                    'start_date' => $currentDate,
                    'end_date' => $currentDate,
                ]);

                $currentDate->addDay();
            }
        }

        return $this->getEvents($department);
    }

    public function getEvents(?string $department = null): Collection
    {
        return AssignShift::query()
            ->when($department, fn ($q) => $q->where('department', $department))
            ->get()
            ->map(function (AssignShift $schedule) {
                $shiftType = ShiftType::tryFrom($schedule->shift);

                return [
                    'id' => $schedule->id,
                    'title' => 'Dr '.$schedule->name."\n".$schedule->shift,
                    'start' => $schedule->start_date,
                    'end' => $schedule->end_date,
                    'allDay' => true,
                    'backgroundColor' => $shiftType?->color() ?? '#cccccc',
                ];
            });
    }
}
