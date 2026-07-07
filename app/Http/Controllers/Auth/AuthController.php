<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(
                $this->redirectBasedOnRole(Auth::user())
            );
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

<<<<<<< HEAD
    // Memproses aksi registrasi
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'tanggal_lahir' => 'required|date|before:today',
            'role' => 'required|in:reader,author',
        ], [
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi untuk verifikasi usia sistem.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Menyimpan data user baru
=======
    public function register(RegisterRequest $request)
    {
>>>>>>> 4e8ee55267e1902bc1fc12f65137dcef8889b2d2
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'tanggal_lahir' => $request->tanggal_lahir,
<<<<<<< HEAD
            'role' => $request->role,
            'status_premium' => false,
=======
>>>>>>> 4e8ee55267e1902bc1fc12f65137dcef8889b2d2
        ]);

        Auth::login($user);

<<<<<<< HEAD
        // Redirect ke dashboard yang sesuai dengan role yang didaftarkan
        $redirectRoute = $user->role === 'author' ? 'author.dashboard' : 'reader.dashboard';

        return redirect()->route($redirectRoute)->with('success', 'Registrasi berhasil! Selamat datang.');
=======
        return redirect($this->redirectBasedOnRole($user))
            ->with('success', 'Selamat datang, ' . $user->nama . '!');
>>>>>>> 4e8ee55267e1902bc1fc12f65137dcef8889b2d2
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Berhasil logout.');
    }

    private function redirectBasedOnRole(User $user): string
    {
        return match ($user->role) {
            'admin' => route('admin.dashboard'),
            'author' => route('author.dashboard'),
            default => route('reader.dashboard'),
        };
    }
class AuthControllerPasswordResetAddition
{
    /*
     * Tempelkan method di bawah ini ke dalam app/Http/Controllers/Auth/AuthController.php
     * (di antara method showRegister() dan logout(), atau di posisi manapun dalam class tersebut)
     */
 
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => ['required', 'email', 'exists:users,email']]);
 
        $status = Password::sendResetLink($request->only('email'));
 
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Tautan reset password telah dikirim ke email Anda.')
            : back()->withErrors(['email' => 'Gagal mengirim tautan reset. Pastikan email benar.']);
    }
 
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }
 
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
 
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => \Illuminate\Support\Facades\Hash::make($password),
                ])->save();
            }
        );
 
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login.')
            : back()->withErrors(['email' => 'Token reset tidak valid atau sudah kedaluwarsa.']);
    }
}
}