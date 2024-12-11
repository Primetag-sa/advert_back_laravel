<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountsX extends Model
{
    protected $table = 'accounts_x';

    use HasFactory;

    protected $fillable = [
        'name',
        'business_name',
        'timezone',
        'timezone_switch_at',
        'account_id',
        'salt',
        'approval_status',
        'deleted',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
