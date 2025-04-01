<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use App\Models\Delivery;

class AuthController extends Controller
{
    public function profileView()
    {
        return view('profile');
    }

    public function profileRegister(Request $request, Profile $profile)
    {
        $dir = 'images';

        $file = $request->file('image');
        $file_name = $file->getClientOriginalName();
        $request->file('image')->storeAs('public/' . $dir, $file_name);

        
        $profile_data = $request->only('user_id', 'name', 'image', 'post', 'address', 'building');
        $image = 'storage/' . $dir . '/' . $file_name;
        $profile_data['image'] = $image;
        
        $delivery = $request->only('user_id','post', 'address', 'building');

        Profile::updateOrCreate(
            ['user_id' => $request['user_id']], 
            [
                'user_id' => $profile_data['user_id'],
                'name' => $profile_data['name'],
                'image' => $profile_data['image'],
                'post' => $profile_data['post'],
                'address' => $profile_data['address'],
                'building' => $profile_data['building'],
            ]
        );

        Delivery::create($delivery);

        return redirect('/');
    }

    
}
