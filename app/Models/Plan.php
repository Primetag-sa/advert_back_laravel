<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'period_type',
        'base_price',
        'min_users',
        'max_users',
        'total_price',
        'user_cost'
    ];

    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}
