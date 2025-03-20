<?php

namespace App\Traits\ModelRelationships;

use App\Models\Position;
use App\Models\User;

trait EmploymentDetailRelationships
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }
}
