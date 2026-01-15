@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Gastos</h1>
            <p class="text-sm text-gray-600">Administra los gastos registrados.</p>
        </div>
        <a href="{{ route('expenses.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
            Nuevo gasto
        </a>
    </div>

    <form method="GET" action="{{ route('expenses.index') }}" class="mb-6 grid gap-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:grid-cols-4">
        <div class="sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Proveedor</label>
            <select
                name="provider_id"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
                <option value="">Todos</option>
                @foreach ($providers as $provider)
                    <option value="{{ $provider->id }}" @selected(($filters['provider_id'] ?? '') == $provider->id)>
                        {{ $provider->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Desde</label>
            <input
                type="date"
                name="date_from"
                value="{{ $filters['date_from'] ?? '' }}"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Hasta</label>
            <input
                type="date"
                name="date_to"
                value="{{ $filters['date_to'] ?? '' }}"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            />
        </div>
        <div class="flex gap-2 sm:col-span-4">
            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                Filtrar
            </button>
            <a href="{{ route('expenses.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Limpiar
            </a>
        </div>
    </form>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Proveedor</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Concepto</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Fecha</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Monto</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($expenses as $expense)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $expense->provider->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <a class="font-medium text-indigo-600 hover:text-indigo-700" href="{{ route('expenses.show', $expense) }}">
                                {{ $expense->concept }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $expense->date }}</td>
                        <td class="px-6 py-4 text-right text-sm font-semibold text-red-600">
                            $ {{ number_format($expense->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 text-right text-sm text-gray-600">
                            <a href="{{ route('expenses.edit', $expense) }}" class="text-indigo-600 hover:text-indigo-700">Editar</a>
                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline-block ml-3" onsubmit="return confirm('¿Eliminar gasto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">No hay gastos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $expenses->links() }}
    </div>
@endsection
