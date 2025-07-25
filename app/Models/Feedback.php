<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'feedback',
        'status'
    ];

    protected $casts = [
        'user_id' => 'string',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
