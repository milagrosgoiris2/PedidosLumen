<div class="min-h-screen bg-gray-50 px-8 py-10 space-y-10">

    {{-- ENCABEZADO --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">📊 Dashboard</h1>
            <p class="text-sm text-gray-500">Resumen general del sistema</p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('stock.index') }}"
               class="px-4 py-2 text-sm rounded-lg border bg-white hover:bg-gray-100">
                Ver stock
            </a>

            <a href="{{ route('pedidos.crear') }}"
               class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                + Nuevo pedido
            </a>
        </div>
    </div>

    {{-- MÉTRICAS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Productos</p>
            <p class="text-3xl font-bold">{{ $productos }}</p>
        </div>

        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Proveedores</p>
            <p class="text-3xl font-bold">{{ $proveedores }}</p>
        </div>

        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Locales</p>
            <p class="text-3xl font-bold">{{ $locales }}</p>
        </div>

        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Pedidos visibles</p>
            <p class="text-3xl font-bold">{{ $totalPedidos }}</p>
        </div>

    </div>

    {{-- PEDIDOS HOY --}}
    <div class="bg-white border rounded-xl p-6 shadow-sm">
        <p class="text-sm text-gray-500">📅 Pedidos de hoy</p>
        <p class="text-4xl font-bold text-blue-700 mt-2">
            {{ $pedidosHoy }}
        </p>
    </div>

    {{-- STOCK --}}
    <div class="bg-white border rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">📦 Stock</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="border rounded-lg p-4">
                <p class="text-sm text-gray-500">Cantidad total</p>
                <p class="text-3xl font-bold">
                    {{ number_format($stockTotal, 0, ',', '.') }}
                </p>
            </div>

            <div class="border rounded-lg p-4">
                <p class="text-sm text-gray-500">Lotes registrados</p>
                <p class="text-3xl font-bold">
                    {{ $stockLotes }}
                </p>
            </div>

            <div class="border rounded-lg p-4">
                <p class="text-sm text-gray-500">Por vencer (10 días)</p>
                <p class="text-3xl font-bold
                    {{ $stockPorVencer > 0 ? 'text-amber-600' : 'text-emerald-600' }}">
                    {{ $stockPorVencer }}
                </p>
            </div>

        </div>
    </div>

</div>
