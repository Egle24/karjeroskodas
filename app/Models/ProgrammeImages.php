<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgrammeImages extends Model
{
    use HasFactory;

    protected $fillable = ['image_path', 'programme_id'];

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }
}
