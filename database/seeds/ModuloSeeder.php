<?php

use App\Modulo;
use Illuminate\Database\Seeder;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modulo::create([
            'id' => 'usuarios',
            'nombre' => 'Usuarios'
        ]);
        Modulo::create([
            'id' => 'roles',
            'nombre' => 'Roles de usuario'
        ]);
    }
}
