<?php

namespace Database\Seeders;

use App\Models\Visitas\Visita\Visit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Visit::factory(200)->create();
    }
}
