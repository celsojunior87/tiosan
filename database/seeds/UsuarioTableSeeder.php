<?php

use Illuminate\Database\Seeder;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Sr. Sanley TIO SAN',
            'role' => 'admin',
            'email' => 'sanley@gmail.com',
            'password' => bcrypt('0819ts'),
            'id_empresa' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'Usuário comum Empresa 1',
            'email' => 'user@user.com',
            'password' => bcrypt('123456'),
            'id_empresa' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'Jr admin empresa 2',
            'email' => 'admin@empresa2.com',
            'password' => bcrypt('123456'),
            'role' => 'admin',
            'id_empresa' => 2
        ]);
    }
}
