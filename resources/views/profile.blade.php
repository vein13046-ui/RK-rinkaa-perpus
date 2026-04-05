<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil Pengguna - RinKa Perpus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen text-slate-700">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar (reuse dashboard style) -->
        <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col">
            <div class="p-6">
                <div class="flex items-center gap-2">
<div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">RK</div>
<span class="text-xl font-bold tracking-tight text-slate-800">RinKa <span class="text-blue-600">Perpus</span></span>
                </div>
            </div>
            <nav class="flex-1 mt-4 px-6">
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-3 mb-1 text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-all rounded-lg font-medium">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('profile') }}" class="flex items-center px-3 py-3 mb-1 bg-blue-50 text-blue-600 font-semibold transition-all rounded-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profil
                </a>
            </nav>
            <div class="p-6 border-t border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full overflow-hidden shadow-md ring-2 ring-slate-200">
                        <img src="{{ $user->profilePhotoUrl() }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-semibold truncate">{{ $user->name }}</p>
                        <p class="text-xs text-slate-400 capitalize">{{ $user->role }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 md:px-8 shrink-0">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-slate-800">Profil Pengguna</h1>
                </div>
                <!-- Profile Dropdown (same as dashboard) -->
                <div class="relative">
                    <button id="profileBtn" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-100 transition-all group">
                        <div class="w-10 h-10 rounded-full overflow-hidden shadow-md ring-2 ring-slate-200 group-hover:ring-blue-300 transition-all">
                            <img src="{{ $user->profilePhotoUrl() }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        </div>
                        <div class="hidden sm:block min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-slate-400 capitalize">{{ $user->role }}</p>
                        </div>
                    </button>
                    <div id="profileDropdown" class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-slate-200 opacity-0 invisible scale-95 origin-top-right transition-all duration-200 z-50 py-2">
                        <div class="px-4 py-3 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->profilePhotoUrl() }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full overflow-hidden shadow-md object-cover">
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $user->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-all">Profil</a>
                        <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-100">@csrf
                            <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-red-50 hover:text-red-600 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
                <script>
                    const profileBtn = document.getElementById('profileBtn');
                    const dropdown = document.getElementById('profileDropdown');
                    profileBtn.addEventListener('click', (e) => { e.stopPropagation(); dropdown.classList.toggle('opacity-100'); dropdown.classList.toggle('invisible'); dropdown.classList.toggle('scale-100'); });
                    document.addEventListener('click', () => { dropdown.classList.add('opacity-0','invisible','scale-95'); });
                </script>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                <div class="max-w-2xl mx-auto">
                    @if (session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl mb-8">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 p-10">
                        <div class="text-center mb-10">
                            <div class="w-32 h-32 rounded-full overflow-hidden shadow-2xl mx-auto mb-6 ring-4 ring-slate-100">
                                <img src="{{ $user->profilePhotoUrl() }}" alt="Foto Profil {{ $user->name }}" class="w-full h-full object-cover">
                            </div>
                            <h1 class="text-3xl font-bold text-slate-800 mb-2">{{ $user->name }}</h1>
                            <p class="text-2xl text-slate-500 mb-1">{{ $user->email }}</p>
                            <span class="inline-flex px-4 py-2 bg-blue-100 text-blue-800 text-lg font-semibold rounded-full">{{ ucfirst($user->role) }}</span>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-3">Unggah Foto Profil Baru</label>
                                <div class="border-2 border-dashed border-slate-300 rounded-2xl p-8 text-center hover:border-blue-400 transition-all bg-slate-50/50">
                                    <input type="file" name="profile_photo" id="photoInput" accept="image/*" class="hidden" required>
                                    <label for="photoInput" class="cursor-pointer flex flex-col items-center gap-3 p-6">
                                        <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="font-semibold text-slate-700 text-lg">Klik untuk unggah foto</p>
                                            <p class="text-sm text-slate-500">JPG, PNG, GIF (Max 2MB)</p>
                                        </div>
                                    </label>
                                    @error('profile_photo')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-8 rounded-2xl text-lg shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-200">
                                <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Update Foto Profil
                            </button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>
