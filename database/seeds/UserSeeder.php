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
            'email' => 'superadministrador@example.com',
            'password' => bcrypt('123456'),
            'es_superadmin' => 'S'
        ]);
    }
}
