<?php

namespace Database\Seeders;

use App\Livewire\Catalogos\TipoDeObservacion\ObservationType;
use App\Livewire\Configuracion\Usuarios\Catalogos\Permiso\Permission;
use App\Livewire\Visitas\Visita\Visit;
use App\Models\User;
use Carbon\Unit;
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
            UnitTypeSeeder::class,
            UnitColorSeeder::class,
            ObservationTypeSeeder::class,
            UserSeeder::class,
            VisitSeeder::class,
        ]);
    }
}
