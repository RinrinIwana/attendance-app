<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\StampCorrectionRequest;
use Illuminate\Support\Carbon;


class AttendanceController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $attendance = Attendance::where('user_id', auth()->id())
            ->where('work_date', $today)
            ->first();

        return view('attendance.index', compact('attendance'));
    }

    public function list()
    {
        $attendances = Attendance::where('user_id', auth()->id())
            ->orderBy('work_date', 'desc')
            ->get();

        return view('attendance.list', compact('attendances'));
    }

    public function show(Attendance $attendance)
    {
        if ($attendance->user_id !== auth()->id()) {
            abort(403);
        }

        $latestRequest = StampCorrectionRequest::where('attendance_id', $attendance->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $hasPending = StampCorrectionRequest::where('attendance_id', $attendance->id)
            ->where('status', 'pending')
            ->exists();

        return view('attendance.detail', compact('attendance', 'latestRequest', 'hasPending'));
    }

    public function clockIn()
    {
        $today = now()->toDateString();
        Attendance::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'work_date' => $today,
            ],
            [
                'clock_in' => now()->format('H:i'),
                'status' => 'working',
            ]
        );
        return redirect()->route('attendance.index');
    }

    public function clockOut()
    {
        $attendance = Attendance::where('user_id', auth()->id())
        ->where('work_date', now()->toDateString())
        ->first();

        if ($attendance && $attendance->clock_out === null) {
            $attendance->update([
                'clock_out' => now()->format('H:i'),
                'status' => 'finished',
            ]);
        }
        return redirect()->route('attendance.index');
    }

}
