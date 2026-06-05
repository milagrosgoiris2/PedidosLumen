<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('archivos', function (Blueprint $table) {

            // Ruta completa dentro de storage (ej: pedidos/8/img123.png)
            $table->string('path')->after('filename');

            // Extensión del archivo (jpg, png, pdf)
            $table->string('extension', 10)->after('mime');
        });
    }

    public function down(): void
    {
        Schema::table('archivos', function (Blueprint $table) {
            $table->dropColumn(['path', 'extension']);
        });
    }
};
