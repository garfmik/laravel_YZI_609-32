<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Рестораны с этим тегом
    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_tag');
    }
}
