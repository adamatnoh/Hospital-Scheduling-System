<?php
// THIS IS ADMIN MANAGE STAFF ACCOUNT CONTROLLER
namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function manageStaff (Request $request)
    {
        $staffs = DB::table('users')
        ->select('id', 'role', 'name', 'email', 'department')
        ->where('role', '!=', 'admin')
        ->get();

        return view('manageStaff', compact('staffs'));
    }

    public function updateStaff(Request $request)
    {
        $user_id = $request->input('user_id');
        $name = $request->input('title');
        $department = $request->input('department');
        $role = $request->input('role');
        $email = $request->input('email');

        DB::table('users')
            ->where('id', $user_id)
            ->update([
                'name' => $name,
                'department' => $department,
                'role' => $role,
                'email' => $email
            ]);

            // echo "<script>alert('Success! Staff details have been successfully updated!');</script>";

        return redirect()->route('manageStaff');
    }

    public function getStaff($id)
    {
        $staff = DB::table('users')->find($id);

        return response()->json($staff);
    }

    public function deleteStaff(Request $request, $id)
    {
        $staff = User::find($id);
        if(! $staff) {
            return response()->json ([
                'error' => 'Unable to locate the event'
            ], 404);
        }
        $staff->delete();

        return response()->json($staff);
    }

    public function addStaff(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            // Add other validation rules for your fields
        ]);

        $hashedPassword = Hash::make($request->input('password'));

        $staff = DB::table('users')->insert([
            'name' => $request->input('name'),
            'department' => $request->input('department'),
            'role' => $request->input('role'),
            'email' => $request->input('email'),
            'password' => $hashedPassword,
        ]);

        return response()->json($staff);
    }
}
