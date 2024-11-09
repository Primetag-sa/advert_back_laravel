<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'snapchat_id',
        'snapchat_name',
        'snapchat_email',
        'snapchat_avatar',
        'snapchat_display_name',
        'snapchat_member_status',
        'snapchat_username',
        'twitter_access_token',
        'twitter_access_token_secret',
        'twitter_account_id',
        'snapchat_access_token',
        'snapchat_refresh_token',
        'snapchat_organization_id',
        'snapchat_token_expires_at',
        'tracking_website',
        'tracking_client_id',
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

    protected $appends = [
        'avatar',
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

    public function getAvatarAttribute()
    {
        if ($this->image) {
            // Generate the full URL using the 'public' disk
            return Storage::disk('public')->url($this->image);
        }

        // Return the URL to a default avatar if no custom avatar exists
        return asset('profile1.jpg');
    }

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

    public function snapchatAccounts()
    {
        return $this->hasMany(SnapchatAccount::class,);
    }

    public function receivedNotifications()
    {
        return $this->hasMany(Notification::class, 'received_id');
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(AccountsX::class);
    }
}
