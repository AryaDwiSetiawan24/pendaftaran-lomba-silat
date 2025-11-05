<nav class="bg-white shadow fixed w-full z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('peserta.dashboard') }}">
                <div class="flex items-center">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-8">
                    <span class="ml-2 text-xl font-bold text-red-900">Dashboard Peserta</span>
                </div>
            </a>
            {{-- <div class="hidden md:flex items-center space-x-6">
                <a href="#home" class="text-gray-600 hover:text-red-900 hover:font-semibold">Home</a>
                <a href="#lomba-tersedia" class="text-gray-600 hover:text-red-900 hover:font-semibold">Lomba</a>
                <a href="#jadwal-pertandingan" class="text-gray-600 hover:text-red-900 hover:font-semibold">Jadwal</a>
            </div> --}}
            <div class="flex items-center space-x-4">
                <div class="h-6 w-6 text-gray-600 cursor-pointer hover:text-red-900">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                        <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                    </svg>
                </div>
                <div class="flex items-center space-x-2">
                    <div
                        class="w-10 h-10 bg-red-900 rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(Auth::user()->name ?? 'Peserta test', 0, 1)) }}</div>
                    <span class="hidden md:block">{{ Auth::user()->name ?? 'Peserta test' }}</span>
                </div>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>

                <a href="#" class="nav-btn text-gray-600 hover:text-red-900"
                    onclick="event.preventDefault(); 
                    if (confirm('Apakah Anda yakin ingin logout?')) { 
                    document.getElementById('logout-form').submit(); 
                    }">
                    <span class="h-5 w-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                    </span>
                    {{-- Logout --}}
                </a>

                {{-- <a href="/logout" data-view="landing" class="nav-btn text-gray-600 hover:text-red-900">
                    <span class="h-5 w-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                    </span>
                </a> --}}
            </div>
        </div>
    </div>
</nav>
