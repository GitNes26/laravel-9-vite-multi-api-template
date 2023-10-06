<?php

namespace Database\Seeders\GomezApp;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AsuntosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql_gomezapp')->table('asuntos')->insert([
            'asunto' => 'BACHEO'
            
        ]);
    }
}
