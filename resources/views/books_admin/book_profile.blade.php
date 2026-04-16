@extends('layouts.panel')

@section('page-title', 'Profile Buku - ' . $book->judul)

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 mb-2">Profile Buku</h1>
                <p class="text-slate-600">Detail lengkap dan informasi buku</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.books.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('admin.books.profile.download', $book) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download Profile
                </a>
            </div>
        </div>
    </div>

    <!-- Book Code Badge -->
    <div class="mb-6">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-full font-semibold text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            Kode Buku: {{ $book->kode_buku }}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Book Cover & Basic Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="text-center">
                    @if($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->judul }}" class="w-full max-w-xs mx-auto rounded-lg shadow-md mb-4">
                    @else
                        <div class="w-full max-w-xs mx-auto h-64 bg-slate-200 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    @endif

                    <div class="space-y-2 text-sm text-slate-600">
                        <div class="flex justify-between">
                            <span>Status:</span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Aktif</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Stok:</span>
                            <span class="font-semibold text-slate-900">{{ $book->stok }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Book Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-slate-900 mb-6">Informasi Buku</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Judul</label>
                            <p class="text-slate-900 font-medium">{{ $book->judul }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Penulis</label>
                            <p class="text-slate-900">{{ $book->penulis }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Penerbit</label>
                            <p class="text-slate-900">{{ $book->penerbit ?: '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $book->kategori }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tahun Terbit</label>
                            <p class="text-slate-900">{{ $book->tahun_terbit }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">ISBN</label>
                            <p class="text-slate-900 font-mono text-sm">{{ $book->isbn ?: '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Profile Path</label>
                            <p class="text-slate-900 font-mono text-sm break-all">{{ $book->profile_path ?: '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Dibuat</label>
                            <p class="text-slate-900 text-sm">{{ $book->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Data JSON -->
            @if($book->book_profile)
            <div class="bg-slate-50 rounded-xl p-6 mt-6">
                <h4 class="text-lg font-bold text-slate-900 mb-4">Data Profile (JSON)</h4>
                <div class="bg-slate-800 rounded-lg p-4 overflow-x-auto">
                    <pre class="text-green-400 text-sm"><code>{{ json_encode($book->book_profile, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection