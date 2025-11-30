<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|string|max:50',
        ]);

        // Bersihkan input dari tag HTML dan spasi berlebih
        $cleanEmail = trim(strip_tags($request->email));
        $cleanPassword = trim(strip_tags($request->password));

        // Cegah input XSS — jika hasil strip_tags berbeda dari input asli
        if ($cleanEmail !== $request->email || $cleanPassword !== $request->password) {
            return back()
                ->withInput()
                ->with('failed', 'Input mengandung karakter tidak diperbolehkan. Mohon periksa kembali.');
        }

        // Autentikasi user
        if (Auth::attempt(['email' => $cleanEmail, 'password' => $cleanPassword], $request->remember)) {
            $user = Auth::user();

            // Redirect sesuai role
            if ($user->role === 'admin') {
                return redirect('/admin')->with('success', 'Login berhasil!');
            }

            return redirect('/peserta')->with('success', 'Login berhasil!');
        }

        return back()->with('failed', 'Email atau password salah!');
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email|max:50',
            'password' => 'required|confirmed|string|min:6|max:50',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak sama. Pastikan kedua kolom password identik.',
        ]);

        // Bersihkan input
        $cleanName = trim(strip_tags($request->name));
        $cleanEmail = trim(strip_tags($request->email));

        // 🚫 Cek apakah input mengandung tag HTML
        if ($cleanName !== $request->name || $cleanEmail !== $request->email) {
            return back()
                ->withInput()
                ->with('failed', 'Input mengandung karakter tidak diperbolehkan. Mohon periksa kembali.');
        }

        // Simpan user baru
        $user = User::create([
            'name' => $cleanName,
            'email' => $cleanEmail,
            'password' => bcrypt($request->password),
            'status' => 'verify',
        ]);

        Auth::login($user);

        return redirect('/peserta')
            ->with('success', 'Register berhasil! Selamat datang ' . e($user->name) . '.');
    }

    // Redirect ke Google
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback Google
    public function googleCallback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if (!$user) {
                // Buat user baru jika belum ada
                $user = User::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar(),
                    'role'      => 'peserta', // default role
                    'status'      => 'active', // status aktif tanpa otp
                    'password'  => Hash::make(Str::random(24)), // random password
                ]);
            }

            // Login user
            Auth::login($user);

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai Admin!');
            } else {
                return redirect()->route('peserta.dashboard')->with('success', 'Login berhasil!');
            }
        } catch (\Exception $e) {
            // Debug sementara: tampilkan error
            // dd($e->getMessage());

            // Produksi: redirect ke login dengan pesan error
            return redirect()->route('login')->with('error', 'Gagal login dengan Google.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus sesi dan regenerasi untuk keamanan tambahan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout berhasil!');
    }
}
