<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Barryvdh\DomPDF\Facade\Pdf;

class PedidoPrintController extends Controller
{
    public function pdf(Pedido $pedido)
    {
        // Cargamos relaciones necesarias
        $pedido->load([
            'items.producto',
            'proveedor',
            'origen',
            'destino'
        ]);

        // Renderizamos la vista PDF
        $pdf = Pdf::loadView('pdf.pedido', [
            'pedido' => $pedido
        ]);

        // Descargar PDF
        return $pdf->download("pedido_{$pedido->id}.pdf");
    }
}
