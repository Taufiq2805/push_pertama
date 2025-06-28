<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'category' => 'Elektronik',
            'slug' => 'Elektronik',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
         Category::create([
            'category' => 'Pakaian',
            'slug' => 'Pakaian',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
         Category::create([
            'category' => 'Peralatan Sekolah',
            'slug' => 'Peralatan Sekolah',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
         Category::create([
            'category' => 'Peralatan Rumah Tangga',
            'slug' => 'Peralatan Rumah Tangga',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
         Category::create([
            'category' => 'Olahraga',
            'slug' => 'Olahraga',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
