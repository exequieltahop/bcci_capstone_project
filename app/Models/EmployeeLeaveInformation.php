<?php

namespace App\Models;

use App\Traits\Modifiers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveInformation extends Model
{
    use HasFactory, Modifiers;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function prettyCredit()
    {
        return $this->is_paid ? 'Paid' : 'Not Paid';
    }
}
