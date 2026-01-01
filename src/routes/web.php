<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Admin\StampCorrectionRequestController as AdminRequestController;
use App\Http\Controllers\StampCorrectionRequestController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\StaffController as AdminStaffController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', function () {
    return view('admin.auth.login');
})->middleware('guest')->name('admin.login');

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/stamp_correction_request/list', [AdminRequestController::class, 'list'])
    ->name('admin.request.list');

    Route::get('/attendance/{attendance}/request',
        [StampCorrectionRequestController::class, 'create']
    )->name('request.create');

    Route::post('/attendance/{attendance}/request',
        [StampCorrectionRequestController::class, 'store']
    )->name('request.store');

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])
        ->name('attendance.clockIn');

    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])
        ->name('attendance.clockOut');

    Route::get('/attendance/list', [AttendanceController::class, 'list'])->name('attendance.list');

    Route::get('/attendance/detail/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');

});

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/staff/list', [AdminStaffController::class, 'list'])
            ->name('admin.staff.list');

        Route::get('/attendance/staff/{user}', [AdminAttendanceController::class, 'staffList'])
            ->name('admin.attendance.staff');

        Route::get('/attendance/list', [AdminAttendanceController::class, 'dailyList'])
        ->name('admin.attendance.daily');

        Route::get('/attendance/{attendance}', [AdminAttendanceController::class, 'show'])
            ->name('admin.attendance.show');

        Route::post('/attendance/{attendance}', [AdminAttendanceController::class, 'update'])
            ->name('admin.attendance.update');

        Route::get('/stamp_correction_request/list', [AdminRequestController::class, 'list'])
            ->name('admin.request.list');

        Route::get('/stamp_correction_request/approve/{request}', [AdminRequestController::class, 'approveForm'])
            ->name('admin.request.approveForm');

        Route::post('/stamp_correction_request/approve/{request}', [AdminRequestController::class, 'approve'])
            ->name('admin.request.approve');
    });