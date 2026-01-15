<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Provider;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $providers = Provider::query()->orderBy('name')->get();
        $filters = request()->only(['provider_id', 'date_from', 'date_to']);

        $expenses = Expense::query()
            ->with('provider')
            ->when($filters['provider_id'] ?? null, fn ($query, $providerId) => $query->where('provider_id', $providerId))
            ->when($filters['date_from'] ?? null, fn ($query, $dateFrom) => $query->whereDate('date', '>=', $dateFrom))
            ->when($filters['date_to'] ?? null, fn ($query, $dateTo) => $query->whereDate('date', '<=', $dateTo))
            ->orderByDesc('date')
            ->paginate(15)
            ->withQueryString();

        return view('expenses.index', compact('expenses', 'providers', 'filters'));
    }

    public function create()
    {
        $providers = Provider::query()->orderBy('name')->get();

        return view('expenses.create', compact('providers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'provider_id' => ['required', 'exists:providers,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'concept' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
        ]);

        Expense::create($data);

        return redirect()
            ->route('expenses.index')
            ->with('status', 'Gasto creado correctamente.');
    }

    public function show(Expense $expense)
    {
        $expense->load('provider');

        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $providers = Provider::query()->orderBy('name')->get();

        return view('expenses.edit', compact('expense', 'providers'));
    }

    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'provider_id' => ['required', 'exists:providers,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'concept' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
        ]);

        $expense->update($data);

        return redirect()
            ->route('expenses.index')
            ->with('status', 'Gasto actualizado correctamente.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->with('status', 'Gasto eliminado correctamente.');
    }
}
