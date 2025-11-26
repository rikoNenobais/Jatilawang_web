<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email         = env('ADMIN_EMAIL', 'admin@jatilawang.test');
        $username      = env('ADMIN_USERNAME', 'admin');
        $fullName      = env('ADMIN_FULL_NAME', 'Admin Jatilawang');
        $plainPassword = env('ADMIN_PASSWORD', 'admin123');

        // buat / update user admin berdasarkan email
        User::updateOrCreate(
            ['email' => $email], // kunci unik
            [
                'username'     => $username,
                'full_name'    => $fullName,
                'password'     => Hash::make($plainPassword),
                'phone_number' => null,
                'address'      => null,
                'role'         => 'admin',
            ]
        );

        $this->command?->warn('Pastikan ubah ADMIN_PASSWORD di produksi.');
        $this->command?->info("Admin user untuk {$email} sudah dibuat / diperbarui.");
    }
}
