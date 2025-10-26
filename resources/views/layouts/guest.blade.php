<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.2.0/css/line.css">

    <style>
        html {
            scroll-behavior: smooth;
        }

        /* Custom animation for hero text fade-in */
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
        <nav class="bg-black bg-opacity-50 backdrop-blur-md fixed w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <a href="#home">
                        <div class="flex items-center">
                            <div class="h-8 w-8 mt-2 text-yellow-400"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6" />
                                    <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18" />
                                    <path d="M4 22h16" />
                                    <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22" />
                                    <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22" />
                                    <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z" />
                                </svg></div>
                            <span class="ml-2 text-xl font-bold text-white">Lomba Silat Demak</span>
                        </div>
                    </a>

                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#home" class="text-white hover:text-yellow-400 transition">Home</a>
                        <a href="#lomba" class="text-white hover:text-yellow-400 transition">Lomba</a>
                        <a href="#tentang" class="text-white hover:text-yellow-400 transition">Tentang</a>
                    </div>

                    <div class="hidden md:flex items-center space-x-4">
                        <a href="/login"
                            class="nav-btn px-4 py-2 text-white border border-white rounded-lg hover:bg-white hover:text-red-900 transition">
                            Login
                        </a>
                        <a href="/register"
                            class="nav-btn px-4 py-2 bg-yellow-400 text-red-900 rounded-lg font-semibold hover:bg-yellow-300 transition">
                            Register
                        </a>
                    </div>

                    <button id="mobile-menu-btn" class="md:hidden text-white"><svg xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="4" x2="20" y1="12" y2="12" />
                            <line x1="4" x2="20" y1="6" y2="6" />
                            <line x1="4" x2="20" y1="18" y2="18" />
                        </svg></button>
                </div>
            </div>

            <div id="mobile-menu" class="hidden md:hidden px-4 pb-4 space-y-3">
                <div class="w-full border-t border-white/30"></div>
                <a href="#home" class="block text-white hover:text-yellow-400">Home</a>
                <a href="#lomba" class="block text-white hover:text-yellow-400">Lomba</a>
                <a href="#tentang" class="block text-white hover:text-yellow-400">Tentang</a>
                <div class="w-full border-t border-white/30"></div>
                <a href="/login" data-view="user"
                    class="nav-btn block w-full text-left text-white hover:text-yellow-400">Login</a>
                <a href="/register" data-view="admin"
                    class="nav-btn block w-full text-left text-white hover:text-yellow-400">Register</a>
            </div>
        </nav>

        <div class="pt-40 pb-20 px-4 h-dvh">
            <div id="hero" class="max-w-7xl mx-auto text-center">
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 animate-fade-in">
                    Kejuaraan PPD 1955 Championship<br>
                    <span class="text-yellow-400">Tahun 2025</span>
                </h1>
                <p class="text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
                    Platform terpadu untuk pendaftaran dan manajemen lomba silat
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#lomba"
                        class="px-8 py-4 bg-yellow-400 text-red-900 rounded-lg font-bold text-lg hover:bg-yellow-300 transition transform hover:scale-105">
                        Daftar Lomba Sekarang
                    </a>
                </div>
            </div>
        </div>

        <div id="lomba" class="max-w-7xl mx-auto px-4 pb-20 h-dvh">
            <h2 class="text-3xl font-bold text-white mb-8 text-center">Lomba Yang Tersedia</h2>

            <div class="grid md:grid-cols-3 gap-6">
                @forelse ($competitions as $competition)
                    <div
                        class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-6 hover:bg-opacity-20 transition transform hover:scale-105">

                        <div
                            class="bg-yellow-400 text-red-900 text-xs font-bold px-3 py-1 rounded-full inline-block mb-4">
                            {{ $competition->category ?? 'Umum' }}
                        </div>

                        <!-- Nama lomba -->
                        <h3 class="text-xl font-bold text-white mb-3">{{ $competition->name }}</h3>

                        <div class="space-y-2 text-gray-200">
                            <p class="flex items-center">
                                <span class="h-4 w-4 mr-2"><i class="uil uil-schedule"></i></span>
                                {{ \Carbon\Carbon::parse($competition->competition_date)->translatedFormat('d F Y') }}
                            </p>

                            <p class="flex items-center">
                                <span class="h-4 w-4 mr-2"><i class="uil uil-users-alt"></i></span>
                                {{ $competition->participants_count ?? 0 }} Peserta
                            </p>
                        </div>

                        <a href="#"
                            class="mt-4 block text-center w-full py-2 bg-yellow-400 text-red-900 rounded-lg font-semibold hover:bg-yellow-500 transition">
                            Lihat Detail
                        </a>
                    </div>
                @empty
                    <p class="text-gray-300 text-center col-span-3">Belum ada lomba yang tersedia.</p>
                @endforelse
            </div>
        </div>


        <footer id="tentang" class="bg-black bg-opacity-70 backdrop-blur-md border-t border-white/20">
            <div class="max-w-7xl mx-auto px-4 py-8">
                <div class="grid md:grid-cols-3 gap-8 mb-8">
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="h-8 w-8 text-yellow-400">
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
                            </div>
                            <span class="ml-2 text-xl font-bold text-white">Lomba Silat Demak</span>
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

                    <div>
                        <h3 class="text-white font-bold mb-4">Hubungi Kami</h3>
                        <div class="space-y-3">
                            <a href="mailto:pendaftaranlombasilat@gmail.com"
                                class="flex items-center text-gray-300 hover:text-yellow-400 transition text-sm">
                                <i class="uil uil-envelope mr-2"></i>
                                pendaftaranlombasilat@gmail.com
                            </a>
                            <p class="text-gray-300 text-sm flex items-start">
                                <i class="uil uil-map-marker mr-2 mt-1"></i>
                                <span>Demak, Jawa Tengah<br>Indonesia</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-white/20 pt-8">
                    <p class="text-center text-gray-400 text-sm">
                        &copy; 2025 Sistem Pendaftaran Lomba Silat. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        attachLandingPageListeners();

        function attachLandingPageListeners() {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            let isMobileMenuOpen = false;

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
        }
    </script>
</body>

</html>
