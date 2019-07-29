<?php

use Illuminate\Database\Seeder;

class EmpresaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresa')->insert([
            'nome' => 'Microsoft'
        ]);

        DB::table('empresa')->insert([
            'nome' => 'Apple'
        ]);
    }
}
