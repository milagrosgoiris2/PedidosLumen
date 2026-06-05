<aside class="w-64 bg-white shadow-md h-screen fixed">
    <nav class="p-4 space-y-3">

        {{-- DASHBOARD --}}
        @can('ver dashboard')
            <a href="{{ route('dashboard') }}"
               class="block px-3 py-2 rounded
               {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }}">
                🏠 Dashboard
            </a>
        @endcan


        {{-- PEDIDOS --}}
        @can('ver pedidos')
            <div class="mt-4 font-semibold text-gray-500 uppercase text-xs">
                Pedidos
            </div>

            <a href="{{ route('pedidos.index') }}"
               class="block px-3 py-2 rounded
               {{ request()->routeIs('pedidos.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }}">
                📄 Ver pedidos
            </a>

            @can('crear pedidos')
                <a href="{{ route('pedidos.crear') }}"
                   class="block px-3 py-2 rounded text-gray-700">
                    ➕ Crear pedido
                </a>
            @endcan
        @endcan


        {{-- CATÁLOGO (PRODUCTOS / MARCAS / PROVEEDORES) --}}
        @can('ver catalogo')
            <div class="mt-4 font-semibold text-gray-500 uppercase text-xs">
                Catálogo
            </div>

            <a href="{{ route('productos.index') }}"
               class="block px-3 py-2 rounded
               {{ request()->routeIs('productos.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }}">
                📦 Productos
            </a>

            <a href="{{ route('marcas.index') }}"
               class="block px-3 py-2 rounded
               {{ request()->routeIs('marcas.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }}">
                🏷️ Marcas
            </a>

            <a href="{{ route('proveedores.index') }}"
               class="block px-3 py-2 rounded
               {{ request()->routeIs('proveedores.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }}">
                🚚 Proveedores
            </a>
        @endcan


        {{-- STOCK --}}
        @can('ver stock')
            <div class="mt-4 font-semibold text-gray-500 uppercase text-xs">
                Stock
            </div>

            <a href="{{ route('stock.index') }}"
               class="block px-3 py-2 rounded
               {{ request()->routeIs('stock.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }}">
                📦 Ver stock
            </a>
        @endcan


        {{-- LOCALES --}}
        @can('ver locales')
            <div class="mt-4 font-semibold text-gray-500 uppercase text-xs">
                Locales
            </div>

            <a href="{{ route('locales.index') }}"
               class="block px-3 py-2 rounded
               {{ request()->routeIs('locales.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700' }}">
                🏬 Ver locales
            </a>
        @endcan

    </nav>
</aside>
