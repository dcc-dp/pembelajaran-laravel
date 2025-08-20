<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $namaBarang = Barang::pluck('namaBarang');
        $bulanJanuari = Penjualan::selectRaw('barang_id, SUM(jumlahBarang) AS total')->whereMonth('created_at',1)->groupBy('barang_id')->get()->pluck('total');
         $bulanFebruari = Penjualan::selectRaw('barang_id, SUM(jumlahBarang) AS total')->whereMonth('created_at',2)->groupBy('barang_id')->get()->pluck('total');
         $bulanMaret= Penjualan::selectRaw('barang_id, SUM(jumlahBarang) AS total')->whereMonth('created_at',3)->groupBy('barang_id')->get()->pluck('total');
         return view('dashboard', compact('namaBarang','bulanJanuari','bulanFebruari','bulanMaret'));
         }
    };