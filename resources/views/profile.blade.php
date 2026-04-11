@extends('layouts.panel')

@section('page-title', 'Profil Akun')
@section('page-description', 'Kelola identitas akun dengan tampilan yang bersih dan fokus.')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="rounded-[2rem] border border-slate-100 bg-white p-6 shadow-xl shadow-slate-200/60 sm:p-8">
            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-[220px_1fr]">
                <div class="text-center lg:text-left">
                    <div class="mx-auto h-36 w-36 overflow-hidden rounded-[1.5rem] ring-4 ring-slate-100 shadow-md lg:mx-0">
                        <img src="{{ $user->profilePhotoUrl() }}" alt="Foto Profil {{ $user->name }}" class="h-full w-full object-cover">
                    </div>
                    <h3 class="mt-4 text-xl font-black text-slate-900">{{ $user->name }}</h3>
                    <p class="mt-1 text-sm text-slate-500">{{ $user->email }}</p>
                    <span class="mt-3 inline-flex rounded-full bg-blue-100 px-3 py-1.5 text-xs font-semibold capitalize text-blue-700">{{ $user->role }}</span>
                </div>

                <div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Profil Pengguna</p>
                        <h4 class="mt-2 text-2xl font-black text-slate-900">Informasi Akun</h4>
                    </div>

                    <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Nama Akun</label>
                            <input type="text" value="{{ $user->name }}" readonly class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Akun Gmail</label>
                            <input type="text" value="{{ $user->email }}" readonly class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Role</label>
                            <input type="text" value="{{ ucfirst($user->role ?? 'user') }}" readonly class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Status</label>
                            <input type="text" value="Aktif" readonly class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900">
                        </div>
                    </div>

                    <div class="mt-6 border-t border-slate-100 pt-6">
                        @if (($user->role ?? 'user') === 'admin')
                            <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                                Foto profil admin dikunci dan tidak dapat diganti.
                            </div>
                        @else
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="photoInput" class="mb-1.5 block text-sm font-semibold text-slate-700">Upload Foto Profil</label>
                                    <input type="file" name="profile_photo" id="photoInput" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" required class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 file:mr-3 file:rounded-md file:border-0 file:bg-slate-900 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-slate-800">
                                    <p class="mt-1.5 text-xs text-slate-500">Format: JPG, PNG, GIF, WEBP (maksimal 5 MB)</p>
                                    @error('profile_photo')
                                        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                                    Simpan Foto Profil
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
