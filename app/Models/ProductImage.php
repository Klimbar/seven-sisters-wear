<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $appends = ['url'];

    public function getUrlAttribute(): string
    {
        return $this->image_path;
    }
}
