<div id="search" class="header__search">
    <form action="/">
        <input wire:model.live.debounce.500ms="search" id="search" name="search" placeholder="なにをお探しですか" type="search">
        <div class="list__nav">
            <p class="list__nav--text">おすすめ</p>
            <p class="list__nav--mylist">マイリスト</p>
        </div>
        <div class="item__contents">
        @if (sizeof($results) > 0)
            @foreach ($results as $result)
            <div class="item__content">
                <a href="/item/{{$result->id}}" class="item__link">
                    <img src="{{ asset($result->image) }}" alt="商品画像" class="img__content">
                    <div class="detail__content">
                        <p>{{$result->name}}</p>
                    </div>
                </a>
            </div>
            @endforeach
        @else
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
        @endif
    </div>
    {{ $items->links() }}
    </form>
</div>
