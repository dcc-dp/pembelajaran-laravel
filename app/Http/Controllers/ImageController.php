<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::latest()->paginate(12);
        return view('images.index', compact('images'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $image = $request->file('image');

        Image::create([
            'name' => $image->getClientOriginalName(),
            'public_id' => '',
            'url' => '',
            'size' => $image->getSize(),
        ]);
        
        return back()->with('success', 'Gambar berhasil diupload!');
    }
    
    public function destroy(Image $image)
    {
        $image->delete();
        
        return back()->with('success', 'Gambar berhasil dihapus!');
    }
}