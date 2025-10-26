{{-- <x-peserta-layout>
    <div class="max-w-7xl mx-auto px-4 py-8 pt-20">
        <div class="bg-gradient-to-r from-red-900 to-orange-800 rounded-xl p-8 mb-8 text-white">
            <h1 class="text-3xl font-bold mb-2">Selamat Datang, Atlet Silat!</h1>
            <p class="text-gray-200">Kelola pendaftaran lomba dan pantau jadwal pertandingan Anda</p>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-gray-500 text-sm mb-2">Lomba Terdaftar</p>
                <p class="text-4xl font-bold">2</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-gray-500 text-sm mb-2">Pertandingan Akan Datang</p>
                <p class="text-4xl font-bold">3</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow mb-8" id="lomba-tersedia">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold">Lomba Tersedia</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <!-- lomba list -->
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                        <div class="flex flex-col sm:flex-row justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold mb-2">Lomba silat</h3>
                                <div class="space-y-1 text-sm text-gray-600">
                                    <p class="flex items-center"><span class="h-4 w-4 mr-2"><i
                                                class="uil uil-calendar"></i></span>
                                        ${lomba.tanggal}</p>
                                    <p class="flex items-center"><span class="h-4 w-4 mr-2"><i
                                                class="uil uil-location-arrow"></i></span>
                                        ${lomba.lokasi}</p>
                                    <p>Kategori: ${lomba.kategori}</p>
                                    <p class="text-red-600 font-semibold">Batas Pendaftaran: ${lomba.batas}</p>
                                </div>
                            </div>
                            <button
                                class="mt-4 sm:mt-0 px-6 py-2 bg-red-900 text-white rounded-lg hover:bg-red-800 transition font-semibold">
                                Daftar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow" id="jadwal-pertandingan">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold">Jadwal Pertandingan Saya</h2>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lomba
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                    &
                                    Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Gelanggang
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <!-- jadwal tabel -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium">${jadwal.lomba}</td>
                                <td class="px-6 py-4 text-gray-600">${jadwal.waktu}</td>
                                <td class="px-6 py-4 text-gray-600">${jadwal.kategori}</td>
                                <td class="px-6 py-4 text-gray-600">${jadwal.gelanggang}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                        ${jadwal.status}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tombol WhatsApp Mengambang -->
        <a href="https://wa.me/6282233445566" target="_blank"
            class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-lg p-4 flex items-center justify-center transition transform hover:scale-110 z-50"
            title="Hubungi via WhatsApp">
            <i class="flex uil uil-whatsapp text-3xl"></i>
        </a>

    </div>
</x-peserta-layout> --}}

