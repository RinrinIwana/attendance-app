@extends('app')

@section('content')
<div class="attendance">
    <div class="attendance__inner">

        {{-- ステータス表示（画像の「勤務外」） --}}
        <div class="attendance__badge">勤務外</div>

        {{-- 日付（例：2023年6月1日(木)） --}}
        <div class="attendance__date">
            {{ now()->isoFormat('YYYY年M月D日(ddd)') }}
        </div>

        {{-- 時刻（例：08:00） --}}
        <div class="attendance__time">
            {{ now()->format('H:i') }}
        </div>

        <div class="attendance__actions">
            @if (!$attendance)
                <form method="POST" action="{{ route('attendance.clockIn') }}">
                    @csrf
                    <button class="btn btn--primary btn--wide" type="submit">出勤</button>
                </form>
            @else
                @if (!$attendance->clock_out)
                    <form method="POST" action="{{ route('attendance.clockOut') }}">
                        @csrf
                        <button class="btn btn--primary btn--wide" type="submit">退勤</button>
                    </form>
                @else
                    <div class="attendance__done">本日の勤怠は登録済みです</div>
                @endif
            @endif
        </div>

    </div>
</div>
@endsection
