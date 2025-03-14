<?php

namespace Database\Seeders;

use App\Models\Configuracion\Usuarios\Catalogos\Headquarter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeadquarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $headquarters = [
            [
                'company_id' => 2,
                'name' => 'SEDE 1',
                'description' => 'SEDE 1 DE LA EMPRESA SLUMBERGER',
            ],
            [
                'company_id' => 2,
                'name' => 'SEDE 2',
                'description' => 'SEDE 2 DE LA EMPRESA SLUMBERGER',
            ],
            [
                'company_id' => 3,
                'name' => 'SEDE 1',
                'description' => 'SEDE 1 DE LA EMPRESA HALLIBURTON',
            ],
            [
                'company_id' => 3,
                'name' => 'SEDE 2',
                'description' => 'SEDE 2 DE LA EMPRESA HALLIBURTON',
            ],
        ];

        foreach ($headquarters as $headquarter) {
            Headquarter::create($headquarter);
        }
    }
}
