<?php

namespace Database\Seeders\cove;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class VehicleStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql_cove')->table('roles')->insert([
            'role' => 'Sin Asignar',
            'description' => 'EL vehículo no tiene un estatus definido.',
            'created_at' => now(),
        ]);
    }
}
