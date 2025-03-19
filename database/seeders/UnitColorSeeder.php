<?php

namespace Database\Seeders;

use App\Models\Catalogos\UnitColor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unitColors = [
            [
                'name' => 'BLANCO',
            ],
            [
                'name' => 'GRIS',
            ],
            [
                'name' => 'AZUL',
            ],
            [
                'name' => 'ROJO',
            ],
            [
                'name' => 'NEGRO',
            ],
            [
                'name' => 'VERDE',
            ],
            [
                'name' => 'AMARILLO',
            ],
            [   
                'name' => 'MORADO',
            ],
            [
                'name' => 'CAFE',
            ],
            [
                'name' => 'NARANJA',
            ],
        ];

        foreach ($unitColors as $unitColor) {
            UnitColor::create($unitColor);
        }
    }
}
