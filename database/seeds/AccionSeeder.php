<?php

use App\Accion;
use Illuminate\Database\Seeder;

class AccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Accion::create([
        //     'id' => 'crear_usuarios',
        //     'descripcion' => 'Crear usuarios',
        //     'modulo_id' => 'usuarios'
        // ]);
        // Accion::create([
        //     'id' => 'editar_usuarios',
        //     'descripcion' => 'Editar usuarios',
        //     'modulo_id' => 'usuarios'
        // ]);
        // Accion::create([
        //     'id' => 'eliminar_usuarios',
        //     'descripcion' => 'Eliminar usuarios',
        //     'modulo_id' => 'usuarios'
        // ]);
        // Accion::create([
        //     'id' => 'reactivar_usuarios',
        //     'descripcion' => 'Re-activar usuarios',
        //     'modulo_id' => 'usuarios'
        // ]);
        // Accion::create([
        //     'id' => 'consultar_usuarios',
        //     'descripcion' => 'Consultar usuarios',
        //     'modulo_id' => 'usuarios'
        // ]);

        // Accion::create([
        //     'id' => 'crear_roles',
        //     'descripcion' => 'Crear roles de usuario',
        //     'modulo_id' => 'roles'
        // ]);
        // Accion::create([
        //     'id' => 'editar_roles',
        //     'descripcion' => 'Editar roles de usuario',
        //     'modulo_id' => 'roles'
        // ]);
        // Accion::create([
        //     'id' => 'eliminar_roles',
        //     'descripcion' => 'Eliminar roles de usuario',
        //     'modulo_id' => 'roles'
        // ]);
        // Accion::create([
        //     'id' => 'reactivar_roles',
        //     'descripcion' => 'Re-activar roles de usuario',
        //     'modulo_id' => 'roles'
        // ]);
        // Accion::create([
        //     'id' => 'consultar_roles_usuario',
        //     'descripcion' => 'Consultar roles de usuario',
        //     'modulo_id' => 'roles'
        // ]);
        Accion::create([
            'id' => 'aprobar_declaraciones_juramentadas',
            'descripcion' => 'Aprobar declaraciones juramentadas',
            'modulo_id' => 'declar'
        ]);
    }
}
