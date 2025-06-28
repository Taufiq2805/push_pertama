<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'is_admin' => true,
            'password' => bcrypt('password'),
        ]);
         User::create([
            'name' => 'Topik',
            'email' => 'topik@email.com',
            'password' => bcrypt('password'),
        ]);
         User::create([
            'name' => 'Scar',
            'email' => 'scar@email.com',
            'password' => bcrypt('password'),
        ]);
    }
}
