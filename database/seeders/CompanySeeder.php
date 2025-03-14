<?php

namespace Database\Seeders;

use App\Models\Configuracion\Usuarios\Catalogos\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'name' => 'NO ASIGNADO',
                'alias' => 'NA',
            ],
            [
                'name' => 'SLUMBERGER',
                'alias' => 'SLB',
            ],
            [
                'name' => 'HALLIBURTON',
                'alias' => 'HB',
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}
