<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'CI', 'estado' => 1],
            ['nombre' => 'EX', 'estado' => 1],
            ['nombre' => 'OTROS', 'estado' => 1],
        ];

        DB::table('tipo_documentos')->insert($tipos);
    }
}
