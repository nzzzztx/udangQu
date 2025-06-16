<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tb_karyawan;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Tambak Pandemo',
            'email' => 'adminpandemo@gmail.com',
            'password' => bcrypt('pandemo123'),
        ]);
        User::factory(10)->create();
        Tb_karyawan::factory(20)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
