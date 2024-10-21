<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    use HasFactory;

    protected $table = 'role_access';

    // Définir les colonnes modifiables par Eloquent
    protected $fillable = [
        'role',
        'access',
    ];
}