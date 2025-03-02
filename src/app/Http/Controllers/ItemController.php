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
}
