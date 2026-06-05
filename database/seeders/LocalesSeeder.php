<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Local;

class LocalesSeeder extends Seeder
{
    public function run(): void
    {
        Local::firstOrCreate(
            ['nombre' => 'Luján Express'],
            ['direccion' => 'Avenida Constituyentes 265']
        );

        Local::firstOrCreate(
            ['nombre' => 'Bolívar Express'],
            ['direccion' => 'Sucursal Bolívar']
        );

        Local::firstOrCreate(
            ['nombre' => 'Catalina Express'],
            ['direccion' => 'Sucursal Catalina']
        );
    }
}

