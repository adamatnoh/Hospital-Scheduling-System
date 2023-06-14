<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartmentSchedule;
use App\Models\LeaveApplication;
use App\Models\OnCallApplication;

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
}