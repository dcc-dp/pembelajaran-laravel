<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CloudinaryController extends Controller
{
    public function index()
    {
        $images = Image::latest()->paginate(12);
        return view('image.index', compact('images'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $image = $request->file('image');
        $cloudinary = new Cloudinary();

        $ImageUploaded = $cloudinary->uploadApi()->upload(
            $image->getRealPath(),
            [
                'folder' => 'images',
            ]
        );

        Image::create([
            'name' => $image->getClientOriginalName(),
            'public_id' => $ImageUploaded['public_id'],
            'size' => $image->getSize(),
        ]);
        
        return back()->with('success', 'Gambar berhasil diupload!');
    }
    
    public function destroy(Image $image)
    {
        // Delete file from storage
        Storage::disk('public')->delete($image->path);
        
        // Delete record from database
        $image->delete();
        
        return back()->with('success', 'Gambar berhasil dihapus!');
    }
}