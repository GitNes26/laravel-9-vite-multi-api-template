<?php

namespace Database\Seeders\becas;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ColonySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql_becas')->table('colonies')->insert([ 
            'code' => '0', 
            'colony' => 'SIN COLONIA', 
            'cp' => '35029', 
            'perimeter_id' => '1', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('colonies')->insert([ 
            'code' => '1', 
            'colony' => 'EL REFUGIO', 
            'cp' => '0',  
            'perimeter_id' => '2', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('colonies')->insert([ 
            'code' => '30', 
            'colony' => 'EJIDO LAS MASITAS', 
            'cp' => '35000', 
            'perimeter_id' => '2', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('colonies')->insert([ 
            'code' => '37', 
            'colony' => 'POBLADO BELLA UNION', 
            'cp' => '35000', 
            'perimeter_id' => '3', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('colonies')->insert([ 
            'code' => '40', 
            'colony' => 'EJIDO BRITTINGHAM', 
            'cp' => '35000', 
            'perimeter_id' => '4', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('colonies')->insert([ 
            'code' => '41', 
            'colony' => 'EJIDO BUCARELI',
            'cp' => '35000', 
            'perimeter_id' => '3', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('colonies')->insert([ 
            'code' => '49', 
            'colony' => 'EJIDO COMPETENCIA', 
            'cp' => '35000', 
            'perimeter_id' => '2', 
            'created_at' => now(),
        ]);
    }
}