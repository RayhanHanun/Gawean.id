<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use App\Models\Company;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test Pelamar
        $pelamarUser = User::create([
            'id' => 'PLM001',
            'name' => 'Rayhan Pratama',
            'email' => 'rayhan@example.com',
            'password' => '123456',
            'role' => 'pelamar',
        ]);

        Profile::create([
            'id' => 'PRF001',
            'user_id' => $pelamarUser->id,
            'phone_number' => '081234567890',
        ]);

        // Create test HRD
        $hrdUser = User::create([
            'id' => 'HRD001',
            'name' => 'Budi Santoso',
            'email' => 'hrd@example.com',
            'password' => '123456',
            'role' => 'hrd',
        ]);

        Company::create([
            'id' => 'COM001',
            'user_id' => $hrdUser->id,
            'company_name' => 'PT. Teknologi Indonesia',
            'address' => 'Jl. Gatot Subroto No. 123, Jakarta',
            'status_verifikasi' => 'approved',
        ]);

        // Create test Admin
        User::create([
            'id' => 'ADM001',
            'name' => 'Admin Gawean',
            'email' => 'admin@example.com',
            'password' => '123456',
            'role' => 'admin',
        ]);

        $this->command->info('Test users created successfully!');
    }
}
