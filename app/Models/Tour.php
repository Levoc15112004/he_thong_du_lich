<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'time', 'price', 'sale_price', 'image', 'description', 
        'start_location', 'end_location', 'status', 'category_id', 
        'quantity', 'start_date', 'embedding'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attrTours()
    {
        return $this->belongsToMany(AttrTour::class, 'tour_attr');
    }

    public function images()
    {
        return $this->hasMany(ImageTour::class);
    }

    public function schedules()
    {
        return $this->hasMany(TourSchedule::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}
