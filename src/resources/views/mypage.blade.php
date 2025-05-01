@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage__profile">
    <div class="profile__icon">
        <img src="{{ asset($profile->image) }}" alt="ユーザーアイコン">
    </div>
    <p class="profile__name">{{$profile->name}}</p>
    <a class="profile__link" href="/mypage/profile">プロフィールを編集</a>
</div>
<div class="list__nav" id="list__nav">
    <a href="{{ route('mypage', ['mypage' => 'sell']) }}" class="list__nav--text {{ request('mypage', 'sell') === 'sell' ? 'active' : '' }}">
        出品した商品
    </a>
    <a href="{{ route('mypage', ['mypage' => 'buy']) }}" class="list__nav--text buy {{ request('mypage') === 'buy' ? 'active' : '' }}">
        購入した商品
    </a>
</div>
<div class="item__contents">
    @if (!empty($items))
    <div class="item__contents--inner">
        @foreach ($items as $item)
            @if (!empty($item['purchaser_id']))
                <div class="item__content">
                    <a href="/item/{{$item->id}}" class="item__link">
                        <img src="{{ asset($item->image) }}" alt="商品画像" class="img__content">
                        <div class="detail__content">
                            <p>{{$item->name}}</p>
                        </div>
                    </a>
                </div>
            @elseif ($item['seller_id'] === Auth::id())
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
    @else
        <div class="hidden"></div>
    @endif
</div>
@endsection

@section('script')
<script>
    
</script>
@endsection