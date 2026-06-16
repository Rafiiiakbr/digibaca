<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses aksi login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Redirect otomatis berdasarkan Role setelah login berhasil
            return match (Auth::user()->role) {
                'admin' => redirect()->intended(route('admin.dashboard')),
                'author' => redirect()->intended(route('author.dashboard')),
                'reader' => redirect()->intended(route('reader.dashboard')),
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Menampilkan halaman registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

    // Memproses aksi registrasi pembaca (Reader)
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'tanggal_lahir' => 'required|date|before:today',
        ], [
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi untuk verifikasi usia sistem.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Menyimpan data user baru (Default role: reader)
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi BCrypt otomatis oleh Laravel
            'tanggal_lahir' => $request->tanggal_lahir,
            'role' => 'reader',
            'status_premium' => false,
        ]);

        Auth::login($user);

        return redirect()->route('reader.dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}