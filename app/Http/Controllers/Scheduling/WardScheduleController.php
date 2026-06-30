<?php

namespace App\Http\Controllers\Scheduling;

use App\Application\Services\Scheduling\WardScheduleService;
use App\Http\Controllers\Controller;
use App\Models\AssignWard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class WardScheduleController extends Controller
{
    public function __construct(
        private readonly WardScheduleService $scheduleService
    ) {}

    public function generate(): Response
    {
        $department = Auth::user()->department;
        $events = $this->scheduleService->generate($department);

        return Inertia::render('Scheduling/Ward/Editor', [
            'events' => $events,
            'generated' => true,
        ]);
    }

    public function editor(): Response
    {
        return Inertia::render('Scheduling/Ward/Editor', [
            'events' => $this->scheduleService->getEvents(Auth::user()->department),
            'generated' => false,
        ]);
    }

    public function departmentView(): Response
    {
        return Inertia::render('Scheduling/Ward/View', [
            'events' => $this->scheduleService->getEvents(),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $schedule = AssignWard::findOrFail($id);
        $schedule->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return back();
    }

    public function destroy(int $id)
    {
        AssignWard::findOrFail($id)->delete();

        return back();
    }
}
