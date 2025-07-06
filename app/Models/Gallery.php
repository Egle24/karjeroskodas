<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug','camp_id', 'description'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($gallery) {
            $gallery->slug = Str::slug($gallery->title . '-galerija');
        });

        static::saving(function ($gallery) {
            $camp = $gallery->camp;
            $gallery->title = $camp->title;
            $gallery->description = $camp->description;
        });
    }

    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }

    public function images()
    {
        return $this->hasMany(GalleryImages::class);
    }

    public function files()
    {
        return $this->hasMany(GalleryFiles::class);
    }

}
