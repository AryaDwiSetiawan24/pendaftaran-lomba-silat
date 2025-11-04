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
            'password' => 'required|max:50',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            if (Auth::user()->role === 'admin') {
                return redirect('/admin')->with('success', 'Login berhasil!');
            }
            return redirect('/peserta')->with('success', 'Login berhasil!');
        }
        return back()->with('failed', 'email atau password salah!');
    }

    function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email|max:50',
            'password' => 'required|confirmed|max:50|min:6',
        ]);

        $request['status'] = 'verify';
        $user = User::create($request->all());
        Auth::login($user);
        return redirect('/peserta')->with('success', 'Register berhasil! Selamat datang ' . $user->name . '.');
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

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logout berhasil!');
    }
}
