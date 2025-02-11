<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcSqlCliente_add_del_upd extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // En tu código PHP (Laravel o similar)
        DB::statement('DROP PROCEDURE IF EXISTS proc_cliente_add_del_upd');
        DB::statement("
           CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_cliente_add_del_upd`(
            IN p_id INT,
            IN p_nombre_apellido VARCHAR(255),
            IN p_tipo_documento VARCHAR(20),
            IN p_numero_documento VARCHAR(20),
            IN p_email VARCHAR(255),
            IN p_direccion TEXT,
            IN p_telefono VARCHAR(20),
            IN p_deuda DECIMAL(10,2),
            IN p_estado ENUM('activo', 'inactivo'),
            IN p_accion ENUM('add', 'upd', 'del'),
            OUT p_mensaje VARCHAR(255)
        )
        main_block: BEGIN  -- Añadida etiqueta main_block
            DECLARE existing_email_count INT DEFAULT 0;
            DECLARE existing_documento_count INT DEFAULT 0;
            DECLARE EXIT HANDLER FOR SQLEXCEPTION
            BEGIN
                GET DIAGNOSTICS CONDITION 1 p_mensaje = MESSAGE_TEXT;
                ROLLBACK;
            END;

            -- Validación de email con expresión regular
            IF p_email NOT REGEXP '^[^@]+@[^@]+\.[^@]+$' THEN
                SET p_mensaje = 'Dirección de correo electrónico inválida.';
                LEAVE main_block;
            END IF;

            -- Consultas SELECT fuera de la transacción
            SELECT COUNT(*) INTO existing_email_count FROM clientes WHERE email = p_email AND id != p_id;
            SELECT COUNT(*) INTO existing_documento_count FROM clientes WHERE numero_documento = p_numero_documento AND id != p_id;


            IF existing_email_count > 0 THEN
                SET p_mensaje = CONCAT('El email ', p_email, ' ya existe.');
                LEAVE main_block; -- Ahora se usa la etiqueta main_block
            END IF;

            IF existing_documento_count > 0 THEN
                SET p_mensaje = CONCAT('El número de documento ', p_numero_documento, ' ya existe.');
                LEAVE main_block; -- Ahora se usa la etiqueta main_block
            END IF;

            IF p_accion != 'del' THEN
                START TRANSACTION;
            END IF;

            CASE p_accion
                WHEN 'add' THEN
                    INSERT INTO clientes (nombre_apellido, tipo_documento, numero_documento, email, direccion, telefono, deuda, estado, created_at, updated_at)
                    VALUES (p_nombre_apellido, p_tipo_documento, p_numero_documento, p_email, p_direccion, p_telefono, p_deuda, p_estado,NOW(),NOW());
                    SET p_mensaje = 'Cliente agregado correctamente.';
                WHEN 'upd' THEN
                    UPDATE clientes
                    SET nombre_apellido = p_nombre_apellido,
                        tipo_documento = p_tipo_documento,
                        numero_documento = p_numero_documento,
                        email = p_email,
                        direccion = p_direccion,
                        telefono = p_telefono,
                        deuda = p_deuda,
                        estado = p_estado,
                        updated_at = NOW()
                    WHERE id = p_id;
                    SET p_mensaje = 'Cliente actualizado correctamente.';
                WHEN 'del' THEN
                    DELETE FROM clientes WHERE id = p_id;
                    SET p_mensaje = 'Cliente eliminado correctamente.';
                ELSE
                    SET p_mensaje = 'Acción inválida.';
            END CASE;

            IF p_accion != 'del' THEN
                COMMIT;
            END IF;

        END main_block
        ");
    }
}
