<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProviderController extends Controller
{
    public function index()
    {
        $search = request()->query('search');

        $providers = Provider::query()
            ->when($search, fn ($query) => $query->where('name', 'like', '%' . $search . '%'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('providers.index', compact('providers', 'search'));
    }

    public function create()
    {
        return view('providers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:providers,name'],
        ]);

        Provider::create($data);

        return redirect()
            ->route('providers.index')
            ->with('status', 'Proveedor creado correctamente.');
    }

    public function show(Provider $provider)
    {
        $provider->load(['incomes', 'expenses']);

        return view('providers.show', compact('provider'));
    }

    public function edit(Provider $provider)
    {
        return view('providers.edit', compact('provider'));
    }

    public function update(Request $request, Provider $provider)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('providers', 'name')->ignore($provider->id),
            ],
        ]);

        $provider->update($data);

        return redirect()
            ->route('providers.index')
            ->with('status', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Provider $provider)
    {
        $provider->delete();

        return redirect()
            ->route('providers.index')
            ->with('status', 'Proveedor eliminado correctamente.');
    }
}
