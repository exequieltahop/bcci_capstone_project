<?php

namespace App\Traits\ModelRelationships;

use App\Models\User;

trait RoleRelationships
{
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
