<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\Profile;
use App\Models\Like;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\PurchaseRequest;


class ItemController extends Controller
{
    public function index()
    {
        $items = Item::paginate(8);
        
        return view('index', compact('items'));
    }

    public function detail($item_id)
    {
        $item = Item::find($item_id);
        $categories = Category::all();

        return view('detail', compact('item', 'categories'));
    }

    public function purchase($item_id)
    {
        $item = Item::find($item_id);

        $delivery = Delivery::where('user_id', \Auth::user()->id)->first(['id', 'post', 'address', 'building']);
        
        // dd($delivery);
        return view('purchase', compact('item', 'delivery'));
    }

    public function buy($item_id, PurchaseRequest $request)
    {
        $item = Item::find($item_id);

        $purchaser_id = $request['user_id'];
        $item['purchaser_id'] = $purchaser_id;

        $delivery_id = $request['delivery_id'];
        $item['delivery_id'] = $delivery_id;

        $item->save();

        return redirect('/');
    }

    public function addressView($item_id)
    {
        $item = Item::find($item_id);

        // dd($item);
        return view('address', compact('item'));
    }

    public function addressUpdate($item_id, AddressRequest $request)
    {
        
        $item = Item::find($item_id);

        $delivery = $request->only('post', 'address', 'building');
        $user_id = $request['user_id'];

        $address = Delivery::find($user_id);

        $address->update($delivery);

        // dd();
        return redirect(route('purchase', $item_id));
    }

    public function registerView()
    {
        return view('auth.register');
    }
    
    public function sellView()
    {
        $categories = Category::all();

        return view('sell', compact('categories'));
    }

    public function itemRegister(ExhibitionRequest $request)
    {
        $dir = 'images';

        $file = $request->file('item__image');
        $file_name = $file->getClientOriginalName();
        $request->file('item__image')->storeAs('public/' . $dir, $file_name);

        $item_data = $request->only('seller_id',  'name', 'image', 'price', 'condition', 'brand', 'description');
        $image = 'storage/' . $dir . '/' . $file_name;
        $item_data['image'] = $image;

        $category = $request->categories;

        $item = Item::create($item_data);
        $item->categories()->attach($category);

        $items = Item::paginate(8);

        // dd($category);
        return redirect('/');
    }

    public function mypageView()
    {
        $items = Item::all();

        $profile = Profile::where('user_id', \Auth::user()->id)->first(['id', 'image', 'name']);

        // dd($profile);
        return view('mypage', compact('items', 'profile'));
    }

    public function search(Request $request)
    {
        $items = Item::with('categories')->KeywordSearch($request->keyword)->paginate(8);


        return view('index', compact('items'));
    }

    public function like($item_id)
    {
        Like::create([
            'item_id' => $item_id,
            'user_id' => Auth::id(),
        ]);

        // dd($item_id);
        return redirect(route('detail', $item_id));
    }

    public function unlike($item_id)
    {
        $like = Like::where('item_id', $item_id)->where('user_id', Auth::id())->first();
        $like->delete();

        return redirect(route('detail', $item_id));
    }
}
