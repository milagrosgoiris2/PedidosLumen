<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();

            // Relación al pedido
            $table->foreignId('pedido_id')
                ->constrained('pedidos')
                ->cascadeOnDelete();

            // Nombre único del archivo almacenado
            $table->string('filename');

            // Tipo MIME del archivo (image/jpeg, image/png, etc.)
            $table->string('mime', 120)->nullable();

            // Tamaño del archivo en bytes
            $table->integer('size')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
