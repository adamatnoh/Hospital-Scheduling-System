<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Register routes
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
});

// Homepage Medicio template routes
Route::get('/homepage', function () {
    return view('homepage');
});

// Assigning staff routes
Route::get('/assign', [App\Http\Controllers\AssignController::class, 'assign'])->name('assign');
// Create On Call Schedule routes
Route::get('/create-oncall', [App\Http\Controllers\AssignController::class, 'oncall'])->name('create-oncall');
// Update On Call Schedule routes
Route::patch('/update-oncall/{id}', [App\Http\Controllers\AssignController::class, 'update'])->name('assign.update');
// Delete On Call Schedule routes
Route::delete('/delete-oncall/{id}', [App\Http\Controllers\AssignController::class, 'delete'])->name('assign.delete');

// Assigning Ward staff routes
Route::get('/assign-ward', [App\Http\Controllers\WardController::class, 'assignWard'])->name('assign-ward');
// Create Ward Schedule routes
Route::get('/create-ward', [App\Http\Controllers\WardController::class, 'ward'])->name('create-ward');
// Update Ward Schedule routes
Route::patch('/update-ward/{id}', [App\Http\Controllers\WardController::class, 'update'])->name('ward.update');
// Delete Ward Schedule routes
Route::delete('/delete-ward/{id}', [App\Http\Controllers\WardController::class, 'delete'])->name('ward.delete');

// Assigning Shift staff routes
Route::get('/assign-shift', [App\Http\Controllers\ShiftController::class, 'assignShift'])->name('assign-shift');
// Create Shift Schedule routes
Route::get('/create-shift', [App\Http\Controllers\ShiftController::class, 'shift'])->name('create-shift');
// Update Shift Schedule routes
Route::patch('/update-shift/{id}', [App\Http\Controllers\ShiftController::class, 'update'])->name('shift.update');
// Delete Shift Schedule routes
Route::delete('/delete-shift/{id}', [App\Http\Controllers\ShiftController::class, 'delete'])->name('shift.delete');

// Leave Application routes
Route::get('/leave', [App\Http\Controllers\CalendarController::class, 'leave'])->name('calendar.leave');
// On Call Application routes
Route::get('/oncall', [App\Http\Controllers\CalendarController::class, 'oncall'])->name('calendar.oncall');
// Store Leave Application routes
Route::post('/leave', [App\Http\Controllers\CalendarController::class, 'storel'])->name('calendar.storeLeave');
// Store On Call Application routes
Route::post('/oncall', [App\Http\Controllers\CalendarController::class, 'storeo'])->name('calendar.storeOnCall');

// Department Schedule routes
Route::get('/department-schedule', [App\Http\Controllers\JoinTableController::class, 'depschedule'])->name('calendar.depschedule');
// Your Schedule routes
Route::get('/your-schedule', [App\Http\Controllers\JoinTableController::class, 'yourschedule'])->name('calendar.yourschedule');

// Review Changes routes
// Route::get('/review', [App\Http\Controllers\CalendarController::class, 'leave'])->name('review');
Route::get('/review', function () {
    return view('review');
})->name('review');;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// For Unauthorized role
Route::get('/unauthorized', function () { return view('unauthorized'); })->name('unauthorized');