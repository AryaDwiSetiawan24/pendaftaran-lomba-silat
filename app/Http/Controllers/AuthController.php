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

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // public function googleCallback(){
    //     $googleUser = Socialite::driver('google')->user();
    //     dd($googleUser);
    // }

    public function googleCallback()
    {
        try {
            // 🔹 Ambil data user dari Google setelah proses login/izin selesai.
            // Gunakan ->stateless() jika kamu masih testing di localhost tanpa session yang stabil.
            $googleUser = Socialite::driver('google')->stateless()->user();

            // 🔹 Cek apakah user dengan google_id ini sudah pernah terdaftar di database.
            $user = User::where('google_id', $googleUser->getId())->first();

            if ($user) {
                // ✅ Jika sudah terdaftar, langsung login.
                Auth::login($user);
            } else {
                // ⚙️ Jika belum terdaftar, buat akun baru menggunakan data dari Google.
                $newUser = User::create([
                    'name'       => $googleUser->getName(),
                    'email'      => $googleUser->getEmail(),
                    'google_id'  => $googleUser->getId(),
                    'avatar'     => $googleUser->getAvatar(),
                    'role'       => 'peserta', // default role
                    'password'   => Hash::make(Str::random(24)), // password acak karena login via Google
                ]);

                // 🔹 Setelah akun dibuat, langsung login-kan user baru ini.
                Auth::login($newUser);
            }

            // 🔹 Redirect ke halaman utama/dashboard setelah berhasil login.
            return redirect()->route('home')->with('success', 'Login dengan Google berhasil!');
        } catch (\Exception $e) {
            // ⚠️ Jika terjadi error (misalnya user membatalkan login atau SSL bermasalah)
            // maka arahkan kembali ke halaman login dengan pesan error.
            return redirect()
                ->route('login')
                ->with('error', 'Gagal melakukan autentikasi dengan Google. Silakan coba lagi.');
            // Jika perlu debugging, aktifkan baris di bawah ini sementara:
            // dd($e->getMessage());
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logout berhasil!');
    }
}
