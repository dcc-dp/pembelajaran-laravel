<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BarangResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'namaBarang' => $this->namaBarang,
            'harga' => $this->harga,
            'stok' => $this->stok,
        ];
    }
}
