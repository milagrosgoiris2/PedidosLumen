<? 
namespace App\Services;

use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class StockService
{
    public function descontarPorPedido($pedido)
    {
        DB::transaction(function () use ($pedido) {
            foreach ($pedido->items as $item) {
                $this->descontarLotes(
                    $pedido->local_origen_id,
                    $item->producto_id,
                    $item->cantidad
                );
            }
        });
    }

    private function descontarLotes($localId, $productoId, $cantidad)
    {
        $lotes = Stock::where('local_id', $localId)
            ->where('producto_id', $productoId)
            ->where('cantidad', '>', 0)
            ->orderBy('fecha_vencimiento')
            ->lockForUpdate()
            ->get();

        foreach ($lotes as $lote) {
            if ($cantidad <= 0) break;

            if ($lote->cantidad >= $cantidad) {
                $lote->cantidad -= $cantidad;
                $lote->save();
                $cantidad = 0;
            } else {
                $cantidad -= $lote->cantidad;
                $lote->cantidad = 0;
                $lote->save();
            }
        }
    }
}
