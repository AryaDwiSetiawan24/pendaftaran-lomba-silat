<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lomba Silat Demak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.2.0/css/line.css">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <style>
        html {
            scroll-behavior: smooth;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }
    </style>
</head>

<body>
    <div id="home" class="min-h-screen bg-gradient-to-br from-red-900 via-red-800 to-orange-900">
        <!-- Navigation -->
        <nav class="bg-black bg-opacity-50 backdrop-blur-md fixed w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <a href="#home" class="flex items-center">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-8">
                        <span class="ml-2 text-lg sm:text-xl font-bold text-white">Lomba Silat Demak</span>
                    </a>

                    <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                        <a href="#home" class="text-white hover:text-yellow-400 transition">Home</a>
                        <a href="#lomba" class="text-white hover:text-yellow-400 transition">Lomba</a>
                        <a href="#tentang" class="text-white hover:text-yellow-400 transition">Tentang</a>
                    </div>

                    <div class="hidden md:flex items-center space-x-3 lg:space-x-4">
                        <a href="/login"
                            class="px-3 lg:px-4 py-2 text-sm lg:text-base text-white border border-white rounded-lg hover:bg-white hover:text-red-900 transition">
                            Login
                        </a>
                        <a href="/register"
                            class="px-3 lg:px-4 py-2 text-sm lg:text-base bg-yellow-400 text-red-900 rounded-lg font-semibold hover:bg-yellow-300 transition">
                            Register
                        </a>
                    </div>

                    <button id="mobile-menu-btn" class="md:hidden text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="4" x2="20" y1="12" y2="12" />
                            <line x1="4" x2="20" y1="6" y2="6" />
                            <line x1="4" x2="20" y1="18" y2="18" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="hidden md:hidden px-4 pb-4 space-y-3">
                <div class="w-full border-t border-white/30"></div>
                <a href="#home" class="block text-white hover:text-yellow-400 py-2">Home</a>
                <a href="#lomba" class="block text-white hover:text-yellow-400 py-2">Lomba</a>
                <a href="#tentang" class="block text-white hover:text-yellow-400 py-2">Tentang</a>
                <div class="w-full border-t border-white/30"></div>
                <a href="/login"
                    class="block w-full text-center py-2 text-white border border-white rounded-lg hover:bg-white hover:text-red-900">Login</a>
                <a href="/register"
                    class="block w-full text-center py-2 bg-yellow-400 text-red-900 rounded-lg font-semibold hover:bg-yellow-300">Register</a>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="pt-24 sm:pt-32 md:pt-40 pb-12 sm:pb-16 md:pb-20 px-4 min-h-screen flex items-center">
            <div id="hero" class="max-w-7xl mx-auto text-center w-full">
                <h1
                    class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-bold text-white mb-4 sm:mb-6 animate-fade-in leading-tight">
                    Kejuaraan PPD 1955 Championship<br>
                    <span class="text-yellow-400">Tahun 2025</span>
                </h1>
                <p class="text-base sm:text-lg md:text-xl text-gray-200 mb-6 sm:mb-8 max-w-2xl mx-auto px-4">
                    Platform terpadu untuk pendaftaran dan manajemen lomba silat
                </p>
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4">
                    <a href="#lomba"
                        class="px-6 sm:px-8 py-3 sm:py-4 bg-yellow-400 text-red-900 rounded-lg font-bold text-base sm:text-lg hover:bg-yellow-300 transition transform hover:scale-105">
                        Daftar Lomba Sekarang
                    </a>
                </div>
            </div>
        </div>

        <!-- Competitions Section -->
        <div id="lomba" class="max-w-7xl mx-auto px-4 py-12 sm:py-16 md:py-20 min-h-screen">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-6 sm:mb-8 text-center">Lomba Yang
                Tersedia</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @forelse ($competitions as $competition)
                    <div
                        class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-5 sm:p-6 hover:bg-opacity-20 transition transform hover:scale-105">
                        <div
                            class="bg-yellow-400 text-red-900 text-xs font-bold px-3 py-1 rounded-full inline-block mb-3 sm:mb-4">
                            {{ $competition->category ?? 'Umum' }}
                        </div>

                        <h3 class="text-lg sm:text-xl font-bold text-white mb-2 sm:mb-3">{{ $competition->name }}</h3>

                        <div class="space-y-2 text-gray-200 text-sm sm:text-base">
                            <p class="flex items-center">
                                <i class="uil uil-schedule mr-2"></i>
                                {{ \Carbon\Carbon::parse($competition->competition_date)->translatedFormat('d F Y') }}
                            </p>
                            <p class="flex items-center">
                                <i class="uil uil-users-alt mr-2"></i>
                                {{ $competition->participants_count ?? 0 }} Peserta
                            </p>
                        </div>

                        <a href="{{ route('peserta.lomba.show', $competition->id) }}"
                            class="mt-4 block text-center w-full py-2 sm:py-2.5 bg-yellow-400 text-red-900 rounded-lg font-semibold hover:bg-yellow-500 transition text-sm sm:text-base">
                            Lihat Detail
                        </a>
                    </div>
                @empty
                    <p class="text-gray-300 text-center col-span-full text-sm sm:text-base">Belum ada lomba yang
                        tersedia.</p>
                @endforelse
            </div>
        </div>

        <!-- Footer -->
        <footer id="tentang" class="bg-black bg-opacity-70 backdrop-blur-md border-t border-white/20">
            <div class="max-w-7xl mx-auto px-4 py-8 sm:py-12">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-6 sm:mb-8">
                    <div>
                        <div class="flex items-center mb-4">
                            {{-- <div class="h-8 w-8 text-yellow-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6" />
                                    <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18" />
                                    <path d="M4 22h16" />
                                    <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22" />
                                    <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22" />
                                    <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z" />
                                </svg>
                            </div> --}}
                            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-8">
                            <span class="ml-2 text-lg sm:text-xl font-bold text-white">Lomba Silat Demak</span>
                        </div>
                        <p class="text-gray-300 text-sm leading-relaxed">
                            Platform pendaftaran lomba silat yang memudahkan atlet dan penyelenggara dalam mengelola
                            kompetisi seni bela diri.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-white font-bold mb-4">Navigasi</h3>
                        <ul class="space-y-2">
                            <li><a href="#home"
                                    class="text-gray-300 hover:text-yellow-400 transition text-sm">Home</a></li>
                            <li><a href="#lomba"
                                    class="text-gray-300 hover:text-yellow-400 transition text-sm">Lomba</a></li>
                            <li><a href="#tentang"
                                    class="text-gray-300 hover:text-yellow-400 transition text-sm">Tentang</a></li>
                        </ul>
                    </div>

                    <div class="sm:col-span-2 lg:col-span-1">
                        <h3 class="text-white font-bold mb-4">Hubungi Kami</h3>
                        <div class="space-y-3">
                            <a href="mailto:pendaftaranlombasilat@gmail.com"
                                class="flex items-center text-gray-300 hover:text-yellow-400 transition text-sm break-all">
                                <i class="uil uil-envelope mr-2 flex-shrink-0"></i>
                                pendaftaranlombasilat@gmail.com
                            </a>
                            <p class="text-gray-300 text-sm flex items-start">
                                <i class="uil uil-map-marker mr-2 mt-1 flex-shrink-0"></i>
                                <span>Demak, Jawa Tengah, Indonesia</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-white/20 pt-6 sm:pt-8">
                    <p class="text-center text-gray-400 text-xs sm:text-sm">
                        &copy; 2025 Sistem Pendaftaran Lomba Silat. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        let isMobileMenuOpen = false;

        const icons = {
            menu: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="4" x2="20" y1="12" y2="12" />
                <line x1="4" x2="20" y1="6" y2="6" />
                <line x1="4" x2="20" y1="18" y2="18" />
            </svg>`,
            x: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" x2="6" y1="6" y2="18" />
                <line x1="6" x2="18" y1="6" y2="18" />
            </svg>`
        };

        mobileMenuBtn.addEventListener('click', () => {
            isMobileMenuOpen = !isMobileMenuOpen;
            if (isMobileMenuOpen) {
                mobileMenu.classList.remove('hidden');
                mobileMenuBtn.innerHTML = icons.x;
            } else {
                mobileMenu.classList.add('hidden');
                mobileMenuBtn.innerHTML = icons.menu;
            }
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                mobileMenuBtn.innerHTML = icons.menu;
                isMobileMenuOpen = false;
            });
        });
    </script>
</body>

</html>
