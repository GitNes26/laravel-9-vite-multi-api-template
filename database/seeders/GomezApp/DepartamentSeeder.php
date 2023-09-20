<?php

namespace Database\Seeders\GomezApp;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DepartamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql_gomezapp')->table('departments')->insert([
            'department' => 'No Aplica',
            'description' => 'Para asignar a usuarios administrativos.',
            'created_at' => now(),
        ]);
    }
}
