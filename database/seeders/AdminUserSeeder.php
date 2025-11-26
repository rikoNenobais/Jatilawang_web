<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email        = env('ADMIN_EMAIL', 'admin@example.com');
        $username     = env('ADMIN_USERNAME', 'admin');
        $fullName     = env('ADMIN_FULL_NAME', 'Admin Jatilawang');
        $plainPassword = env('ADMIN_PASSWORD');
        
        if (empty($plainPassword)) {
            $this->command?->error('ADMIN_PASSWORD belum di-set di file .env');
            return;
        }

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

        $this->command?->info("Admin user untuk {$email} sudah dibuat / diperbarui.");
    }
}
