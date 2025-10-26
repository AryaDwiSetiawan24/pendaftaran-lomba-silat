<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Penilaian Lomba Silat</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl mb-4 shadow-2xl">
                    <span class="text-3xl">🥋</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Pendaftaran Lomba Silat</h1>
                <p class="text-blue-200 text-sm mt-2">Masuk untuk mengakses sistem pendaftaran lomba silat</p>
            </div>

            <!-- Login Form -->
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20 fade-in">
                @if (session('failed'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative"
                        role="alert">
                        {{ session('failed') }}</div>
                @endif
                <h1 class="text-2xl text-center font-bold text-white">Login</h1>

                <form action="/verify/{{ $unique_id }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-blue-100 mb-2">OTP</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-300" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="number" id="otp" name="otp"
                                class="w-full pl-10 pr-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200"
                                required>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-3 px-4 rounded-xl font-medium hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-transparent transform transition-all duration-200 hover:scale-[1.02] shadow-lg">
                        Submit
                    </button>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                        <div class="flex flex-col items-end text-end space-y-1">
                            <a href="#!" class="text-sm text-blue-200 hover:text-white transition-colors duration-200">
                                Kirim ulang email verifikasi
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-blue-200">
                        © 2025 Sistem Pendaftaran Lomba Silat.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // function handleGoogleLogin() {
        //     showNotification('Login Google akan dihubungkan dengan Laravel Socialite', 'info');
        // }

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
