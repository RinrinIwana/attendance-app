<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\StampCorrectionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StampCorrectionRequestController extends Controller
{
    public function list()
    {
        $status = request('status', 'pending');

        $requests = \App\Models\StampCorrectionRequest::with(['user', 'attendance'])
        ->where('status', $status)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('admin.stamp_correction_request.list', compact('requests', 'status'));
    }

    public function approveForm(StampCorrectionRequest $request)
    {
        $request->load(['user', 'attendance']);

        return view('admin.stamp_correction_request.approve', [
            'req' => $request, // bladeで分かりやすくするため
        ]);
    }

    public function approve(Request $httpRequest, StampCorrectionRequest $request)
    {
        if ($request->status !== 'pending') {
            return redirect()->route('admin.request.list', ['status' => 'pending']);
        }

        DB::transaction(function () use ($request) {
            $attendance = $request->attendance;


            if (!is_null($request->requested_clock_in)) {
                $attendance->clock_in = $request->requested_clock_in;
            }
            if (!is_null($request->requested_clock_out)) {
                $attendance->clock_out = $request->requested_clock_out;
            }
            $attendance->save();

            $request->status = 'approved';
            $request->save();
        });

        return redirect()->route('admin.request.list', ['status' => 'pending'])
        ->with('success', '申請を承認しました');
    }
}
