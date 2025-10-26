<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lomba Silat Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom animation for hero text fade-in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div id="app"></div>

    {{-- <div class="fixed bottom-4 right-4 bg-white rounded-lg shadow-lg p-4 z-50">
        <p class="text-xs text-gray-500 mb-2 font-semibold">Demo Navigation:</p>
        <div id="demo-nav" class="space-y-2">
            <button data-view="landing" class="demo-btn block w-full text-left px-3 py-2 rounded bg-red-900 text-white text-sm">
                Landing Page
            </button>
            <button data-view="admin" class="demo-btn block w-full text-left px-3 py-2 rounded bg-gray-100 hover:bg-gray-200 text-sm">
                Admin Dashboard
            </button>
            <button data-view="user" class="demo-btn block w-full text-left px-3 py-2 rounded bg-gray-100 hover:bg-gray-200 text-sm">
                User Dashboard
            </button>
        </div>
    </div> --}}

    <script>
        const app = document.getElementById('app');
        let currentView = 'landing';

        // --- ICONS (SVG replacements for lucide-react) ---
        const icons = {
            menu: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>`,
            x: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>`,
            calendar: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>`,
            trophy: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/></svg>`,
            users: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>`,
            logOut: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>`,
            plus: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>`,
            edit: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>`,
            trash2: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>`,
            eye: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>`,
            bell: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>`,
            search: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>`,
            filter: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>`,
        };

        // --- DATA ---
        const landingPageLomba = [
            { title: 'Kejuaraan Nasional Silat 2025', date: '15-17 Oktober 2025', peserta: 156, kategori: 'Tanding & Seni' },
            { title: 'Piala Gubernur Jawa Tengah', date: '5-7 November 2025', peserta: 89, kategori: 'Tanding' },
            { title: 'Festival Silat Nusantara', date: '1-3 Desember 2025', peserta: 234, kategori: 'Seni' }
        ];

        const adminStats = [
            { title: 'Total Lomba', value: '12', icon: 'trophy', color: 'bg-blue-500' },
            { title: 'Total Peserta', value: '487', icon: 'users', color: 'bg-green-500' },
            { title: 'Lomba Aktif', value: '3', icon: 'calendar', color: 'bg-yellow-500' },
            { title: 'Jadwal Hari Ini', value: '8', icon: 'calendar', color: 'bg-red-500' }
        ];

        const adminLombaTable = [
            { nama: 'Kejuaraan Nasional Silat 2025', tanggal: '15-17 Okt 2025', peserta: 156, status: 'Aktif' },
            { nama: 'Piala Gubernur Jawa Tengah', tanggal: '5-7 Nov 2025', peserta: 89, status: 'Pendaftaran' },
            { nama: 'Festival Silat Nusantara', tanggal: '1-3 Des 2025', peserta: 234, status: 'Pendaftaran' }
        ];
        
        const userLombaList = [
            { nama: 'Kejuaraan Nasional Silat 2025', tanggal: '15-17 Oktober 2025', lokasi: 'Jakarta', kategori: 'Tanding & Seni', batas: '10 Oktober 2025' },
            { nama: 'Piala Gubernur Jawa Tengah', tanggal: '5-7 November 2025', lokasi: 'Semarang', kategori: 'Tanding', batas: '30 Oktober 2025' },
            { nama: 'Festival Silat Nusantara', tanggal: '1-3 Desember 2025', lokasi: 'Surabaya', kategori: 'Seni', batas: '25 November 2025' }
        ];

        const userJadwalTable = [
            { lomba: 'Kejuaraan Nasional', waktu: '15 Okt 2025, 09:00', kategori: 'Tanding Putra', gelanggang: 'A1', status: 'Akan Datang' },
            { lomba: 'Kejuaraan Nasional', waktu: '16 Okt 2025, 14:00', kategori: 'Seni Tunggal', gelanggang: 'B2', status: 'Akan Datang' }
        ];


        // --- TEMPLATE RENDERING FUNCTIONS ---

        // Landing Page
        function renderLombaCards() {
            return landingPageLomba.map(lomba => `
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-6 hover:bg-opacity-20 transition transform hover:scale-105">
                    <div class="bg-yellow-400 text-red-900 text-xs font-bold px-3 py-1 rounded-full inline-block mb-4">
                        ${lomba.kategori}
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">${lomba.title}</h3>
                    <div class="space-y-2 text-gray-200">
                        <p class="flex items-center"><span class="h-4 w-4 mr-2">${icons.calendar}</span> ${lomba.date}</p>
                        <p class="flex items-center"><span class="h-4 w-4 mr-2">${icons.users}</span> ${lomba.peserta} Peserta</p>
                    </div>
                    <button class="mt-4 w-full py-2 bg-yellow-400 text-red-900 rounded-lg font-semibold hover:bg-yellow-300 transition">
                        Daftar Sekarang
                    </button>
                </div>
            `).join('');
        }
        
        function LandingPage() {
            return `
            <div class="min-h-screen bg-gradient-to-br from-red-900 via-red-800 to-orange-900">
                <nav class="bg-black bg-opacity-50 backdrop-blur-md fixed w-full z-50">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center h-16">
                            <div class="flex items-center">
                                <div class="h-8 w-8 text-yellow-400">${icons.trophy}</div>
                                <span class="ml-2 text-xl font-bold text-white">Lomba Silat Indonesia</span>
                            </div>
                            
                            <div class="hidden md:flex items-center space-x-8">
                                <a href="#lomba" class="text-white hover:text-yellow-400 transition">Lomba</a>
                                <a href="#jadwal" class="text-white hover:text-yellow-400 transition">Jadwal</a>
                                <a href="#klasemen" class="text-white hover:text-yellow-400 transition">Klasemen</a>
                                <a href="#tentang" class="text-white hover:text-yellow-400 transition">Tentang</a>
                            </div>

                            <div class="hidden md:flex items-center space-x-4">
                                <button data-view="user" class="nav-btn px-4 py-2 text-white border border-white rounded-lg hover:bg-white hover:text-red-900 transition">
                                    Login Peserta
                                </button>
                                <button data-view="admin" class="nav-btn px-4 py-2 bg-yellow-400 text-red-900 rounded-lg font-semibold hover:bg-yellow-300 transition">
                                    Login Admin
                                </button>
                            </div>

                            <button id="mobile-menu-btn" class="md:hidden text-white">${icons.menu}</button>
                        </div>
                    </div>

                    <div id="mobile-menu" class="hidden md:hidden bg-black bg-opacity-90 px-4 py-4 space-y-3">
                        <a href="#lomba" class="block text-white hover:text-yellow-400">Lomba</a>
                        <a href="#jadwal" class="block text-white hover:text-yellow-400">Jadwal</a>
                        <a href="#klasemen" class="block text-white hover:text-yellow-400">Klasemen</a>
                        <button data-view="user" class="nav-btn block w-full text-left text-white hover:text-yellow-400">Login Peserta</button>
                        <button data-view="admin" class="nav-btn block w-full text-left text-white hover:text-yellow-400">Login Admin</button>
                    </div>
                </nav>

                <div class="pt-32 pb-20 px-4">
                    <div class="max-w-7xl mx-auto text-center">
                        <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 animate-fade-in">
                            Unjuk Kebolehan<br>
                            <span class="text-yellow-400">Seni Bela Diri Nusantara</span>
                        </h1>
                        <p class="text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
                            Platform terpadu untuk pendaftaran dan manajemen lomba silat se-Indonesia
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <button class="px-8 py-4 bg-yellow-400 text-red-900 rounded-lg font-bold text-lg hover:bg-yellow-300 transition transform hover:scale-105">
                                Daftar Lomba Sekarang
                            </button>
                            <button class="px-8 py-4 bg-white bg-opacity-20 text-white rounded-lg font-bold text-lg hover:bg-opacity-30 transition backdrop-blur">
                                Lihat Jadwal
                            </button>
                        </div>
                    </div>
                </div>

                <div class="max-w-7xl mx-auto px-4 pb-20">
                    <h2 class="text-3xl font-bold text-white mb-8 text-center">Lomba Yang Tersedia</h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        ${renderLombaCards()}
                    </div>
                </div>
            </div>
            `;
        }
        
        // Admin Dashboard
        function renderAdminStats() {
            return adminStats.map(stat => `
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">${stat.title}</p>
                            <p class="text-3xl font-bold mt-2">${stat.value}</p>
                        </div>
                        <div class="${stat.color} p-3 rounded-lg">
                            <div class="h-6 w-6 text-white">${icons[stat.icon]}</div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function renderAdminTable() {
            return adminLombaTable.map(lomba => `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">${lomba.nama}</td>
                    <td class="px-6 py-4 text-gray-600">${lomba.tanggal}</td>
                    <td class="px-6 py-4 text-gray-600">${lomba.peserta}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold ${
                            lomba.status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'
                        }">
                            ${lomba.status}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <button class="p-2 text-blue-600 hover:bg-blue-50 rounded"><span class="h-4 w-4">${icons.eye}</span></button>
                            <button class="p-2 text-yellow-600 hover:bg-yellow-50 rounded"><span class="h-4 w-4">${icons.edit}</span></button>
                            <button class="p-2 text-red-600 hover:bg-red-50 rounded"><span class="h-4 w-4">${icons.trash2}</span></button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function AdminDashboard() {
            return `
            <div class="min-h-screen bg-gray-100">
                <nav class="bg-red-900 text-white shadow-lg">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center h-16">
                            <div class="flex items-center">
                                <div class="h-8 w-8 text-yellow-400">${icons.trophy}</div>
                                <span class="ml-2 text-xl font-bold">Admin Dashboard</span>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="h-6 w-6 cursor-pointer hover:text-yellow-400">${icons.bell}</div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center text-red-900 font-bold">A</div>
                                    <span>Admin</span>
                                </div>
                                <button data-view="landing" class="nav-btn flex items-center hover:text-yellow-400">
                                    <span class="h-5 w-5 mr-1">${icons.logOut}</span> Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="flex">
                    <div class="w-64 bg-white h-screen shadow-lg hidden md:block">
                        <div class="p-6 space-y-2">
                            <button class="w-full flex items-center px-4 py-3 bg-red-900 text-white rounded-lg"><span class="h-5 w-5 mr-3">${icons.trophy}</span> Dashboard</button>
                            <button class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg"><span class="h-5 w-5 mr-3">${icons.plus}</span> Lomba Baru</button>
                            <button class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg"><span class="h-5 w-5 mr-3">${icons.users}</span> Peserta</button>
                            <button class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg"><span class="h-5 w-5 mr-3">${icons.calendar}</span> Jadwal</button>
                        </div>
                    </div>

                    <div class="flex-1 p-8">
                        <div class="grid md:grid-cols-4 gap-6 mb-8">${renderAdminStats()}</div>

                        <div class="bg-white rounded-xl shadow">
                            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                                <h2 class="text-xl font-bold">Manajemen Lomba</h2>
                                <button class="px-4 py-2 bg-red-900 text-white rounded-lg hover:bg-red-800 transition flex items-center">
                                    <span class="h-4 w-4 mr-2">${icons.plus}</span> Tambah Lomba
                                </button>
                            </div>
                            <div class="p-6">
                                <div class="flex gap-4 mb-6">
                                    <div class="flex-1 relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400">${icons.search}</span>
                                        <input type="text" placeholder="Cari lomba..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent"/>
                                    </div>
                                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center">
                                        <span class="h-4 w-4 mr-2">${icons.filter}</span> Filter
                                    </button>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Lomba</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peserta</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">${renderAdminTable()}</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
        }

        // User Dashboard
        function renderUserLombaList() {
            return userLombaList.map(lomba => `
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                    <div class="flex flex-col sm:flex-row justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-bold mb-2">${lomba.nama}</h3>
                            <div class="space-y-1 text-sm text-gray-600">
                                <p class="flex items-center"><span class="h-4 w-4 mr-2">${icons.calendar}</span> ${lomba.tanggal}</p>
                                <p class="flex items-center"><span class="h-4 w-4 mr-2">${icons.trophy}</span> ${lomba.lokasi}</p>
                                <p>Kategori: ${lomba.kategori}</p>
                                <p class="text-red-600 font-semibold">Batas Pendaftaran: ${lomba.batas}</p>
                            </div>
                        </div>
                        <button class="mt-4 sm:mt-0 px-6 py-2 bg-red-900 text-white rounded-lg hover:bg-red-800 transition font-semibold">
                            Daftar
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function renderUserJadwalTable() {
            return userJadwalTable.map(jadwal => `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">${jadwal.lomba}</td>
                    <td class="px-6 py-4 text-gray-600">${jadwal.waktu}</td>
                    <td class="px-6 py-4 text-gray-600">${jadwal.kategori}</td>
                    <td class="px-6 py-4 text-gray-600">${jadwal.gelanggang}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                            ${jadwal.status}
                        </span>
                    </td>
                </tr>
            `).join('');
        }


        function UserDashboard() {
            return `
            <div class="min-h-screen bg-gray-100">
                <nav class="bg-white shadow">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center h-16">
                            <div class="flex items-center">
                                <div class="h-8 w-8 text-red-900">${icons.trophy}</div>
                                <span class="ml-2 text-xl font-bold text-red-900">Dashboard Peserta</span>
                            </div>
                            <div class="hidden md:flex items-center space-x-6">
                                <a href="#" class="text-red-900 font-semibold">Lomba</a>
                                <a href="#" class="text-gray-600 hover:text-red-900">Jadwal</a>
                                <a href="#" class="text-gray-600 hover:text-red-900">Klasemen</a>
                                <a href="#" class="text-gray-600 hover:text-red-900">Profil</a>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="h-6 w-6 text-gray-600 cursor-pointer hover:text-red-900">${icons.bell}</div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-10 h-10 bg-red-900 rounded-full flex items-center justify-center text-white font-bold">P</div>
                                    <span class="hidden md:block">Peserta</span>
                                </div>
                                <button data-view="landing" class="nav-btn text-gray-600 hover:text-red-900">
                                    <span class="h-5 w-5">${icons.logOut}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="max-w-7xl mx-auto px-4 py-8">
                    <div class="bg-gradient-to-r from-red-900 to-orange-800 rounded-xl p-8 mb-8 text-white">
                        <h1 class="text-3xl font-bold mb-2">Selamat Datang, Atlet Silat!</h1>
                        <p class="text-gray-200">Kelola pendaftaran lomba dan pantau jadwal pertandingan Anda</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white rounded-xl shadow p-6">
                            <p class="text-gray-500 text-sm mb-2">Lomba Terdaftar</p>
                            <p class="text-4xl font-bold">2</p>
                        </div>
                        <div class="bg-white rounded-xl shadow p-6">
                            <p class="text-gray-500 text-sm mb-2">Pertandingan Akan Datang</p>
                            <p class="text-4xl font-bold">3</p>
                        </div>
                        <div class="bg-white rounded-xl shadow p-6">
                            <p class="text-gray-500 text-sm mb-2">Medali</p>
                            <p class="text-4xl font-bold">1</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow mb-8">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-bold">Lomba Tersedia</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">${renderUserLombaList()}</div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-bold">Jadwal Pertandingan Saya</h2>
                        </div>
                        <div class="p-6">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lomba</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal & Waktu</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gelanggang</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">${renderUserJadwalTable()}</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
        }

        // --- EVENT LISTENERS & ROUTING ---
        
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

        function attachCommonListeners() {
            // Attach listeners to any button with 'nav-btn' class
            document.querySelectorAll('.nav-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const view = button.getAttribute('data-view');
                    if (view) {
                        setView(view);
                    }
                });
            });
        }

        function updateDemoNavUI() {
            document.querySelectorAll('#demo-nav .demo-btn').forEach(btn => {
                if(btn.getAttribute('data-view') === currentView) {
                    btn.classList.add('bg-red-900', 'text-white');
                    btn.classList.remove('bg-gray-100', 'hover:bg-gray-200');
                } else {
                    btn.classList.remove('bg-red-900', 'text-white');
                    btn.classList.add('bg-gray-100', 'hover:bg-gray-200');
                }
            });
        }

        function setView(viewName) {
            currentView = viewName;
            
            // Render the view
            if (viewName === 'landing') {
                app.innerHTML = LandingPage();
                attachLandingPageListeners();
            } else if (viewName === 'admin') {
                app.innerHTML = AdminDashboard();
            } else if (viewName === 'user') {
                app.innerHTML = UserDashboard();
            }

            // Attach listeners common to all views (like nav buttons)
            attachCommonListeners();
            
            // Update the demo navigation UI
            updateDemoNavUI();

            // Scroll to top on view change
            window.scrollTo(0, 0);
        }

        // Initial load
        document.addEventListener('DOMContentLoaded', () => {
            // Attach listeners for the demo navigation itself
            document.querySelectorAll('#demo-nav .demo-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const view = button.getAttribute('data-view');
                    setView(view);
                });
            });
            
            // Set the initial view
            setView('landing');
        });

    </script>
</body>
</html>