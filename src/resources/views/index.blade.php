@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="list__nav" id="list__nav">
    <p class="list__nav--text">おすすめ</p>
    <p class="list__nav--mylist">マイリスト</p>
</div>

<div class="item__contents">
    @foreach ($items as $item)
        @if ($item['seller_id'] == Auth::id())
            <div class="hidden"></div>
        @elseif (empty($item['purchaser_id']))
            <div class="item__content">
                <a href="/item/{{$item->id}}" class="item__link">
                    <img src="{{ asset($item->image) }}" alt="商品画像" class="img__content">
                    <div class="detail__content">
                        <p>{{$item->name}}</p>
                    </div>
                </a>
            </div>
        @else 
            <div class="sold__item">
                <p>sold</p>
            </div>
        @endif
    @endforeach
</div>
{{ $items->links('pagination::default') }}
@endsection