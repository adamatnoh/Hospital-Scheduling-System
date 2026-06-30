<?php

namespace App\Application\Services\Scheduling;

use App\Models\Assign;
use App\Models\AssignShift;
use App\Models\AssignWard;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PersonalScheduleService
{
    public function getEventsForUser(?int $userId = null): Collection
    {
        $user = $userId ? \App\Models\User::find($userId) : Auth::user();

        if (! $user) {
            return collect();
        }

        $events = collect();

        Assign::query()
            ->where('user_id', $user->id)
            ->get()
            ->each(fn (Assign $schedule) => $events->push([
                'title' => 'On Call',
                'start' => $schedule->start_date,
                'end' => $schedule->end_date,
                'allDay' => true,
            ]));

        AssignWard::query()
            ->where('user_id', $user->id)
            ->get()
            ->each(fn (AssignWard $schedule) => $events->push([
                'title' => $schedule->ward,
                'start' => $schedule->start_date,
                'end' => $schedule->end_date,
                'allDay' => true,
            ]));

        AssignShift::query()
            ->where('user_id', $user->id)
            ->get()
            ->each(fn (AssignShift $schedule) => $events->push([
                'title' => $schedule->shift,
                'start' => $schedule->start_date,
                'end' => $schedule->end_date,
                'allDay' => true,
            ]));

        return $events;
    }
}
