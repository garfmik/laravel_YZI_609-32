<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id', 'name', 'description', 'price', 'category', 'image'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
