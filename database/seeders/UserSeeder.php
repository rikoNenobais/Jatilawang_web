<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'user_id'       => 1,
                'remember_token'=> null,
                'username'      => 'admin',
                'password'      => '$2y$12$K61pnIJQfeigXPoCe9VX1uhEw.r5HH36Wuc4l6bNeoRp9iWQImFQC',
                'full_name'     => 'jatilawang',
                'email'         => 'jatilawang@gmail.com',
                'phone_number'  => '08888888888',
                'address'       => 'Maguwo',
                'role'          => 'admin',
                'created_at'    => '2025-11-25 03:46:19',
                'updated_at'    => '2025-11-25 03:46:19',
            ],
            [
                'user_id'       => 2,
                'remember_token'=> null,
                'username'      => 'zeunux',
                'password'      => '$2y$12$K61pnIJQfeigXPoCe9VX1uhEw.r5HH36Wuc4l6bNeoRp9iWQImFQC',
                'full_name'     => 'riko',
                'email'         => 'jatilawang@gmail.com',
                'phone_number'  => '08888888888',
                'address'       => 'Maguwo',
                'role'          => 'customer',
                'created_at'    => '2025-11-25 03:46:19',
                'updated_at'    => '2025-11-25 03:46:19',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['user_id' => $user['user_id']],
                $user
            );
        }
    }
}
