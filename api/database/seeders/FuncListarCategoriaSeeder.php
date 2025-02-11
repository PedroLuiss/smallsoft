<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuncListarCategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // En tu código PHP (Laravel o similar)
        DB::statement('DROP PROCEDURE IF EXISTS list_categoria');
        DB::statement("
        CREATE PROCEDURE list_categoria()
        BEGIN
             SELECT id, nombre
                FROM smallsoftapi.categorias;
        END;");
    }

    /**
     * Ejecucion
     * SELECT id, nombre
    *FROM smallsoftapi.categorias;
     */
}
