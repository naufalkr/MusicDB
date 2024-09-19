<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role Admin dan User
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Ambil pengguna pertama sebagai admin
        $adminUser = User::first(); // Ambil user pertama yang ada di tabel
        if ($adminUser) {
            $adminUser->assignRole($adminRole);
        } else {
            // Buat user baru jika tidak ada user yang ditemukan
            $adminUser = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
            $adminUser->assignRole($adminRole);
        }

        // Buat user biasa
        $normalUser = User::create([
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);
        $normalUser->assignRole($userRole);
    }
}
