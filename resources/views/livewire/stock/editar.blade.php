<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow space-y-5">

    <h1 class="text-xl font-semibold">
        Editar stock – {{ $stock->producto->nombre }}
    </h1>

    <div>
        <label class="text-sm">Cantidad</label>
        <input type="number" wire:model="cantidad"
               class="w-full border rounded-lg px-3 py-2">
    </div>

    <div>
        <label class="text-sm">Vencimiento</label>
        <input type="date" wire:model="fecha_vencimiento"
               class="w-full border rounded-lg px-3 py-2">
    </div>

    <button wire:click="guardar"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg">
        Guardar cambios
    </button>
</div>
