<?php

namespace Database\Seeders\becas;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql_becas')->table('schools')->insert([ 
            'code' => '10DPR0697Z', 
            'school' => 'PDTE ADOLFO LOPEZ MATEOS', 
            'address' => 'CUAUHTEMOC Y ESCOBEDO COL SANTA ROSA', 
            'city_id' => 1, 
            'colony_id' => 1, 
            'tel' => '8717143002', 
            'director' => 'MARIA GUADALUPE VAZQUEZ RAMOS', 
            'type' => 'U', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('schools')->insert([ 
            'code' => '10EPR0099C', 
            'school' => 'ESCUELA PRIMARIA 20 DE NOVIEMBRE', 
            'address' => 'SANTIAGO LAVIN 260 PTE', 
            'city_id' => 1, 
            'colony_id' => 2, 
            'tel' => '8717141411', 
            'director' => 'MA. GUILLERMINA CISNEROS VALDEZ', 
            'type' => 'U', 
            'created_at' => now(),
        ]);
    }
}