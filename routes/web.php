<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Scheduling\OnCallScheduleController;
use App\Http\Controllers\Scheduling\PersonalScheduleController;
use App\Http\Controllers\Scheduling\ShiftScheduleController;
use App\Http\Controllers\Scheduling\WardScheduleController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/unauthorized', fn () => Inertia::render('Unauthorized'))->name('unauthorized');

    // Personal schedule — all authenticated users
    Route::get('/your-schedule', [PersonalScheduleController::class, 'show'])->name('calendar.yourschedule');

    // Applications — regular staff and schedulers
    Route::middleware('role:regular,scheduler,admin')->group(function () {
        Route::get('/leave', [ApplicationController::class, 'leaveForm'])->name('calendar.leave');
        Route::post('/leave', [ApplicationController::class, 'storeLeave'])->name('calendar.storeLeave');
        Route::get('/oncall', [ApplicationController::class, 'onCallForm'])->name('calendar.oncall');
        Route::post('/oncall', [ApplicationController::class, 'storeOnCall'])->name('calendar.storeOnCall');
        Route::get('/history', [ApplicationController::class, 'history'])->name('calendar.history');
    });

    // Schedule generation — schedulers and admins
    Route::middleware('role:scheduler,admin')->group(function () {
        Route::get('/assign', [OnCallScheduleController::class, 'generate'])->name('assign');
        Route::get('/create-oncall', [OnCallScheduleController::class, 'editor'])->name('create-oncall');
        Route::patch('/update-oncall/{id}', [OnCallScheduleController::class, 'update'])->name('assign.update');
        Route::delete('/delete-oncall/{id}', [OnCallScheduleController::class, 'destroy'])->name('assign.delete');

        Route::get('/assign-ward', [WardScheduleController::class, 'generate'])->name('assign-ward');
        Route::get('/create-ward', [WardScheduleController::class, 'editor'])->name('create-ward');
        Route::patch('/update-ward/{id}', [WardScheduleController::class, 'update'])->name('ward.update');
        Route::delete('/delete-ward/{id}', [WardScheduleController::class, 'destroy'])->name('ward.delete');

        Route::get('/assign-shift', [ShiftScheduleController::class, 'generate'])->name('assign-shift');
        Route::get('/create-shift', [ShiftScheduleController::class, 'editor'])->name('create-shift');
        Route::patch('/update-shift/{id}', [ShiftScheduleController::class, 'update'])->name('shift.update');
        Route::delete('/delete-shift/{id}', [ShiftScheduleController::class, 'destroy'])->name('shift.delete');

        Route::get('/review', [ReviewController::class, 'pending'])->name('review');
        Route::get('/review-history', [ReviewController::class, 'history'])->name('reviewHistory');
        Route::patch('/review/update-leave/{id}', [ReviewController::class, 'updateLeave'])->name('updateReviewLeave');
        Route::patch('/review/update-oncall/{id}', [ReviewController::class, 'updateOnCall'])->name('updateReviewOnCall');
    });

    // Department views — all authenticated users
    Route::get('/department-oncall', [OnCallScheduleController::class, 'departmentView'])->name('calendar.depschedule');
    Route::get('/department-ward', [WardScheduleController::class, 'departmentView'])->name('calendar.view-ward');
    Route::get('/department-shift', [ShiftScheduleController::class, 'departmentView'])->name('calendar.view-shift');

    // Admin staff management
    Route::middleware('role:admin')->group(function () {
        Route::get('/staff', [StaffController::class, 'index'])->name('manageStaff');
        Route::get('/add-staff', [StaffController::class, 'create'])->name('staff-form');
        Route::post('/adding', [StaffController::class, 'store'])->name('addStaff');
        Route::post('/staff/update', [StaffController::class, 'update'])->name('updateStaff');
        Route::get('/getStaff/{id}', [StaffController::class, 'show'])->name('getStaff');
        Route::delete('/deleteStaff/{id}', [StaffController::class, 'destroy'])->name('deleteStaff');
    });
});
