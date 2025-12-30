<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'namaBarang' => 'string|max:255',
            'harga' => 'integer',
            'stok' => 'integer',
        ];
    }
}
