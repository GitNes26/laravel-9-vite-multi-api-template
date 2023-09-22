<?php

namespace Database\Seeders\GomezApp;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class TiposReportesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql_gomezapp')->table('tipos_reportes')->insert([
            'tipo_nombre' => 'BACHEO',
            'bg_circle' => 'green',
            'bg_card' => '#1F2227',
            'icono' => '',
            'letter_black' => 1,
            'active' => 1,
            'created_at' => now(),
        ]);
        DB::connection('mysql_gomezapp')->table('tipos_reportes')->insert([
            'tipo_nombre' => 'BASURA',
            'bg_circle' => 'yellow',
            'bg_card' => '#1F2227',
            'icono' => '',
            'letter_black' => 1,
            'active' => 1,
            'created_at' => now(),
        ]);
        DB::connection('mysql_gomezapp')->table('tipos_reportes')->insert([
            'tipo_nombre' => 'ECOLOGIA',
            'bg_circle' => 'coral',
            'bg_card' => '#1F2227',
            'icono' => '',
            'letter_black' => 1,
            'active' => 1,
            'created_at' => now(),
        ]);
        DB::connection('mysql_gomezapp')->table('tipos_reportes')->insert([
            'tipo_nombre' => 'ALUMBRADO PUBLICO',
            'bg_circle' => 'red',
            'bg_card' => '#1F2227',
            'icono' => '',
            'letter_black' => 1,
            'active' => 1,
            'created_at' => now(),
        ]);
        DB::connection('mysql_gomezapp')->table('tipos_reportes')->insert([
            'tipo_nombre' => 'VIGILANCIA',
            'bg_circle' => 'blue',
            'bg_card' => '#1F2227',
            'icono' => '',
            'letter_black' => 1,
            'active' => 1,
            'created_at' => now(),
        ]);
    }
}
