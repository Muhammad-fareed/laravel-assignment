<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function feedback()
{
    return $this->hasMany(Feedback::class);
}
}
