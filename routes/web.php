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
    return view('auth.register');
});

// Homepage Medicio template routes
Route::get('/homepage', function () {
    return view('homepage');
});

// Leave Application routes
Route::get('/leave', [App\Http\Controllers\CalendarController::class, 'leave'])->name('calendar.leave');
// On Call Application routes
Route::get('/oncall', [App\Http\Controllers\CalendarController::class, 'oncall'])->name('calendar.oncall');
// Store Leave Application routes
Route::post('/leave', [App\Http\Controllers\CalendarController::class, 'storel'])->name('calendar.storeLeave');
// Store On Call Application routes
Route::post('/oncall', [App\Http\Controllers\CalendarController::class, 'storeo'])->name('calendar.storeOnCall');

// Department Schedule routes
Route::get('/department-schedule', [App\Http\Controllers\CalendarController::class, 'depschedule'])->name('calendar.depschedule');
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
