<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_id',
        'customer_id',
        'payment_agreement_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
