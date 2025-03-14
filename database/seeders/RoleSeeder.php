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
                    'VISITAS DEL DIA',
                ],
            ],
            [
                'name' => 'ADMINISTRADOR DE SEDE',
                'permissions' => [
                    'ADMINISTRACIÓN DE LA SEDE',
                    'VISITAS DEL DIA',
                ],
            ],
            [
                'name' => 'ADMINISTRADOR GENERAL',
                'permissions' => [
                    'ADMINISTRACIÓN GENERAL',
                ],
            ],
            [
                'name' => 'SUPER USUARIO',
                'permissions' => [
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
