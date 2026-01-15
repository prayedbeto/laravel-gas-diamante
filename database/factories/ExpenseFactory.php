<?php

namespace Database\Factories;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(2, 50, 5000),
            'concept' => fake()->words(3, true),
            'date' => fake()->date(),
            'description' => fake()->boolean(70) ? fake()->sentence() : null,
        ];
    }
}
