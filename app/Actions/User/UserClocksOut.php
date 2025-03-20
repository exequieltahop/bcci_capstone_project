<?php

namespace App\Actions\User;

use App\Models\{Entry, User};
use Illuminate\Support\Carbon;

class UserClocksOut
{
    public function execute(User $user, array $attributes = []): Entry|bool
    {
        $entry = Entry::whereDate('clock_in', Carbon::today())
            ->whereNull('clock_out')
            ->first();

        $entry->update([
            ...$attributes,
            'clock_out'  => Carbon::now(),
            'updated_by' => $user->id,
        ]);

        return $entry;
    }
}
