<?php

namespace Database\Factories;

use App\Models\Entry;
use App\Models\Overtime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'clock_in' => now()->setHour((int) config('app.clock_in'))->setMinute(0)->setSecond(0),
            'clock_out' => now()->setHour((int) config(key: 'app.clock_out'))->setMinute(0)->setSecond(0),
            'created_by' => 1,
            'updated_by' => 1
        ];
    }

    public function hasOvertime(int $minutes) {
        $this->state(function (array $attributes) use ($minutes) {
            return ['clock_out' => Carbon::parse($attributes['clock_out'])->addMinutes($minutes)];
        })
        ->has(Overtime::factory()->state(function (array $attributes, Entry $entry) use ($minutes) {
            return [
                'user_id' => $entry->user->id,
                'entry_id' => $entry->id,
                'time_start' => Carbon::parse($entry->clock_out)->subMinutes($minutes),
                'time_end' => Carbon::parse($entry->clock_out)->addMinutes($minutes),
                'created_by' => 1,
                'updated_by' => 1
            ];
        }), 'overtime');

        return $this;
    }
}
