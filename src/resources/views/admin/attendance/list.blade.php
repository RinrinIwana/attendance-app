@extends('app')

@section('content')
@php
    $dt = \Carbon\Carbon::parse($date);
@endphp

<div class="admin-attendance">
    <div class="admin-attendance__inner">

        <h1 class="page-title">
            <span class="page-title__bar"></span>
            <span class="page-title__text">{{ $dt->format('Y年n月j日') }}の勤怠</span>
        </h1>

        {{-- 日付ナビ --}}
        <div class="day-nav">
            <a class="day-nav__link" href="{{ route('admin.attendance.daily', ['date' => $prev]) }}">← 前日</a>

            <div class="day-nav__center">
                <span class="day-nav__icon" aria-hidden="true">📅</span>
                <span class="day-nav__date">{{ $dt->format('Y/m/d') }}</span>
            </div>

            <a class="day-nav__link" href="{{ route('admin.attendance.daily', ['date' => $next]) }}">翌日 →</a>
        </div>

        {{-- テーブル --}}
        <div class="attendance-table">
            @if ($attendances->isEmpty())
                <p class="attendance-table__empty">この日の勤怠データがありません。</p>
            @else
                <table class="attendance-table__table">
                    <thead class="attendance-table__thead">
                        <tr class="attendance-table__tr">
                            <th class="attendance-table__th">名前</th>
                            <th class="attendance-table__th">出勤</th>
                            <th class="attendance-table__th">退勤</th>
                            <th class="attendance-table__th">休憩</th>
                            <th class="attendance-table__th">合計</th>
                            <th class="attendance-table__th">詳細</th>
                        </tr>
                    </thead>

                    <tbody class="attendance-table__tbody">
                        @foreach ($attendances as $attendance)
                            <tr class="attendance-table__tr">
                                <td class="attendance-table__td">{{ $attendance->user->name ?? '-' }}</td>
                                <td class="attendance-table__td">{{ $attendance->clock_in ?? '' }}</td>
                                <td class="attendance-table__td">{{ $attendance->clock_out ?? '' }}</td>
                                <td class="attendance-table__td">1:00</td>
                                <td class="attendance-table__td">8:00</td>
                                <td class="attendance-table__td">
                                    <a class="attendance-table__detail" href="{{ route('admin.attendance.show', $attendance) }}">
                                        詳細
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</div>
@endsection