<x-peserta-layout>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    <!-- Header -->
    <div class="bg-gradient-to-r from-red-900 to-orange-800 rounded-xl p-8 mb-8 text-white" id="home">
        <h1 class="text-3xl font-bold mb-2">
            Selamat Datang, {{ Auth::user()->name }}!
        </h1>
        <p class="text-gray-200">Kelola pendaftaran lomba dan pantau jadwal pertandingan Anda</p>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500 text-sm mb-2">Peserta Terdaftar</p>
            <p class="text-4xl font-bold">{{ $myCompetitions->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500 text-sm mb-2">Lomba Terdaftar</p>
            <p class="text-4xl font-bold">{{ $registeredCompetitions }}</p>
        </div>
        {{-- <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500 text-sm mb-2">Pertandingan Akan Datang</p>
            <p class="text-4xl font-bold"></p>
        </div> --}}
    </div>

    <!-- Tombol Manajemen Pendaftaran -->
    <div class="item-right text-end mb-8">
            <a href="{{ route('peserta.pendaftaran.index') }}"
                class="flex-1 sm:flex-none px-5 py-2.5 bg-red-900 text-white rounded-lg hover:bg-red-800 hover:shadow-md transition-all duration-200 font-semibold text-center text-sm sm:text-base whitespace-nowrap">
                <i class="uil uil-chart mr-1"></i>
                Manajemen Pendaftaran
            </a>
    </div>


    <!-- Lomba Tersedia -->
    <div class="bg-white rounded-xl shadow mb-8" id="lomba-tersedia">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Lomba Tersedia</h2>
        </div>
        <div class="p-4 sm:p-6">
            @forelse ($competitions as $competition)
                <div
                    class="border border-gray-200 rounded-lg p-4 sm:p-6 hover:shadow-lg hover:border-red-200 transition-all duration-300 mb-4 last:mb-0">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <!-- Logo dan Info Lomba -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 flex-1">
                            @if ($competition->competition_logo)
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . $competition->competition_logo) }}"
                                        alt="Logo {{ $competition->name }}"
                                        class="h-16 w-16 sm:h-20 sm:w-20 object-contain rounded-lg border-2 border-gray-100 bg-gray-50 p-2">
                                </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg sm:text-xl font-bold mb-2 text-red-900 line-clamp-2">
                                    {{ $competition->name }}
                                </h3>
                                <div class="space-y-2">
                                    <div class="flex items-start text-sm text-gray-700">
                                        <i class="uil uil-calendar text-red-900 mr-2 mt-0.5 flex-shrink-0"></i>
                                        <span class="font-medium">
                                            {{ $competition->competition_date ? $competition->competition_date->format('d M Y, H:i') : 'Belum dijadwalkan' }}
                                        </span>
                                    </div>
                                    <div class="flex items-start text-sm text-gray-600">
                                        <i class="uil uil-clock text-red-900 mr-2 mt-0.5 flex-shrink-0"></i>
                                        <span>
                                            <span class="font-medium">Pendaftaran:</span>
                                            {{ $competition->registration_start_date->format('d M Y') }} –
                                            {{ $competition->registration_end_date->format('d M Y') }}
                                        </span>
                                    </div>
                                    @if ($competition->location)
                                        <div class="flex items-start text-sm text-gray-600">
                                            <i class="uil uil-map-marker text-red-900 mr-2 mt-0.5 flex-shrink-0"></i>
                                            <span>{{ $competition->location }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div
                            class="flex flex-col sm:flex-row gap-3 lg:flex-col xl:flex-row lg:min-w-[140px] xl:min-w-[280px]">
                            <a href="{{ route('peserta.lomba.show', $competition->id) }}"
                                class="flex-1 sm:flex-none px-5 py-2.5 bg-white border-2 border-red-900 text-red-900 rounded-lg hover:bg-red-100 transition-all duration-200 font-semibold text-center text-sm sm:text-base whitespace-nowrap">
                                <i class="uil uil-info-circle mr-1"></i>
                                Lihat Detail
                            </a>
                            <a href="{{ route('peserta.lomba.daftar', $competition->id) }}"
                                class="flex-1 sm:flex-none px-5 py-2.5 bg-red-900 text-white rounded-lg hover:bg-red-800 hover:shadow-md transition-all duration-200 font-semibold text-center text-sm sm:text-base whitespace-nowrap">
                                <i class="uil uil-check-circle mr-1"></i>
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>

                    <!-- Status Badge (Optional) -->
                    @php
                        $now = now();
                        $isOpen = $now->between(
                            $competition->registration_start_date,
                            $competition->registration_end_date,
                        );
                        $isComing = $now->lt($competition->registration_start_date);
                        $isClosed = $now->gt($competition->registration_end_date);
                    @endphp

                    <div class="mt-4 pt-4 border-t border-gray-100">
                        @if ($isOpen)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                Pendaftaran Dibuka
                            </span>
                        @elseif ($isComing)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                <i class="uil uil-clock-three mr-1"></i>
                                Akan Dibuka
                            </span>
                        @elseif ($isClosed)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                <i class="uil uil-lock mr-1"></i>
                                Pendaftaran Ditutup
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                        <i class="uil uil-trophy text-3xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 text-lg">Belum ada lomba yang tersedia untuk pendaftaran.</p>
                    <p class="text-gray-400 text-sm mt-2">Silakan cek kembali nanti</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Placeholder Jadwal (abaikan dulu) -->
    <div class="bg-white rounded-xl shadow" id="jadwal-pertandingan">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold">Jadwal Pertandingan Saya</h2>
        </div>
        <div class="p-6">
            <p class="text-gray-500 text-center">Fitur jadwal akan segera tersedia.</p>
        </div>
    </div>

    {{-- Tombol WhatsApp --}}
    <a href="https://wa.me/6282233445566" target="_blank"
        class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-lg p-4 flex items-center justify-center transition transform hover:scale-110 z-50"
        title="Hubungi via WhatsApp">
        <i class="flex uil uil-whatsapp text-3xl"></i>
    </a>
</x-peserta-layout>
