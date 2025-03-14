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
                'name' => 'ADMINISTRACIÓN GENERAL',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'ADMINISTRACIÓN DE LA SEDE',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'VISITAS DEL DIA',
                'guard_name' => 'sanctum',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
