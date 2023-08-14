<?php

namespace Database\Seeders\becas;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql_becas')->table('cities')->insert([ 
            'code' => '1', 
            'city' => 'GÓMEZ PALACIO', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('cities')->insert([ 
            'code' => '29', 
            'city' => 'PROPIEDAD PRIVADA GRANJA ANA', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('cities')->insert([ 
            'code' => '30', 
            'city' => 'LOS ÁNGELES', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('cities')->insert([ 
            'code' => '34', 
            'city' => 'LA AURORA', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('cities')->insert([ 
            'code' => '35', 
            'city' => 'PEQUEÑA BAHÍA', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('cities')->insert([ 
            'code' => '36', 
            'city' => 'EL BARRO', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('cities')->insert([ 
            'code' => '37', 
            'city' => 'BELLA UNIÓN', 
            'created_at' => now(),
        ]);
        DB::connection('mysql_becas')->table('cities')->insert([ 
            'code' => '39', 
            'city' => 'BERLÍN', 
            'created_at' => now(),
        ]);
    }
}