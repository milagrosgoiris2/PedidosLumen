<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // =====================
        // ADMIN
        // =====================
        $admin = User::firstOrCreate(
            ['email' => 'admin@lumen.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // =====================
        // GERENTE
        // =====================
        $gerente = User::firstOrCreate(
            ['email' => 'gerente@lumen.com'],
            [
                'name' => 'Gerente General',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $gerente->assignRole('gerente');

        // =====================
        // ENCARGADO – LUJÁN EXPRESS
        // =====================
        $encargadoLujan = User::firstOrCreate(
            ['email' => 'encargado.lujan@lumen.com'],
            [
                'name' => 'Encargado Luján Express',
                'password' => Hash::make('password'),
                'local_id' => 1,
                'email_verified_at' => now(),
            ]
        );
        $encargadoLujan->assignRole('encargado');

        // =====================
        // ENCARGADO – BOLÍVAR EXPRESS
        // =====================
        $encargadoBolivar = User::firstOrCreate(
            ['email' => 'encargado.bolivar@lumen.com'],
            [
                'name' => 'Encargado Bolívar Express',
                'password' => Hash::make('password'),
                'local_id' => 2,
                'email_verified_at' => now(),
            ]
        );
        $encargadoBolivar->assignRole('encargado');

        // =====================
        // ENCARGADO – CATALINA EXPRESS
        // =====================
        $encargadoCatalina = User::firstOrCreate(
            ['email' => 'encargado.catalina@lumen.com'],
            [
                'name' => 'Encargado Catalina Express',
                'password' => Hash::make('password'),
                'local_id' => 3,
                'email_verified_at' => now(),
            ]
        );
        $encargadoCatalina->assignRole('encargado');
    }
}
