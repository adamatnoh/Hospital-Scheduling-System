<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DepartmentSchedule;
use App\Models\OnCallApplication;
use App\Models\Assign;
use App\Models\AssignWard;
use App\Models\Ward;

class WardController extends Controller
{
    public function assignWard()
    {
        $userDepartment = Auth::user()->department;

        $leaveApplications = DB::table('leave_applications')
            ->select('title', 'user_id', 'department', 'start_date', 'end_date', 'status')
            ->where('department', $userDepartment)
            ->get();

        $doctors = DB::table('users')
            ->select('name', 'id', 'department')
            ->where('department', $userDepartment)
            ->get();

        $wardLists = DB::table('wards')
            ->select('id', 'name', 'department')
            ->where('department', $userDepartment)
            ->get();

        // $doctors = DB::table('assigns')
        //     ->select('title', 'user_id', 'department', 'start_date', 'end_date')
        //     ->where('department', $userDepartment)
        //     ->get();

        AssignWard::truncate();

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $usedDates = [];

        foreach ($doctors as $doctor) {
            $currentDate = $startDate->copy();
        
            while ($currentDate <= $endDate) {
                // Check if the doctor's name appears in leaveApplications
                $foundInLeave = false;
                foreach ($leaveApplications as $leave) {
                    if ($leave->status == 'Yes' && $leave->start_date == $currentDate && $doctor->name == $leave->title) {
                        $foundInLeave = true;
                        break;
                    }
                }
        
                if ($foundInLeave) {
                    // Skip to the next day if the doctor's name was found in leaveApplications with status 'Yes'
                    $currentDate->addDay();
                    continue;
                }
        
                // If the doctor's name was not found in leaveApplications with status 'Yes', assign a random shift
                if ($currentDate->isWeekday()) {
                    $rand = mt_rand(0, count($wardLists) - 1);
        
                    AssignWard::create([
                        'name' => $doctor->name,
                        'user_id' => $doctor->id,
                        'department' => $doctor->department,
                        'ward' => $wardLists[$rand]->name,
                        'ward_id' => $wardLists[$rand]->id,
                        'start_date' => $currentDate,
                        'end_date' => $currentDate,
                    ]);
        
                    $usedDates[] = $currentDate->toDateString(); // Add the used date to the array
                }
        
                $currentDate->addDay();
            }
        }

        $events = array();
        $schedule = AssignWard::all();
        foreach ($schedule as $schedule) {
            $events[] = [
                'id' => $schedule->id,
                'title' => 'Dr ' . $schedule->name . PHP_EOL . $schedule->ward,
                'start' => $schedule->start_date,
                'end' => $schedule->end_date,
                'allDay' => true
            ];
        }

        return view('calendar.create-ward', ['events' => $events]);
    }

    private function generateRandomDate($usedDates)
    {
        $date = Carbon::now()->addDays(mt_rand(1, 30));

        while (in_array($date->toDateString(), $usedDates)) {
            $date = Carbon::now()->addDays(mt_rand(1, 30));
        }

        return $date;
    }

    public function ward()
    {
        $events = array();
        $schedule = AssignWard::all();
        foreach ($schedule as $schedule) {
            $events[] = [
                'id' => $schedule->id,
                'title' => 'Dr ' . $schedule->name . PHP_EOL . $schedule->ward,
                'start' => $schedule->start_date,
                'end' => $schedule->end_date,
                'allDay' => true
            ];
        }

        return view('calendar.create-ward', ['events' => $events]);
    }

    public function update(Request $request, $id)
    {
        $schedule = AssignWard::find($id);
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
        $schedule = AssignWard::find($id);
        if(! $schedule) {
            return response()->json ([
                'error' => 'Unable to locate the event'
            ], 404);
        }
        $schedule->delete();
        return $id;
    }
}