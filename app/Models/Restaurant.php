<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'address', 'city', 'phone',
        'website', 'average_price', 'opening_hours', 'average_rating',
    ];

    public function cuisines()
    {
        return $this->belongsToMany(Cuisine::class, 'restaurant_cuisine');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'restaurant_tag');
    }

    // Изображения ресторана
    public function images()
    {
        return $this->hasMany(RestaurantImage::class);
    }

    // Отзывы
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Избранные
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // События
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // Меню
    public function menu()
    {
        return $this->hasMany(Menu::class);
    }
}
