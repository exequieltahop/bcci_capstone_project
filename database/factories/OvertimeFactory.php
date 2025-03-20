<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\Entry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Overtime>
 */
class OvertimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $entry = Entry::inRandomOrder()->first();
        return [
            'entry_id' => $entry?->id,
            'user_id' => User::factory(),
            'time_start' =>  Carbon::parse($entry?->clock_in)->subMinutes(120),
            'time_end' => Carbon::parse($entry?->clock_in)->addMinutes(120),
            'purpose' => fake()->sentence(6),
            'comment' => '',
            'status' => StatusEnum::APPROVED,
            'is_sp_approved' => true,
            'is_mng_approved' => true,
            'created_by' => 1,
            'updated_by' => 1
        ];
    }
}
