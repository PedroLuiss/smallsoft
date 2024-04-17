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
            [ 'name' => 'Cliente 1',
              'identificacion'=> 'id-1580513',
              'telefono'=> '+5829653265256',
              'person_contact'=> '+49132185256',
              'correo'=>"Cliente1@gmail.com",
              'pais'=>"Venezuela",
              'otros'=>"Example",
              'direccion'=>"Direccion1 y direccion2",
              'created_at'=>date("Y-m-d H:i:s"),
              'updated_at'=>date("Y-m-d H:i:s")
            ],[ 'name' => 'Cliente 2',
                'identificacion'=> 'id-1580513',
                'telefono'=> '+5829653265256',
                'person_contact'=> '+49132185256',
                'correo'=>"Cliente2@gmail.com",
                'pais'=>"Venezuela",
                'otros'=>"Example",
                'direccion'=>"Direccion1 y direccion2",
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ],[ 'name' => 'Cliente 3',
                'identificacion'=> 'id-1580513',
                'telefono'=> '+5829653265256',
                'person_contact'=> '+49132185256',
                'correo'=>"Cliente3@gmail.com",
                'pais'=>"Venezuela",
                'otros'=>"Example",
                'direccion'=>"Direccion1 y direccion2",
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]

        ];
          DB::table('clientes')->insert($data);
    }
}
