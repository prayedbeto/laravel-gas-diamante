<?php

namespace Database\Factories;

use App\Models\Income;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Income>
 */
class IncomeFactory extends Factory
{
    protected $model = Income::class;

    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(2, 100, 8000),
            'concept' => fake()->words(3, true),
            'date' => fake()->date(),
            'description' => fake()->boolean(70) ? fake()->sentence() : null,
        ];
    }
}
