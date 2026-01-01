@extends('app')

@section('content')
<div class="staff-list">
    <div class="staff-list__inner">

        <h1 class="page-title">
            <span class="page-title__bar"></span>
            <span class="page-title__text">スタッフ一覧</span>
        </h1>

        <div class="staff-table">
            @if ($users->isEmpty())
                <p class="staff-table__empty">スタッフがいません。</p>
            @else
                <table class="staff-table__table">
                    <thead class="staff-table__thead">
                        <tr class="staff-table__tr">
                            <th class="staff-table__th">名前</th>
                            <th class="staff-table__th">メールアドレス</th>
                            <th class="staff-table__th">月次勤怠</th>
                        </tr>
                    </thead>
                    <tbody class="staff-table__tbody">
                        @foreach ($users as $user)
                            <tr class="staff-table__tr">
                                <td class="staff-table__td">{{ $user->name }}</td>
                                <td class="staff-table__td">{{ $user->email }}</td>
                                <td class="staff-table__td">
                                    <a class="staff-table__detail" href="{{ route('admin.attendance.staff', $user) }}">
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
