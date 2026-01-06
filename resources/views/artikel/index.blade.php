<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Artikel
            </h2>

            <a href="{{ route('articles.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                + Tambah Artikel
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('articles.create') }}">
                + Tambah Artikel
            </a>
            <br>
            <br>

            {{-- Alert --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Grid Artikel --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse ($articles as $article)
                    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                        {{-- Cover --}}
                        <img
                            src="{{$article->getFirstMediaUrl('cover', 'thumb') }}"
                            alt="{{ $article->title }}"
                            class="w-full h-48 object-cover"
                        >

                        {{-- Content --}}
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">
                                {{ $article->title }}
                            </h3>

                            <p class="text-sm text-gray-600 mb-3 line-clamp-3">
                                {{ Str::limit(strip_tags($article->content), 120) }}
                            </p>

                            <div class="text-xs text-gray-500 mb-4">
                                {{ $article->created_at }}
                            </div>

                            {{-- Action --}}
                            <div class="flex justify-between items-center">
                                <a href="{{ route('articles.show', $article) }}"
                                   class="text-blue-600 hover:underline text-sm">
                                    Detail
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-500">
                        Belum ada artikel
                    </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $articles->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
