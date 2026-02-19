<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'restaurant_id',
        'food_rating', 'service_rating', 'atmosphere_rating',
        'price_quality_rating', 'rating_interior', 'rating_location',
        'overall_rating', 'impressions', 'pros', 'cons', 'image_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
