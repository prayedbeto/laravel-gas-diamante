<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Provider;
use Illuminate\Http\JsonResponse;

class UtilitiesController extends Controller
{
    public function index()
    {
        $totalIncomes = Income::query()->sum('amount');
        $totalExpenses = Expense::query()->sum('amount');
        $grossUtility = $totalIncomes - $totalExpenses;

        $providers = Provider::query()
            ->withSum('incomes', 'amount')
            ->withSum('expenses', 'amount')
            ->orderBy('name')
            ->get();

        return view('utilities.index', compact(
            'totalIncomes',
            'totalExpenses',
            'grossUtility',
            'providers'
        ));
    }

    public function providerDetail(Provider $provider): JsonResponse
    {
        $incomes = $provider->incomes()
            ->orderByDesc('date')
            ->get(['id', 'concept', 'amount', 'date', 'description']);

        $expenses = $provider->expenses()
            ->orderByDesc('date')
            ->get(['id', 'concept', 'amount', 'date', 'description']);

        return response()->json([
            'provider' => [
                'id' => $provider->id,
                'name' => $provider->name,
            ],
            'totals' => [
                'incomes' => $incomes->sum('amount'),
                'expenses' => $expenses->sum('amount'),
                'utility' => $incomes->sum('amount') - $expenses->sum('amount'),
            ],
            'incomes' => $incomes,
            'expenses' => $expenses,
        ]);
    }
}
