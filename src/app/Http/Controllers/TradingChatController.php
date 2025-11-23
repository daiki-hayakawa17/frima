<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;
use App\Models\Room;
use App\Models\Message;

class TradingChatController extends Controller
{
    public function chatView($item_id) {
        $user = Auth::user();
        $user_id = $user->id;

        $item = Item::find($item_id);

        $seller = $item->user;
        $sellerProfile = $seller->profile;

        $purchaser = User::where('id', $item->purchaser_id)->first();
        $purchaserProfile = $purchaser->profile;
        
        if ($item->user_id === $user_id) {
            $otherItems = Item::where('status', 'trading')
                ->where('user_id', $user_id)->where('id', '!=', $item->id)->get();
        } elseif ($item->purchaser_id === $user_id) {
            $otherItems = Item::where('status', 'trading')
                ->where('purchaser_id', $user_id)
                ->where('id', '!=', $item->id)
                ->get();
        }
        
        $room = Room::whereHas('users', function ($query) use ($seller) {
            $query->where('user_id', $seller->id);
        })->whereHas('users', function ($query) use ($purchaser) {
            $query->where('user_id', $purchaser->id);
        })->first();
        $messages = Message::where('room_id', $room->id);

        
        return view('trading_chat', compact('user', 'item', 'otherItems', 'sellerProfile', 'purchaserProfile', 'room'));
    }

    public function send($room_id, Request $request) {
        $user_id = Auth::id();

        $room = Room::find($room_id);

        $dir = 'images';

        if ($request->file('item__image')) {
            $file = $request->file('item__image');
            $file_name = $file->getClientOriginalName();
            $path = $file->storeAs('public/' . $dir, $file_name);
            $image = 'storage/' . $dir . '/' . $file_name;
        }

        $message = Message::create([
            'room_id' => $room->id,
            'user_id' => $user_id,
            'message' => $request->message,
            'image' => $image,
        ]);

        return back();
    }
}
