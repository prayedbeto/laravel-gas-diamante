<?php

namespace Database\Seeders;

use App\Models\Income;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    public function run(): void
    {
        $providers = Provider::query()->orderBy('id')->get();
        $startDate = now()->subDays(90);

        $states = [];
        for ($i = 0; $i < 30; $i++) {
            $states[] = [
                'provider_id' => $providers[$i % $providers->count()]->id,
                'date' => $startDate->copy()->addDays($i * 3)->toDateString(),
            ];
        }

        Income::factory()
            ->count(30)
            ->state(new Sequence(...$states))
            ->create();
    }
}
