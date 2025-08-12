<?php

namespace Database\Seeders;

use App\Models\Penjualan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hargaBarang = [
            1 => 7000,
            2 => 7000,
            3 => 7000,
            4 => 3000,
            5 => 15000,
            6 => 1500,
            7 => 2000,
        ];
        for ($bulan = 1; $bulan <= 7; $bulan++) {
            foreach (range(1, 7) as $barangId) {
                $jumlah = rand(5, 50);
                Penjualan::create([
                    'barang_id'    => $barangId,
                    'jumlahBarang' => $jumlah,
                    'totalHarga'   => $jumlah * $hargaBarang[$barangId],
                    'created_at'   => Carbon::create(2024, $bulan, rand(1, 28)),
                    'updated_at'   => Carbon::now(),
                ]);
            }
        }
    }
}
