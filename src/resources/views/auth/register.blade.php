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
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
</head>

<body>
    <header class="header">
        <div class="header__title">
            <img src="{{ asset('/images/logo.svg') }}" class="header__logo">
        </div>
    </header> 
    
    <main>
        <form class="register__form" action="/register" method="post">
            @csrf
            <h2 class="form__title">会員登録</h2>
            <div class="form__group">
                <span class="form__label">ユーザー名</span>
                <div class="form__input">
                    <input type="text" name="name" value="{{ old('name') }}">
                </div>
            </div>
            <div class="form__group">
                <span class="form__label">メールアドレス</span>
                <div class="form__input">
                    <input type="email" name="email" value="{{ old('email') }}">
                </div>
            </div>
            <div class="form__group">
                <span class="form__label">パスワード</span>
                <div class="form__input">
                    <input type="password" name="password">
                </div>
            </div>
            <div class="form__group">
                <span class="form__label">確認用パスワード</span>
                <div class="form__input">
                    <input type="password" name="password_confirmation">
                </div>
            </div>
            <div class="form__button">
                <button class="form__button--submit" type="submit">登録する</button>
            </div>
            <a class="login__link" href="/login">ログインはこちら</a>
        </form>
    </main>
</body>
</html>