<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Billing;
use App\Models\Transaction;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(2, 0, 99999999.99),
            'date' => fake()->date(),
            'status' => fake()->randomElement(["pending","paid","failure"]),
            'snap_token' => fake()->word(),
            'billing_id' => Billing::factory(),
        ];
    }
}
