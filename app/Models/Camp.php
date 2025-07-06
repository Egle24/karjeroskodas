<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Camp extends Model
{
    use HasFactory;


    public static function boot()
    {
        parent::boot();

        static::creating(function ($camp) {
            $camp->slug = Str::slug($camp->title . ' ' . $camp->description);
        });

        static::updating(function ($camp) {
            $camp->slug = Str::slug($camp->title . ' ' . $camp->description);
        });
    }

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'main_image',
        'address',
        'priceForGuests',
        'priceForMembers',
        'foodChoice',
        'accommodation',
        'clothing',
        'worth',
        'audience',
        'programme_id',
        'status'

    ];

    public function programme()
    {
        return $this->belongsTo(Programme::class, 'programme_id');
    }

    public function registrations()
    {
        return $this->hasMany(UserCamps::class);
    }

    public function gallery()
    {
        return $this->hasOne(Gallery::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public static function calculateTotalPayments()
    {
        $userCamps = UserCamps::all();

        $totalPayment = 0;

        foreach ($userCamps as $userCamp) {

            if ($userCamp->paid === 'no') {
                continue;
            }

            $camp = $userCamp->camp;

            $price = $userCamp->user_id ? $camp->priceForMembers : $camp->priceForGuests;

            $totalPayment += $price;
        }

        return $totalPayment;
    }
}
