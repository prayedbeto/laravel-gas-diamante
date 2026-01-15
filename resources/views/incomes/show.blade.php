@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Ingreso</h1>
            <p class="text-sm text-gray-600">Detalle del ingreso.</p>
        </div>
        <a href="{{ route('incomes.edit', $income) }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Editar
        </a>
    </div>

    <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
        <div class="grid gap-6 px-6 py-6 sm:grid-cols-2">
            <div>
                <p class="text-xs font-semibold uppercase text-gray-500">Proveedor</p>
                <p class="text-sm text-gray-900">{{ $income->provider->name }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase text-gray-500">Fecha</p>
                <p class="text-sm text-gray-900">{{ $income->date }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase text-gray-500">Concepto</p>
                <p class="text-sm text-gray-900">{{ $income->concept }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase text-gray-500">Monto</p>
                <p class="text-sm font-semibold text-green-600">$ {{ number_format($income->amount, 2) }}</p>
            </div>
            <div class="sm:col-span-2">
                <p class="text-xs font-semibold uppercase text-gray-500">Descripción</p>
                <p class="text-sm text-gray-900">{{ $income->description ?: 'Sin descripción.' }}</p>
            </div>
        </div>
    </div>
@endsection
