<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'namaBarang','harga','stok'
    ];
       public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'barang_id');
    }
}
