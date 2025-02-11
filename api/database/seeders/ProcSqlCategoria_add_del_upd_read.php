<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcSqlCategoria_add_del_upd_read extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // En tu código PHP (Laravel o similar)
        DB::statement('DROP PROCEDURE IF EXISTS proc_categoria_add_upd_del_read');
        DB::statement("
                CREATE PROCEDURE proc_categoria_add_upd_del_read (
                    IN accion VARCHAR(20),
                    IN id INT,
                    IN nombre VARCHAR(255),
                    IN estado BOOLEAN,
                    IN created_at DATETIME,
                    IN updated_at DATETIME
                )
                BEGIN
                    DECLARE mensaje VARCHAR(255);

                    IF accion = 'add' THEN
                        INSERT INTO categorias (nombre, estado, created_at, updated_at)
                        VALUES (nombre, estado, NOW(), NOW());
                        SET mensaje = 'Categoría agregada correctamente.';
                    ELSEIF accion = 'del' THEN
                        DELETE FROM categorias WHERE id = id;
                        SET mensaje = 'Categoría eliminada correctamente.';
                    ELSEIF accion = 'upd' THEN
                        UPDATE categorias
                        SET nombre = nombre, estado = estado, updated_at = NOW()
                        WHERE id = id;
                        SET mensaje = 'Categoría actualizada correctamente.';
                    ELSEIF accion = 'read' THEN
                        SELECT id, nombre, estado, created_at, updated_at
                        FROM categorias
                        WHERE id = id;
                        SET mensaje = 'Detalle de categoría mostrado.';
                    ELSE
                        SET mensaje = 'Acción inválida.';
                    END IF;

                    SELECT mensaje;
                END;");

                /**
                 *
                 * Su Uso
                 * CALL proc_categoria_add_upd_del_read('agregar', NULL, 'Nueva Categoría', TRUE, NULL, NULL);
                 * CALL proc_categoria_add_upd_del_read('eliminar', 5, NULL, NULL, NULL, NULL);
                 * CALL proc_categoria_add_upd_del_read('actualizar', 3, 'Categoría Actualizada', FALSE, NULL, NULL);
                 * CALL proc_categoria_add_upd_del_read('ver', 2, NULL, NULL, NULL, NULL);
                 */
    }
}
