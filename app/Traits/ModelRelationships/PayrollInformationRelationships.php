<?php

namespace App\Traits\ModelRelationships;

use App\Models\User;

trait PayrollInformationRelationships
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
