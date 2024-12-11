<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorEvent extends Model
{
    use HasFactory;

    protected $fillable = ['url','title','event_type','time_spent','click_count','create_at','visitor_id'];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}
