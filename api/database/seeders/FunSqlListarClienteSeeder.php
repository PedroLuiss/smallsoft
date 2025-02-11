<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FunSqlListarClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // En tu código PHP (Laravel o similar)
        DB::statement('DROP PROCEDURE IF EXISTS listar_clientes');
        DB::statement('
            CREATE DEFINER=`root`@`localhost` PROCEDURE listar_clientes()
            BEGIN
                SELECT id, nombre_apellido, tipo_documento, numero_documento, email, direccion, telefono, deuda, estado, created_at, updated_at FROM clientes;
            END;
        ');
    }
}
