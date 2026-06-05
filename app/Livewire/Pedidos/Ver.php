<?php

namespace App\Livewire\Pedidos;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pedido;
use App\Models\Archivo;
use Illuminate\Support\Facades\Storage;

class Ver extends Component
{
    use WithFileUploads;

    public Pedido $pedido;
    public $archivo;

    public function mount(Pedido $pedido)
    {
        $this->pedido = $pedido->load([
            'items.producto.marca',
            'proveedor',
            'origen',
            'destino',
            'archivos'
        ]);
    }

public function uploadArchivo()
{
    $this->validate(
    [
        'archivo' => 'required|file|max:10240|mimes:jpg,jpeg,png,pdf',
    ],
    [
        'archivo.required' => 'Debés seleccionar un archivo.',
        'archivo.file'     => 'El archivo no es válido.',
        'archivo.max'      => 'El archivo no puede superar los 10 MB.',
        'archivo.mimes'    => 'Solo se permiten archivos JPG, PNG o PDF.',
    ]
);


    // Guardar archivo
    $path = $this->archivo->store('pedidos_archivos/' . $this->pedido->id, 'public');

    Archivo::create([
    'pedido_id' => $this->pedido->id,
    'filename'  => $this->archivo->getClientOriginalName(),
    'extension' => $this->archivo->getClientOriginalExtension(), 
    'path'      => $path,
    'mime'      => $this->archivo->getMimeType(),
    'size'      => $this->archivo->getSize(),
]);


    // Resetear campo
    $this->archivo = null;

    // Recargar archivos
    $this->pedido->load('archivos');

    session()->flash('message', 'Archivo subido correctamente.');
}


    public function eliminarArchivo($archivoId)
    {
        $archivo = Archivo::findOrFail($archivoId);

        // eliminar archivo físico
        Storage::disk('public')->delete($archivo->path);

        // eliminar base
        $archivo->delete();

        // refrescar
        $this->pedido->load('archivos');
    }

    public function render()
    {
        return view('livewire.pedidos.ver')->layout('layouts.app');
    }

    public function marcarEntregado()
{
    $this->pedido->marcarComoEntregado();

    session()->flash('success', 'Pedido entregado y stock actualizado');
}

}

