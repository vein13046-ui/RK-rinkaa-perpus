<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RinKa Perpus - Masuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
        }
    </style>
</head>
<body class="text-slate-700">

<div class="min-h-screen flex items-center justify-center bg-slate-50 px-4">

    <div class="w-full max-w-sm bg-white rounded-2xl p-8 shadow-xl shadow-slate-200/60 border border-slate-200">

        <!-- Tab Navigation -->
        <div class="flex bg-slate-100 rounded-xl p-1 mb-6 max-w-sm mx-auto">
            <a href="/login" class="flex-1 text-center py-3 px-4 font-bold text-sm rounded-lg bg-white shadow-sm active"
               style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                Masuk
            </a>
            <a href="/register" class="flex-1 text-center py-3 px-4 font-semibold text-sm text-slate-600 hover:text-slate-800 transition">
                Daftar
            </a>
        </div>

        <div class="text-center mb-8">
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white font-bold text-3xl mx-auto mb-4 shadow-lg shadow-blue-100">
                RK
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">RinKa <span class="text-blue-600">Perpus</span></h1>
            <p class="text-slate-500 text-sm mt-2">Silahkan login </p>
        </div>

        @if ($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl">
                <div class="flex">
                    <svg class="w-5 h-5 text-red-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h3 class="font-bold text-red-800 text-sm">Login Gagal!</h3>
                        <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-xl">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Email Perpustakaan</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@sekolah.sch.id"
                    class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('email') ? 'border-red-300 ring-2 ring-red-200/50' : 'border-slate-200' }} rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition duration-200 @error('email') ring-2 ring-red-500/20 border-red-500 @enderror"
                    required autofocus>
                @error('email')
                    <p class="mt-1 text-xs text-red-600 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex justify-between items-center mb-1.5 ml-1">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest">Password</label>
                    <a href="#" class="text-[11px] font-bold text-blue-600 hover:text-blue-700 uppercase tracking-tighter">Lupa?</a>
                </div>
                <input type="password" name="password" placeholder="••••••••"
                    class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('password') ? 'border-red-300 ring-2 ring-red-200/50' : 'border-slate-200' }} rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition duration-200 @error('password') ring-2 ring-red-500/20 border-red-500 @enderror"
                    required>
                @error('password')
                    <p class="mt-1 text-xs text-red-600 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center px-1">
                <label class="flex items-center group cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500/20 cursor-pointer transition">
                    <span class="ml-2 text-sm text-slate-500 group-hover:text-slate-700 transition">Ingat saya di perangkat ini</span>
                </label>
            </div>

            <button type="submit"
                class="w-full py-3.5 mt-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm transition duration-300 shadow-lg shadow-blue-200 hover:shadow-blue-300 transform hover:-translate-y-0.5 active:scale-[0.98]">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-500">
                Belum punya akun? 
                <a href="/register" class="text-blue-600 font-bold hover:text-blue-700 hover:underline transition">
                    Daftar
                </a>
            </p>
        </div>

    </div>
</div>

</body>
</html>