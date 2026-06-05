<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Local;
use App\Models\Pedido;
use App\Models\Stock;

class Home extends Component
{
    public function render()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | CATÁLOGO
        |--------------------------------------------------------------------------
        */
        $productos   = Producto::count();
        $proveedores = Proveedor::count();
        $locales     = Local::count();

        /*
        |--------------------------------------------------------------------------
        | PEDIDOS
        |--------------------------------------------------------------------------
        */
        if ($user->hasRole('encargado')) {

            $totalPedidos = Pedido::where(function ($q) use ($user) {
                $q->where('origen_local_id', $user->local_id)
                  ->orWhere('destino_local_id', $user->local_id)
                  ->orWhere('creado_por', $user->id);
            })->count();

            $pedidosHoy = Pedido::whereDate('created_at', now())
                ->where(function ($q) use ($user) {
                    $q->where('origen_local_id', $user->local_id)
                      ->orWhere('destino_local_id', $user->local_id)
                      ->orWhere('creado_por', $user->id);
                })->count();

        } else {

            $totalPedidos = Pedido::count();
            $pedidosHoy   = Pedido::whereDate('created_at', now())->count();
        }

        /*
        |--------------------------------------------------------------------------
        | STOCK (SIMPLE, SIN SCOPES)
        |--------------------------------------------------------------------------
        */
        if ($user->hasRole('encargado')) {

            $stockTotal = Stock::where('local_id', $user->local_id)->sum('cantidad');
            $stockLotes = Stock::where('local_id', $user->local_id)->count();

            $stockPorVencer = Stock::where('local_id', $user->local_id)
                ->whereNotNull('fecha_vencimiento')
                ->whereDate('fecha_vencimiento', '<=', now()->addDays(10))
                ->where('cantidad', '>', 0)
                ->count();

        } else {

            $stockTotal = Stock::sum('cantidad');
            $stockLotes = Stock::count();

            $stockPorVencer = Stock::whereNotNull('fecha_vencimiento')
                ->whereDate('fecha_vencimiento', '<=', now()->addDays(10))
                ->where('cantidad', '>', 0)
                ->count();
        }

        return view('livewire.dashboard.home', [
            'productos'      => $productos,
            'proveedores'    => $proveedores,
            'locales'        => $locales,
            'totalPedidos'   => $totalPedidos,
            'pedidosHoy'     => $pedidosHoy,
            'stockTotal'     => $stockTotal,
            'stockLotes'     => $stockLotes,
            'stockPorVencer' => $stockPorVencer,
        ])->layout('layouts.app', [
            'title' => 'Dashboard | Pedidos Lumen'
        ]);
    }
}
