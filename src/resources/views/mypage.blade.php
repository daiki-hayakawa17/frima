@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage__profile">
    <div class="profile__icon">
        <img src="{{ asset($profile->image) }}" alt="ユーザーアイコン">
    </div>
    <div>
        <p class="profile__name">{{$profile->name}}</p>
        @if ($averageScore)
            <div class="rating">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="star {{ $i <= $averageScore ? 'active' : ''}}">★</span>
                @endfor
            </div>
        @endif
    </div>
    <a class="profile__link" href="/mypage/profile">プロフィールを編集</a>
</div>
<div class="list__nav" id="list__nav">
    @php
        $totalUnread = $items->sum(function ($item) {
            return $item->room ? $item->room->messages->count() : 0;
        });
    @endphp
    <a href="{{ route('mypage', ['mypage' => 'sell']) }}" class="list__nav--text {{ request('mypage', 'sell') === 'sell' ? 'active' : '' }}">
        出品した商品
    </a>
    <a href="{{ route('mypage', ['mypage' => 'buy']) }}" class="list__nav--text buy {{ request('mypage') === 'buy' ? 'active' : '' }}">
        購入した商品
    </a>
    <a href="{{ route('mypage', ['mypage' => 'trading']) }}" class="list__nav--text trading {{ request('mypage') === 'trading' ? 'active' : '' }}">
        取引中の商品
    </a>
    @if ($totalUnread > 0)
        <p class="total__unread">{{ $totalUnread }}</p>
    @endif
</div>
<div class="line"></div>
<div class="item__contents">
    @if (!empty($items))
    <div class="item__contents--inner">
        @foreach ($items as $item)
            @if ($item->status === 'trading' && request('mypage') === 'trading')
            <div class="item__content">
                @php
                    $unread = $item->room ? $item->room->messages->count() : 0;
                @endphp
                <a href="/trading/chat/{{$item->id}}" class="item__link">
                    @if ($unread > 0)
                        <span class="badge__red">{{ $unread }}</span>
                    @endif
                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}の画像" class="img__content">
                    <div class="detail__content">
                        <p>{{$item->name}}</p>
                    </div>
                </a>
            </div>
            @else
            <div class="item__content">
                <a href="/item/{{$item->id}}" class="item__link">
                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}の画像" class="img__content">
                    <div class="detail__content">
                        <p>{{$item->name}}</p>
                    </div>
                </a>
            </div>
            @endif
        @endforeach
    </div>
    @else
        <div class="hidden"></div>
    @endif
</div>
@endsection