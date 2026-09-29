<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, \Kalnoy\Nestedset\NodeTrait;

    protected $fillable = ['name', 'category_id', 'link', 'status', '_lft', '_rgt', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }
}
