<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = $request->user()
            ->products()
            ->latest()
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_produk' => ['required', 'string', 'max:255', Rule::unique('products', 'kode_produk')],
            'nama_produk' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'harga' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'stok' => ['required', 'integer', 'min:0', 'max:4294967295'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('products', 'public');
        }

        $request->user()->products()->create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Request $request, Product $product): View
    {
        $product = $request->user()->products()->findOrFail($product->id);

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $product = $request->user()->products()->findOrFail($product->id);

        $validated = $request->validate([
            'kode_produk' => ['required', 'string', 'max:255', Rule::unique('products', 'kode_produk')->ignore($product->id)],
            'nama_produk' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'harga' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'stok' => ['required', 'integer', 'min:0', 'max:4294967295'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $oldPhoto = null;

        if ($request->hasFile('foto')) {
            $oldPhoto = $product->foto;
            $validated['foto'] = $request->file('foto')->store('products', 'public');
        } else {
            unset($validated['foto']);
        }

        $product->update($validated);

        if ($oldPhoto) {
            Storage::disk('public')->delete($oldPhoto);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $product = $request->user()->products()->findOrFail($product->id);
        $photo = $product->foto;

        $product->delete();

        if ($photo) {
            Storage::disk('public')->delete($photo);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

}
