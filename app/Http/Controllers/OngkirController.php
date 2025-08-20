<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OngkirController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'Accept' => 'Aplication/json',
            'key' => config('rajaOngkir.api_key')
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        if ($response->successful()) {
            $provinces = $response->json()['data'];
        }
        
        return view('cekongkir', compact('provinces'));
    }

    public function getKota($id_prov)
    {
        $response = Http::withHeaders([
            'Accept' => 'Aplication/json',
            'key' => config('rajaOngkir.api_key')
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$id_prov}");

        return response()->json(
            $response->json()['data']
        );
    }

    public function getKec($id_kota){
        $response = Http::withHeaders([
            'Accept' => 'Aplication/json',
            'key' => config('rajaOngkir.api_key')
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$id_kota}");

        return response()->json(
            $response->json()['data']
        );
    }

    public function cekRong(Request $request)
    {
        $response = Http::asForm()->withHeaders([
            'Accept' => 'Application/json',
            'key' => config('rajaOngkir.api_key'),
        ])->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'origin' => 6729,
            'destination' => $request->input('district_id'), // ID kecamatan tujuan
            'weight'      => $request->input('weight'),
            'courier'     => $request->input('courier'),
        ]);

        return $response->json()['data'];
    }
}