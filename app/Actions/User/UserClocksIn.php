<?php

namespace App\Actions\User;

use App\Models\{Entry, User};
use Illuminate\Support\Carbon;

class UserClocksIn
{
    public function execute(User $user, array $attributes = []): Entry|bool
    {
        if ($this->hasExistingEntry($user)) {
            return false;
        }

        $entry = Entry::create([
            'user_id'  => $user->id,
            'clock_in' => Carbon::now(),
        ]);

        return $entry;
    }

    private function hasExistingEntry(User $user): bool
    {
        $entry = Entry::whereDate('clock_in', Carbon::today())
            ->whereNull('clock_out')
            ->where('user_id', $user->id)
            ->first();

        return $entry !== null;
    }
}
