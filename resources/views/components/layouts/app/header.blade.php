<header 
    x-data="{ sidebarOpen: false, menuOpen: false }"
    class="flex items-center justify-between bg-white border-b px-4 py-3 shadow-sm"
>

    {{-- LOGO + HAMBURGUESA --}}
    <div class="flex items-center gap-3">
        {{-- BOTÓN SIDEBAR (mobile) --}}
        <button @click="sidebarOpen = true" class="lg:hidden text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <span class="text-lg font-bold text-gray-700">Pedidos Lumen</span>
    </div>

    {{-- MENÚ DESKTOP --}}
    <nav class="hidden lg:flex items-center gap-6 text-sm font-medium text-gray-700">

        <a href="{{ route('pedidos.index') }}" class="hover:text-blue-600">Pedidos</a>
        <a href="{{ route('productos.index') }}" class="hover:text-blue-600">Productos</a>
        <a href="{{ route('marcas.index') }}" class="hover:text-blue-600">Marcas</a>
        <a href="{{ route('proveedores.index') }}" class="hover:text-blue-600">Proveedores</a>
        <a href="{{ route('locales.index') }}" class="hover:text-blue-600">Locales</a>

        @can('ver stock')
            <a href="{{ route('stock.index') }}" class="hover:text-blue-600">
                Stock
            </a>
        @endcan
    </nav>

    {{-- ACCIONES DERECHA --}}
    <div class="flex items-center gap-4">

        {{-- PANEL ADMIN --}}
        @role('admin')
            <a href="/admin"
               class="px-3 py-1.5 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200">
                ⚙️ Panel Admin
            </a>
        @endrole

        {{-- CAMBIAR ESTADO --}}
       @can('aprobar pedidos')
    Cambiar Estado
@endcan


        {{-- PERFIL --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 text-gray-700">
                <span>{{ auth()->user()->name }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" @click.away="open = false"
                 class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-lg py-2">

                <a href="/profile" class="block px-4 py-2 hover:bg-gray-100">
                    👤 Mi Perfil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-4 py-2 hover:bg-gray-100">
                        🚪 Cerrar sesión
                    </button>
                </form>
            </div>
        </div>

        {{-- BOTÓN MENÚ MOBILE --}}
        <button @click="menuOpen = !menuOpen" class="lg:hidden text-gray-600">
            ☰
        </button>
    </div>

    {{-- MENÚ MOBILE --}}
    <div x-show="menuOpen" class="absolute top-full left-0 w-full bg-white border-b shadow-lg lg:hidden">
        <nav class="flex flex-col divide-y text-sm">

            <a href="{{ route('pedidos.index') }}" class="px-4 py-3 hover:bg-gray-100">Pedidos</a>
            <a href="{{ route('productos.index') }}" class="px-4 py-3 hover:bg-gray-100">Productos</a>
            <a href="{{ route('marcas.index') }}" class="px-4 py-3 hover:bg-gray-100">Marcas</a>
            <a href="{{ route('proveedores.index') }}" class="px-4 py-3 hover:bg-gray-100">Proveedores</a>
            <a href="{{ route('locales.index') }}" class="px-4 py-3 hover:bg-gray-100">Locales</a>

            @can('ver stock')
                <a href="{{ route('stock.index') }}" class="px-4 py-3 hover:bg-gray-100">
                    Stock
                </a>
            @endcan
        </nav>
    </div>

</header>
