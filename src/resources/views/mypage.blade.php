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
    <ul class="tab-contena">
        <li class="tab-elem" data-tabid="tab-page1">
            出品した商品
        </li>
        <li class="tab-elem" data-tabid="tab-page2">
            購入した商品
        </li>
    </ul>
    <div class="tab-body" id="tab-body">
        <div class="tab__body--elem" id="tab-page1">
            @foreach ($items as $item)
                @if ($item['seller_id'] === Auth::id() )
                    <div class="item__content">
                        <a href="/item/{{$item->id}}" class="item__link">
                            <img src="{{ asset($item->image) }}" alt="商品画像" class="img__content">
                            <div class="detail__content">
                                <p>{{$item->name}}</p>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
        {{ $items->links() }}
        <div class="tab__body--elem" id="tab-page2">
            @foreach ($items as $item)
                @if ($item['purchaser_id'] === Auth::id() )
                    <div class="item__content">
                        <a href="/item/{{$item->id}}" class="item__link">
                            <img src="{{ asset($item->image) }}" alt="商品画像" class="img__content">
                            <div class="detail__content">
                                <p>{{$item->name}}</p>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
        {{ $items->links() }}
    </div>
</div>
@endsection

@section('script')
<script>
    let tabs = document.getElementById('list__nav').getElementsByClassName('tab-elem');
    let pages = document.getElementById('tab-body').getElementsByClassName('tab__body--elem');

    function changeTab() {
        let targetId = this.dataset.tabid;

        for (let i = 0; i < pages.length; i++) {
            if (pages[i].id != targetId) {
                pages[i].style.display = "none";
            } else {
                pages[i].style.display = "flex";
            }
        }

        for (let i = 0; i < tabs.length; i++)
        {
            tabs[i].classList.remove('active');
        }
        this.classList.add('active');
    }

    for (let i = 0; i < tabs.length; i++) {
        tabs[i].onclick = changeTab;
    }

    tabs[0].onclick();
</script>
@endsection