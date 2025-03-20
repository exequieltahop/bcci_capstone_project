<?php

namespace App\Traits\ModelRelationships;

use App\Models\Deduction;
use App\Models\EmployeeLeaveInformation;
use App\Models\EmploymentDetail;
use App\Models\Entry;
use App\Models\Leave;
use App\Models\Overtime;
use App\Models\PayrollInformation;
use App\Models\Role;

trait UserRelationships
{
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function employmentDetail()
    {
        return $this->hasOne(EmploymentDetail::class);
    }

    public function payrollInformation()
    {
        return $this->hasOne(PayrollInformation::class);
    }

    public function deductions()
    {
        return $this->hasMany(Deduction::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function leaveInformation()
    {
        return $this->hasOne(EmployeeLeaveInformation::class, 'user_id');
    }

    public function overtimes()
    {
        return $this->hasMany(Overtime::class, 'user_id');
    }

    public function entries()
    {
        return $this->hasMany(Entry::class, 'user_id');
    }
}
