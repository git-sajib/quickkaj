<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@quickkaj.com'],
            [
                'name' => 'Quickkaj Admin',
                'password' => Hash::make('Admin@123!'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Admin: admin@quickkaj.com / Admin@123!');
    }
}
