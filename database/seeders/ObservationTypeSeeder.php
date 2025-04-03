<?php

namespace Database\Seeders;

use App\Models\Catalogos\ObservationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ObservationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $observationTypes = [
            [
                'name' => 'GENERAL',
            ],
            [
                'name' => 'IMPORTANTE',
            ],
        ];

        foreach ($observationTypes as $observationType) {
            ObservationType::create($observationType);
        }
    }
}
