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
<div class="list__nav">
    <a class="list__nav--sell">出品した商品</a>
    <a class="list__nav--purchase">購入した商品</a>
</div>
<div class="mypage__content">
    
</div>
@endsection