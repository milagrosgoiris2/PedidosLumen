<div class="min-h-screen bg-white text-black px-8 py-10">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Pedidos</h1>

        <div class="flex items-center gap-3">
            <input 
                wire:model.live="search"
                type="text"
                placeholder="Buscar por #ID"
                class="bg-white border border-gray-300 text-gray-900 rounded-lg px-3 py-2 text-sm 
                       focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition"
            />

            <a href="{{ route('pedidos.crear') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg 
                       text-sm font-semibold shadow-sm transition">
                + Nuevo
            </a>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

        <table class="min-w-full text-sm text-gray-800">

            <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 uppercase text-xs tracking-wide">
                <tr>
                    <th class="text-left py-3 px-4">#</th>
                    <th class="text-left py-3 px-4">Tipo</th>
                    <th class="text-left py-3 px-4">Origen → Destino</th>
                    <th class="text-left py-3 px-4">Proveedor</th>
                    <th class="text-left py-3 px-4">Estado</th>
                    <th class="text-left py-3 px-4">Fecha</th>
                    <th class="text-right py-3 px-4">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">

                @forelse ($pedidos as $pedido)
                    <tr class="hover:bg-gray-100/70 transition">

                        <td class="py-3 px-4 font-medium text-gray-700">
                            #{{ $pedido->id }}
                        </td>

                        <td class="py-3 px-4">
                            {{ $pedido->tipo == 1 ? 'A proveedor' : 'Entre locales' }}
                        </td>

                        <td class="py-3 px-4">
                            @if ($pedido->tipo == 2)
                                {{ $pedido->origen?->nombre ?? '—' }}
                                →
                                {{ $pedido->destino?->nombre ?? '—' }}
                            @else
                                {{ $pedido->destino?->nombre ?? '—' }}
                            @endif
                        </td>

                        <td class="py-3 px-4">
                            {{ $pedido->proveedor?->nombre ?? '—' }}
                        </td>

                        <td class="py-3 px-4">
                            @php
                                $estado = \App\Models\Pedido::labels()[$pedido->estado] ?? 'Desconocido';
                                $color = match($pedido->estado) {
                                    0 => 'bg-gray-200 text-gray-700',   // Borrador
                                    1 => 'bg-blue-100 text-blue-700',   // Aprobado
                                    2 => 'bg-indigo-100 text-indigo-700', // Enviado
                                    3 => 'bg-green-100 text-green-700', // Recibido
                                    4 => 'bg-rose-100 text-rose-700',   // Cancelado
                                };
                            @endphp

                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                {{ $estado }}
                            </span>
                        </td>

                        <td class="py-3 px-4 text-gray-600">
                            {{ $pedido->created_at?->format('d/m/Y H:i') ?? '—' }}
                        </td>

                        {{-- ACCIONES --}}
                        <td class="py-3 px-4 text-right space-x-2">

                            {{-- VER: TODOS --}}
                            <a href="{{ route('pedidos.ver', $pedido->id) }}"
                               class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                Ver
                            </a>

{{-- SOLO ADMIN / GERENTE --}}
@can('aprobar pedidos')

    @if($pedido->estado == 0)
        <button
            wire:click="cambiarEstado({{ $pedido->id }}, 1)"
            class="px-2 py-1 text-xs bg-green-500 text-white rounded">
            Aprobar
        </button>
    @endif

    @if($pedido->estado == 1)
        <button
            wire:click="cambiarEstado({{ $pedido->id }}, 2)"
            class="px-2 py-1 text-xs bg-blue-500 text-white rounded">
            Enviar
        </button>
    @endif

    @if($pedido->estado == 2)
        <button
            wire:click="cambiarEstado({{ $pedido->id }}, 3)"
            class="px-2 py-1 text-xs bg-indigo-500 text-white rounded">
            Recibir
        </button>
    @endif

    @if($pedido->estado != 4)
        <button
            wire:click="cambiarEstado({{ $pedido->id }}, 4)"
            class="px-2 py-1 text-xs bg-red-500 text-white rounded">
            Cancelar
        </button>
    @endif

@endcan

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-gray-500">
                            No hay pedidos registrados.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

    </div>
</div>
