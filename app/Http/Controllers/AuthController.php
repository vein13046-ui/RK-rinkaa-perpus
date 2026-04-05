<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Tampilkan Form Login
    public function showLogin()
    {
        return view('auth.login');
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
        return view('auth.register');
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
        if (($user->role ?? 'user') === 'admin') {
            return view('dashboard');
        }
        return $this->userDashboard();
    }

        // User Dashboard
    public function userDashboard()
    {
        $books = \App\Models\Book::latest()->paginate(12);
        return view('dashboard_user', compact('books'));
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
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old photo if exists
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Store new photo
        $path = $request->file('profile_photo')->store('avatars', 'public');
        
        $user->update(['profile_photo' => $path]);
        
        return back()->with('success', 'Foto profil berhasil diupdate!');
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