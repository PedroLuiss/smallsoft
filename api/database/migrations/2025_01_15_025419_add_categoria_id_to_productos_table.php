<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')->after('precio_venta')->nullable(); // Agregar la columna
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade'); // Crear la relación
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']); // Eliminar la restricción al revertir
            $table->dropColumn('categoria_id'); // Eliminar la columna al revertir
        });
    }
};
