<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\Profile;


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
        
        // dd($item_id);
        return view('purchase', compact('item', 'delivery'));
    }

    public function buy($item_id, Request $request)
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

    public function addressUpdate($item_id, Request $request)
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

    public function itemRegister(Request $request)
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
        
    }
}
