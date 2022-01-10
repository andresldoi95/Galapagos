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
        // Accion::create([
        //     'id' => 'aprobar_declaraciones_juramentadas',
        //     'descripcion' => 'Aprobar declaraciones juramentadas',
        //     'modulo_id' => 'declar'
        // ]);
        // Accion::create([
        //     'id' => 'crear_productos',
        //     'descripcion' => 'Crear productos',
        //     'modulo_id' => 'prods'
        // ]);
        // Accion::create([
        //     'id' => 'editar_productos',
        //     'descripcion' => 'Editar productos',
        //     'modulo_id' => 'prods'
        // ]);
        // Accion::create([
        //     'id' => 'eliminar_productos',
        //     'descripcion' => 'Eliminar productos',
        //     'modulo_id' => 'prods'
        // ]);
        // Accion::create([
        //     'id' => 'reactivar_productos',
        //     'descripcion' => 'Re-activar productos',
        //     'modulo_id' => 'prods'
        // ]);
        // Accion::create([
        //     'id' => 'consultar_roles_productos',
        //     'descripcion' => 'Consultar productos',
        //     'modulo_id' => 'prods'
        // ]);
        // Accion::create([
        //     'id' => 'registrar_retencion',
        //     'descripcion' => 'Registrar retenciones',
        //     'modulo_id' => 'rets'
        // ]);
        // Accion::create([
        //     'id' => 'editar_retencion',
        //     'descripcion' => 'Editar retenciones',
        //     'modulo_id' => 'rets'
        // ]);
        // Accion::create([
        //     'id' => 'anular_retencion',
        //     'descripcion' => 'Anular retenciones',
        //     'modulo_id' => 'rets'
        // ]);
        Accion::create([
            'id' => 'consultar_retenciones',
            'descripcion' => 'Consultar retenciones',
            'modulo_id' => 'rets'
        ]);
    }
}
