<?php

namespace App\Http\Controllers\Scheduling;

use App\Application\Services\Scheduling\PersonalScheduleService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PersonalScheduleController extends Controller
{
    public function __construct(
        private readonly PersonalScheduleService $scheduleService
    ) {}

    public function show(): Response
    {
        return Inertia::render('Scheduling/PersonalSchedule', [
            'events' => $this->scheduleService->getEventsForUser(Auth::id()),
        ]);
    }
}
