<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Livewire Pages
|--------------------------------------------------------------------------
*/
use App\Livewire\Dashboard\Home as DashboardHome;

// Pedidos
use App\Livewire\Pedidos\Index as PedidosIndex;
use App\Livewire\Pedidos\Crear as PedidosCrear;
use App\Livewire\Pedidos\Ver   as PedidosVer;

// Locales
use App\Livewire\Locales\Index as LocalesIndex;
use App\Livewire\Locales\Crear as LocalesCrear;
use App\Livewire\Locales\Editar as LocalesEditar;

// Catálogo: Productos, Proveedores, Marcas
use App\Livewire\Productos\Index as ProductosIndex;
use App\Livewire\Productos\Crear as ProductosCrear;
use App\Livewire\Productos\Editar as ProductosEditar;

use App\Livewire\Proveedores\Index as ProveedoresIndex;
use App\Livewire\Proveedores\Crear as ProveedoresCrear;
use App\Livewire\Proveedores\Editar as ProveedoresEditar;

use App\Livewire\Marcas\Index as MarcasIndex;
use App\Livewire\Marcas\Crear as MarcasCrear;
use App\Livewire\Marcas\Editar as MarcasEditar;

// Stock
use App\Livewire\Stock\Index as StockIndex;
use App\Livewire\Stock\Ajuste as StockAjuste;
use App\Livewire\Stock\Editar as StockEditar;
/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\PedidoPrintController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

/*
|--------------------------------------------------------------------------
| Rutas protegidas
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', DashboardHome::class)
        ->middleware('permission:ver dashboard')
        ->name('dashboard');

    // =====================
    // PEDIDOS
    // =====================
    Route::get('/pedidos', PedidosIndex::class)
        ->middleware('permission:ver pedidos')
        ->name('pedidos.index');

    Route::get('/pedidos/crear', PedidosCrear::class)
        ->middleware('permission:crear pedidos')
        ->name('pedidos.crear');

    Route::get('/pedidos/{pedido}', PedidosVer::class)
        ->middleware('permission:ver pedidos')
        ->name('pedidos.ver');

    Route::get('/pedidos/{pedido}/pdf', [PedidoPrintController::class, 'pdf'])
        ->middleware('permission:ver pedidos')
        ->name('pedidos.pdf');

    // =====================
    // LOCALES
    // =====================
    Route::get('/locales', LocalesIndex::class)
        ->middleware('permission:ver locales')
        ->name('locales.index');

    Route::get('/locales/crear', LocalesCrear::class)
        ->middleware('permission:gestionar locales')
        ->name('locales.crear');

    Route::get('/locales/{local}/editar', LocalesEditar::class)
        ->middleware('permission:gestionar locales')
        ->name('locales.editar');

    // =====================
    // CATÁLOGO
    // Marcas · Productos · Proveedores
    // =====================
    Route::get('/marcas', MarcasIndex::class)
        ->middleware('permission:ver catalogo')
        ->name('marcas.index');

    Route::get('/marcas/crear', MarcasCrear::class)
        ->middleware('permission:gestionar catalogo')
        ->name('marcas.crear');

    Route::get('/marcas/{marca}/editar', MarcasEditar::class)
        ->middleware('permission:gestionar catalogo')
        ->name('marcas.editar');

    Route::get('/productos', ProductosIndex::class)
        ->middleware('permission:ver catalogo')
        ->name('productos.index');

    Route::get('/productos/crear', ProductosCrear::class)
        ->middleware('permission:gestionar catalogo')
        ->name('productos.crear');

    Route::get('/productos/{producto}/editar', ProductosEditar::class)
        ->middleware('permission:gestionar catalogo')
        ->name('productos.editar');

    Route::get('/proveedores', ProveedoresIndex::class)
        ->middleware('permission:ver catalogo')
        ->name('proveedores.index');

    Route::get('/proveedores/crear', ProveedoresCrear::class)
        ->middleware('permission:gestionar catalogo')
        ->name('proveedores.crear');

    Route::get('/proveedores/{proveedor}/editar', ProveedoresEditar::class)
        ->middleware('permission:gestionar catalogo')
        ->name('proveedores.editar');

    // =====================
    // STOCK
    // =====================
  Route::get('/stock', StockIndex::class)
        ->middleware('permission:ver stock')
        ->name('stock.index');

    Route::get('/stock/ajuste', StockAjuste::class)
        ->middleware('permission:ajustar stock')
        ->name('stock.ajuste');

    Route::get('/stock/{stock}/editar', StockEditar::class)
        ->middleware('permission:ajustar stock')
        ->name('stock.editar');
});

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
if (file_exists(__DIR__ . '/auth.php')) {
    require __DIR__ . '/auth.php';
}
