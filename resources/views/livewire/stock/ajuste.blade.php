<div class="max-w-xl mx-auto space-y-6">

    <h1 class="text-2xl font-bold">Ajustar stock</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="guardar" class="space-y-4">

        {{-- PRODUCTO --}}
        <div>
            <label class="block text-sm font-medium mb-1">Producto</label>
            <select wire:model="producto_id"
                    class="w-full border rounded-lg px-3 py-2">
                <option value="">Seleccionar producto</option>

                @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}">
                        {{ $producto->nombre }}
                        ({{ $producto->marca->nombre ?? 'Sin marca' }})
                    </option>
                @endforeach
            </select>
            @error('producto_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- CANTIDAD --}}
        <div>
            <label class="block text-sm font-medium mb-1">Cantidad</label>
            <input type="number" step="0.001" wire:model="cantidad"
                   class="w-full border rounded-lg px-3 py-2">
            @error('cantidad') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- VENCIMIENTO --}}
        <div>
            <label class="block text-sm font-medium mb-1">Fecha de vencimiento</label>
            <input type="date" wire:model="fecha_vencimiento"
                   class="w-full border rounded-lg px-3 py-2">
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            Guardar lote
        </button>
    </form>
</div>
