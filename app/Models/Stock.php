<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'local_id',
        'producto_id',
        'cantidad',
        'fecha_vencimiento',
        'fecha_ingreso',
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'fecha_ingreso' => 'date',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function local()
    {
        return $this->belongsTo(Local::class);
    }
}
