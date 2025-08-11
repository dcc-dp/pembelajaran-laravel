<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Barang::create([
        'namaBarang'=> 'qtela',
        'harga'=>7000,
        'stok'=>100
        ]);
       Barang::create([
        'namaBarang'=> 'oreo',
        'harga'=>7000,
        'stok'=>70
        ]);
       Barang::create([
        'namaBarang'=> 'ultra milk',
        'harga'=>7000,
        'stok'=>80
        ]);
       Barang::create([
        'namaBarang'=> 'pop mie',
        'harga'=>11000,
        'stok'=>90
        ]);
    }
}
