@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell__content">
    <h2 class="sell__title">商品の出品</h2>
    <form class="sell__form">
        <div class="form__input--image">
            <span class="form__input--label">商品画像</span>
            <div class="image__content">
                <output id="image" class="image__output"></output>
                <label for="item__image">画像を選択する</label>
                <input type="file" id="item__image" name="item__image">
            </div>
        </div>
        <div class="form__item--detail">
            <h3 class="item__subtitle">商品の詳細</h3>
            <div class="under__line"></div>
            <div class="item__detail--category">
                <span class="form__input--label">カテゴリー</span>
                <div class="form__input--category">
                    @foreach($categories as $category)
                    <label>
                        <input type="checkbox" name="category" value="{{$category->content}}">
                        <span>{{$category->content}}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="item__detail--condition">
                <span class="form__input--label">商品の状態</span>
                <div class="form__select">
                    <select class="select__inner" name="condition">
                        <option disabled selected>選択してください</option>
                        <option value="1">良好</option>
                        <option value="2">目立った傷や汚れなし</option>
                        <option value="3">やや傷や汚れあり</option>
                        <option value="4">状態が悪い</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="item__description">
            <h3 class="item__subtitle">商品名と説明</h3>
            <div class="under__line"></div>
            <div class="form__group">
                <span class="form__input--label">商品名</span>
                <div class="form__input--text">
                    <input type="text" name="name">
                </div>
            </div>
            <div class="form__group">
                <span class="form__input--label">ブランド名</span>
                <div class="form__input--text">
                    <input type="text" name="brand">
                </div>
            </div>
            <div class="form__group">
                <span class="form__input--label">商品の説明</span>
                <div class="form__input--text">
                    <textarea name="description"  cols="30" ros="5"></textarea>
                </div>
            </div>
            <div class="form__group">
                <span class="form__input--label">販売価格</span>
                <div class="form__input--text">
                    <input type="text" name="price" value="￥">
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button--submit">出品する</button>
        </div>
    </form>
</div>
@endsection

@section('script')
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
@endsection