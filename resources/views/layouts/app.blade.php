<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 text-gray-900">
        <div class="min-h-screen">
            <nav class="bg-white border-b">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center gap-6">
                            <a href="{{ route('providers.index') }}" class="font-semibold text-gray-900">
                                Gas Diamante
                            </a>
                            <div class="hidden sm:flex items-center gap-4 text-sm">
                                <a href="{{ route('providers.index') }}" class="text-gray-600 hover:text-gray-900">
                                    Proveedores
                                </a>
                                <a href="{{ route('incomes.index') }}" class="text-gray-600 hover:text-gray-900">
                                    Ingresos
                                </a>
                                <a href="{{ route('expenses.index') }}" class="text-gray-600 hover:text-gray-900">
                                    Gastos
                                </a>
                                <a href="{{ route('utilities.index') }}" class="text-gray-600 hover:text-gray-900">
                                    Utilidades
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                @include('partials.flash')
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </body>
</html>
