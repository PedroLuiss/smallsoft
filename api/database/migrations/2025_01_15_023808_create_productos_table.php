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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->double('precio_costo')->nullable();
            $table->double('precio_venta')->nullable();
            // $table->unsignedBigInteger('categoria_id'); // Modificado: unsignedBigInteger y unsigned
            $table->float('stock')->nullable();
            $table->float('stock_minimo')->nullable();
            $table->integer('estado');
            $table->string('foto')->nullable();
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
