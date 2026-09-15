<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TourAttr extends Pivot
{
    protected $table = 'tour_attr';
    
    protected $fillable = ['tour_id', 'attr_tour_id'];
}
