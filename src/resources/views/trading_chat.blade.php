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
    <link rel="stylesheet" href="{{ asset('css/trading_chat.css') }}">
</head>

<body>
    <header class="header">
        <a class="header__title" href="/">
            <img src="{{ asset('/images/logo.svg') }}" class="header__logo" alt="Coachtech Free Marketのロゴ">
        </a>
    </header>
    <main>
        <div class="sidebar">
            <h3 class="sidebar__title">その他の取引</h3>
            @foreach($otherItems as $otherItem)
                <a href="/trading/chat/{{$otherItem->id}}" class="other__item--link">
                    <p class="other__item--name">
                        {{ $otherItem->name }}
                    </p>
                </a>
            @endforeach
        </div>
        <div class="content">
            <div class="content__title">
                @if ($item->user_id === $user->id)
                    <img src="{{ asset($purchaserProfile->image) }}">
                    <h3 class="trading__user">{{ $purchaserProfile->name}}さんとの取引画面</h3>
                @else
                    <img src="{{ asset($sellerProfile->image) }}">
                    <h3 class="trading__user">{{ $sellerProfile->name}}さんとの取引画面</h3>
                    <form class="trade__complete--form" action="/trade/complete/{{$item->id}}" method="POST">
                        @csrf
                        <button class="trade__complete--button">取引を完了する</button>
                    </form>
                @endif
            </div>
            <div class="trading__item">
                <img src="{{ asset($item->image) }}" alt="商品画像">
                <div class="trading__item--information">
                    <h3 class="trading__item--name">{{ $item->name }}</h3>
                    <p class="trading__item--price">￥{{ $item->price }}</p>
                </div>
            </div>
            <div class="chat__messages">
                @foreach ($messages as $message)
                    @if ($message->user_id === $user->id)
                        <div class="message__inner--right">
                            <div class="message__user--profile right">
                                <img src="{{ asset($message->user->profile->image) }}" alt="プロフィール画像">
                                <p class="message__user--name">{{ $message->user->profile->name }}</p>
                            </div>
                            @if ($message->image !== null)
                                <div class="image__content--right">
                                    <img src="{{ asset($message->image) }}" class="message__image">
                                </div>
                            @endif
                            <input type="text" name="message" class="message" value="{{ $message->message }}" form="editForm_{{ $message->id }}">
                            <div class="buttons">
                                <form id="editForm_{{ $message->id }}" class="edit__form" action="/trading/chat/{{$message->id}}/update" method="POST">
                                    @csrf
                                    <button class="edit__button" type="submit">編集</button>
                                </form>
                                <form class="delete__form" action="/trading/chat/{{ $message->id}}/delete" method="POST">
                                    @csrf
                                    <button class="delete__button" type="submit">
                                        削除
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="message__inner--left">
                            <div class="message__user--profile">
                                <img src="{{ asset( $message->user->profile->image) }}" alt="プロフィール画像">
                                <p class="message__user--name">{{ $message->user->profile->name }}</p>
                            </div>
                            @if ($message->image !== null)
                                <img src="{{ asset($message->image) }}" class="message__image">
                            @endif
                            <p class="message">{{ $message->message }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
            <form class="chat__form" action="/trading/chat/{{$room->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="message" class="chat__input" placeholder="取引メッセージを記入してください">
                <div class="image__content">
                    <label class="output__label" for="item__image">
                        <output id="image" class="image__output"></output>
                    </label>
                    <label class="input__label" for="item__image">画像を追加</label>
                    <input type="file" id="item__image" name="item__image" accept="image/*" class="input__image">
                </div>
                <button class="submit__button">
                    <img src="{{ asset('images/inputbutton.jpg') }}" alt="送信ボタン">
                </button>
            </form>
        </div>
    </main>
    <script>
        document.getElementById('item__image').onchange = function(event){

            initializeFiles();

            var files = event.target.files;

            for (var i = 0, f; f = files[i]; i++) {
                var reader = new FileReader;
                reader.readAsDataURL(f);

                reader.onload = (function(theFile) {
                    return function (e) {
                        var div = document.createElement('div');
                        div.className = 'reader_file';
                        div.innerHTML += '<img class="reader_image" src="' + e.target.result + '" />';
                        document.getElementById('image').insertBefore(div, null);
                    }
                })(f);
            }
        };

        function initializeFiles() {
            document.getElementById('image').innerHTML = '';
        }
    </script>
</body>
</html>