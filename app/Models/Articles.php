<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'image', 'date', 'link', 'status', 'category_id', 'camp_id'];

    protected $casts = [
    'date' => 'datetime:Y-m-d',
];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }


}
