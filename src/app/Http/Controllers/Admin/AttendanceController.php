<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function list()
    {
        $attendances = Attendance::with('user')
            ->orderBy('work_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.attendance.list', compact('attendances'));
    }

    public function dailyList()
    {
        $date = request('date', now()->toDateString());
        $dt = Carbon::parse($date);

        $prev = $dt->copy()->subDay()->toDateString();
        $next = $dt->copy()->addDay()->toDateString();

        $attendances = Attendance::with('user')
        ->where('work_date', $date)
        ->orderBy('user_id', 'asc')
        ->get();

        return view('admin.attendance.list', compact('attendances', 'date', 'prev', 'next'));
    }


    public function show(Attendance $attendance)
    {
        $attendance->load('user');

        return view('admin.attendance.detail', compact('attendance'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'clock_in'  => ['nullable', 'date_format:H:i'],
            'clock_out' => ['nullable', 'date_format:H:i'],
        ]);

        $attendance->update([
            'clock_in'  => $request->input('clock_in'),
            'clock_out' => $request->input('clock_out'),
        ]);

        return redirect()
        ->route('admin.attendance.show', $attendance)
        ->with('success', '勤怠を更新しました');
    }

    public function staffList(User $user)
    {
        $month = request('month', now()->format('Y-m'));
        $start = \Carbon\Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $attendances = Attendance::where('user_id', $user->id)
        ->whereBetween('work_date', [$start->toDateString(), $end->toDateString()])
        ->orderBy('work_date', 'asc')
        ->get();

        return view('admin.attendance.staff', compact('user', 'attendances'));
    }
}
