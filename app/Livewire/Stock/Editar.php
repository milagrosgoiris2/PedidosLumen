<?php

namespace App\Livewire\Stock;

use Livewire\Component;
use App\Models\Stock;

class Editar extends Component
{
    public Stock $stock;
    public $cantidad;
    public $fecha_vencimiento;

    public function mount(Stock $stock)
    {
        if (auth()->user()->hasRole('encargado')) {
            abort_if(
                $stock->local_id !== auth()->user()->local_id,
                403
            );
        }

        $this->stock = $stock;
        $this->cantidad = $stock->cantidad;
        $this->fecha_vencimiento = $stock->fecha_vencimiento;
    }

    public function guardar()
    {
        $this->validate([
            'cantidad' => 'required|numeric|min:0',
            'fecha_vencimiento' => 'nullable|date',
        ]);

        $this->stock->update([
            'cantidad' => $this->cantidad,
            'fecha_vencimiento' => $this->fecha_vencimiento,
        ]);

        session()->flash('success', 'Stock actualizado');

        return redirect()->route('stock.index');
    }

    public function render()
    {
        return view('livewire.stock.editar')
            ->layout('layouts.app', ['title' => 'Editar stock']);
    }
}
