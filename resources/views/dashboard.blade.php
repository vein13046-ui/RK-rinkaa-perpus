<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
        }
        /* Custom Scrollbar untuk tampilan lebih bersih */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .active-menu {
            background-color: #EFF6FF;
            color: #2563EB;
            border-right: 4px solid #2563EB;
        }
    </style>
</head>
<body class="text-slate-700">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col">
            <div class="p-6">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">RK</div>
                    <span class="text-xl font-bold tracking-tight text-slate-800">RinKa <span class="text-blue-600">Perpus</span></span>
                </div>
            </div>

            <nav class="flex-1 mt-4">
                <p class="px-6 text-xs font-semibold text-slate-400 uppercase tracking-widest mb-4">Main Menu</p>
                <a href="#" class="flex items-center px-6 py-3 mb-1 active-menu transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.books.index') }}" class="flex items-center px-6 py-3 mb-1 text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span>Data Buku</span>
                </a>
                </a>
                <a href="{{ route('admin.books.create') }}" class="flex items-center px-6 py-3 mb-1 text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span>Tambah Buku</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 mb-1 text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Anggota</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 mb-1 text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    <span>Peminjaman</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 mb-1 text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m0 0l-4-4m4 4l-4 4m-5 3v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2a2 2 0 012 2v1"></path></svg>
                    <span>Laporan</span>
                </a>
            </nav>

            <div class="p-6 border-t border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full overflow-hidden shadow-md ring-2 ring-slate-200">
                        <img src="{{ Auth::user()->profilePhotoUrl() }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 md:px-8 shrink-0">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-slate-800">Dashboard Utama</h1>
                </div>
                <div class="flex items-center gap-4">
                    <button class="p-2 text-slate-400 hover:text-blue-600 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-400 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="h-8 w-[1px] bg-slate-200"></div>
                    <span class="hidden sm:inline text-sm font-medium text-slate-500">Kamis, 2 April 2026</span>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button id="profileBtn" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-100 transition-all group">
                            <div class="w-10 h-10 rounded-full overflow-hidden shadow-md ring-2 ring-slate-200 group-hover:ring-blue-300 transition-all">
                                <img src="{{ Auth::user()->profilePhotoUrl() }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="hidden sm:block min-w-0">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-400 capitalize">{{ Auth::user()->role }}</p>
                            </div>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="profileDropdown" class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-slate-200 opacity-0 invisible scale-95 origin-top-right transition-all duration-200 z-50 py-2">
                            <div class="px-4 py-3 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full overflow-hidden shadow-md">
                                        <img src="{{ Auth::user()->profilePhotoUrl() }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                                        <p class="text-sm text-slate-500">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-100">
                                @csrf
                                <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();" 
                                        class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-red-50 hover:text-red-600 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>

                    <script>
                        const profileBtn = document.getElementById('profileBtn');
                        const dropdown = document.getElementById('profileDropdown');
                        
                        profileBtn.addEventListener('click', (e) => {
                            e.stopPropagation();
                            dropdown.classList.toggle('opacity-100');
                            dropdown.classList.toggle('invisible');
                            dropdown.classList.toggle('scale-100');
                        });
                        
                        document.addEventListener('click', () => {
                            dropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                        });
                    </script>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 md:p-8">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>