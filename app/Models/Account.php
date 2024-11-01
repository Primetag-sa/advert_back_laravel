<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'business_name',
        'timezone',
        'timezone_switch_at',
        'account_id',
        'salt',
        'approval_status',
        'deleted',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
