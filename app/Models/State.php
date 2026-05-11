<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'image',
    ];

    public function tribes(): HasMany
    {
        return $this->hasMany(Tribe::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
