<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCamps extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'camp_id',
        'name',
        'surname',
        'phone_number',
        'email',
        'workplace',
        'payment',
        'invoice',
        'food_choice',
        'special_needs',
        'paid'
    ];

    protected $casts = [
        'user_id' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function camp()
    {
        return $this->belongsTo(Camp::class, 'camp_id');
    }
}
