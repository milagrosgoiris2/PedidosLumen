<?php

namespace App\Livewire\Stock;

use Livewire\Component;
use App\Models\Stock;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class Ajuste extends Component
{
    public $producto_id;
    public $cantidad;
    public $fecha_vencimiento;

    public function guardar()
    {
        $this->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:0.001',
            'fecha_vencimiento' => 'nullable|date',
        ]);

        Stock::create([
            'producto_id' => $this->producto_id,
            'local_id' => Auth::user()->local_id,
            'cantidad' => $this->cantidad,
            'fecha_vencimiento' => $this->fecha_vencimiento,
            'fecha_ingreso' => now(),
        ]);

        session()->flash('success', 'Lote creado correctamente');

        $this->reset(['producto_id', 'cantidad', 'fecha_vencimiento']);
    }

    public function render()
    {
        return view('livewire.stock.ajuste', [
                    'productos' => Producto::with('marca')->orderBy('nombre')->get(),
        ])->layout('layouts.app', ['title' => 'Ajustar stock']);
    }
}
