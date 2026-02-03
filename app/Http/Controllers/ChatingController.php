<?php

namespace App\Http\Controllers;

use Cloudinary\Cloudinary;
use Illuminate\Http\Request;

class ChatingController extends Controller
{
    public function index()
    {
        return view('chating.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $image = $request->file('image');

        $cloudinary = new Cloudinary();
        $uploaded = $cloudinary->uploadApi()->upload(
            $image->getRealPath(),
            ['folder' => 'chating']
        );

        return response()->json([
            'url' => $uploaded['secure_url'],
            'public_id' => $uploaded['public_id'],
        ]);
    }

    public function deleteImage(Request $request)
    {
        $request->validate([
            'public_id' => 'required|string'
        ]);

        $cloudinary = new Cloudinary();

        $cloudinary->uploadApi()->destroy($request->public_id, [
            'resource_type' => 'image'
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}
