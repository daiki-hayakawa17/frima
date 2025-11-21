<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\Profile;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Room;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\CommentRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;


class ItemController extends Controller
{
    public function index(Request $request)
    {
        $page = request()->query('page');
        $query = Item::with('categories');

        if ($request->filled('keyword')) {
            $query->keywordSearch($request->keyword);
        }

        $user = Auth::user();
        
        if ($page != 'mylist') {
            $items = $query->when(isset($user), function ($q) use ($user) {
                return $q->where('user_id', '!=', $user->id);
            })->get();
            return view('index', compact('items'));
        }
        
        
        $items = null;
        if (isset($user)) {
            $items = Item::whereHas('likes', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->when($request->filled('keyword'), function ($q) use ($request){
                return $q->keywordSearch($request->keyword);
            })
            ->where('user_id', '!=', $user->id)
            ->get();
        }
        
        return view('index', compact('items'));
    }

    public function detail($item_id)
    {
        $item = Item::find($item_id);
        $categories = Category::all();

        $comments = Comment::where('item_id', $item_id)->with('user.profile')->get();

        return view('detail', compact('item', 'categories', 'comments'));
    }

    public function purchase($item_id)
    {
        $item = Item::find($item_id);

        $delivery = Delivery::where('user_id', \Auth::user()->id)->first(['id', 'post', 'address', 'building']);
        
        return view('purchase', compact('item', 'delivery'));
    }

    public function buy($item_id, PurchaseRequest $request)
    {
        $item = Item::find($item_id);

        $seller = $item->user;

        $purchaser = Auth::user();
        
        $delivery_id = $request['delivery_id'];

        $pay = $request['pay'];

        $item->update([
            'delivery_id' => $delivery_id,
            'purchaser_id' => $purchaser->id,
            'pay' => $pay,
            'status' => 'trading',
        ]);

        $room = Room::create();

        $room->users()->attach([$seller->id, $purchaser->id]);

        return redirect('/');
    }

    public function addressView($item_id)
    {
        $item = Item::find($item_id);

        $delivery = Delivery::where('user_id', \Auth::user()->id)->first(['id', 'post', 'address', 'building']);

        // dd($item);
        return view('address', compact('item', 'delivery'));
    }

    public function addressUpdate($item_id, AddressRequest $request)
    {
        
        $item = Item::find($item_id);

        $delivery = $request->only('post', 'address', 'building');
        $user_id = Auth::id();

        $address = Delivery::where('user_id', $user_id)->first();

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

        $item_data = $request->only('name', 'image', 'price', 'condition', 'brand', 'description');
        $image = 'storage/' . $dir . '/' . $file_name;
        $item_data['image'] = $image;
        $item_data['user_id'] = Auth::id();

        $category = $request->categories;

        $item = Item::create($item_data);
        $item->categories()->attach($category);

        return redirect('/');
    }

    public function mypageView()
    {
        $mypage = request()->query('mypage', 'sell');
        $user_id = Auth::id();
        if ($mypage === 'buy') {
            $items = Item::where('purchaser_id', $user_id)->where('status', 'sold')->get();
        } elseif ($mypage === 'sell') {
            $items = Item::where('user_id', $user_id)->get();
        } elseif ($mypage === 'trading') {
            $items = Item::where('status', 'trading')->where(function ($query) use ($user_id) {
                $query->where('user_id', $user_id)->orWhere('purchaser_id', $user_id);
            })->get();
        }

        $profile = Profile::where('user_id', $user_id)->first(['id', 'image', 'name']);

        return view('mypage', compact('items', 'profile'));
    }

    public function search(Request $request)
    {
        $items = Item::with('categories')->KeywordSearch($request->keyword)->get();


        return view('index', compact('items'));
    }

    public function like($item_id)
    {
        $user_id = Auth::id();

        $alreadyLiked = Like::where('item_id', $item_id)->where('user_id', $user_id)->exists();

        if (!$alreadyLiked) {
            Like::create([
                'item_id' => $item_id,
                'user_id' => Auth::id(),
            ]);
        }

        return redirect(route('detail', $item_id));
    }

    public function unlike($item_id)
    {
        $like = Like::where('item_id', $item_id)->where('user_id', Auth::id())->first();
        $like->delete();

        return redirect(route('detail', $item_id));
    }

    public function comment($item_id, CommentRequest $request)
    {
        $item = Item::find($item_id);

        Comment::create([
            'comment' => $request->comment,
            'item_id' => $item_id,
            'user_id' => Auth::id(),
        ]);

        return redirect(route('detail', $item_id));
    }
}
