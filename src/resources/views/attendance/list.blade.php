@extends('app')

@section('content')
<div class="attendance-list">
    <div class="attendance-list__inner">

        <h1 class="page-title">
            <span class="page-title__bar"></span>
            <span class="page-title__text">勤怠一覧</span>
        </h1>

        {{-- 月切替（※今は見た目だけ。リンク先は後で実装でOK） --}}
        <div class="month-nav">
            <a class="month-nav__link" href="#">← 前月</a>

            <div class="month-nav__center">
                <span class="month-nav__icon" aria-hidden="true">📅</span>
                <span class="month-nav__ym">{{ now()->format('Y/m') }}</span>
            </div>

            <a class="month-nav__link" href="#">翌月 →</a>
        </div>

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
                                <td class="attendance-table__td">{{ $attendance->work_date }}</td>
                                <td class="attendance-table__td">{{ $attendance->clock_in ?? '' }}</td>
                                <td class="attendance-table__td">{{ $attendance->clock_out ?? '' }}</td>

                                {{-- 休憩/合計は後で実装する想定なので仮 --}}
                                <td class="attendance-table__td">-</td>
                                <td class="attendance-table__td">-</td>

                                <td class="attendance-table__td">
                                    <a class="attendance-table__detail" href="{{ route('attendance.show', $attendance) }}">
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
