<?php

namespace App\Models;

use App\Traits\Modifiers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveType extends Model
{
    use HasFactory, Modifiers;

    protected $guarded = [];

    public function prettyIsPaid()
    {
        return $this->is_paid ? 'PAID' : 'NOT PAID';
    }

    public function employeeLeaveInformation()
    {
        return $this->hasMany(EmployeeLeaveInformation::class, 'leave_type_id');
    }
}
