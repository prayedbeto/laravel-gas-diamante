@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Utilidades</h1>
            <p class="text-sm text-gray-600">Resumen general y detalle por proveedor.</p>
        </div>
        <a href="{{ route('providers.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Ver proveedores
        </a>
    </div>

    <div class="grid gap-4 sm:grid-cols-3 mb-8">
        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase text-gray-500">Total ingresos</p>
            <p class="mt-2 text-2xl font-semibold text-green-600">$ {{ number_format($totalIncomes, 2) }}</p>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase text-gray-500">Total gastos</p>
            <p class="mt-2 text-2xl font-semibold text-red-600">$ {{ number_format($totalExpenses, 2) }}</p>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase text-gray-500">Utilidad bruta</p>
            <p class="mt-2 text-2xl font-semibold {{ $grossUtility >= 0 ? 'text-green-600' : 'text-red-600' }}">
                $ {{ number_format($grossUtility, 2) }}
            </p>
        </div>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Proveedor</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Ingresos</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Gastos</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Utilidad</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Detalle</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($providers as $provider)
                    @php
                        $income = $provider->incomes_sum_amount ?? 0;
                        $expense = $provider->expenses_sum_amount ?? 0;
                        $utility = $income - $expense;
                    @endphp
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $provider->name }}</td>
                        <td class="px-6 py-4 text-right text-sm text-green-600 font-semibold">$ {{ number_format($income, 2) }}</td>
                        <td class="px-6 py-4 text-right text-sm text-red-600 font-semibold">$ {{ number_format($expense, 2) }}</td>
                        <td class="px-6 py-4 text-right text-sm font-semibold {{ $utility >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            $ {{ number_format($utility, 2) }}
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <button
                                type="button"
                                class="text-indigo-600 hover:text-indigo-700"
                                data-utility-detail
                                data-target="provider-detail-{{ $provider->id }}"
                                data-url="{{ route('utilities.providers.show', $provider) }}"
                            >
                                Detalle
                            </button>
                        </td>
                    </tr>
                    <tr class="hidden bg-gray-50" data-detail-row>
                        <td colspan="5" class="px-6 py-4">
                            <div id="provider-detail-{{ $provider->id }}" class="text-sm text-gray-600">
                                Cargando detalle...
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">No hay proveedores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const escapeHtml = (value) => String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

        const formatMoney = (value) => {
            const number = Number(value ?? 0);
            return number.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        };

        document.querySelectorAll('[data-utility-detail]').forEach((button) => {
            button.addEventListener('click', async () => {
                const targetId = button.dataset.target;
                const url = button.dataset.url;
                const container = document.getElementById(targetId);
                const row = container.closest('tr');

                if (!row) return;

                row.classList.toggle('hidden');

                if (container.dataset.loaded === 'true') {
                    return;
                }

                container.textContent = 'Cargando detalle...';

                try {
                    const response = await axios.get(url);
                    const { totals, incomes, expenses } = response.data;

                    const incomesHtml = incomes.length
                        ? incomes.map((item) => `
                            <div class="flex items-center justify-between border-b border-gray-200 py-2 last:border-b-0">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">${escapeHtml(item.concept)}</p>
                                    <p class="text-xs text-gray-500">${escapeHtml(item.date)}</p>
                                </div>
                                <span class="text-sm font-semibold text-green-600">$ ${formatMoney(item.amount)}</span>
                            </div>
                        `).join('')
                        : '<p class="text-sm text-gray-500">Sin ingresos registrados.</p>';

                    const expensesHtml = expenses.length
                        ? expenses.map((item) => `
                            <div class="flex items-center justify-between border-b border-gray-200 py-2 last:border-b-0">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">${escapeHtml(item.concept)}</p>
                                    <p class="text-xs text-gray-500">${escapeHtml(item.date)}</p>
                                </div>
                                <span class="text-sm font-semibold text-red-600">$ ${formatMoney(item.amount)}</span>
                            </div>
                        `).join('')
                        : '<p class="text-sm text-gray-500">Sin gastos registrados.</p>';

                    const utilityClass = totals.utility >= 0 ? 'text-green-600' : 'text-red-600';

                    container.innerHTML = `
                        <div class="grid gap-4 md:grid-cols-3">
                            <div class="rounded-md border border-gray-200 bg-white p-4">
                                <p class="text-xs font-semibold uppercase text-gray-500">Ingresos</p>
                                <p class="mt-2 text-lg font-semibold text-green-600">$ ${formatMoney(totals.incomes)}</p>
                            </div>
                            <div class="rounded-md border border-gray-200 bg-white p-4">
                                <p class="text-xs font-semibold uppercase text-gray-500">Gastos</p>
                                <p class="mt-2 text-lg font-semibold text-red-600">$ ${formatMoney(totals.expenses)}</p>
                            </div>
                            <div class="rounded-md border border-gray-200 bg-white p-4">
                                <p class="text-xs font-semibold uppercase text-gray-500">Utilidad</p>
                                <p class="mt-2 text-lg font-semibold ${utilityClass}">$ ${formatMoney(totals.utility)}</p>
                            </div>
                        </div>
                        <div class="mt-4 grid gap-6 md:grid-cols-2">
                            <div class="rounded-md border border-gray-200 bg-white p-4">
                                <p class="text-sm font-semibold text-gray-700 mb-3">Ingresos</p>
                                ${incomesHtml}
                            </div>
                            <div class="rounded-md border border-gray-200 bg-white p-4">
                                <p class="text-sm font-semibold text-gray-700 mb-3">Gastos</p>
                                ${expensesHtml}
                            </div>
                        </div>
                    `;

                    container.dataset.loaded = 'true';
                } catch (error) {
                    container.textContent = 'No se pudo cargar el detalle.';
                }
            });
        });
    </script>
@endsection
