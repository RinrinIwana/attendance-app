@extends('app')

@section('content')
<div class="auth-form">
    <div class="auth-form__inner">

        <h1 class="auth-form__title">会員登録</h1>

        <form class="auth-form__form" method="POST" action="{{ url('/register') }}" novalidate>
            @csrf

            <div class="auth-form__group">
                <label class="auth-form__label" for="name">名前</label>
                <input class="auth-form__input" id="name" name="name" type="text" value="{{ old('name') }}">
                @error('name')
                    <p class="auth-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-form__group">
                <label class="auth-form__label" for="email">メールアドレス</label>
                <input class="auth-form__input" id="email" name="email" type="email" value="{{ old('email') }}" required>
                @error('email')
                    <p class="auth-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-form__group">
                <label class="auth-form__label" for="password">パスワード</label>
                <input class="auth-form__input" id="password" name="password" type="password" required>
                @error('password')
                    <p class="auth-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-form__group">
                <label class="auth-form__label" for="password_confirmation">パスワード確認</label>
                <input class="auth-form__input" id="password_confirmation" name="password_confirmation" type="password" required>
                {{-- password_confirmation は "confirmed" のエラーが password に付くので、ここは不要でOK --}}
            </div>

            <button class="auth-form__submit" type="submit">登録する</button>
        </form>

        <div class="auth-form__links">
            <a class="auth-form__link" href="{{ url('/login') }}">ログインはこちら</a>
        </div>

    </div>
</div>
@endsection
