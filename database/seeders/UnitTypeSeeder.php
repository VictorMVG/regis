<?php

namespace Database\Seeders;

use App\Models\Catalogos\UnitType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unitTypes = [
            [
                'name' => 'AUTOMOVIL',
            ],
            [
                'name' => 'CAMION',
            ],
            [
                'name' => 'CAMIONETA PICK UP',
            ],
            [
                'name' => 'MONTACARGAS',
            ],
            [
                'name' => 'PIPA',
            ],
            [
                'name' => 'TRAILER',
            ],
            [
                'name' => 'VAN',
            ],
        ];

        foreach ($unitTypes as $unitType) {
            UnitType::create($unitType);
        }
    }
}
