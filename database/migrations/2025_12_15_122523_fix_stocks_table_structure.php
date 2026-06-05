<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('stocks', function (Blueprint $table) {

            // producto
            if (!Schema::hasColumn('stocks', 'producto_id')) {
                $table->foreignId('producto_id')
                    ->after('local_id')
                    ->constrained('productos')
                    ->cascadeOnDelete();
            }

            // cantidad
            if (!Schema::hasColumn('stocks', 'cantidad')) {
                $table->decimal('cantidad', 12, 3)
                    ->default(0)
                    ->after('producto_id');
            }

            // fecha de vencimiento
            if (!Schema::hasColumn('stocks', 'fecha_vencimiento')) {
                $table->date('fecha_vencimiento')
                    ->nullable()
                    ->after('cantidad');
            }
        });
    }

    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            if (Schema::hasColumn('stocks', 'fecha_vencimiento')) {
                $table->dropColumn('fecha_vencimiento');
            }
            if (Schema::hasColumn('stocks', 'cantidad')) {
                $table->dropColumn('cantidad');
            }
            if (Schema::hasColumn('stocks', 'producto_id')) {
                $table->dropForeign(['producto_id']);
                $table->dropColumn('producto_id');
            }
        });
    }
};
