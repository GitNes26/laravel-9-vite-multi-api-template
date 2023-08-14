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
            'colony' => 'COL. EL REFUGIO', 
            'cp' => '35029', 
            'perimeter' => 'URBANO', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('colonies')->insert([ 
            'code' => '1', 
            'colony' => 'SIN COLONIA', 
            'cp' => '0',  
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('colonies')->insert([ 
            'code' => '30', 
            'colony' => 'EJIDO LAS MASITAS', 
            'cp' => '35000', 
            'perimeter' => 'SACRAMENTO', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('colonies')->insert([ 
            'code' => '37', 
            'colony' => 'POBLADO BELLA UNION', 
            'cp' => '35000', 
            'perimeter' => 'CENTRO', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('colonies')->insert([ 
            'code' => '40', 
            'colony' => 'EJIDO BRITTINGHAM', 
            'cp' => '35000', 
            'perimeter' => 'LAVIN', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('colonies')->insert([ 
            'code' => '41', 
            'colony' => 'EJIDO BUCARELI', 
            'cp' => '35000', 
            'perimeter' => 'LAVIN', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('colonies')->insert([ 
            'code' => '49', 
            'colony' => 'EJIDO COMPETENCIA', 
            'cp' => '35000', 
            'perimeter' => 'LAVIN', 
            'created_at' => now(),
        ]);
    }
}