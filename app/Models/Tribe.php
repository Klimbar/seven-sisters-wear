<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tribe extends Model
{
    protected $fillable = [
        'name', 'slug', 'state_id', 'description', 'image'
    ];

    public function state(): BelongsTo`
    {
        return $this->belongsTo(State::class);
    }

    public function sellers(): HasMany`
    {
        return $this->hasMany(Seller::class);
    }

    public function products(): HasMany`
    {
        return $this->hasMany(Product::class);
    }
}
