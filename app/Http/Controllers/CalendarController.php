<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartmentSchedule;
use App\Models\LeaveApplication;
use App\Models\OnCallApplication;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function leave()
    {
        return view('calendar.leave');
    }

    public function oncall()
    {
        return view('calendar.oncall');
    }

    public function depschedule()
    {
        $events = array();
        $schedule = DepartmentSchedule::all();
        foreach($schedule as $schedule) {
            $events[] = [
                'title' => $schedule->title,
                'start' => $schedule->start_date,
                'end' => $schedule->end_date,
                'allDay' => true
            ];
        }

        return view('calendar.depschedule', ['events' => $events]);
    }

    public function storel (Request $request)
    {
        $request->validate([
            'title' => 'required | string'
        ]);

        $schedule = LeaveApplication::create([
            'title' => $request->title,
            'user_id' => $request->user_id,
            'department' => $request->department,
            'reason' => $request->reason,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return response()->json ($schedule);
    }

    public function storeo (Request $request)
    {
        $request->validate([
            'title' => 'required | string'
        ]);

        $schedule = OnCallApplication::create([
            'title' => $request->title,
            'user_id' => $request->user_id,
            'department' => $request->department,
            'reason' => $request->reason,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return response()->json ($schedule);
    }

    public function history (Request $request)
    {
        $leaves = LeaveApplication::select('id', 'title', 'department', 'start_date', 'end_date', 'reason', 'status', 'rejection')
            ->where('user_id', auth()->user()->id)
            ->get();

        $onCalls = OnCallApplication::select('id', 'title', 'department', 'start_date', 'end_date', 'reason', 'status', 'rejection')
            ->where('user_id', auth()->user()->id)
            ->get();

        $leaves = $leaves->map(function ($leave) {
            $leave['application_type'] = 'Leave';
            $leave['start_date'] = Carbon::parse($leave['start_date'])->format('d-m');
            $leave['end_date'] = Carbon::parse($leave['end_date'])->format('d-m');
            return $leave;
        });

        $onCalls = $onCalls->map(function ($onCall) {
            $onCall['application_type'] = 'On Call';
            $onCall['start_date'] = Carbon::parse($onCall['start_date'])->format('d-m');
            $onCall['end_date'] = Carbon::parse($onCall['end_date'])->format('d-m');
            return $onCall;
        });

        $applications = $leaves->concat($onCalls);

        return view('calendar.history', compact('applications'));
    }

    public function review (Request $request)
    {
        $leaves = LeaveApplication::select('id', 'start_date', 'end_date', 'reason', 'status', 'title', 'rejection')
            ->where('status', 'Pending')
            ->get();

        $onCalls = OnCallApplication::select('id', 'start_date', 'end_date', 'reason', 'status', 'title', 'rejection')
            ->where('status', 'Pending')
            ->get();

        $leaves = $leaves->map(function ($leave) {
            $leave['application_type'] = 'Leave';
            $leave['start_date'] = Carbon::parse($leave['start_date'])->format('d-m');
            $leave['end_date'] = Carbon::parse($leave['end_date'])->format('d-m');
            return $leave;
        });

        $onCalls = $onCalls->map(function ($onCall) {
            $onCall['application_type'] = 'On Call';
            $onCall['start_date'] = Carbon::parse($onCall['start_date'])->format('d-m');
            $onCall['end_date'] = Carbon::parse($onCall['end_date'])->format('d-m');
            return $onCall;
        });

        $applications = $leaves->concat($onCalls);

        return view('review', compact('applications'));
    }

    public function reviewHistory (Request $request)
    {
        $leaves = LeaveApplication::select('id', 'title', 'department', 'start_date', 'end_date', 'reason', 'status', 'rejection')
            ->where('status', '!=', 'Pending')
            ->get();

        $onCalls = OnCallApplication::select('id', 'title', 'department', 'start_date', 'end_date', 'reason', 'status', 'rejection')
            ->where('status', '!=', 'Pending')
            ->get();

        $leaves = $leaves->map(function ($leave) {
            $leave['application_type'] = 'Leave';
            $leave['start_date'] = Carbon::parse($leave['start_date'])->format('d-m');
            $leave['end_date'] = Carbon::parse($leave['end_date'])->format('d-m');
            return $leave;
        });

        $onCalls = $onCalls->map(function ($onCall) {
            $onCall['application_type'] = 'On Call';
            $onCall['start_date'] = Carbon::parse($onCall['start_date'])->format('d-m');
            $onCall['end_date'] = Carbon::parse($onCall['end_date'])->format('d-m');
            return $onCall;
        });

        $applications = $leaves->concat($onCalls);

        return view('review-history', compact('applications'));
    }

    public function updateReviewLeave (Request $request, $id)
    {
        $schedule = LeaveApplication::find($id);
        if(! $schedule) {
            return response()->json ([
                'error' => 'Unable to locate the event'
            ], 404);
        }

        $schedule->update([
            'status' => $request->status,
            'rejection' => $request->rejection,
        ]);

        return response()->json ($schedule);
    }

    public function updateReviewOnCall (Request $request, $id)
    {
        $schedule = OnCallApplication::find($id);
        if(! $schedule) {
            return response()->json ([
                'error' => 'Unable to locate the event'
            ], 404);
        }

        $schedule->update([
            'status' => $request->status,
            'rejection' => $request->rejection,
        ]);

        return response()->json ($schedule);
    }

    public function updateStatusLeave (Request $request, $id)
    {
        $schedule = LeaveApplication::find($id);
        if(! $schedule) {
            return response()->json ([
                'error' => 'Unable to locate the event'
            ], 404);
        }

        $schedule->update([
            'status' => $request->status,
        ]);

        return response()->json ($schedule);
    }
    public function updateStatusOnCall (Request $request, $id)
    {
        $schedule = OnCallApplication::find($id);
        if(! $schedule) {
            return response()->json ([
                'error' => 'Unable to locate the event'
            ], 404);
        }

        $schedule->update([
            'status' => $request->status,
        ]);

        return response()->json ($schedule);
    }
}