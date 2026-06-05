<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\StockService;

class Pedido extends Model
{
    protected $fillable = [
        'tipo',
        'origen_local_id',
        'destino_local_id',
        'proveedor_id',
        'estado',
        'total_estimado',
        'creado_por'
    ];

    public $timestamps = true;

    /** Estados posibles */
    public static function labels(): array
    {
        return [
            0 => 'Borrador',
            1 => 'Aprobado',
            2 => 'Enviado',
            3 => 'Recibido',
            4 => 'Cancelado',
        ];
    }

    /** Cambiar estado de forma segura */
    public function cambiarEstado(int $nuevoEstado): void
    {
        if (!array_key_exists($nuevoEstado, self::labels())) {
            throw new \Exception("Estado inválido");
        }

        $this->estado = $nuevoEstado;
        $this->save();
    }

    /** Nombre del estado */
    public function estadoNombre(): string
    {
        return self::labels()[$this->estado] ?? 'Desconocido';
    }

    /** Relaciones */
    public function items()
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function origen()
    {
        return $this->belongsTo(Local::class, 'origen_local_id');
    }

    public function destino()
    {
        return $this->belongsTo(Local::class, 'destino_local_id');
    }

    public function archivos()
    {
        return $this->hasMany(\App\Models\Archivo::class);
    }

    public function marcarComoEntregado()
{
    if ($this->estado === 'entregado') {
        return;
    }

    app(StockService::class)->descontarPorPedido($this);

    $this->estado = 'entregado';
    $this->save();
}

}
