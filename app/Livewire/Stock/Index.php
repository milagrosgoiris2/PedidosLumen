<?php

namespace App\Livewire\Stock;

use Livewire\Component;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public function eliminar($id)
    {
        $stock = Stock::findOrFail($id);

        if (Auth::user()->hasRole('encargado')) {
            abort_if(
                $stock->local_id !== Auth::user()->local_id,
                403
            );
        }

        $stock->delete();

        session()->flash('success', 'Lote eliminado');
    }

    public function render()
    {
        $user = Auth::user();

        $query = Stock::with(['producto.marca']);

        if ($user->hasRole('encargado')) {
            $query->where('local_id', $user->local_id);
        }

        return view('livewire.stock.index', [
            'stocks' => $query
                ->orderBy('fecha_vencimiento')
                ->get(),
        ])->layout('layouts.app', ['title' => 'Stock']);
    }
}
