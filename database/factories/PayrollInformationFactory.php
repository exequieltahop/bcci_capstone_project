<?php

namespace Database\Factories;

use App\Enums\PaymentMethodEnum;
use App\Enums\PayModeEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PayrollInformation>
 */
class PayrollInformationFactory extends Factory
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
            'basic_salary' => rand(1000, 99999),
            'pay_mode' => Arr::random(PayModeEnum::cases()),
            'payment_method' => Arr::random(PaymentMethodEnum::cases()),
            'created_by' => 1,
            'updated_by' => 1
        ];
    }
}
