<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'nombre_apellido' => 'Cliente 1',
                'tipo_documento'=> 'CI',
                'numero_documento'=> '45581215',
                'email'=> 'Cliente1@gmail.com',
                'direccion'=>"asdksnmdklm ks kmdklñs",
                'telefono'=>"150515055",
                'deuda'=>0,
                'estado'=>1,
            ],[ 'nombre_apellido' => 'Cliente 2',
                'tipo_documento'=> 'CI',
                'numero_documento'=> '2434345',
                'email'=> 'Cliente2@gmail.com',
                'direccion'=>"asdksnmdklm ks kmdklñs",
                'telefono'=>"150515055",
                'deuda'=>0,
                'estado'=>1,
            ]

        ];
          DB::table('clientes')->insert($data);
    }
}
