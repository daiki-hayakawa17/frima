@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="list__nav" id="list__nav">
    <a href="{{ route('index') }}" class="list__nav--text" id="navButton">
        <p id="text">おすすめ</p>
    </a>
    <a href="{{ route('index', ['page' => 'mylist']) }}" class="list__nav--text mylist" id="navButton">
        <p id="text">マイリスト</p>
    </a>
</div>

<div class="item__contents">
    @if (!empty($items))
    <div class="item__content--inner">
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
    @else
        <div class="hidden"></div>
    @endif
</div>
@endsection

@section('script')
<script>
    document.querySelectorAll('.list__nav--text').forEach(link => {
        link.addEventListener('click', function(){

            document.querySelectorAll('.list__nav--text').forEach(l => l.classList.remove('active'));

            this.classList.add('active');
        });
    });
</script>
@endsection