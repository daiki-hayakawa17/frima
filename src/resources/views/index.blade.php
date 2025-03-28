@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="list__nav">
    <p class="list__nav--text">おすすめ</p>
    <p class="list__nav--mylist">マイリスト</p>
</div>

<div class="item__contents">
    @foreach ($items as $item)
        <div class="item__content">
            <a href="/item/{{$item->id}}" class="item__link">
                <img src="{{ asset($item->image) }}" alt="商品画像" class="img__content">
                <div class="detail__content">
                    <p>{{$item->name}}</p>
                </div>
            </a>
        </div>
    @endforeach
</div>
{{ $items->links() }}
@endsection