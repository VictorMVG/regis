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
            [
                'name' => 'VISUALIZAR USUARIOS',
            ],
            [
                'name' => 'CREAR USUARIO',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'EDITAR USUARIO',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'VER DETALLES DEL USUARIO',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'ELIMINAR USUARIO',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'VISUALIZAR SEDES',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'CREAR SEDE',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'EDITAR SEDE',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'VER DETALLES DE LA SEDE',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'ELIMINAR SEDE',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'VISUALIZAR EMPRESAS',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'CREAR EMPRESA',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'EDITAR EMPRESA',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'VER DETALLES DE LA EMPRESA',
                'guard_name' => 'sanctum',
            ]
            ,
            [
                'name' => 'ELIMINAR EMPRESA',
                'guard_name' => 'sanctum',
            ],
            // CATALOGO
            [
                'name' => 'VISUALIZAR CATALOGOS',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'CREAR CATALOGO',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'EDITAR CATALOGO',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'VER DETALLES DEL CATALOGO',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'ELIMINAR CATALOGO',
                'guard_name' => 'sanctum',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']], // Condición para buscar el permiso existente
                $permission // Datos para crear o actualizar
            );
        }
    }
}
