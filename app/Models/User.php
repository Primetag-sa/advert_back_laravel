<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'image',
        'password',
        'role',
        'is_confirm',
        'confirm_at',
        'is_active',
        'active_at',
        'token',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }
    public function agency(): HasOne
    {
        return $this->hasOne(Agency::class);
    }
    public function agent(): HasOne
    {
        return $this->hasOne(Agent::class);
    }

    public function sentNotifications()
    {
        return $this->hasMany(Notification::class, 'sender_id');
    }

    public function receivedNotifications()
    {
        return $this->hasMany(Notification::class, 'received_id');
    }
}
