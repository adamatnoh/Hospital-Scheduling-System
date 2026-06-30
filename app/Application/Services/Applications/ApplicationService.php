<?php

namespace App\Application\Services\Applications;

use App\Domain\Applications\Enums\ApplicationStatus;
use App\Models\LeaveApplication;
use App\Models\OnCallApplication;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ApplicationService
{
    public function createLeave(array $data): LeaveApplication
    {
        return LeaveApplication::create([
            'title' => $data['title'],
            'user_id' => $data['user_id'],
            'department' => $data['department'],
            'reason' => $data['reason'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status'] ?? ApplicationStatus::Pending->value,
            'rejection' => '',
        ]);
    }

    public function createOnCall(array $data): OnCallApplication
    {
        return OnCallApplication::create([
            'title' => $data['title'],
            'user_id' => $data['user_id'],
            'department' => $data['department'],
            'reason' => $data['reason'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status'] ?? ApplicationStatus::Pending->value,
            'rejection' => '',
        ]);
    }

    public function getUserHistory(int $userId): Collection
    {
        return $this->formatApplications(
            LeaveApplication::where('user_id', $userId)->get(),
            OnCallApplication::where('user_id', $userId)->get()
        );
    }

    public function getPendingReview(): Collection
    {
        return $this->formatApplications(
            LeaveApplication::where('status', ApplicationStatus::Pending->value)->get(),
            OnCallApplication::where('status', ApplicationStatus::Pending->value)->get()
        );
    }

    public function getReviewHistory(): Collection
    {
        return $this->formatApplications(
            LeaveApplication::where('status', '!=', ApplicationStatus::Pending->value)->get(),
            OnCallApplication::where('status', '!=', ApplicationStatus::Pending->value)->get()
        );
    }

    public function updateLeaveReview(int $id, string $status, ?string $rejection = null): LeaveApplication
    {
        $application = LeaveApplication::findOrFail($id);
        $application->update([
            'status' => $status,
            'rejection' => $rejection ?? $application->rejection,
        ]);

        return $application;
    }

    public function updateOnCallReview(int $id, string $status, ?string $rejection = null): OnCallApplication
    {
        $application = OnCallApplication::findOrFail($id);
        $application->update([
            'status' => $status,
            'rejection' => $rejection ?? $application->rejection,
        ]);

        return $application;
    }

    private function formatApplications(Collection $leaves, Collection $onCalls): Collection
    {
        $formattedLeaves = $leaves->map(function ($leave) {
            return [
                'id' => $leave->id,
                'title' => $leave->title,
                'department' => $leave->department,
                'start_date' => Carbon::parse($leave->start_date)->format('d-m'),
                'end_date' => Carbon::parse($leave->end_date)->format('d-m'),
                'reason' => $leave->reason,
                'status' => $leave->status,
                'rejection' => $leave->rejection,
                'application_type' => 'Leave',
            ];
        });

        $formattedOnCalls = $onCalls->map(function ($onCall) {
            return [
                'id' => $onCall->id,
                'title' => $onCall->title,
                'department' => $onCall->department,
                'start_date' => Carbon::parse($onCall->start_date)->format('d-m'),
                'end_date' => Carbon::parse($onCall->end_date)->format('d-m'),
                'reason' => $onCall->reason,
                'status' => $onCall->status,
                'rejection' => $onCall->rejection,
                'application_type' => 'On Call',
            ];
        });

        return $formattedLeaves->concat($formattedOnCalls)->values();
    }
}
