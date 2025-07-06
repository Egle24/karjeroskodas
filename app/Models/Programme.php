<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function images()
    {
        return $this->hasMany(ProgrammeImages::class);
    }

    public function camps()
    {
        return $this->hasMany(Camp::class);
    }

}
