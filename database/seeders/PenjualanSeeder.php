<?php

namespace Database\Seeders;

use App\Models\Penjualan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Penjualan::create([
            'barang_id' => 1,
            'jumlahBarang' => 20,
            'totalHarga' => 100000,

        ]);
        Penjualan::create([
            'barang_id' => 2,
            'jumlahBarang' => 20,
            'totalHarga' => 170000,

        ]);
        Penjualan::create([
            'barang_id' => 3,
            'jumlahBarang' => 5,
            'totalHarga' => 74000,

        ]);
        Penjualan::create([
            'barang_id' => 4,
            'jumlahBarang' => 12,
            'totalHarga' => 87000,

        ]);
    }
}
