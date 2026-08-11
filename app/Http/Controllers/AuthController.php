<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectUserByRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi login
     */
    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            return $this->redirectUserByRole($user)
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'Kredensial yang Anda masukkan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan form registrasi pelamar
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectUserByRole(Auth::user());
        }

        return view('auth.register');
    }

    /**
     * Proses pendaftaran akun baru (Role: Pelamar)
     */
    public function processRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'no_hp' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string', 'max:1000'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Alamat email ini sudah terdaftar dalam sistem.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'no_hp.required' => 'Nomor HP/WhatsApp wajib diisi.',
            'alamat.required' => 'Alamat domisili lengkap wajib diisi.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'role' => 'pelamar',
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
        ]);

        Auth::login($user);

        return redirect()->route('pelamar.dashboard')
            ->with('success', 'Pendaftaran akun berhasil! Silakan lengkapi profil & daftarkan lamaran Anda.');
    }

    /**
     * Proses logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar dari akun.');
    }

    /**
     * Helper redirect berbasis role user
     */
    protected function redirectUserByRole(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'hrd') {
            return redirect()->route('hrd.dashboard');
        }

        return redirect()->route('pelamar.dashboard');
    }
}
