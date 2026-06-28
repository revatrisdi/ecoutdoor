<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed akun admin ECOutdoor.
     */
    public function run(): void
    {
        // Cek dulu, jangan duplikat jika sudah ada
        if (! User::where('email', 'admin@ecoutdoor.com')->exists()) {
            User::create([
                'name'     => 'Admin ECOutdoor',
                'email'    => 'admin@ecoutdoor.com',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]);

            $this->command->info('✅ Admin account created: admin@ecoutdoor.com / admin123');
        } else {
            $this->command->warn('⚠️  Admin account already exists, skipping.');
        }
    }
}
