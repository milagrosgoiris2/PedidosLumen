<!DOCTYPE html>
<html lang="es" class="h-full" x-data="{ openMobile: false }" x-cloak>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Pedidos Lumen' }}</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen bg-gray-50 text-gray-900">

{{-- ================= NAVBAR ================= --}}
<header class="sticky top-0 z-40 bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 h-14 flex items-center justify-between">

        {{-- IZQUIERDA --}}
        <div class="flex items-center gap-3">
            <button class="lg:hidden" @click="openMobile = true">
                ☰
            </button>

            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-bold">
                <span class="h-8 w-8 bg-black text-white rounded-lg grid place-items-center">PL</span>
                Pedidos Lumen
            </a>
        </div>

        {{-- MENÚ DESKTOP --}}
        <nav class="hidden lg:flex gap-4 text-sm">

            @can('ver pedidos')
                <a href="{{ route('pedidos.index') }}" class="hover:underline">
                    Pedidos
                </a>
            @endcan

            @can('ver stock')
                <a href="{{ route('stock.index') }}" class="hover:underline">
                    Stock
                </a>
            @endcan

            {{-- CATÁLOGO --}}
            @can('ver catalogo')
                <a href="{{ route('productos.index') }}" class="hover:underline">
                    Productos
                </a>

                <a href="{{ route('marcas.index') }}" class="hover:underline">
                    Marcas
                </a>

                <a href="{{ route('proveedores.index') }}" class="hover:underline">
                    Proveedores
                </a>
            @endcan

            {{-- ✅ LOCALES --}}
            @can('ver locales')
                <a href="{{ route('locales.index') }}" class="hover:underline">
                    Locales
                </a>
            @endcan

        </nav>

        {{-- USUARIO --}}
        <div class="flex items-center gap-3">
            <div class="text-right text-sm hidden sm:block">
                <div class="font-semibold">
                    {{ auth()->user()->name }}
                </div>
                <div class="text-xs text-gray-500">
                    {{ auth()->user()->local->nombre ?? '' }}
                </div>
            </div>

            <div class="h-9 w-9 rounded-full bg-black text-white flex items-center justify-center">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="px-3 py-1.5 bg-black text-white rounded-lg">
                    Salir
                </button>
            </form>
        </div>
    </div>
</header>

{{-- ================= OVERLAY MOBILE ================= --}}
<div x-show="openMobile"
     x-cloak
     @click="openMobile = false"
     class="fixed inset-0 bg-black/40 z-40 lg:hidden">
</div>

{{-- ================= PANEL MOBILE ================= --}}
<div x-show="openMobile"
     x-cloak
     class="fixed top-0 left-0 h-full w-64 bg-white z-50 shadow-lg p-6 lg:hidden">

    <button @click="openMobile = false" class="mb-6">✕</button>

    {{-- USUARIO --}}
    <div class="mb-6 border-b pb-4">
        <div class="font-semibold">
            {{ auth()->user()->name }}
        </div>
        <div class="text-xs text-gray-500">
            {{ auth()->user()->local->nombre ?? '' }}
        </div>
    </div>

    {{-- MENÚ MOBILE --}}
    <nav class="flex flex-col gap-3 text-sm">

        @can('ver pedidos')
            <a href="{{ route('pedidos.index') }}">🧾 Pedidos</a>
        @endcan

        @can('ver stock')
            <a href="{{ route('stock.index') }}">📦 Stock</a>
        @endcan

        {{-- CATÁLOGO --}}
        @can('ver catalogo')
            <a href="{{ route('productos.index') }}">🧺 Productos</a>
            <a href="{{ route('marcas.index') }}">🏷️ Marcas</a>
            <a href="{{ route('proveedores.index') }}">🚚 Proveedores</a>
        @endcan

        {{-- ✅ LOCALES --}}
        @can('ver locales')
            <a href="{{ route('locales.index') }}">🏪 Locales</a>
        @endcan

        <form method="POST" action="{{ route('logout') }}" class="pt-6">
            @csrf
            <button class="w-full bg-black text-white py-2 rounded-lg">
                Salir
            </button>
        </form>
    </nav>
</div>

{{-- ================= CONTENIDO ================= --}}
<main class="max-w-7xl mx-auto px-4 py-8">
    {{ $slot }}
</main>

@livewireScripts
</body>
</html>
