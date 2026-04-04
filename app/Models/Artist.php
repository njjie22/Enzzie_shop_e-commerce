<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artist extends Model
{
    protected $fillable = ['name', 'slug', 'avatar', 'image'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($artist) {
            if (empty($artist->slug)) {
                $artist->slug = Str::slug($artist->name);
            }
        });
    }

    public function merches()
    {
        return $this->hasMany(Merch::class);
    }

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }

    public function getPhotoAttribute()
    {
        return $this->avatar ?? $this->image;
    }
}