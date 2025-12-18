<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Cek apakah user sudah ada
        $admin = User::where('email', 'admin@tegalsambi.id')->first();

        if (!$admin) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@tegalsambi.id',
                'password' => Hash::make('password'), // Password default
                'email_verified_at' => now(),
            ]);
            echo "User Admin created: admin@tegalsambi.id / password\n";
        } else {
            // Update password just in case
            $admin->update([
                'password' => Hash::make('password')
            ]);
            echo "User Admin password reset to: password\n";
        }
    }
}
