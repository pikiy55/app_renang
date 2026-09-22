<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun admin default
        User::updateOrCreate(
            ['email' => 'admin@renang.test'],
            [
                'name'      => 'Administrator',
                'password'  => Hash::make('password'),
                'role'      => 'admin',
                'nama_klub' => null,
                'whatsapp'  => null,
                'is_active' => true,
            ]
        );

        // Buat 2 akun perkumpulan contoh
        $clubs = [
            ['name' => 'Klub Harapan', 'email' => 'harapan@renang.test', 'nama_klub' => 'Perkumpulan Renang Harapan', 'whatsapp' => '081234567890'],
            ['name' => 'Klub Garuda',  'email' => 'garuda@renang.test',  'nama_klub' => 'Perkumpulan Renang Garuda',  'whatsapp' => '082345678901'],
        ];

        foreach ($clubs as $club) {
            User::updateOrCreate(
                ['email' => $club['email']],
                [
                    'name'      => $club['name'],
                    'password'  => Hash::make('password'),
                    'role'      => 'perkumpulan',
                    'nama_klub' => $club['nama_klub'],
                    'whatsapp'  => $club['whatsapp'],
                    'is_active' => true,
                ]
            );
        }
    }
}
