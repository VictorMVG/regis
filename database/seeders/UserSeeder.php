<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'SUPER USUARIO',
            'email' => 'ADMIN@GMAIL.COM',
            'password' => bcrypt('12345678'),
            'status_id' => 1,
        ]);

        $user->assignRole('SUPER USUARIO');

        $user2 = User::factory()->create([
            'name' => 'ADMINISTRADOR GENERAL',
            'email' => 'ADMINGENERAL@GMAIL.COM',
            'password' => bcrypt('12345678'),
            'status_id' => 1,
        ]);

        $user2->assignRole('ADMINISTRADOR GENERAL');

        $user3 = User::factory()->create([
            'name' => 'ADMINISTRADOR DE SEDE HB',
            'email' => 'ADMINHB@GMAIL.COM',
            'password' => bcrypt('12345678'),
            'status_id' => 1,
            'company_id' => 3,
        ]);

        $user3->assignRole('ADMINISTRADOR DE SEDE');

        $user4 = User::factory()->create([
            'name' => 'ADMINISTRADOR DE SEDE SLB',
            'email' => 'ADMINSLB@GMAIL.COM',
            'password' => bcrypt('12345678'),
            'status_id' => 1,
            'company_id' => 2,
        ]);

        $user4->assignRole('ADMINISTRADOR DE SEDE');

        $user5 = User::factory()->create([
            'name' => 'GUARDIA UNO HB SEDE 1',
            'email' => 'GUARDIAHBSEDE1@GMAIL.COM',
            'password' => bcrypt('12345678'),
            'status_id' => 1,
            'headquarter_id' => 3,
        ]);

        $user5->assignRole('GUARDIA');

        $user6 = User::factory()->create([
            'name' => 'GUARDIA DOS HB SEDE 2',
            'email' => 'GUARDIAHBSEDE2@GMAIL.COM',
            'password' => bcrypt('12345678'),
            'status_id' => 1,
            'headquarter_id' => 4,
        ]);

        $user6->assignRole('GUARDIA');

        $user7 = User::factory()->create([
            'name' => 'GUARDIA UNO SLB SEDE 1',
            'email' => 'GUARDIASLBSEDE1@GMAIL.COM',
            'password' => bcrypt('12345678'),
            'status_id' => 1,
            'headquarter_id' => 1,
        ]);

        $user7->assignRole('GUARDIA');

        $user8 = User::factory()->create([
            'name' => 'GUARDIA DOS SLB SEDE 2',
            'email' => 'GUARDIASLBSEDE2@GMAIL.COM',
            'password' => bcrypt('12345678'),
            'status_id' => 1,
            'headquarter_id' => 2,
        ]);

        $user8->assignRole('GUARDIA');
       
    }
}
