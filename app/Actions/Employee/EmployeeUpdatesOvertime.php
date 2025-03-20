<?php

namespace App\Actions\Employee;

use App\Models\{Entry, Overtime, User};

class EmployeeUpdatesOvertime
{
    public function execute(User $user, Overtime $overtime, array $attributes): Overtime|bool
    {
        $entry = Entry::find($attributes['entry_id']);

        [$startHour, $startMinute] = explode(':', $attributes['time_start']);
        [$endHour, $endMinute]     = explode(':', $attributes['time_end']);

        $timeStart = $entry->clock_in->copy()->setTime($startHour, $startMinute);
        $timeEnd   = $entry->clock_out->copy()->setTime($endHour, $endMinute);

        $attributes = [
            'entry_id'   => $entry->id,
            'user_id'    => $user->id,
            'time_start' => $timeStart,
            'time_end'   => $timeEnd,
            'purpose'    => $attributes['purpose'],
        ];

        $overtime->update($attributes);

        return $overtime;
    }
}
