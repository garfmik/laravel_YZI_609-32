<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id', 'title', 'description',
        'event_date', 'event_time', 'price', 'image'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
