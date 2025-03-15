<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;

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
        

        return view('purchase', compact('item'));
    }

    public function loginView()
    {
        return view('auth.login');
    }

    public function registerView()
    {
        return view('auth.register');
    }

    public function profileRegister()
    {
        return view('profile');
    }

    public function sellView()
    {
        $categories = Category::all();

        return view('sell', compact('categories'));
    }

    public function addressView($item_id)
    {
        return view('address');
    }
}
