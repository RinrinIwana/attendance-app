<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="l-body">
<header class="header">
    <div class="header__inner">
        <a class="header__brand" href="{{ url('/') }}">
            <img class="header__logo" src="{{ asset('images/logo.jpg') }}" alt="COACHTECHロゴ">
            <span class="header__brand-text">COACHTECH</span>
        </a>

        {{-- ▼ ナビは「ログイン中のみ」表示 --}}
        @auth
            <nav class="header__nav">
                @if (auth()->user()->role === 'admin')
                    <a class="header__nav-link" href="{{ url('/admin/attendance/list') }}">勤怠一覧</a>
                    <a class="header__nav-link" href="{{ url('/admin/staff/list') }}">スタッフ一覧</a>
                    <a class="header__nav-link" href="{{ url('/admin/stamp_correction_request/list') }}">申請一覧</a>
                @else
                    <a class="header__nav-link" href="{{ url('/attendance') }}">勤怠</a>
                    <a class="header__nav-link" href="{{ url('/attendance/list') }}">勤怠一覧</a>
                    <a class="header__nav-link" href="{{ url('/stamp_correction_request/list') }}">申請</a>
                @endif

                <form method="POST" action="{{ url('/logout') }}" class="header__logout">
                    @csrf
                    <button type="submit" class="header__nav-link header__nav-link--button">
                        ログアウト
                    </button>
                </form>
            </nav>
        @endauth
    </div>
</header>
<main class="l-main">
    @yield('content')
</main>
</body>
</html>
