<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubRole extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function userRoles() {
        return $this->hasMany(UserRole::class);
    }

    public function club() {
        return $this->belongsTo(Club::class);
    }
}
