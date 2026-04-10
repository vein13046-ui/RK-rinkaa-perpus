@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
    <div class="relative z-10 min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
            <div class="hidden lg:flex flex-col justify-between rounded-[2rem] bg-white/10 backdrop-blur-xl border border-white/15 p-10 text-white shadow-2xl">
                <div>
                    <div class="inline-flex items-center gap-3 rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-blue-100">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                        Sistem Perpustakaan Digital
                    </div>
                    <h1 class="mt-8 text-5xl font-black leading-tight">RinKa <span class="text-blue-200">Perpus</span></h1>
                    <p class="mt-5 max-w-md text-base leading-relaxed text-slate-200/90">
                        Akses katalog, kelola data buku, dan pantau aktivitas perpustakaan lewat tampilan yang bersih dan profesional.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-3xl bg-white/10 p-5">
                        <p class="text-sm text-blue-100/80">Navigasi cepat</p>
                        <p class="mt-2 text-2xl font-black">Rapi</p>
                    </div>
                    <div class="rounded-3xl bg-white/10 p-5">
                        <p class="text-sm text-blue-100/80">Tampilan</p>
                        <p class="mt-2 text-2xl font-black">Profesional</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] bg-white/95 backdrop-blur-xl border border-slate-200/70 shadow-2xl shadow-slate-900/10 p-6 sm:p-8 lg:p-10">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Masuk</p>
                        <h2 class="mt-2 text-3xl font-black text-slate-900">Selamat datang kembali</h2>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white flex items-center justify-center font-black text-2xl shadow-lg shadow-blue-200">
                        RK
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 rounded-2xl bg-slate-100 p-1 mb-6">
                    <a href="{{ route('login') }}" class="rounded-xl bg-white px-4 py-3 text-center text-sm font-bold text-slate-900 shadow-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-xl px-4 py-3 text-center text-sm font-semibold text-slate-500 transition hover:text-slate-800">Daftar</a>
                </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-800">
                        <p class="font-bold">Login gagal</p>
                        <ul class="mt-2 list-disc pl-5 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="mb-3 block text-sm font-semibold text-slate-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@sekolah.sch.id" required autofocus
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-slate-900 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">
                        @error('email') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-3 block text-sm font-semibold text-slate-700">Password</label>
                        <input type="password" name="password" placeholder="Masukkan password" required
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-slate-900 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">
                        @error('password') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <label class="flex items-center gap-3 text-sm text-slate-600">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            Ingat saya
                        </label>
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Secure access</span>
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-slate-900 px-6 py-4 font-semibold text-white transition hover:bg-slate-800">
                        Masuk ke Dashboard
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-slate-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-blue-700 hover:text-blue-800">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
@endsection
