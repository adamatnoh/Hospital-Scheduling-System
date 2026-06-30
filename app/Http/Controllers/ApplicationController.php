<?php

namespace App\Http\Controllers;

use App\Application\Services\Applications\ApplicationService;
use App\Domain\Applications\Enums\ApplicationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ApplicationController extends Controller
{
    public function __construct(
        private readonly ApplicationService $applicationService
    ) {}

    public function leaveForm(): Response
    {
        return Inertia::render('Applications/LeaveForm', [
            'user' => Auth::user(),
        ]);
    }

    public function onCallForm(): Response
    {
        return Inertia::render('Applications/OnCallForm', [
            'user' => Auth::user(),
        ]);
    }

    public function storeLeave(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'reason' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $this->applicationService->createLeave([
            ...$validated,
            'user_id' => Auth::id(),
            'department' => Auth::user()->department,
            'status' => ApplicationStatus::Pending->value,
        ]);

        return redirect()->route('calendar.history')
            ->with('success', 'Leave application submitted successfully.');
    }

    public function storeOnCall(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'reason' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $this->applicationService->createOnCall([
            ...$validated,
            'user_id' => Auth::id(),
            'department' => Auth::user()->department,
            'status' => ApplicationStatus::Pending->value,
        ]);

        return redirect()->route('calendar.history')
            ->with('success', 'On-call application submitted successfully.');
    }

    public function history(): Response
    {
        return Inertia::render('Applications/History', [
            'applications' => $this->applicationService->getUserHistory(Auth::id()),
        ]);
    }
}
