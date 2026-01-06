<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Artikel
            </h2>

            <div class="flex gap-2">
                <a href="{{ route('articles.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm">
                    ← Kembali
                </a>

                <a href="{{ route('articles.edit', $article) }}"
                   class="px-4 py-2 bg-yellow-400 text-white rounded-md hover:bg-yellow-500 text-sm">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Cover --}}
            <div class="bg-white rounded-xl shadow overflow-hidden mb-6">
                <img
                    src="{{ $article->getFirstMediaUrl('cover') }}"
                    alt="{{ $article->title }}"
                    class="w-full h-80 object-cover"
                >
            </div>

            {{-- Content --}}
            <div class="bg-white rounded-xl shadow p-6 space-y-6">

                {{-- Title --}}
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        {{ $article->title }}
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Dipublikasikan {{ $article->created_at }}
                    </p>
                </div>

                {{-- Isi Artikel --}}
                <div class="prose max-w-none">
                    {!! nl2br(e($article->content)) !!}
                </div>

                {{-- Gambar Isi --}}
                @if ($article->getMedia('content_images')->count())
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-3">
                            Galeri Gambar
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($article->getMedia('content_images') as $image)
                                <div class="rounded-lg overflow-hidden shadow-sm">
                                    <img
                                        src="{{ $image->getUrl('content') }}"
                                        alt="Gambar Artikel"
                                        class="w-full h-64 object-cover hover:scale-105 transition"
                                    >
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
