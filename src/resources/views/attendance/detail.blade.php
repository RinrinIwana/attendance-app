@extends('app')

@section('content')
<div class="attendance-detail">
    <div class="attendance-detail__inner">

        <h1 class="page-title">
            <span class="page-title__bar"></span>
            <span class="page-title__text">勤怠詳細</span>
        </h1>

        <div class="attendance-detail__card">
            <table class="attendance-detail__table">
                <tr class="attendance-detail__tr">
                    <th class="attendance-detail__th">名前</th>
                    <td class="attendance-detail__td" colspan="3">
                        {{ auth()->user()->name }}
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
                        <span class="attendance-detail__input">{{ $attendance->clock_in ?? '' }}</span>
                    </td>
                    <td class="attendance-detail__td attendance-detail__td--center">
                        <span class="attendance-detail__range">〜</span>
                    </td>
                    <td class="attendance-detail__td attendance-detail__td--center">
                        <span class="attendance-detail__input">{{ $attendance->clock_out ?? '' }}</span>
                    </td>
                </tr>

                <tr class="attendance-detail__tr">
                    <th class="attendance-detail__th">休憩</th>
                    <td class="attendance-detail__td attendance-detail__td--center">
                        <span class="attendance-detail__input"></span>
                    </td>
                    <td class="attendance-detail__td attendance-detail__td--center">
                        <span class="attendance-detail__range">〜</span>
                    </td>
                    <td class="attendance-detail__td attendance-detail__td--center">
                        <span class="attendance-detail__input"></span>
                    </td>
                </tr>

                <tr class="attendance-detail__tr">
                    <th class="attendance-detail__th">休憩2</th>
                    <td class="attendance-detail__td attendance-detail__td--center">
                        <span class="attendance-detail__input"></span>
                    </td>
                    <td class="attendance-detail__td attendance-detail__td--center">
                        <span class="attendance-detail__range">〜</span>
                    </td>
                    <td class="attendance-detail__td attendance-detail__td--center">
                        <span class="attendance-detail__input"></span>
                    </td>
                </tr>

                <tr class="attendance-detail__tr">
                    <th class="attendance-detail__th">備考</th>
                    <td class="attendance-detail__td" colspan="3">
                        <div class="attendance-detail__textarea">
                            @if ($latestRequest)
                                {{ $latestRequest->reason }}
                            @else
                                -
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="attendance-detail__actions">
            @if ($hasPending)
                <p class="attendance-detail__note attendance-detail__note--error">
                    未承認の修正申請があるため、修正申請できません。
                </p>
            @else
                <a class="btn btn--primary attendance-detail__submit"
                href="{{ route('request.create', $attendance) }}">
                    修正
                </a>
            @endif
        </div>

    </div>
</div>
@endsection
