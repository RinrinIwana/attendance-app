@extends('app')

@section('content')
<div class="auth-form">
    <div class="auth-form__inner">

        <h1 class="auth-form__title">ログイン</h1>

        <form class="auth-form__form" method="POST" action="{{ url('/login') }}" novalidate>
            @csrf

            <div class="auth-form__group">
                <label class="auth-form__label" for="email">メールアドレス</label>
                <input class="auth-form__input" id="email" name="email" type="email" value="{{ old('email') }}">
                @error('email')
                    <p class="auth-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-form__group">
                <label class="auth-form__label" for="password">パスワード</label>
                <input class="auth-form__input" id="password" name="password" type="password">
                @error('password')
                    <p class="auth-form__error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 認証失敗（メール/パス不一致など）のエラーは "email" に付くことが多いので表示しておく --}}
            @error('email')
                {{-- 上で出してるので重複回避したいならここは不要 --}}
            @enderror

            <button class="auth-form__submit" type="submit">ログインする</button>
        </form>

        <div class="auth-form__links">
            <a class="auth-form__link" href="{{ url('/register') }}">会員登録はこちら</a>
        </div>

    </div>
</div>
@endsection
