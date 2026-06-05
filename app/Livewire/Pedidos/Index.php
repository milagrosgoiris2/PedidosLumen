<?php

namespace App\Livewire\Pedidos;

use Livewire\Component;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public string $search = '';

    /**
     * Cambiar estado del pedido
     */
    public function cambiarEstado(int $pedidoId, int $nuevoEstado)
{
    abort_if(
        !auth()->user()->can('aprobar pedidos'),
        403,
        'No tenés permiso para cambiar el estado'
    );

 
        $pedido = Pedido::findOrFail($pedidoId);

        // Evitar cambios inválidos
        if ($pedido->estado == 4) {
            return; // cancelado no se toca
        }

        $pedido->update([
            'estado' => $nuevoEstado,
        ]);

        session()->flash('success', 'Estado del pedido actualizado');
    }

    public function render()
    {
        $user = Auth::user();

        $query = Pedido::query();

        // ENCARGADO → solo pedidos que le corresponden
        if ($user->hasRole('encargado')) {
            $query->where(function ($q) use ($user) {

                // Entre locales
                $q->where(function ($sub) use ($user) {
                    $sub->where('origen_local_id', $user->local_id)
                        ->orWhere('destino_local_id', $user->local_id);
                })

                // A proveedor creados por él
                ->orWhere(function ($sub) use ($user) {
                    $sub->where('tipo', 1)
                        ->where('creado_por', $user->id);
                });

            });
        }

        // Buscar por ID
        if ($this->search !== '') {
            $query->where('id', $this->search);
        }

        return view('livewire.pedidos.index', [
            'pedidos' => $query->latest()->get(),
        ])->layout('layouts.app', [
            'title' => 'Pedidos',
        ]);
    }
}
