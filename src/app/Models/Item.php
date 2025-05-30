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
        return $this->categories->contains('id', $category->id) ? 'yes' : 'no';
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)){
            $query->where('name', 'like', '%' . $keyword . '%');
        }
    }

    public function isLikedByAuthUser()
    {
        return $this->likes->contains('user_id', Auth::id());
    }
}

