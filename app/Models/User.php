<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\PasswordReset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use HasRoles;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'surname',
        'profile_image',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isUserMember(): bool
    {
        if($this->hasRole('member')){
            return true;
        }
        return false;
    }
    public function isUserAdmin(): bool
    {
        if($this->hasRole('admin')){
            return true;
        }
        return false;
    }

    public function registrations()
    {
        return $this->hasMany(UserCamps::class);
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Memberships::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }

}
