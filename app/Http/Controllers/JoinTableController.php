<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DepartmentSchedule;
use App\Models\OnCallApplication;
use App\Models\Assign;

class JoinTableController extends Controller
{ 
    public function depschedule()
    {
        $events = array();
        $userDepartment = Auth::user()->department;

        // $schedule = DepartmentSchedule::join('on_call_applications', 'department_schedules.department', '=', 'on_call_applications.department')
        //     ->select('department_schedules.title', 'department_schedules.start_date')
        //     ->union(OnCallApplication::select('title', 'start_date'))
        //     ->where('on_call_applications.status', '=', 'Yes')
        //     ->where('on_call_applications.department', '=', Auth::user()->department)
        //     ->where('department_schedules.department', '=', Auth::user()->department)
        //     ->get();

        // $onCall = DB::table('assigns')
        //     ->select('title', 'start_date', 'end_date')
        //     ->where('department', $userDepartment);
        
        // $onCall = $onCall->first(); // Fetch the first result

        $wards = DB::table('assign_wards')
            ->select('assign_wards.name', 'assign_wards.user_id', 'assign_wards.start_date', 'assign_wards.end_date', 'assign_wards.ward')
            ->where('assign_wards.department', $userDepartment);

        $onCall = DB::table('assigns')
            ->select('assigns.name', 'assigns.user_id', 'assigns.start_date', 'assigns.end_date')
            ->where('assigns.department', $userDepartment);

        $result = $wards
            ->leftJoin('assigns', function ($join) {
                $join->on('assign_wards.user_id', '=', 'assigns.user_id')
                    ->on('assign_wards.start_date', '=', 'assigns.start_date');
            })
            ->get();

        foreach($result as $item) {
            DepartmentSchedule::create([
                'title' => $item->name,
                'user_id' => $item->user_id,
                'department' => $userDepartment,
                'start_date' => $item->start_date,
                'end_date' => $item->end_date,
                'ward' => $item->ward,
                'shift' => 'On-Call',
            ]);
        }
        
        // $wards = DB::table('assign_wards')
        //     ->select('title', 'user_id', 'start_date', 'end_date', 'ward')
        //     ->where('department', $userDepartment);

        // $shift = DB::table('assign_shifts')
        //     ->select('title', 'user_id', 'start_date', 'end_date', 'shift')
        //     ->where('department', $userDepartment);
        
        // $schedule = $onCalls
        //     ->union($wards)
        //     ->union($shift)
        //     ->get();

        $schedule = DB::table('assign_wards')
        ->select('assign_wards.name', 'assign_wards.user_id', 'assign_wards.start_date', 'assign_wards.end_date', 'assign_wards.ward')
        ->leftJoin('assign_shifts', function ($join) {
            $join->on('assign_wards.user_id', '=', 'assign_shifts.user_id')
                ->on('assign_wards.start_date', '=', 'assign_shifts.start_date');
        })
        ->where('assign_wards.department', $userDepartment)
        ->get();

        foreach ($schedule as $item) {
            $shift = property_exists($item, 'shift') ? $item->shift : null;
            DepartmentSchedule::create([
                'title' => $item->name,
                'user_id' => $item->user_id,
                'department' => $userDepartment,
                'start_date' => $item->start_date,
                'end_date' => $item->end_date,
                'ward' => $item->ward,
                'shift' => $shift,
            ]);
        }
        

        $events = array();
        $onCall = DepartmentSchedule::all();
        foreach($onCall as $onCall) {
            $events[] = [
                'id' => $onCall->id,
                'title' => 'Dr ' . $onCall->name . PHP_EOL . $onCall->shift,
                'start' => $onCall->start_date,
                'end' => $onCall->end_date,
                'allDay' => true
            ];
        }

        // $onCalls = DB::table('assigns')
        //     ->select('assigns.title', 'assigns.user_id', 'assigns.start_date', 'assigns.end_date', 'assign_wards.ward')
        //     ->leftJoin('assign_wards', function ($join) {
        //         $join->on('assigns.user_id', '=', 'assign_wards.user_id')
        //             ->on('assigns.start_date', '=', 'assign_wards.start_date');
        //     })
        //     ->leftJoin('assign_shifts', function ($join) {
        //         $join->on('assigns.user_id', '=', 'assign_shifts.user_id')
        //             ->on('assigns.start_date', '=', 'assign_shifts.start_date');
        //     })
        //     ->where('assigns.department', $userDepartment)
        //     ->get();
        
        // Create DepartmentSchedule records
        // foreach ($onCalls as $onCall) {
        //     // If on-call exists, use its ward and shift
        //     if ($onCall->ward !== null) {
        //         $ward = $onCall->ward;
        //         $shift = $onCall->shift;
        //     } else {
        //         // If ward is null, search for other shifts for the same person and date
        //         $otherShift = DB::table('assign_shifts')
        //             ->select('shift')
        //             ->where('user_id', $onCall->user_id)
        //             ->where('start_date', $onCall->start_date)
        //             ->whereNotNull('shift')
        //             ->first();
                
        //         $ward = null;
        //         $shift = $otherShift ? $otherShift->shift : null;
        //     }
        
        //     DepartmentSchedule::create([
        //         'title' => $onCall->title,
        //         'user_id' => $onCall->user_id,
        //         'department' => $userDepartment,
        //         'start_date' => $onCall->start_date,
        //         'end_date' => $onCall->end_date,
        //         'ward' => $ward,
        //         'shift' => $shift,
        //     ]);
        
        //     $events[] = [
        //         'title' => 'Dr ' . $onCall->title . PHP_EOL . $shift, 
        //         'start' => $onCall->start_date,
        //         'end' => $onCall->end_date,
        //         'allDay' => true
        //     ];
        // }

        return view('calendar.depschedule', ['events' => $events]);
    }

    // public function depschedule()
    // {
    //     $events = array();
    //     $onCall = DepartmentSchedule::all();
    //     foreach($onCall as $onCall) {
    //         $events[] = [
    //             'id' => $onCall->id,
    //             'title' => 'Dr ' . $onCall->name . PHP_EOL . $onCall->shift,
    //             'start' => $onCall->start_date,
    //             'end' => $onCall->end_date,
    //             'allDay' => true
    //         ];
    //     }

    //     return view('calendar.create-shift', ['events' => $events]);
    // }

    public function yourschedule()
    {
        $events = array();
        $username = Auth::user()->name;

        $departmentSchedules = DB::table('department_schedules')
            ->select('title', 'start_date', 'end_date')
            ->where('title', $username);
        
        $onCallApplications = DB::table('on_call_applications')
            ->select('title', 'start_date', 'end_date')
            ->where('status', 'Yes')
            ->where('title', $username);
        
        $schedule = $departmentSchedules
            ->union($onCallApplications)
            ->get();

        foreach($schedule as $schedule) {
            $events[] = [
                'title' => 'Dr ' . $schedule->title, 
                'start' => $schedule->start_date,
                'end' => $schedule->end_date,
                'allDay' => true
            ];
        }

        return view('calendar.your-schedule', ['events' => $events]);
    }
}
