<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuisine extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Рестораны этой кухни
    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_cuisine');
    }
}
