<div class="min-h-screen bg-white px-8 py-10">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold">Stock</h1>
            <p class="text-sm text-gray-500">
                Control por lote y vencimiento
            </p>
        </div>

        @can('ajustar stock')
            <a href="{{ route('stock.ajuste') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold transition">
                + Ajustar stock
            </a>
        @endcan
    </div>

    {{-- TABLA --}}
    <div class="bg-white border rounded-2xl shadow overflow-hidden">

        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">Producto</th>
                    <th class="px-6 py-4 text-left">Marca</th>
                    <th class="px-6 py-4 text-center">Cantidad</th>
                    <th class="px-6 py-4 text-left">Vencimiento</th>
                    <th class="px-6 py-4 text-left">Estado</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse ($stocks as $stock)

                    @php
                        $dias = $stock->fecha_vencimiento
                            ? now()->diffInDays($stock->fecha_vencimiento, false)
                            : null;

                        [$texto, $color] = match (true) {
                            is_null($dias) => ['—', 'bg-gray-200 text-gray-700'],
                            $dias < 0       => ['Vencido', 'bg-red-200 text-red-800'],
                            $dias <= 10     => ['Próximo', 'bg-yellow-200 text-yellow-800'],
                            default        => ['OK', 'bg-green-200 text-green-800'],
                        };
                    @endphp

                    <tr class="hover:bg-gray-50">

                        {{-- PRODUCTO --}}
                        <td class="px-6 py-4 font-semibold">
                            {{ $stock->producto->nombre }}
                        </td>

                        {{-- MARCA --}}
                        <td class="px-6 py-4">
                            {{ $stock->producto->marca->nombre ?? '—' }}
                        </td>

                        {{-- CANTIDAD (SOLO NÚMERO) --}}
                        <td class="px-6 py-4 text-center font-semibold">
                            {{ (int) $stock->cantidad }}
                        </td>

                        {{-- VENCIMIENTO --}}
                        <td class="px-6 py-4">
                            {{ $stock->fecha_vencimiento?->format('d/m/Y') ?? '—' }}
                        </td>

                        {{-- ESTADO --}}
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $color }}">
                                {{ $texto }}
                            </span>
                        </td>

                        {{-- ACCIONES --}}
                        <td class="px-6 py-4 text-right space-x-3">
                            <a href="{{ route('stock.editar', $stock->id) }}"
                               class="text-blue-600 hover:underline">
                                Editar
                            </a>

                            <button
                                wire:click="eliminar({{ $stock->id }})"
                                onclick="confirm('¿Eliminar este lote?') || event.stopImmediatePropagation()"
                                class="text-red-600 hover:underline">
                                Eliminar
                            </button>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-gray-500">
                            No hay stock cargado.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

    </div>
</div>
