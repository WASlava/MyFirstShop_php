<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Визначте зв'язок з користувачами
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
