<?php

namespace Database\Seeders;

use App\Livewire\Configuracion\Usuarios\Catalogos\Permiso\Permission;
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

        $this->call([
            StatusSeeder::class,
            CompanySeeder::class,
            HeadquarterSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            // UserSeeder::class,
        ]);

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
