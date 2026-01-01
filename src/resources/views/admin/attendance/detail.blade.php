@extends('app')

@section('content')
<div class="attendance-detail">
    <div class="attendance-detail__inner">

        <h1 class="page-title">
            <span class="page-title__bar"></span>
            <span class="page-title__text">勤怠詳細</span>
        </h1>

        @if (session('success'))
            <div class="message message--success attendance-detail__message">
                {{ session('success') }}
            </div>
        @endif

        <div class="attendance-detail__card">
            <form method="POST" action="{{ route('admin.attendance.update', $attendance) }}">
                @csrf

                <table class="attendance-detail__table">
                    <tr class="attendance-detail__tr">
                        <th class="attendance-detail__th">名前</th>
                        <td class="attendance-detail__td" colspan="3">
                            {{ $attendance->user->name ?? '-' }}
                        </td>
                    </tr>

                    <tr class="attendance-detail__tr">
                        <th class="attendance-detail__th">日付</th>
                        <td class="attendance-detail__td attendance-detail__td--center">
                            {{ \Carbon\Carbon::parse($attendance->work_date)->format('Y年') }}
                        </td>
                        <td class="attendance-detail__td attendance-detail__td--center">
                            {{ \Carbon\Carbon::parse($attendance->work_date)->format('n月j日') }}
                        </td>
                        <td class="attendance-detail__td"></td>
                    </tr>

                    <tr class="attendance-detail__tr">
                        <th class="attendance-detail__th">出勤・退勤</th>
                        <td class="attendance-detail__td attendance-detail__td--center">
                            <input class="attendance-detail__time" type="time" name="clock_in"
                                   value="{{ old('clock_in', $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '') }}">
                        </td>
                        <td class="attendance-detail__td attendance-detail__td--center">
                            <span class="attendance-detail__range">〜</span>
                        </td>
                        <td class="attendance-detail__td attendance-detail__td--center">
                            <input class="attendance-detail__time" type="time" name="clock_out"
                                   value="{{ old('clock_out', $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '') }}">
                        </td>
                    </tr>

                    <tr class="attendance-detail__tr">
                        <th class="attendance-detail__th">休憩</th>
                        <td class="attendance-detail__td attendance-detail__td--center">
                            <input class="attendance-detail__time" type="time" value="">
                        </td>
                        <td class="attendance-detail__td attendance-detail__td--center">
                            <span class="attendance-detail__range">〜</span>
                        </td>
                        <td class="attendance-detail__td attendance-detail__td--center">
                            <input class="attendance-detail__time" type="time" value="">
                        </td>
                    </tr>

                    <tr class="attendance-detail__tr">
                        <th class="attendance-detail__th">休憩2</th>
                        <td class="attendance-detail__td attendance-detail__td--center">
                            <input class="attendance-detail__time" type="time" value="">
                        </td>
                        <td class="attendance-detail__td attendance-detail__td--center">
                            <span class="attendance-detail__range">〜</span>
                        </td>
                        <td class="attendance-detail__td attendance-detail__td--center">
                            <input class="attendance-detail__time" type="time" value="">
                        </td>
                    </tr>

                    <tr class="attendance-detail__tr">
                        <th class="attendance-detail__th">備考</th>
                        <td class="attendance-detail__td" colspan="3">
                            <div class="attendance-detail__textarea"></div>
                        </td>
                    </tr>
                </table>

                <div class="attendance-detail__actions">
                    <button class="btn btn--primary attendance-detail__submit" type="submit">修正</button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
