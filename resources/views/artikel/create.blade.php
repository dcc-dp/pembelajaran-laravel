<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Artikel
            </h2>

            <a href="{{ route('articles.index') }}"
               class="text-sm text-gray-600 hover:text-gray-900">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl p-6">

                {{-- Error Validation --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('articles.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf

                    {{-- Judul --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Judul Artikel
                        </label>
                        <input type="text"
                               name="title"
                               value="{{ old('title') }}"
                               placeholder="Masukkan judul artikel"
                               class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                               required>
                    </div>

                    {{-- Isi --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Isi Artikel
                        </label>
                        <textarea name="content"
                                  rows="6"
                                  placeholder="Tulis isi artikel..."
                                  class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                  required>{{ old('content') }}</textarea>
                    </div>

                    {{-- Cover --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Cover Artikel
                        </label>
                        <input type="file"
                               name="cover"
                               accept="image/*"
                               class="block w-full text-sm text-gray-600
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-blue-50 file:text-blue-700
                                      hover:file:bg-blue-100"
                               required>
                        <p class="text-xs text-gray-500 mt-1">
                            Format: JPG, PNG (Max 2MB)
                        </p>
                    </div>

                    {{-- Gambar Isi --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Gambar Isi Artikel
                        </label>
                        <input type="file"
                               name="content_images[]"
                               multiple
                               accept="image/*"
                               class="block w-full text-sm text-gray-600
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-gray-50 file:text-gray-700
                                      hover:file:bg-gray-100">
                        <p class="text-xs text-gray-500 mt-1">
                            Bisa upload lebih dari satu gambar
                        </p>
                    </div>

                    {{-- Action --}}
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('articles.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Batal
                        </a>

                        <button type="submit"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Simpan Artikel
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
