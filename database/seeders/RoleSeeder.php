<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'GUARDIA',
                'permissions' => [
                    'VISUALIZAR LAS VISITAS DIARIAS',
                    'CREAR VISITA',
                    'CREAR BITACORA',
                    'EDITAR BITACORA',
                    'VER DETALLES DE LA BITACORA',
                ],
            ],
            [
                'name' => 'ADMINISTRADOR DE SEDE',
                'permissions' => [
                    'VISUALIZAR LAS VISITAS DIARIAS',
                    'VISUALIZAR TODAS LAS VISITAS',
                    'CREAR VISITA',
                    'EDITAR VISITA',
                    'VER DETALLES DE LA VISITA',
                    'DESCARGAR EXCEL DE VISITAS DIARIAS',
                    'DESCARGAR EXCEL DE TODAS LAS VISITAS',
                    'VISUALIZAR LAS BITACORAS DIARIAS',
                    'VISUALIZAR TODAS LAS BITACORAS',
                    'CREAR BITACORA',
                    'EDITAR BITACORA',
                    'VER DETALLES DE LA BITACORA',
                    'DESCARGAR EXCEL DE BITACORAS DIARIAS',
                    'DESCARGAR EXCEL DE TODAS LAS BITACORAS',
                ],
            ],
            [
                'name' => 'ADMINISTRADOR GENERAL',
                'permissions' => [
                    'VISUALIZAR LAS VISITAS DIARIAS',
                    'VISUALIZAR TODAS LAS VISITAS',
                    'CREAR VISITA',
                    'EDITAR VISITA',
                    'ELIMINAR VISITA',
                    'VER DETALLES DE LA VISITA',
                    'DESCARGAR EXCEL DE VISITAS DIARIAS',
                    'DESCARGAR EXCEL DE TODAS LAS VISITAS',
                    'VISUALIZAR LAS BITACORAS DIARIAS',
                    'VISUALIZAR TODAS LAS BITACORAS',
                    'CREAR BITACORA',
                    'EDITAR BITACORA',
                    'ELIMINAR BITACORA',
                    'VER DETALLES DE LA BITACORA',
                    'DESCARGAR EXCEL DE BITACORAS DIARIAS',
                    'DESCARGAR EXCEL DE TODAS LAS BITACORAS',
                ],
            ],
            [
                'name' => 'SUPER USUARIO',
                'permissions' => [
                    'VISUALIZAR LAS VISITAS DIARIAS',
                    'VISUALIZAR TODAS LAS VISITAS',
                    'CREAR VISITA',
                    'EDITAR VISITA',
                    'ELIMINAR VISITA',
                    'VER DETALLES DE LA VISITA',
                    'DESCARGAR EXCEL DE VISITAS DIARIAS',
                    'DESCARGAR EXCEL DE TODAS LAS VISITAS',
                    'VISUALIZAR LAS BITACORAS DIARIAS',
                    'VISUALIZAR TODAS LAS BITACORAS',
                    'CREAR BITACORA',
                    'EDITAR BITACORA',
                    'ELIMINAR BITACORA',
                    'VER DETALLES DE LA BITACORA',
                    'DESCARGAR EXCEL DE BITACORAS DIARIAS',
                    'DESCARGAR EXCEL DE TODAS LAS BITACORAS',
                ],
            ],
        ];

        foreach ($roles as $roleData) {
            // Crear el rol
            $role = Role::create([
                'name' => $roleData['name'],
                'guard_name' => 'sanctum'
            ]);
        
            // Asignar los permisos al rol
            $role->guard_name = 'sanctum';
            $role->givePermissionTo($roleData['permissions']);
        }
    }
}
