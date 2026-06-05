<div class="p-6 max-w-xl space-y-6">

  <div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold text-black">Editar local</h1>
    <a href="{{ route('locales.index') }}" 
       class="text-sm text-gray-600 hover:text-gray-800">
      ← Volver
    </a>
  </div>

  <!-- CARD BLANCA -->
  <div class="bg-white border border-gray-200 rounded-xl shadow-md p-6 space-y-4">

    <div>
      <label class="text-sm text-gray-700 mb-1 block">Nombre</label>
      <input type="text" 
             wire:model="nombre"
             class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
      @error('nombre')
        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label class="text-sm text-gray-700 mb-1 block">Dirección</label>
      <input type="text" 
             wire:model="direccion"
             class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
      @error('direccion')
        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <label class="inline-flex items-center gap-2">
      <input type="checkbox" wire:model="activo" class="h-4 w-4">
      <span class="text-sm text-gray-700">Activo</span>
    </label>

    <div class="pt-2">
      <button wire:click="update"
              class="rounded-lg bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">
        Actualizar
      </button>
    </div>

  </div>

</div>
