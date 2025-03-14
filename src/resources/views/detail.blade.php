@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="detail__content">
    <div class="left__content">
        <div class="item__image">
            <img src="{{ asset($item->image) }}" alt="商品画像" class="img-content">
            <input type="hidden" name="image" value="{{$item->image}}">
        </div>
    </div>
    <div class="right__content">
        <div class="form">
            <div class="item__title">
                <h2 class="item__name">{{ $item->name }}</h2>
                <input type="hidden" name="name" value="{{$item->name}}">
                <p class="brand__name">
                    {{ $item->brand }}
                </p>
                <p class="item__price">
                    ￥<span class="price">{{ $item->price }}</span>(税込)
                </p>
                <input type="hidden" name="price" value="{{$item->price}}">
                <div class="icons">
                    <button class="like__button">
                        <img src="{{ asset('storage/images/like-button.png') }}" alt="いいねボタン">
                    </button>
                    <div class="comment__icon">
                        <img src="{{ asset('storage/images/comment-icon.png') }}" alt="コメントアイコン">
                    </div>
                </div>
            </div>
            <div class="buy__button">
                <a href="/purchase/{{$item->id}}" class="buy__button--submit">
                    購入手続きへ
                </a>
            </div>
        </div>
        <div class="item__description">
            <h2 class="description__title">商品説明</h2>
            <p class="description__content">
               {{ $item->description }} 
            </p>
        </div>
        <div class="item__information">
            <h2 class="information__title">商品の情報</h2>
            <div class="information__category">
                <p class="subtitle__category">カテゴリー</p>
                <div class="category__content">
                    @foreach($categories as $category)
                        @if($item->checkCategory ($category,$item) == "no")
                            <input type="hidden" id="category" value="{{$category->id}}">
                        @elseif($item->checkCategory ($category,$item) == "yes")
                            <p class="category__icon">
                            {{$category->content}}
                            </p>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="information__status">
                <p class="subtitle__status">商品の状態</p>
                <p class="status__content">
                    @if($item['condition'] == 1)
                    良好
                    @elseif($item['condition'] == 2)
                    目立った傷や汚れなし
                    @elseif($item['condition'] == 3)
                    やや傷や汚れあり
                    @else
                    状態が悪い
                    @endif
                </p>
            </div>
        </div>
        <div class="item__comment">

        </div>
    </div>
</div>
@endsection