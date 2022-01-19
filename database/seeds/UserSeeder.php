<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Superadministrador',
            'email' => 'superadministrador@abg-galapagos.info',
            'password' => bcrypt('Password.1'),
            'es_superadmin' => 'S'
        ]);
    }
}
