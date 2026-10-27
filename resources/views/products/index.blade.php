<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Produk</h2>
            <p class="mt-1 text-sm text-gray-600">Produk yang tersimpan pada akun Anda.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                @if (session('success'))
                    <div class="m-6 rounded-md bg-green-50 p-4 text-sm font-medium text-green-800" role="status">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex flex-col gap-3 border-b border-gray-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="font-medium text-gray-900">Produk</h3>
                        <p class="mt-1 text-sm text-gray-600">Jumlah produk: {{ $products->total() }}</p>
                    </div>
                    <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Tambah Produk
                    </a>
                </div>

                @if ($products->isEmpty())
                    <div class="px-6 py-10 text-center">
                        <p class="font-medium text-gray-900">Belum ada produk</p>
                        <p class="mt-1 text-sm text-gray-600">Gunakan tombol Tambah Produk untuk memasukkan produk pertama.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Kode</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nama produk</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Harga</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Stok</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $product->kode_produk }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            <div>{{ $product->nama_produk }}</div>
                                            @if ($product->deskripsi)
                                                <div class="mt-1 max-w-md truncate font-normal text-gray-500">{{ $product->deskripsi }}</div>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-600">Rp {{ number_format((float) $product->harga, 0, ',', '.') }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-600">{{ $product->stok }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                            <div class="flex items-center justify-end gap-3">
                                                <a href="{{ route('products.edit', $product) }}" class="font-medium text-indigo-600 hover:text-indigo-800">Edit</a>
                                                <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 hover:text-red-800">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-gray-200 px-6 py-4">{{ $products->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
