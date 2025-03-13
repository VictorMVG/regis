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
                'company' => 'SLB',
                'headquarter' => 'VILLAHERMOSA',
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}
