<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyAdmin extends Model
{
    use HasFactory;

    protected $fillable = ['agency_id','user_id', 'name', 'email', 'password', 'permissions'];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'agency_admin_user');
    }
}
