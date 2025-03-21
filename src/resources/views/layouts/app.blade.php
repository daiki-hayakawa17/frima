<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoachtechFreeMarket</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gorditas:wght@400;700&family=Inika:wght@400;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lora:ital,wght@0,400..700;1,400..700&family=Noto+Serif+JP:wght@900&display=swap" rel="stylesheet">
    @yield('css')
</head>

<body>
    <header class="header">
        <a class="header__title" href="/">
            <img src="{{ asset('/images/logo.svg') }}" class="header__logo">
        </a>
        <div class="header__search">
            <input type="text" name="name" placeholder="なにをお探しですか?">
        </div>
        <nav class="header__nav">
            <ul class="header__nav--list">
                @if (Auth::check())
                <li class="header__nav--item">
                    <form action="/logout" method="post">
                        @csrf
                        <button class="header__nav--button">ログアウト</button>
                    </form>
                </li>
                @else
                <li class="header__nav--item">
                    <form action="/login" method="get">
                        <button class="header__nav--button">ログイン</button>
                    </form>
                </li>
                @endif
                <li class="header__nav--item">
                    <a class="header__nav--link" href="/mypage">マイページ</a>
                </li>
                <li class="header__nav--item">
                    <a class="header__nav--link" href="/sell">出品</a>
                </li>
            </ul>
        </nav>
    </header> 
    
    <main>
        @yield('content')
    </main>
    @yield('script')
</body>
</html>