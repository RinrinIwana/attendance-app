@extends('app')

@section('content')
@php
    // 月切替（見た目だけ。実装するなら controller で month を受ける）
    $ym = request('month', now()->format('Y-m'));
    $dt = \Carbon\Carbon::createFromFormat('Y-m', $ym)->startOfMonth();
    $prev = $dt->copy()->subMonth()->format('Y-m');
    $next = $dt->copy()->addMonth()->format('Y-m');
@endphp

<div class="staff-attendance">
    <div class="staff-attendance__inner">

        <h1 class="page-title">
            <span class="page-title__bar"></span>
            <span class="page-title__text">{{ $user->name }}さんの勤怠</span>
        </h1>

        {{-- 月ナビ --}}
        <div class="month-nav">
            <a class="month-nav__link" href="{{ route('admin.attendance.staff', $user) }}?month={{ $prev }}">← 前月</a>

            <div class="month-nav__center">
                <span class="month-nav__icon" aria-hidden="true">📅</span>
                <span class="month-nav__ym">{{ $dt->format('Y/m') }}</span>
            </div>

            <a class="month-nav__link" href="{{ route('admin.attendance.staff', $user) }}?month={{ $next }}">翌月 →</a>
        </div>

        {{-- テーブル --}}
        <div class="attendance-table">
            @if ($attendances->isEmpty())
                <p class="attendance-table__empty">勤怠データがありません。</p>
            @else
                <table class="attendance-table__table">
                    <thead class="attendance-table__thead">
                        <tr class="attendance-table__tr">
                            <th class="attendance-table__th">日付</th>
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
                                <td class="attendance-table__td">
                                    {{ \Carbon\Carbon::parse($attendance->work_date)->format('m/d') }}
                                    ({{ \Carbon\Carbon::parse($attendance->work_date)->locale('ja')->isoFormat('ddd') }})
                                </td>
                                <td class="attendance-table__td">{{ $attendance->clock_in ?? '' }}</td>
                                <td class="attendance-table__td">{{ $attendance->clock_out ?? '' }}</td>
                                <td class="attendance-table__td">-</td>
                                <td class="attendance-table__td">-</td>
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

        {{-- CSV出力（まずは見た目だけ） --}}
        <div class="staff-attendance__actions">
            <button class="btn btn--primary staff-attendance__csv" type="button">CSV出力</button>
        </div>

    </div>
</div>
@endsection
