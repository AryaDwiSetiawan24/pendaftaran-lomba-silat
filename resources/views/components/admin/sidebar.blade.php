<!-- Sidebar for mobile -->
<div id="mobile-sidebar"
    class="fixed h-full inset-0 z-40 transform -translate-x-full transition-transform duration-300 md:hidden">
    <!-- Overlay hitam transparan -->
    <div id="mobile-overlay" class="absolute inset-0 bg-black opacity-50"></div>

    <!-- Kontainer sidebar -->
    <div class="relative w-64 h-full bg-white overflow-y-auto">
        <div class="p-6 space-y-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800">Menu</h2>
                <button id="close-sidebar" class="p-2 hover:bg-gray-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Menu Items -->
            <a href="{{ route('admin.dashboard') }}"
                class="w-full flex items-center px-4 py-3 rounded-lg text-sm 
                {{ request()->routeIs('admin.dashboard') ? 'bg-red-800 hover:bg-red-700 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                <span class="h-5 w-5 mr-3"><i class="uil uil-estate"></i></span> Dashboard
            </a>
            <a href="{{ route('admin.lomba') }}"
                class="w-full flex items-center px-4 py-3 rounded-lg text-sm 
                {{ request()->routeIs('admin.lomba') ||
                request()->routeIs('admin.add-lomba') ||
                request()->routeIs('admin.lomba.show') ||
                request()->routeIs('admin.lomba.edit')
                    ? 'bg-red-800 hover:bg-red-700 text-white'
                    : 'text-gray-700 hover:bg-gray-200' }}">
                <span class="h-5 w-5 mr-3"><i class="uil uil-plus"></i></span> Lomba Baru
            </a>
            <a href="{{ route('admin.peserta') }}"
                class="w-full flex items-center px-4 py-3 rounded-lg text-sm 
                {{ request()->routeIs('admin.peserta') ? 'bg-red-800 hover:bg-red-700 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                <span class="h-5 w-5 mr-3"><i class="uil uil-user"></i></span> Peserta
            </a>
            <a href="{{ route('admin.jadwal.index') }}"
                class="w-full flex items-center px-4 py-3 rounded-lg text-sm 
                {{ request()->routeIs('admin.jadwal') ? 'bg-red-800 hover:bg-red-700 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                <span class="h-5 w-5 mr-3"><i class="uil uil-calendar"></i></span> Jadwal
            </a>
        </div>
    </div>
</div>

<!-- Desktop sidebar -->
<div class="fixed hidden md:block w-64 bg-white h-screen shadow-lg">
    <div class="p-4 space-y-2">
        <a href="{{ route('admin.dashboard') }}"
            class="w-full flex items-center px-4 py-3 rounded-lg
            {{ request()->routeIs('admin.dashboard') ? 'bg-red-800 hover:bg-red-700 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
            <span class="h-5 w-5 mr-3 mb-1 text-center"><i class="uil uil-estate"></i></span> Dashboard
        </a>
        <a href="{{ route('admin.lomba') }}"
            class="w-full flex items-center px-4 py-3 rounded-lg
            {{ request()->routeIs('admin.lomba') ||
            request()->routeIs('admin.add-lomba') ||
            request()->routeIs('admin.lomba.show') ||
            request()->routeIs('admin.lomba.edit')
                ? 'bg-red-800 hover:bg-red-700 text-white'
                : 'text-gray-700 hover:bg-gray-200' }}">
            <span class="h-5 w-5 mr-3 mb-1 text-center"><i class="uil uil-medal"></i></span> Lomba
        </a>
        <a href="{{ route('admin.peserta') }}"
            class="w-full flex items-center px-4 py-3 rounded-lg
            {{ request()->routeIs('admin.peserta') ||
            request()->routeIs('admin.peserta.show') ||
            request()->routeIs('admin.peserta.edit')
                ? 'bg-red-800 hover:bg-red-700 text-white'
                : 'text-gray-700 hover:bg-gray-200' }}">
            <span class="h-5 w-5 mr-3 mb-1 text-center"><i class="uil uil-user"></i></span> Peserta
        </a>
        <a href="{{ route('admin.jadwal.index') }}"
            class="w-full flex items-center px-4 py-3 rounded-lg
            {{ request()->routeIs('admin.jadwal.index') ||
            request()->routeIs('admin.jadwal.pool') ||
            request()->routeIs('admin.jadwal.view')
                ? 'bg-red-800 hover:bg-red-700 text-white'
                : 'text-gray-700 hover:bg-gray-200' }}">
            <span class="h-5 w-5 mr-3 mb-1 text-center"><i class="uil uil-calendar"></i></span> Jadwal
        </a>
    </div>
</div>

{{-- Fungsi buka tutup sidebar --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('mobile-sidebar');
        const openBtn = document.getElementById('mobile-menu-button');
        const closeBtn = document.getElementById('close-sidebar');
        const overlay = document.getElementById('mobile-overlay');

        // buka sidebar
        openBtn?.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
        });

        // tutup sidebar (klik tombol X)
        closeBtn?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });

        // tutup sidebar jika klik area overlay hitam
        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });
    });
</script>
