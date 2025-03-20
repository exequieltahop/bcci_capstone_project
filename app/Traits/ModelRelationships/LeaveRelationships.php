<?php

namespace App\Traits\ModelRelationships;

use App\Models\LeaveType;
use App\Models\User;

trait LeaveRelationships
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }
}
