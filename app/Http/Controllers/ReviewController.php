<?php

namespace App\Http\Controllers;

use App\Application\Services\Applications\ApplicationService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReviewController extends Controller
{
    public function __construct(
        private readonly ApplicationService $applicationService
    ) {}

    public function pending(): Response
    {
        return Inertia::render('Review/Pending', [
            'applications' => $this->applicationService->getPendingReview(),
        ]);
    }

    public function history(): Response
    {
        return Inertia::render('Review/History', [
            'applications' => $this->applicationService->getReviewHistory(),
        ]);
    }

    public function updateLeave(Request $request, int $id)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'rejection' => 'nullable|string',
        ]);

        $this->applicationService->updateLeaveReview(
            $id,
            $validated['status'],
            $validated['rejection'] ?? ''
        );

        return back();
    }

    public function updateOnCall(Request $request, int $id)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'rejection' => 'nullable|string',
        ]);

        $this->applicationService->updateOnCallReview(
            $id,
            $validated['status'],
            $validated['rejection'] ?? ''
        );

        return back();
    }
}
