<?php

namespace Database\Factories;

use App\Enums\EmploymentStatusEnum;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmploymentDetail>
 */
class EmploymentDetailFactory extends Factory
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
            'position_id' => Position::inRandomOrder()->first()?->id,
            'department' => 'IT',
            'manager_id' => User::inRandomOrder()->first()?->id,
            'supervisor_id' => User::inRandomOrder()->first()?->id,
            'employment_status' => EmploymentStatusEnum::REGULAR,
            'date_hired' => now(),
            'date_regularized' =>  now(),
            'created_by' => 1,
            'updated_by' => 1
        ];
    }
}
