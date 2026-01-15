<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Provider;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        $providers = Provider::query()->orderBy('name')->get();
        $filters = request()->only(['provider_id', 'date_from', 'date_to']);

        $incomes = Income::query()
            ->with('provider')
            ->when($filters['provider_id'] ?? null, fn ($query, $providerId) => $query->where('provider_id', $providerId))
            ->when($filters['date_from'] ?? null, fn ($query, $dateFrom) => $query->whereDate('date', '>=', $dateFrom))
            ->when($filters['date_to'] ?? null, fn ($query, $dateTo) => $query->whereDate('date', '<=', $dateTo))
            ->orderByDesc('date')
            ->paginate(15)
            ->withQueryString();

        return view('incomes.index', compact('incomes', 'providers', 'filters'));
    }

    public function create()
    {
        $providers = Provider::query()->orderBy('name')->get();

        return view('incomes.create', compact('providers'));
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

        Income::create($data);

        return redirect()
            ->route('incomes.index')
            ->with('status', 'Ingreso creado correctamente.');
    }

    public function show(Income $income)
    {
        $income->load('provider');

        return view('incomes.show', compact('income'));
    }

    public function edit(Income $income)
    {
        $providers = Provider::query()->orderBy('name')->get();

        return view('incomes.edit', compact('income', 'providers'));
    }

    public function update(Request $request, Income $income)
    {
        $data = $request->validate([
            'provider_id' => ['required', 'exists:providers,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'concept' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
        ]);

        $income->update($data);

        return redirect()
            ->route('incomes.index')
            ->with('status', 'Ingreso actualizado correctamente.');
    }

    public function destroy(Income $income)
    {
        $income->delete();

        return redirect()
            ->route('incomes.index')
            ->with('status', 'Ingreso eliminado correctamente.');
    }
}
