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
                        {{ $req->user->name ?? '-' }}
                    </td>
                </tr>

                <tr class="attendance-detail__tr">
                    <th class="attendance-detail__th">日付</th>
                    <td class="attendance-detail__td attendance-detail__td--center">
                        {{ \Carbon\Carbon::parse($req->attendance->work_date)->format('Y年') }}
                    </td>
                    <td class="attendance-detail__td attendance-detail__td--center">
                        {{ \Carbon\Carbon::parse($req->attendance->work_date)->format('n月j日') }}
                    </td>
                    <td class="attendance-detail__td"></td>
                </tr>

                <tr class="attendance-detail__tr">
                    <th class="attendance-detail__th">出勤・退勤</th>
                    <td class="attendance-detail__td attendance-detail__td--center">
                        {{ $req->requested_clock_in ? \Carbon\Carbon::parse($req->requested_clock_in)->format('H:i') : '' }}
                    </td>
                    <td class="attendance-detail__td attendance-detail__td--center">
                        〜
                    </td>
                    <td class="attendance-detail__td attendance-detail__td--center">
                        {{ $req->requested_clock_out ? \Carbon\Carbon::parse($req->requested_clock_out)->format('H:i') : '' }}
                    </td>
                </tr>

                <tr class="attendance-detail__tr">
                    <th class="attendance-detail__th">休憩</th>
                    <td class="attendance-detail__td attendance-detail__td--center"></td>
                    <td class="attendance-detail__td attendance-detail__td--center"></td>
                    <td class="attendance-detail__td attendance-detail__td--center"></td>
                </tr>

                <tr class="attendance-detail__tr">
                    <th class="attendance-detail__th">休憩2</th>
                    <td class="attendance-detail__td attendance-detail__td--center"></td>
                    <td class="attendance-detail__td attendance-detail__td--center"></td>
                    <td class="attendance-detail__td attendance-detail__td--center"></td>
                </tr>

                <tr class="attendance-detail__tr">
                    <th class="attendance-detail__th">備考</th>
                    <td class="attendance-detail__td" colspan="3">
                        {{ $req->reason }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="attendance-detail__actions">
            <form method="POST" action="{{ route('admin.request.approve', $req) }}">
                @csrf
                <button class="btn btn--primary attendance-detail__submit" type="submit">承認</button>
            </form>
        </div>

    </div>
</div>
@endsection
