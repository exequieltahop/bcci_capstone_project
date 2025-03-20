<?php

namespace App\Actions\Employee;

use App\Models\Overtime;

class EmployeeCancelsOvertime
{
    public function execute(Overtime $overtime): void
    {
        $overtime->delete();
    }
}
