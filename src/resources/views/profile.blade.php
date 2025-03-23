@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile__content">
    <h2 class="profile__title">プロフィール設定</h2>
    <form class="profile__register--form" action="/mypage/profile" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <div class="form__input--image">
            <output id="image" class="image__output"></output>
            <label for="profile__image">画像を選択する</label>
            <input type="file" id="profile__image" name="image">
        </div>
        <div class="form__group">
            <span class="form__input--label">ユーザー名</span>
            <div class="form__input--text">
                <input type="text" name="name">
            </div>
        </div>
        <div class="form__group">
            <span class="form__input--label">郵便番号</span>
            <div class="form__input--text">
                <input type="text" name="post">
            </div>
        </div>
        <div class="form__group">
            <span class="form__input--label">住所</span>
            <div class="form__input--text">
                <input type="text" name="address">
            </div>
        </div>
        <div class="form__group">
            <span class="form__input--label">建物名</span>
            <div class="form__input--text">
                <input type="text" name="building">
            </div>
        </div>
        <div class="form__button">
            <button class="form__button--submit">更新する</button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
        document.getElementById('profile__image').onchange = function(event){

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
@endsection