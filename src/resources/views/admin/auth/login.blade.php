@extends('app')

@section('content')
<div class="auth-form">
    <div class="auth-form__inner">

        <h1 class="auth-form__title">管理者ログイン</h1>

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

            <button class="auth-form__submit" type="submit">管理者ログインする</button>
        </form>

    </div>
</div>
@endsection
