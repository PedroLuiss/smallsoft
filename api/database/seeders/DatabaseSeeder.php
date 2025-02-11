<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersSeeder::class);
        // $this->call(ClienteSeeder::class);
        $this->call([
            UsersSeeder::class,
            ClienteSeeder::class,
            FunSqlListarClienteSeeder::class,
            ProcSqlCliente_add_del_upd::class,
            ProcSqlCategoria_add_del_upd_read::class,
            FuncListarCategoriaSeeder::class,
            TipoDocumentoSeeder::class,
         ]);
    }
}
