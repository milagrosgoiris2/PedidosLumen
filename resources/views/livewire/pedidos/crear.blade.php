<div class="min-h-screen bg-white text-black p-8 space-y-6">

    <h1 class="text-2xl font-semibold mb-4 text-black">Nuevo Pedido</h1>

    {{-- Datos principales --}}
    <div class="bg-white border border-gray-200 rounded-xl p-6 space-y-6 shadow">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            {{-- Tipo --}}
            <div>
                <label class="block text-sm text-gray-700 mb-1">Tipo</label>
                <select wire:model="tipo"
                        class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2">
                    <option value="1">A proveedor</option>
                    <option value="2">Entre locales</option>
                </select>
            </div>

            {{-- Destino --}}
            <div>
                <label class="block text-sm text-gray-700 mb-1">Destino</label>
                <select wire:model="destino_local_id"
                        class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">-- seleccionar --</option>
                    @foreach($locales as $local)
                        <option value="{{ $local->id }}">{{ $local->nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Proveedor --}}
            <div>
                <label class="block text-sm text-gray-700 mb-1">Proveedor</label>
                <select wire:model="proveedor_id"
                        class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">-- seleccionar --</option>
                    @foreach($proveedores as $prov)
                        <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Origen --}}
            <div>
                <label class="block text-sm text-gray-700 mb-1">Origen (solo entre locales)</label>
                <select wire:model="origen_local_id"
                        class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">-- seleccionar --</option>
                    @foreach($locales as $local)
                        <option value="{{ $local->id }}">{{ $local->nombre }}</option>
                    @endforeach
                </select>
            </div>

        </div>

    </div>

    {{-- Ítems --}}
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow">

        <div class="flex items-center justify-between mb-3">
            <h2 class="font-medium text-gray-800">Ítems</h2>

            <button wire:click="addItem" type="button"
                    class="rounded-lg bg-blue-600 text-white px-3 py-1 text-sm hover:bg-blue-700">
                + Agregar ítem
            </button>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left py-2 px-2">Producto</th>
                    <th class="text-left py-2 px-2 w-32">Cantidad</th>
                    <th class="text-left py-2 px-2 w-32">Unidad</th>
                    <th class="text-left py-2 px-2">Nota</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach($items as $i => $item)
                    <tr class="border-b">

                        {{-- PRODUCTO --}}
                        <td class="py-2 px-2">
                            <select wire:model="items.{{ $i }}.producto_id"
                                class="w-full bg-white border border-gray-300 rounded-lg px-2 py-1">
                                <option value="">-- seleccionar --</option>

                                @foreach($marcas as $marca)
                                    <optgroup label="{{ $marca->nombre }}">
                                        @foreach($marca->productos as $prod)
                                            <option value="{{ $prod->id }}">
                                                {{ $marca->nombre }} — {{ $prod->nombre }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach

                            </select>
                        </td>

                        {{-- CANTIDAD --}}
                        <td class="py-2 px-2">
                            <input type="number" min="0.001" step="0.001"
                                   wire:model="items.{{ $i }}.cantidad"
                                   class="w-full bg-white border border-gray-300 rounded-lg px-2 py-1">
                        </td>

                        {{-- UNIDAD --}}
                        <td class="py-2 px-2">
                            <select wire:model="items.{{ $i }}.unidad"
                                class="w-full bg-white border border-gray-300 rounded-lg px-2 py-1">
                                <option value="unidad">Unidad</option>
                                <option value="caja">Caja</option>
                                <option value="pack">Pack</option>
                                <option value="kg">Kg</option>
                            </select>
                        </td>

                        {{-- NOTA --}}
                        <td class="py-2 px-2">
                            <input type="text"
                                   wire:model="items.{{ $i }}.nota"
                                   placeholder="Opcional"
                                   class="w-full bg-white border border-gray-300 rounded-lg px-2 py-1">
                        </td>

                        {{-- QUITAR --}}
                        <td class="py-2 px-2 text-right">
                            <button wire:click="removeItem({{ $i }})"
                                    class="text-red-600 hover:underline">
                                Quitar
                            </button>
                        </td>

                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>

    {{-- GUARDAR --}}
    <div class="text-right">
        <button wire:click="save"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
            Guardar pedido
        </button>
    </div>

</div>
