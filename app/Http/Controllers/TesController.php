<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TesController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->id());
        $products = [
            ['id' => 1, 'name' => 'Pulsa 50K', 'price' => 50000],
            ['id' => 2, 'name' => 'Paket Data 75K', 'price' => 75000],
            ['id' => 3, 'name' => 'Token Listrik 100K', 'price' => 100000],
        ];
        return view('wallet.index', compact('user', 'products'));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:1000',
        ]);
        $user = User::find(auth()->id());
        $user->deposit($request->nominal);

        return back()->with('success', 'Deposit berhasil');
    }

    public function kurang(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:1000',
        ]);
        $user = User::find(auth()->id());
        $user->withdraw($request->nominal);

        return back()->with('success', 'Withdraw berhasil');
    }

    public function transfer(Request $request)
    {
        request()->validate([
            'user_id' => 'required|exists:users,id',
            'nominal' => 'required|numeric|min:1000',
        ]);
        $user1 = User::find(auth()->id());
        $user2 = User::find($request->user_id);

        $user1->transfer($user2, $request->nominal);

        return back()->with('success', 'Transfer berhasil');

    }
}
