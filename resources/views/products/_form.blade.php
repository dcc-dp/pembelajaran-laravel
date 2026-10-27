@if ($errors->any())
    <p class="rounded-md bg-red-50 p-4 text-sm font-medium text-red-800" role="alert">
        Periksa kembali input yang ditandai di bawah.
    </p>
@endif

<div>
    <label for="kode_produk" class="block text-sm font-medium text-gray-700">Kode produk</label>
    <input id="kode_produk" name="kode_produk" type="text" value="{{ old('kode_produk', $product->kode_produk ?? '') }}" required maxlength="255" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    @error('kode_produk') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama produk</label>
    <input id="nama_produk" name="nama_produk" type="text" value="{{ old('nama_produk', $product->nama_produk ?? '') }}" required maxlength="255" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    @error('nama_produk') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi <span class="font-normal text-gray-500">(opsional)</span></label>
    <textarea id="deskripsi" name="deskripsi" rows="4" maxlength="5000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('deskripsi', $product->deskripsi ?? '') }}</textarea>
    @error('deskripsi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid gap-6 sm:grid-cols-2">
    <div>
        <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
        <input id="harga" name="harga" type="number" min="0" max="9999999999.99" step="0.01" value="{{ old('harga', $product->harga ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('harga') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
        <input id="stok" name="stok" type="number" min="0" max="4294967295" step="1" value="{{ old('stok', $product->stok ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('stok') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div>
    <label for="foto" class="block text-sm font-medium text-gray-700">Foto <span class="font-normal text-gray-500">(opsional, JPG/PNG/WEBP, maksimal 2 MB)</span></label>
    <input id="foto" name="foto" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200">
    @error('foto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

    @if (isset($product) && $product->foto)
        <div class="mt-4">
            <p class="mb-2 text-sm text-gray-600">Foto saat ini:</p>
            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($product->foto) }}" alt="Foto {{ $product->nama_produk }}" class="h-32 w-32 rounded-md object-cover">
        </div>
    @endif
</div>
