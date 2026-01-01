@extends('app')

@section('content')
@php
    $status = request('status', 'pending'); // pending / approved
@endphp

<div class="request-list">
    <div class="request-list__inner">

        <h1 class="page-title">
            <span class="page-title__bar"></span>
            <span class="page-title__text">申請一覧</span>
        </h1>

        {{-- Tabs --}}
        <div class="request-tabs">
            <div class="request-tabs__inner">
                <a
                    class="request-tabs__tab {{ $status === 'pending' ? 'request-tabs__tab--active' : '' }}"
                    href="{{ url('/stamp_correction_request/list') }}?status=pending"
                >
                    承認待ち
                </a>

                <a
                    class="request-tabs__tab {{ $status === 'approved' ? 'request-tabs__tab--active' : '' }}"
                    href="{{ url('/stamp_correction_request/list') }}?status=approved"
                >
                    承認済み
                </a>
            </div>
            <div class="request-tabs__line"></div>
        </div>

        {{-- Table --}}
        <div class="request-table">
            @if ($requests->isEmpty())
                <p class="request-table__empty">申請データがありません。</p>
            @else
                <table class="request-table__table">
                    <thead class="request-table__thead">
                        <tr class="request-table__tr">
                            <th class="request-table__th">状態</th>
                            <th class="request-table__th">名前</th>
                            <th class="request-table__th">対象日時</th>
                            <th class="request-table__th">申請理由</th>
                            <th class="request-table__th">申請日時</th>
                            <th class="request-table__th">詳細</th>
                        </tr>
                    </thead>

                    <tbody class="request-table__tbody">
                        @foreach ($requests as $req)
                            <tr class="request-table__tr">
                                <td class="request-table__td">
                                    @if ($req->status === 'pending')
                                        承認待ち
                                    @elseif ($req->status === 'approved')
                                        承認済み
                                    @elseif ($req->status === 'rejected')
                                        却下
                                    @endif
                                </td>

                                <td class="request-table__td">{{ $req->user->name ?? auth()->user()->name }}</td>

                                <td class="request-table__td">
                                    {{ \Carbon\Carbon::parse($req->attendance->work_date ?? null)->format('Y/m/d') }}
                                </td>

                                <td class="request-table__td">{{ $req->reason }}</td>

                                <td class="request-table__td">
                                    {{ \Carbon\Carbon::parse($req->created_at)->format('Y/m/d') }}
                                </td>

                                <td class="request-table__td">
                                    {{-- 詳細画面が「勤怠詳細」に統合されている想定 --}}
                                    <a class="request-table__detail" href="{{ route('attendance.show', $req->attendance_id) }}">
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
