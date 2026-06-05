<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Archivo extends Model
{
    protected $fillable = [
        'pedido_id',
        'filename',
        'path',
        'mime',
        'extension',
        'size',
    ];

    public function url()
    {
        return Storage::disk('public')->url($this->path);
    }

    public function esImagen()
    {
        return str_starts_with($this->mime, 'image/');
    }
}
