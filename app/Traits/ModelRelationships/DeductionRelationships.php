<?php

namespace App\Traits\ModelRelationships;

use App\Models\Benefit;
use App\Models\User;

trait DeductionRelationships
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function benefit()
    {
        return $this->belongsTo(Benefit::class);
    }
}
