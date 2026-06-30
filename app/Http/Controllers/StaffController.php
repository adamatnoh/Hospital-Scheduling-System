<?php

namespace App\Http\Controllers;

use App\Application\Services\Staff\StaffManagementService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StaffController extends Controller
{
    public function __construct(
        private readonly StaffManagementService $staffService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Staff/Index', [
            'staff' => $this->staffService->listStaff(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Staff/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'department' => 'required|string',
            'role' => 'required|in:scheduler,regular',
            'password' => 'required|string|min:8',
        ]);

        $this->staffService->createStaff($validated);

        return redirect()->route('manageStaff')
            ->with('success', 'Staff member added successfully.');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'department' => 'required|string',
            'role' => 'required|in:scheduler,regular',
        ]);

        $this->staffService->updateStaff($validated['user_id'], $validated);

        return redirect()->route('manageStaff')
            ->with('success', 'Staff member updated successfully.');
    }

    public function show(int $id)
    {
        $staff = $this->staffService->findStaff($id);

        return response()->json($staff);
    }

    public function destroy(int $id)
    {
        $this->staffService->deleteStaff($id);

        return back();
    }
}
