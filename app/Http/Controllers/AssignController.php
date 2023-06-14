<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DepartmentSchedule;
use App\Models\OnCallApplication;
use App\Models\Assign;

class AssignController extends Controller
{
    public function assign()
    {
        $userDepartment = Auth::user()->department;

        $leaveApplications = DB::table('leave_applications')
            ->select('title', 'user_id', 'department', 'start_date', 'end_date')
            ->where('status', 'No')
            ->where('department', $userDepartment)
            ->get();

        $onCallApplications = DB::table('on_call_applications')
            ->select('title', 'user_id', 'department', 'start_date', 'end_date')
            ->where('status', 'Yes')
            ->where('department', $userDepartment)
            ->get();

        $otherDoctors = DB::table('users')
            ->select('name', 'id', 'department')
            ->where('department', $userDepartment)
            ->get();

        Assign::truncate();

        $usedDates = [];

        // Create Assign records for each available doctor
        // foreach ($leaveApplications as $leave) {
        //     $startDate = $this->generateRandomDate($usedDates);
        //     $endDate = $startDate->copy();

        //     $approvedLeave = $leaveApplications->where('start_date', $startDate);
        //     if (!$approvedLeave) {
        //         Assign::create([
        //             'title' => $leave->title,
        //             'user_id' => $leave->user_id,
        //             'department' => $leave->department,
        //             'start_date' => $startDate,
        //             'end_date' => $endDate,
        //         ]);

        //         $usedDates[] = $startDate->toDateString(); // Add the used date to the array
        //     }
        // }

        // foreach ($onCallApplications as $onCall) {
        //     Assign::create([
        //         'title' => $onCall->title,
        //         'user_id' => $onCall->user_id,
        //         'department' => $onCall->department,
        //         'start_date' => $onCall->start_date,
        //         'end_date' => $onCall->end_date,
        //     ]);

        //     $usedDates[] = $startDate->toDateString(); 
        // }

        foreach ($otherDoctors as $doctor) {
            // Check if the doctor's name appears in leaveApplications
            $foundInLeave = false;
            foreach ($leaveApplications as $leave)  {
                if ($doctor->name == $leave->title) {
                    $startDate = $this->generateRandomDate($usedDates);
                    $endDate = $startDate->copy();

                    $approvedLeave = $leaveApplications->where('start_date', $startDate);
                    if (!$approvedLeave) {
                        Assign::create([
                            'title' => $leave->title,
                            'user_id' => $leave->user_id,
                            'department' => $leave->department,
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                        ]);

                        $usedDates[] = $startDate->toDateString(); // Add the used date to the array
                        $foundInLeave = true;
                        break;
                    }
                }
            }
        
            if ($foundInLeave) {
                // Skip to the next doctor if the name was found in leaveApplications
                continue;
            }
            
            // Check if the doctor's name appears in onCallApplications
            $foundInOnCall = false;
            foreach ($onCallApplications as $onCall) {
                if ($doctor->name == $onCall->title) {
                    Assign::create([
                        'title' => $onCall->title,
                        'user_id' => $onCall->user_id,
                        'department' => $onCall->department,
                        'start_date' => $onCall->start_date,
                        'end_date' => $onCall->end_date,
                    ]);
                    $usedDates[] = Carbon::parse($onCall->start_date)->toDateString();
                    $foundInOnCall = true;
                    break;
                }
            }
        
            if ($foundInOnCall) {
                // Skip to the next doctor if the name was found in onCallApplications
                continue;
            }
        
            // If the name was not found in onCallApplications, assign random dates
            $startDate = $this->generateRandomDate($usedDates);
            $endDate = $startDate->copy();
        
            Assign::create([
                'title' => $doctor->name,
                'user_id' => $doctor->id,
                'department' => $doctor->department,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
        
            $usedDates[] = $startDate->toDateString(); // Add the used date to the array
        }
        

        $events = array();
        $schedule = Assign::all();
        foreach ($schedule as $schedule) {
            $events[] = [
                'id' => $schedule->id,
                'title' => 'Dr ' . $schedule->title,
                'start' => $schedule->start_date,
                'end' => $schedule->end_date,
                'allDay' => true
            ];
        }

        return view('calendar.create-oncall', ['events' => $events]);
    }

    private function generateRandomDate($usedDates)
    {
        $date = Carbon::now()->addDays(mt_rand(1, 30));

        while (in_array($date->toDateString(), $usedDates)) {
            $date = Carbon::now()->addDays(mt_rand(1, 30));
        }

        return $date;
    }

    public function oncall()
    {
        $events = array();
        $schedule = Assign::all();
        foreach($schedule as $schedule) {
            $events[] = [
                'id' => $schedule->id,
                'title' => 'Dr ' . $schedule->title,
                'start' => $schedule->start_date,
                'end' => $schedule->end_date,
                'allDay' => true
            ];
        }

        return view('calendar.create-oncall', ['events' => $events]);
    }

    public function update(Request $request, $id)
    {
        $schedule = Assign::find($id);
        if(! $schedule) {
            return response()->json ([
                'error' => 'Unable to locate the event'
            ], 404);
        }
        $schedule->update ([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        return response()->json ('Event updated');
    }

    public function delete(Request $request, $id)
    {
        $schedule = Assign::find($id);
        if(! $schedule) {
            return response()->json ([
                'error' => 'Unable to locate the event'
            ], 404);
        }
        $schedule->delete();
        return $id;
    }
}