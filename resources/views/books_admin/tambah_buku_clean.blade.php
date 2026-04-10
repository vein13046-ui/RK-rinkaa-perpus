@extends('layouts.panel')

@section('page-title', 'Tambah Buku')
@section('page-description', 'Form input buku yang lebih rapi, fokus, dan mudah diisi.')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/60 p-6 sm:p-8 lg:p-10">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Form Admin</p>
                    <h3 class="mt-2 text-3xl font-black text-slate-900">Tambah Buku Baru</h3>
                    <p class="mt-3 text-slate-600">Masukkan data buku dengan tampilan form yang lebih bersih dan profesional.</p>
                </div>
                <a href="{{ route('admin.books.index') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-3.5 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="judul" class="block text-sm font-semibold text-slate-700 mb-3">Judul Buku</label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-slate-900 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            placeholder="Masukkan judul buku">
                        @error('judul') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="penulis" class="block text-sm font-semibold text-slate-700 mb-3">Penulis</label>
                        <input type="text" id="penulis" name="penulis" value="{{ old('penulis') }}" required
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-slate-900 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            placeholder="Nama penulis">
                        @error('penulis') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-3">Kategori</label>
                        <input type="text" id="kategori" name="kategori" value="{{ old('kategori') }}" required
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-slate-900 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            placeholder="Contoh: Fiksi, Teknologi">
                        @error('kategori') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tahun_terbit" class="block text-sm font-semibold text-slate-700 mb-3">Tahun Terbit</label>
                        <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') }}" min="1901" max="{{ date('Y') + 1 }}" required
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-slate-900 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            placeholder="2025">
                        @error('tahun_terbit') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="penerbit" class="block text-sm font-semibold text-slate-700 mb-3">Penerbit</label>
                        <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit') }}"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-slate-900 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            placeholder="Opsional">
                    </div>

                    <div>
                        <label for="isbn" class="block text-sm font-semibold text-slate-700 mb-3">ISBN</label>
                        <input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-slate-900 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            placeholder="Opsional">
                        @error('isbn') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="stok" class="block text-sm font-semibold text-slate-700 mb-3">Stok</label>
                        <input type="number" id="stok" name="stok" value="{{ old('stok', 1) }}" min="0" max="1000" required
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-slate-900 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            placeholder="10">
                        @error('stok') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="rounded-[2rem] border border-dashed border-slate-200 bg-slate-50/70 p-6 sm:p-8">
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Foto Cover Buku</label>
                    <div class="rounded-[1.5rem] border border-slate-200 bg-white px-6 py-10 text-center">
                        <input type="file" id="foto" name="foto" accept="*/*" required class="hidden">
                        <label for="foto" class="cursor-pointer block">
                            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <p class="text-lg font-bold text-slate-900">Pilih file untuk cover</p>
                            <p class="mt-2 text-sm text-slate-500">Semua format file kecuali MP4, maksimal 100 MB</p>
                            <p id="fileName" class="mt-4 text-sm font-medium text-slate-600"></p>
                        </label>
                        @error('foto') <p class="mt-4 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="inline-flex flex-1 items-center justify-center gap-2 rounded-2xl bg-slate-900 px-6 py-4 font-semibold text-white transition hover:bg-slate-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"></path>
                        </svg>
                        Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const input = document.getElementById('foto');
    const fileName = document.getElementById('fileName');

    if (input && fileName) {
        input.addEventListener('change', function () {
            fileName.textContent = this.files && this.files.length ? this.files[0].name : '';
        });
    }
</script>
@endpush
