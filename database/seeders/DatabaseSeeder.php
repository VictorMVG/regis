<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'USUARIO DE PRUEBA',
            'email' => 'ADMIN@GMAIL.COM',
            'password' => bcrypt('12345678'),
        ]);

        $this->call([
            StatusSeeder::class,
            CompanySeeder::class,
            // UserSeeder::class,
        ]);
    }
}
