<div class="space-y-10"> {{-- ÚNICO ROOT ELEMENT --}}

    {{-- ENCABEZADO --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Pedido #{{ $pedido->id }}</h1>

        <a href="{{ route('pedidos.index') }}"
           class="text-blue-600 text-sm hover:underline">← Volver</a>
    </div>

    {{-- DETALLES DEL PEDIDO --}}
    <div class="bg-white border rounded-xl shadow p-6">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold">Detalles del pedido</h2>

            {{-- PDF --}}
            <a href="{{ route('pedidos.pdf', $pedido) }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-600 text-white font-semibold shadow hover:bg-red-700 transition">
                Descargar PDF
            </a>
        </div>

        <div class="grid md:grid-cols-2 gap-6 text-sm">

            <p>
                <span class="font-semibold text-gray-600">Tipo:</span>
                {{ $pedido->tipo == 1 ? 'A proveedor' : 'Entre locales' }}
            </p>

            <p>
                <span class="font-semibold text-gray-600">Proveedor:</span>
                {{ $pedido->proveedor->nombre ?? '—' }}
            </p>

            <p>
                <span class="font-semibold text-gray-600">Origen:</span>
                {{ $pedido->origen->nombre ?? '—' }}
            </p>

            <p>
                <span class="font-semibold text-gray-600">Destino:</span>
                {{ $pedido->destino->nombre ?? '—' }}
            </p>

            {{-- ESTADO --}}
            <div class="flex flex-col gap-4 mt-2">

                @php
                    $labels = \App\Models\Pedido::labels();
                    $estado = $labels[$pedido->estado] ?? 'Desconocido';

                    $color = match($pedido->estado) {
                        0 => 'bg-gray-100 text-gray-700 ring-gray-300',
                        1 => 'bg-blue-100 text-blue-700 ring-blue-300',
                        2 => 'bg-purple-100 text-purple-700 ring-purple-300',
                        3 => 'bg-green-100 text-green-700 ring-green-300',
                        4 => 'bg-red-100 text-red-700 ring-red-300',
                        default => 'bg-gray-100 text-gray-700 ring-gray-300',
                    };
                @endphp

                <div class="flex items-center gap-3">
                    <span class="font-semibold text-gray-600">Estado:</span>
                    <span class="px-4 py-1.5 rounded-full text-sm font-semibold ring-1 {{ $color }}">
                        {{ $estado }}
                    </span>
                </div>

{{-- BOTONES SOLO GERENTE / ADMIN --}}
@can('aprobar pedidos')
    <div class="flex gap-3">

        @if($pedido->estado == 0)
            <button wire:click="cambiarEstado({{ $pedido->id }}, 1)"
                    class="px-5 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                Aprobar
            </button>
        @endif

        @if($pedido->estado != 4)
            <button wire:click="cambiarEstado({{ $pedido->id }}, 4)"
                    class="px-5 py-2 text-sm rounded-lg bg-red-600 text-white hover:bg-red-700">
                Cancelar
            </button>
        @endif

    </div>
@endcan


            </div>
        </div>
    </div>

    {{-- ÍTEMS --}}
    <div class="bg-white border rounded-xl shadow p-6 space-y-4">
        <h2 class="text-lg font-semibold mb-2">Ítems del pedido</h2>

        @php
            $agrupados = $pedido->items->groupBy(fn($i) => $i->producto->marca->nombre ?? 'Sin marca');
        @endphp

        @foreach ($agrupados as $marca => $itemsMarca)
            <div class="border rounded-lg overflow-hidden">

                <div class="bg-gray-100 px-4 py-2 flex justify-between items-center">
                    <span class="font-semibold">{{ $marca }}</span>
                    <span class="text-sm text-gray-500">
                        {{ $itemsMarca->count() }} producto(s)
                    </span>
                </div>

                <table class="w-full text-sm">
                    <tbody>
                        @foreach ($itemsMarca as $item)
                            <tr class="border-b">
                                <td class="py-2 px-3">{{ $item->producto->nombre }}</td>
                                <td class="py-2 px-3 text-right">
                                    {{ number_format($item->cantidad, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        @endforeach

        @if ($agrupados->isEmpty())
            <p class="text-gray-600">No hay ítems cargados.</p>
        @endif
    </div>

    {{-- ARCHIVOS ADJUNTOS --}}
    <div class="bg-white p-6 rounded-xl shadow border">
        <h2 class="text-lg font-semibold mb-4">Archivos adjuntos</h2>

        {{-- SUBIR --}}
        <div class="flex items-center gap-3 mb-4">
            <input type="file"
                   wire:model="archivo"
                   class="border rounded-lg px-3 py-2">

            <button wire:click="uploadArchivo"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                Subir archivo
            </button>
        </div>

        @error('archivo')
            <p class="text-red-600 text-sm mb-4">{{ $message }}</p>
        @enderror

        {{-- GALERÍA --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mt-6">
            @foreach ($pedido->archivos as $file)
                <div class="relative border rounded-lg shadow-sm overflow-hidden bg-gray-50">

                    <button wire:click="eliminarArchivo({{ $file->id }})"
                            class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full hover:bg-red-700 shadow">
                        ✕
                    </button>

                    @if (str_starts_with($file->mime, 'image/'))
                        <img
                            src="{{ Storage::url($file->path) }}"
                            class="w-full h-40 object-cover"
                            alt="Archivo adjunto"
                        >
                    @else
                        <div class="h-40 flex flex-col items-center justify-center bg-gray-200">
                            <span class="text-gray-600 text-sm">📄 Archivo</span>
                            <span class="text-xs text-gray-500">
                                {{ strtoupper($file->extension) }}
                            </span>
                        </div>
                    @endif

                    <div class="p-2 text-center text-xs truncate">
                        {{ $file->filename }}
                    </div>
                </div>
            @endforeach
        </div>

        @if ($pedido->archivos->isEmpty())
            <p class="text-gray-600 mt-4">No hay archivos adjuntos.</p>
        @endif
    </div>

</div>
