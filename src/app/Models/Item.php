<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_id',
        'seller_id',
        'purchaser_id',
        'pay',
        'name',
        'image',
        'brand',
        'price',
        'condition',
        'description'
    ];

    public function categories()
    {
        return $this->belongsTomany(Category::class,
        'item_category','item_id','category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function deliveries()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function checkCategory($category,$item)
    { 
        $category_id = $category->id;
        $item_id = $item->id;

        $item_data = Item::find($item_id);
        $itemCategories = $item_data->categories; 
        
        foreach ($itemCategories as $itemCategory) 
        {
            if($itemCategory->id == $category_id)
            {
                $returnTxt ="yes";

                return $returnTxt;
            }
        }
        
        if($itemCategory->id != $category_id)
        {
            $returnTxt ="no";

            return $returnTxt;
        }
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)){
            $query->where('name', 'like', '%' . $keyword . '%');
        }
    }

    public function is_liked_by_auth_user()
    {
        $id = Auth::id();

        $likers = array();
        // dd($this->likes);
        foreach($this->likes as $like) {
            array_push($likers, $like->user_id);
        }

        if (in_array($id, $likers)) {
            return true;
        } else {
            return false;
        }
       
    }
}

