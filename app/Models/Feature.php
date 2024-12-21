<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'name',
        'price',
        'is_include'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
