@extends('app')

@section('content')
<div class="request-create">
    <div class="request-create__inner">

        <h1 class="page-title">
            <span class="page-title__bar"></span>
            <span class="page-title__text">修正申請</span>
        </h1>

        {{-- エラー表示 --}}
        @if ($errors->any())
            <div class="message message--error request-create__message">
                <ul class="request-create__error-list">
                    @foreach ($errors->all() as $error)
                        <li class="request-create__error-item">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="request-create__card">
            <table class="request-create__table">
                <tr class="request-create__tr">
                    <th class="request-create__th">状態</th>
                    <td class="request-create__td">承認待ち</td>
                </tr>

                <tr class="request-create__tr">
                    <th class="request-create__th">名前</th>
                    <td class="request-create__td">{{ auth()->user()->name }}</td>
                </tr>

                <tr class="request-create__tr">
                    <th class="request-create__th">対象日時</th>
                    <td class="request-create__td">
                        {{ \Carbon\Carbon::parse($attendance->work_date)->format('Y/m/d') }}
                    </td>
                </tr>

                <tr class="request-create__tr">
                    <th class="request-create__th">出勤・退勤</th>
                    <td class="request-create__td">
                        <form class="request-create__form" method="POST" action="{{ route('request.store', $attendance) }}"novalidate>
                            @csrf

                            <div class="request-create__time-row">
                                <input
                                    class="request-create__time"
                                    type="time"
                                    name="requested_clock_in"
                                    value="{{ old('requested_clock_in') }}"
                                >
                                @error('requested_clock_in')
                                <p class="auth-form__error">{{ $message }}</p>
                                @enderror

                                <span class="request-create__range">〜</span>
                                <input
                                    class="request-create__time"
                                    type="time"
                                    name="requested_clock_out"
                                    value="{{ old('requested_clock_out') }}"
                                >
                                @error('requested_clock_in')
                                <p class="auth-form__error">{{ $message }}</p>
                                @enderror

                            </div>

                            <div class="request-create__hint">
                                ※ 変更が必要な方だけ入力してください
                            </div>

                            <div class="request-create__reason">
                                <label class="request-create__label" for="reason">申請理由</label>
                                <textarea
                                    class="request-create__textarea"
                                    id="reason"
                                    name="reason"
                                    required
                                >{{ old('reason') }}</textarea>
                            </div>

                            <div class="request-create__actions">
                                <button class="btn btn--primary request-create__submit" type="submit">申請</button>
                            </div>
                        </form>
                    </td>
                </tr>

                <tr class="request-create__tr">
                    <th class="request-create__th">申請日時</th>
                    <td class="request-create__td">（申請後に自動で登録されます）</td>
                </tr>
            </table>
        </div>

        <div class="request-create__footer">
            <a class="request-create__back" href="{{ route('attendance.show', $attendance) }}">← 勤怠詳細へ戻る</a>
        </div>

    </div>
</div>
@endsection
