<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// use Database\Seeders\cove\RoleSeeder;
// use Database\Seeders\cove\VehicleStatusSeeder;
use Illuminate\Database\Seeder;

class DatabaseCoveSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            cove\RoleSeeder::class,
            cove\DepartamentSeeder::class,
            cove\VehicleStatusSeeder::class,
            cove\UserSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
