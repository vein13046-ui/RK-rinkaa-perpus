<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan - Dashboard Pengguna</title>
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
        .active-menu {
            background-color: #EFF6FF;
            color: #2563EB;
            border-right: 4px solid #2563EB;
        }
        .tab-pane {
            display: none;
        }
        .tab-pane.active {
            display: block;
        }
    </style>
</head>
<body class="text-slate-700">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar for USER -->
        <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col">
            <div class="p-6">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">RK</div>
                    <span class="text-xl font-bold tracking-tight text-slate-800">RinKa <span class="text-blue-600">Perpus</span></span>
                </div>
            </div>

            <nav class="flex-1 mt-4">
                <p class="px-6 text-xs font-semibold text-slate-400 uppercase tracking-widest mb-4">Menu Pengguna</p>
<a href="#" data-tab="dashboard" class="flex items-center px-6 py-3 mb-1 active-menu transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="font-medium">Dashboard</span>
                </a>
<a href="#" data-tab="daftar-buku" class="flex items-center px-6 py-3 mb-1 text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span>Daftar Buku</span>
                </a>
<a href="#" data-tab="peminjaman" class="flex items-center px-6 py-3 mb-1 text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    <span>Peminjaman Saya</span>
                </a>
<a href="#" data-tab="riwayat" class="flex items-center px-6 py-3 mb-1 text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m0 0l-4-4m4 4l-4 4m Asc -5 3v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2a2 2 0 012 2v1"></path></svg>
                    <span>Riwayat Peminjaman</span>
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
                    <h1 class="text-xl font-semibold text-slate-800">Dashboard Pengguna</h1>
                </div>
                <!-- Same profile dropdown as dashboard -->
                <div class="flex items-center gap-4">
                    <!-- Notifications button -->
                    <button class="p-2 text-slate-400 hover:text-blue-600 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-400 rounded-full border-2 border-white"></span>
                    </button>
                    <span class="hidden sm:inline text-sm font-medium text-slate-500">{{ date('l, d F Y') }}</span>
                    <!-- Profile Dropdown (copied from dashboard.blade.php) -->
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
                        <div id="profileDropdown" class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-slate-200 opacity-0 invisible scale-95 origin-top-right transition-all duration-200 z-50 py-2">
                            <div class="px-4 py-3 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <img src="{{ Auth::user()->profilePhotoUrl() }}" alt="{{ Auth::user()->name }}" class="w-12 h-12 rounded-full overflow-hidden shadow-md object-cover">
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
                </div>
            </header>


            <main class="flex-1 overflow-y-auto p-4 md:p-8">
                <div class="max-w-6xl mx-auto">
                    <!-- Tab: Dashboard -->
                    <div id="tab-dashboard" class="tab-pane active">
                    <!-- Tab: Daftar Buku -->
                    <div id="tab-daftar-buku" class="tab-pane">
                        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 p-8 mb-8">
                            <div class="flex items-center justify-between mb-8">
                                <div>
                                    <h2 class="text-2xl font-bold text-slate-800 mb-2">Daftar Buku Tersedia</h2>
                                    <p class="text-slate-600">Jelajahi koleksi buku perpustakaan kami</p>
                                </div>
                            </div>

                            @forelse ($books as $book)
                                <div class="group bg-gradient-to-br from-indigo-50 to-blue-50 p-6 rounded-2xl border border-indigo-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 mb-6">
                                    <div class="flex gap-6">
                                        <div class="w-24 h-32 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-2xl transition-all">
                                            <svg class="w-12 h-12 text-indigo-500 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-xl font-bold text-slate-800 mb-1 line-clamp-2 group-hover:text-indigo-700 transition-colors">{{ $book->judul }}</h3>
                                            <p class="text-slate-600 font-medium mb-1">{{ $book->penulis }}</p>
                                            <p class="text-sm text-slate-500 mb-3">{{ $book->penerbit }} • {{ $book->tahun_terbit }}</p>
                                            <div class="flex items-center gap-4 text-sm">
                                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 rounded-full font-medium">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path></svg>
                                                    Stok: {{ $book->stok }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-20">
                                    <div class="w-24 h-24 bg-slate-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                                        <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-slate-800 mb-3">Mohon Maaf</h3>
                                    <p class="text-xl font-semibold text-slate-500 mb-8">Buku belum ditambahkan</p>
                                    <p class="text-slate-600 max-w-md mx-auto">Koleksi buku akan segera tersedia. Silakan cek kembali nanti atau hubungi admin perpustakaan.</p>
                                </div>
                            @endforelse
                        </div>

                    <!-- Tab: Peminjaman Saya -->
                    <div id="tab-peminjaman" class="tab-pane">
                        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 p-10">
                            <h2 class="text-2xl font-bold text-slate-800 mb-8">Peminjaman Saya</h2>
                            <div class="text-center py-16 text-slate-500">
                                <svg class="w-20 h-20 mx-auto mb-6 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                <h3 class="text-xl font-semibold mb-2">Belum ada peminjaman</h3>
                                <p>Pilih buku dari Daftar Buku untuk meminjam</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Riwayat Peminjaman -->
                    <div id="tab-riwayat" class="tab-pane">
                        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 p-10">
                            <h2 class="text-2xl font-bold text-slate-800 mb-8">Riwayat Peminjaman</h2>
                            <div class="text-center py-16 text-slate-500">
                                <svg class="w-20 h-20 mx-auto mb-6 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="text-xl font-semibold mb-2">Belum ada riwayat</h3>
                                <p>Riwayat peminjaman akan muncul di sini</p>
                            </div>
                        </div>
                    </div>
                </div> 
                        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 p-10 mb-8">
                            <h2 class="text-2xl font-bold text-slate-800 mb-6">Selamat Datang, {{ Auth::user()->name }}!</h2>
                            <p class="text-lg text-slate-600 mb-8">Kelola peminjaman buku Anda dengan mudah melalui menu di sidebar.</p>
                            
                            <!-- Personal Stats Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-2xl border border-blue-100 shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-500">Buku Tersedia</p>
                                        <h3 class="text-2xl font-bold text-slate-800">2,450</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 p-6 rounded-2xl border border-emerald-100 shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-500">Sedang Dipinjam</p>
                                        <h3 class="text-2xl font-bold text-slate-800">5</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-orange-50 to-yellow-50 p-6 rounded-2xl border border-orange-100 shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-orange-100 text-orange-600 rounded-xl">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-500">Batas Waktu</p>
                                        <h3 class="text-2xl font-bold text-slate-800">2 hari</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-2xl border border-purple-100 shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-purple-100 text-purple-600 rounded-xl">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-500">Total Riwayat</p>
                                        <h3 class="text-2xl font-bold text-slate-800">23</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<script>
    // Tab switching functionality
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarLinks = document.querySelectorAll('[data-tab]');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetTab = this.getAttribute('data-tab');
                
                // Update sidebar active state
                sidebarLinks.forEach(l => l.classList.remove('active-menu'));
                this.classList.add('active-menu');
                
                // Update tab panes
                tabPanes.forEach(pane => {
                    pane.classList.remove('active');
                });
                document.getElementById('tab-' + targetTab).classList.add('active');
            });
        });
    });
</script>
    </div>
</main>
        </div>
    </div>

</body>
</html>
