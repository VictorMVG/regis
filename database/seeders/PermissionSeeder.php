<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'VISUALIZAR TODAS LAS VISITAS',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'VISUALIZAR LAS VISITAS DIARIAS',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'CREAR VISITA',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'EDITAR VISITA',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'VER DETALLES DE LA VISITA',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'ELIMINAR VISITA',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'DESCARGAR EXCEL DE VISITAS DIARIAS',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'DESCARGAR EXCEL DE TODAS LAS VISITAS',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'VISUALIZAR TODAS LAS BITACORAS',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'VISUALIZAR LAS BITACORAS DIARIAS',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'CREAR BITACORA',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'EDITAR BITACORA',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'VER DETALLES DE LA BITACORA',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'ELIMINAR BITACORA',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'DESCARGAR EXCEL DE BITACORAS DIARIAS',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'DESCARGAR EXCEL DE TODAS LAS BITACORAS',
                'guard_name' => 'sanctum',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
