<p>{{ $item->user->name }}様</p>

<p>以下の内容で取引が完了されました</p>

<ul>
    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" style="max-width: 200px;"> 
    <li>取引商品:{{ $item->name }}</li>
    <li>価格:￥{{ $item->price }}</li>
    <li>購入者:{{ $purchaser->name }}</li>
</ul>