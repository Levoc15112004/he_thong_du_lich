<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id', 'day_number', 'title', 'description', 'location_name', 
        'latitude', 'longitude', 'map_link', 'image'
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
