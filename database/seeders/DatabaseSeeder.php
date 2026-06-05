<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class, // roles y permisos
            LocalesSeeder::class,             // locales
            UsersSeeder::class,               // usuarios (usan local_id)
        ]);
    }
}
