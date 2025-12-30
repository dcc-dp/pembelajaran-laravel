<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatingController extends Controller
{
    public function index(){
        return view('chating.index');
    }
}
