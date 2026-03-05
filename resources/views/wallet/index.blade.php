<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            💳 Wallet
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-6 space-y-8">

            {{-- SALDO CARD --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-black 
                        rounded-3xl shadow-xl p-10 text-center">
                <p class="text-lg opacity-80">Saldo Kamu</p>
                <h1 class="text-5xl font-bold mt-3">
                    Rp {{ number_format($user->balance, 0, ',', '.') }}
                </h1>

                <button onclick="document.getElementById('modal').classList.remove('hidden')"
                    class="mt-6 bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:scale-105 transition">
                    + Tambah Saldo
                </button>
            </div>

            {{-- PRODUK --}}
            <div>
                <h3 class="text-xl font-semibold mb-6 text-gray-700">
                    🛒 Produk
                </h3>

                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
                            <h4 class="text-lg font-semibold">
                                {{ $product['name'] }}
                            </h4>

                            <p class="text-gray-500 mt-2">
                                Rp {{ number_format($product['price'], 0, ',', '.') }}
                            </p>

                            <form action="{{ route('kurang') }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" name="nominal" value="{{ $product['price'] }}">
                                <button class="w-full bg-green-500 hover:bg-green-600 
                                                   text-white py-2 rounded-xl transition">
                                    Beli Sekarang
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- TRANSFER --}}
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h3 class="text-xl font-semibold mb-6 text-gray-700">
                    🔄 Transfer Saldo
                </h3>

                <form action="{{ route('transfer') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-gray-600 mb-1">
                            ID User Tujuan
                        </label>
                        <input type="number" name="user_id" class="w-full border rounded-xl px-4 py-2 
                       focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Masukkan ID User" required>
                    </div>

                    <div>
                        <label class="block text-gray-600 mb-1">
                            Nominal Transfer
                        </label>
                        <input type="number" name="nominal" class="w-full border rounded-xl px-4 py-2 
                       focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Masukkan nominal" required>
                    </div>

                    <button class="w-full bg-indigo-600 hover:bg-indigo-700 
                       text-white py-3 rounded-xl font-semibold transition">
                        Transfer Sekarang
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- MODAL TAILWIND --}}
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 
         flex items-center justify-center z-50">

        <div class="bg-white rounded-2xl p-8 w-96 shadow-2xl">
            <h3 class="text-lg font-semibold mb-4">Tambah Saldo</h3>

            <form action="{{ route('tambah') }}" method="POST">
                @csrf
                <input type="number" name="nominal" class="w-full border rounded-xl px-4 py-2 mb-4 
                           focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Masukkan nominal" required>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('modal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-200 rounded-xl">
                        Batal
                    </button>

                    <button class="px-4 py-2 bg-blue-600 text-white rounded-xl">
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>