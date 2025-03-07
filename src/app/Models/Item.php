<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'brand',
        'price',
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
        return $this->hasMany(Like::class, 'item_id');
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
}
