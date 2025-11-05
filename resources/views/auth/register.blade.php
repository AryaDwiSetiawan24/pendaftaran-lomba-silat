<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Penilaian Lomba Silat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.2.0/css/line.css">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .silat-pattern {
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .fade-in {
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-red-900 via-red-800 to-orange-900 silat-pattern">
    {{-- alert --}}
    <x-alert />

    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div
            class="absolute top-1/4 left-1/4 w-72 h-72 rounded-full mix-blend-multiply filter blur-xl opacity-20 floating">
        </div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 rounded-full mix-blend-multiply filter blur-xl opacity-20 floating"
            style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 rounded-full mix-blend-multiply filter blur-xl opacity-20 floating"
            style="animation-delay: 4s;"></div>
    </div>

    <div class="mt-8 mb-8 relative min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">
            <!-- Logo & Title -->
            <div class="text-center mb-8 fade-in">
                <div class="inline-flex items-center w-20 h-20 mb-4">
                    <img src="{{ asset('logo.png') }}" alt="Logo">
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Pendaftaran Lomba Silat</h1>
                <p class="text-blue-200 text-sm mt-2">Register untuk mengakses sistem pendaftaran lomba silat</p>
            </div>

            <!-- Register Form -->
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20 fade-in">
                <h1 class="text-2xl text-center font-bold text-white">Register</h1>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- ⚠️ Alert khusus jika password tidak cocok --}}
                @if ($errors->has('password'))
                    @foreach ($errors->get('password') as $message)
                        @if (Str::contains($message, 'confirmation'))
                            <div
                                class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-2 rounded-lg mb-4">
                                ⚠️ Konfirmasi password tidak sama. Pastikan kedua kolom password identik.
                            </div>
                        @endif
                    @endforeach
                @endif

                <form action="{{ route('register') }}" method="POST" class="space-y-6 text-white">
                    @csrf
                    <!-- Name Input -->
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2">Nama</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="uil uil-user"></i>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="w-full pl-10 pr-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200"
                                required>
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="w-full pl-10 pr-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200"
                                required>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" id="password" name="password"
                                class="w-full pl-10 pr-12 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200"
                                required>
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                onclick="togglePassword()">
                                <svg id="eye-open" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password Input -->
                    <div>
                        <label for="confirm-password" class="block text-sm font-medium mb-2">Ulangi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full pl-10 pr-12 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200"
                                required>
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                onclick="toggleConfirmPassword()">
                                <svg id="eye-open" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <div class="flex items-center justify-between">
                        <a href="/login"
                            class="text-sm text-blue-200 hover:text-white transition-colors duration-200">
                            Sudah punya akun? Login
                        </a>
                    </div>

                    <!-- Login Button -->
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-3 px-4 rounded-xl font-medium hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-transparent transform transition-all duration-200 hover:scale-[1.02] shadow-lg">
                        Register
                    </button>

                    <!-- Tombol Batal -->
                    <a href="{{ route('welcome') }}"
                        class="w-full mt-3 inline-block text-center bg-white/20 border border-white/30 text-white py-3 px-4 rounded-xl font-medium hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-white/50 focus:ring-offset-2 focus:ring-offset-transparent transform transition-all duration-200 hover:scale-[1.02] shadow-md">
                        Batal
                    </a>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/30"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 pt-6 bg-transparent text-blue-200">atau</span>
                        </div>
                    </div>

                    <!-- Google Login Button -->
                    <a href="{{ route('auth.google') }}"
                        class="w-full bg-white/10 text-white py-3 px-4 rounded-xl font-medium hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/50 focus:ring-offset-2 focus:ring-offset-transparent transform transition-all duration-200 hover:scale-[1.02] border border-white/30 flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="currentColor"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="currentColor"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="currentColor"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        Masuk dengan Google
                    </a>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-blue-200">
                        &copy; 2025 Sistem Pendaftaran Lomba Silat. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-open');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }

        function toggleConfirmPassword() {
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const eyeIcon = document.getElementById('eye-open');

            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
            } else {
                confirmPasswordInput.type = 'password';
            }
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? 'from-green-500 to-emerald-600' :
                type === 'error' ? 'from-red-500 to-rose-600' :
                'from-blue-500 to-indigo-600';

            notification.className =
                `fixed top-5 right-5 bg-gradient-to-r ${bgColor} text-white px-6 py-4 rounded-xl z-50 shadow-lg transform translate-x-96 transition-all duration-300 max-w-sm`;
            notification.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        ${type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️'}
                    </div>
                    <p class="text-sm font-medium">${message}</p>
                </div>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.remove('translate-x-96');
            }, 100);

            setTimeout(() => {
                notification.classList.add('translate-x-96');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
    </script>
</body>

</html>
