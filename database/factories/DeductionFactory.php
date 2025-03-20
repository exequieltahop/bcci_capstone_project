<?php

namespace Database\Factories;

use App\Models\Benefit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deduction>
 */
class DeductionFactory extends Factory
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
            'benefit_id' => Benefit::inRandomOrder()->first()?->id,
            'amount' => rand(100, 1000),
            'created_by' => 1,
            'updated_by' => 1
        ];
    }
}
