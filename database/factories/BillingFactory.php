<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Billing;
use App\Models\Enrollment;

class BillingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Billing::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(2, 0, 99999999.99),
            'due_date' => fake()->date(),
            'note' => fake()->word(),
            'enrollment_id' => Enrollment::factory(),
        ];
    }
}
