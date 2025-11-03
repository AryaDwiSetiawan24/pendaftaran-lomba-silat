<nav class="bg-red-900 text-white fixed shadow-lg w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <!-- Tombol menu mobile -->
                <button id="mobile-menu-button" class="md:hidden p-2 mr-2 hover:bg-red-800 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>

                <!-- Logo -->
                <a href="/admin" class="h-8 w-8 text-yellow-400 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6" />
                        <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18" />
                        <path d="M4 22h16" />
                        <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22" />
                        <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22" />
                        <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z" />
                    </svg>
                </a>

                <a href="/admin" class="ml-2 text-lg sm:text-xl font-bold truncate">Admin Dashboard</a>
            </div>

            <!-- Menu kanan -->
            <div class="flex items-center space-x-3 sm:space-x-4">
                <!-- Notifikasi -->
                <div class="h-6 w-6 cursor-pointer hover:text-yellow-400 hidden sm:block">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                        <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                    </svg>
                </div>

                <!-- Profil -->
                <div class="flex items-center space-x-2">
                    <div
                        class="w-9 h-9 sm:w-10 sm:h-10 bg-yellow-400 rounded-full flex items-center justify-center text-red-900 font-bold text-sm sm:text-base">
                        {{ strtoupper(substr(Auth::user()->name ?? 'Admin', 0, 1)) }}
                    </div>
                    <span class="hidden sm:block">{{ Auth::user()->name ?? 'Admin' }}</span>
                </div>

                <!-- Logout -->
                <a href="/logout" class="hover:text-yellow-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</nav>