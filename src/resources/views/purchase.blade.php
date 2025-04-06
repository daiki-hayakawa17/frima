@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<form class="purchase__form" action="/purchase/{{$item->id}}" method="post">
    @csrf
    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
    <div class="left__content">
        <div class="left__content--item">
            <div class="item__image">
                <img src="{{ asset($item->image) }}" alt="商品画像">
            </div>
            <div class="item__text">
                <h2 class="item__text--name">{{$item->name}}</h2>
                <span class="item__text--price"><span>￥</span>{{$item->price}}</span>
            </div>
        </div>
        <div class="under__line--item"></div>
        <div class="left__content--pay">
            <h3 class="form__input--label">支払い方法</h3>
            <div class="form__select">
                <select class="select__inner" name="pay" id="pay">
                    <option disabled selected>選択してください</option>
                    <option value="1">コンビニ払い</option>
                    <option value="2">カード支払い</option>
                </select>
            </div>
            <div class="form__error">
                @error('pay')
                {{ $message }}
                @enderror
            </div>
            <div class="under__line--pay"></div>
        </div>
        <div class="left__content--address">
            <div class="address__header">
                <h3>配送先</h3>
                <a class="destination__link" href="/purchase/address/{{$item->id}}">変更する</a>
            </div>
            <div class="address__content">
                <input type="hidden" name="delivery_id" value="{{$delivery->id}}">    
                <p>〒 {{$delivery->post}}</p>
                <input type="hidden" name="post" value="{{$delivery->post}}">
                <p>{{$delivery->address}} {{$delivery->building}}</p>
                <input type="hidden" name="address" value="{{$delivery->address}}">
                <input type="hidden" name="building" value="{{$delivery->building}}">
            </div>
            <div class="form__error">
                @error('delivery_id')
                {{ $message }}
                @enderror
            </div>
            <div class="under__line--address"></div>
        </div>
    </div>
    <div class="right__content">
        <table class="pay__confirm">
            <tr>
                <th>商品代金</th>
                <td><span>￥</span>{{$item->price}}</td>
            </tr>
            <tr>
                <th>支払い方法</th>
                <td>
                    <textarea name="output" id="output">コンビニ払い</textarea>
                </td>
            </tr>
        </table>
        <div class="form__button">
            <button class="form__button--submit" type="submit">購入する</button>
        </div>
    </div>
</form>
@endsection

@section('script')
<script>
    const outputpay = () => {
        const pay = document.getElementById("pay");
        const output = document.getElementById("output");
        const payIndex = pay.selectedIndex;
        output.value = pay.options[payIndex].textContent;
    }
    document.getElementById("pay").onchange = outputpay;
</script>
@endsection