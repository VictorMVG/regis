<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'USUARIO DE PRUEBA',
            'email' => 'ADMIN@GMAIL.COM',
            'password' => bcrypt('12345678'),
            'status_id' => 1,
            'company_id' => 1,
        ]);

        $user->assignRole('SUPER USUARIO');
    }
}
