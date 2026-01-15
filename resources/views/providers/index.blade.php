@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Proveedores</h1>
            <p class="text-sm text-gray-600">Administra los proveedores registrados.</p>
        </div>
        <a href="{{ route('providers.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
            Nuevo proveedor
        </a>
    </div>

    <form method="GET" action="{{ route('providers.index') }}" class="mb-6">
        <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Buscar proveedor</label>
                    <div class="relative mt-1">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.5 3.5a5 5 0 1 0 0 10 5 5 0 0 0 0-10ZM2 8.5a6.5 6.5 0 1 1 11.293 4.243l3.982 3.982a.75.75 0 1 1-1.06 1.06l-3.983-3.982A6.5 6.5 0 0 1 2 8.5Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Ej. Proveedor Norte"
                            class="w-full rounded-md border-gray-300 pl-9 pr-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                        Buscar
                    </button>
                    <a href="{{ route('providers.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Limpiar
                    </a>
                </div>
            </div>
        </div>
    </form>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Nombre</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($providers as $provider)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <a class="font-medium text-indigo-600 hover:text-indigo-700" href="{{ route('providers.show', $provider) }}">
                                {{ $provider->name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-right text-sm text-gray-600">
                            <a href="{{ route('providers.edit', $provider) }}" class="text-indigo-600 hover:text-indigo-700">Editar</a>
                            <form action="{{ route('providers.destroy', $provider) }}" method="POST" class="inline-block ml-3" onsubmit="return confirm('¿Eliminar proveedor?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-10 text-center text-sm text-gray-500">No hay proveedores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $providers->links() }}
    </div>
@endsection
