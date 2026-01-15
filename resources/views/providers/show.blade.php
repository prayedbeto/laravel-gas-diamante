@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">{{ $provider->name }}</h1>
            <p class="text-sm text-gray-600">Detalle del proveedor.</p>
        </div>
        <a href="{{ route('providers.edit', $provider) }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Editar
        </a>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-sm font-semibold text-gray-700">Ingresos</h2>
            </div>
            <div class="px-6 py-4">
                @forelse ($provider->incomes as $income)
                    <div class="flex items-center justify-between border-b border-gray-100 py-3 last:border-b-0">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $income->concept }}</p>
                            <p class="text-xs text-gray-500">{{ $income->date }}</p>
                        </div>
                        <span class="text-sm font-semibold text-green-600">$ {{ number_format($income->amount, 2) }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No hay ingresos registrados.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-sm font-semibold text-gray-700">Gastos</h2>
            </div>
            <div class="px-6 py-4">
                @forelse ($provider->expenses as $expense)
                    <div class="flex items-center justify-between border-b border-gray-100 py-3 last:border-b-0">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $expense->concept }}</p>
                            <p class="text-xs text-gray-500">{{ $expense->date }}</p>
                        </div>
                        <span class="text-sm font-semibold text-red-600">$ {{ number_format($expense->amount, 2) }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No hay gastos registrados.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
