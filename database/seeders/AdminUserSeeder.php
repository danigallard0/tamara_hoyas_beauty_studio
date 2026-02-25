<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario administrador para acceso al panel de gestión
        User::updateOrCreate(
            ['email' => 'admin@thbeautystudio.local'],
            [
                'name' => 'Admin',
                'nombre' => 'Admin',
                'apellidos' => 'Beauty Studio',
                'password' => Hash::make('Admin12345!'),
                'role' => 'admin',
                'activo' => true,
                'phone_1' => null,
                'phone_2' => null,
            ]
        );
    }
}
