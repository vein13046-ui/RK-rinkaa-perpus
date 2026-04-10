<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Tampilkan Form Login
    public function showLogin()
    {
        return view('auth.login_clean');
    }

    // Proses Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            Log::info('User logged in', ['user_id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'role' => $user->role ?? 'NULL']);
            
            $redirectTo = 'dashboard';
            Log::info('Redirecting user to route', ['role' => $user->role ?? 'NULL', 'redirect_to' => $redirectTo]);
            
            return redirect()->intended($redirectTo);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Tampilkan Form Register
    public function showRegister()
    {
        return view('auth.register_clean');
    }

    // Proses Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // Auth::login($user); // Commented auto-login per user request

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan login dengan akun baru Anda.');
    }



    // Dashboard - role based
    public function dashboard()
    {
        $user = Auth::user();
        $stats = [
            'bookCount' => Book::count(),
            'stockCount' => Book::sum('stok'),
            'availableCount' => Book::where('stok', '>', 0)->count(),
            'memberCount' => User::where('role', 'user')->count(),
        ];

        $recentBooks = Book::latest()->take(5)->get();

        if (($user->role ?? 'user') === 'admin') {
            return view('dashboard', compact('stats', 'recentBooks'));
        }
        return $this->userDashboard();
    }

        // User Dashboard
    public function userDashboard()
    {
        $featuredBooks = Book::latest()->take(6)->get();
        $stats = [
            'bookCount' => Book::count(),
            'stockCount' => Book::sum('stok'),
            'availableCount' => Book::where('stok', '>', 0)->count(),
            'categoryCount' => Book::distinct('kategori')->count('kategori'),
        ];

        return view('dashboard_user_clean', compact('featuredBooks', 'stats'));
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    /**
     * Update user profile photo
     */
    public function updateProfilePhoto(Request $request)
    {
        $user = Auth::user();

        if (($user->role ?? 'user') === 'admin') {
            return back()
                ->withErrors(['profile_photo' => 'Foto profil admin dikunci dan tidak dapat diganti.']);
        }

        $request->validate([
            'profile_photo' => 'required|file|max:102400',
        ]);

        $file = $request->file('profile_photo');

        if (! $file || ! $file->isValid()) {
            return back()
                ->withErrors(['profile_photo' => 'Upload gagal. Coba file yang lebih kecil atau periksa batas upload server.'])
                ->withInput();
        }

        $extension = strtolower((string) $file->getClientOriginalExtension());
        $mimeType = strtolower((string) $file->getMimeType());

        if ($extension === 'mp4' || $mimeType === 'video/mp4') {
            return back()
                ->withErrors(['profile_photo' => 'File MP4 tidak diperbolehkan.'])
                ->withInput();
        }

        try {
            // Store new photo first so the existing profile stays intact if anything fails
            $path = $file->store('avatars', 'public');

            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $user->update(['profile_photo' => $path]);

            return back()->with('success', 'Foto profil berhasil diupdate!');
        } catch (\Throwable $e) {
            Log::error('Profile photo upload failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withErrors(['profile_photo' => 'Upload gagal saat menyimpan file.'])
                ->withInput();
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
