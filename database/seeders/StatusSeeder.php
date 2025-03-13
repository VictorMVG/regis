<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'ACTIVO (A)',
            ],
            [
                'name' => 'INACTIVO (A)',
            ],
        ];

        foreach ($statuses as $status) {
            \App\Models\Configuracion\Catalogos\Status::create($status);
        }
    }
}
