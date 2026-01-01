<?php

namespace App\Http\Controllers;

use App\Models\StampCorrectionRequest;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStampCorrectionRequest;

class StampCorrectionRequestController extends Controller
{
    public function list()
    {
        $status = request('status', 'pending');

        $requests = \App\Models\StampCorrectionRequest::where('user_id', auth()->id())
        ->where('status', $status)
        ->with(['attendance', 'user'])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('stamp_correction_request.list', compact('requests'));
    }

    public function create(Attendance $attendance)
    {
        if ($attendance->user_id !== auth()->id()) {
            abort(403);
        }

        $hasPending = StampCorrectionRequest::where('attendance_id', $attendance->id)
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            return redirect()
                ->route('attendance.show', $attendance)
                ->withErrors('この勤怠には未処理の修正申請（pending）があるため、再申請できません。');
        }

        return view('stamp_correction_request.create', compact('attendance'));
    }

    public function store(StoreStampCorrectionRequest $request, Attendance $attendance)
    {
        if ($attendance->user_id !== auth()->id()) {
            abort(403);
        }

        $hasPending = StampCorrectionRequest::where('attendance_id', $attendance->id)
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            return redirect()
                ->route('attendance.show', $attendance)
                ->withErrors('この勤怠には未処理の修正申請（pending）があるため、再申請できません。');
        }

        $validated = $request->validated();

        $data = $request->validate([
            'requested_clock_in' => ['nullable', 'date_format:H:i'],
            'requested_clock_out' => ['nullable', 'date_format:H:i'],
            'reason' => ['required', 'string'],
        ]);

        StampCorrectionRequest::create([
            'attendance_id' => $attendance->id,
            'user_id' => auth()->id(),
            'requested_clock_in' => $data['requested_clock_in'] ?? null,
            'requested_clock_out' => $data['requested_clock_out'] ?? null,
            'reason' => $data['reason'],
            'status' => 'pending',
        ]);

        return redirect()->route('request.list');
    }
}
