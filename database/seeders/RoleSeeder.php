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
                    'VISUALIZAR USUARIOS',
                    'CREAR USUARIO',
                    'EDITAR USUARIO',
                    'VER DETALLES DEL USUARIO',
                    'ELIMINAR USUARIO',
                    'VISUALIZAR SEDES',
                    'CREAR SEDE',
                    'EDITAR SEDE',
                    'VER DETALLES DE LA SEDE',
                    'ELIMINAR SEDE',
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
                    'VISUALIZAR USUARIOS',
                    'CREAR USUARIO',
                    'EDITAR USUARIO',
                    'VER DETALLES DEL USUARIO',
                    'ELIMINAR USUARIO',
                    'VISUALIZAR SEDES',
                    'CREAR SEDE',
                    'EDITAR SEDE',
                    'VER DETALLES DE LA SEDE',
                    'ELIMINAR SEDE',
                    'VISUALIZAR EMPRESAS',
                    'CREAR EMPRESA',
                    'EDITAR EMPRESA',
                    'VER DETALLES DE LA EMPRESA',
                    'ELIMINAR EMPRESA',
                    'VISUALIZAR CATALOGOS',
                    'CREAR CATALOGOS',
                    'EDITAR CATALOGOS',
                    'VER DETALLES DE CATALOGOS',
                    'ELIMINAR CATALOGOS',
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
                    'VISUALIZAR USUARIOS',
                    'CREAR USUARIO',
                    'EDITAR USUARIO',
                    'VER DETALLES DEL USUARIO',
                    'ELIMINAR USUARIO',
                    'VISUALIZAR SEDES',
                    'CREAR SEDE',
                    'EDITAR SEDE',
                    'VER DETALLES DE LA SEDE',
                    'ELIMINAR SEDE',
                    'VISUALIZAR EMPRESAS',
                    'CREAR EMPRESA',
                    'EDITAR EMPRESA',
                    'VER DETALLES DE LA EMPRESA',
                    'ELIMINAR EMPRESA',
                    'VISUALIZAR CATALOGOS',
                    'CREAR CATALOGOS',
                    'EDITAR CATALOGOS',
                    'VER DETALLES DE CATALOGOS',
                    'ELIMINAR CATALOGOS',
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
