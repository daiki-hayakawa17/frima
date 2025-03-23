<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'post',
        'address',
        'building',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
