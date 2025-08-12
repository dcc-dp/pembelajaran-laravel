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
        'namaBarang'=> 'sosis',
        'harga'=>3000,
        'stok'=>100
        ]);
       Barang::create([
        'namaBarang'=> 'milo',
        'harga'=>15000,
        'stok'=>50
        ]);
       Barang::create([
        'namaBarang'=> 'coki - coki',
        'harga'=>1500,
        'stok'=>150
        ]);
       Barang::create([
        'namaBarang'=> 'cokolatos',
        'harga'=>2000,
        'stok'=>120
        ]);
    }
}
