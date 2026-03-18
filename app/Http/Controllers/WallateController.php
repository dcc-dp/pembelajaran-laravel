<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WallateController extends Controller
{
    public function tambah()
    {
        $user = User::first();
        $user->deposit(100000);

        dd($user->balance);
    }
}
