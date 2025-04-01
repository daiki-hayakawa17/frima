@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address__content">
    <h2 class="address__title">住所の変更</h2>
    <form class="form" action="/purchase/address/{{$item->id}}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <div class="form__group--post">
            <span class="form__input--label">郵便番号</span>
            <div class="form__input--text">
                <input type="text" name="post">
            </div>
        </div>
        <div class="form__group--address">
            <span class="form__input--label">住所</span>
            <div class="form__input--text">
                <input type="text" name="address">
            </div>
        </div>
        <div class="form__group--building">
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