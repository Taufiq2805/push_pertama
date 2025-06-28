<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Product::create([
            'nama' => 'Laptop Gaming',
            'slug' => 'laptop-gaming',
            'deskripsi' => 'Laptop dengan performa yang bagus dan layar yang sangat halus',
            'harga' => '4000000',
            'stok' => '20',
            'gambar' => 'laptop_gaming.jpg',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
         Product::create([
            'nama' => 'Hoodie Anti Air',
            'slug' => 'hoodie-anti-air',
            'deskripsi' => 'Hoodie yang sangat bagus saat kehujanan di jalan',
            'harga' => '120000',
            'stok' => '50',
            'gambar' => 'hoodie.jpg',
            'category_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
         Product::create([
            'nama' => 'Pulpen Unlimited',
            'slug' => 'pulpen-unlimited',
            'deskripsi' => 'Pulpen ini tidak akan habis ',
            'harga' => '14000',
            'stok' => '100',
            'gambar' => 'pulpen.jpg',
            'category_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
         Product::create([
            'nama' => 'Blender Multifungsi',
            'slug' => 'blender-multifungsi',
            'deskripsi' => 'Blender ini memiliki fitur yang menarik bisa memblender apapun',
            'harga' => '2000000',
            'stok' => '40',
            'gambar' => 'blender.jpg',
            'category_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
         Product::create([
            'nama' => 'Raket Badminton',
            'slug' => 'raket-badminton',
            'deskripsi' => 'Raket yang sangat bagus untuk bermain badminton kuat dan ringan untuk dimainkan',
            'harga' => '300000',
            'stok' => '90',
            'gambar' => 'raket.jpg',
            'category_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
