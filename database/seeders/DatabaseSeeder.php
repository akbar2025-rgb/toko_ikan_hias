<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\KategoriIkan;
use App\Models\Ikan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@tokoikan.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // Create Kasir User
        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@tokoikan.com',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir'
        ]);

        // Create Kategori
        $kategoris = [
            ['nama_kategori' => 'Ikan Hias Air Tawar', 'deskripsi' => 'Ikan hias yang hidup di air tawar'],
            ['nama_kategori' => 'Ikan Hias Air Laut', 'deskripsi' => 'Ikan hias yang hidup di air laut'],
            ['nama_kategori' => 'Ikan Predator', 'deskripsi' => 'Ikan hias jenis predator'],
        ];

        foreach ($kategoris as $kategori) {
            KategoriIkan::create($kategori);
        }

        // Create Sample Ikan
        $ikans = [
            [
                'kategori_id' => 1,
                'nama_ikan' => 'Ikan Cupang',
                'harga_beli' => 15000,
                'harga_jual' => 25000,
                'stok' => 50,
                'ukuran' => 'Kecil (3-5 cm)',
                'deskripsi' => 'Ikan cupang dengan warna cerah dan ekor indah'
            ],
            [
                'kategori_id' => 1,
                'nama_ikan' => 'Ikan Guppy',
                'harga_beli' => 5000,
                'harga_jual' => 10000,
                'stok' => 100,
                'ukuran' => 'Kecil (2-4 cm)',
                'deskripsi' => 'Ikan guppy warna-warni mudah dipelihara'
            ],
            [
                'kategori_id' => 2,
                'nama_ikan' => 'Ikan Nemo (Clownfish)',
                'harga_beli' => 50000,
                'harga_jual' => 85000,
                'stok' => 20,
                'ukuran' => 'Sedang (5-8 cm)',
                'deskripsi' => 'Ikan badut air laut yang populer'
            ],
            [
                'kategori_id' => 3,
                'nama_ikan' => 'Ikan Arwana',
                'harga_beli' => 500000,
                'harga_jual' => 750000,
                'stok' => 5,
                'ukuran' => 'Besar (20-30 cm)',
                'deskripsi' => 'Ikan predator premium'
            ],
        ];

        foreach ($ikans as $ikan) {
            Ikan::create($ikan);
        }
    }
}