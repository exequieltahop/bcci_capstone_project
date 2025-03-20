<?php

namespace App\Actions\Employee;

use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Models\{Overtime, User};

class EmployeeApprovesOvertime
{
    public function execute(User $causer, Overtime $overtime, array $attributes = []): void
    {
        $overtime->loadMissing([
            'employee:id,first_name,last_name',
            'employee.employmentDetail:id,user_id,manager_id,supervisor_id',
            'employee.employmentDetail.supervisor:id,first_name,last_name',
            'employee.employmentDetail.manager:id,first_name,last_name'
        ]);

        $overtime->comment = isset($attributes['comment']) ? $attributes['comment'] : $overtime->comment;

        $supervisor = $overtime->employee->employmentDetail?->supervisor;
        $manager    = $overtime->employee->employmentDetail?->manager;

        if($causer->role->name == RoleEnum::ADMIN->value || $causer->can_approve) {
            $overtime->is_sp_approved = true;
            $overtime->is_mng_approved = true;
        }

        if ($supervisor && $supervisor->id === $causer->id) {
            $overtime->is_sp_approved = true;
        }

        if ($manager && $manager->id === $causer->id) {
            $overtime->is_mng_approved = true;
        }

        if ($overtime->is_sp_approved && $overtime->is_sp_approved) {
            $overtime->status = StatusEnum::APPROVED;
        }

        $overtime->save();
    }
}
