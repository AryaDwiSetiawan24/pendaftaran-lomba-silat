<x-peserta-layout>
    <!-- Header -->
    <div class="bg-gradient-to-r from-red-900 to-orange-800 rounded-xl p-6 sm:p-8 mb-8 text-white shadow-lg"
        id="home">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h1>
                <p class="text-gray-200 text-sm sm:text-base">Kelola pendaftaran lomba dan pantau jadwal pertandingan
                    Anda</p>
            </div>
            <div class="hidden sm:block">
                <i class="uil uil-user-circle text-6xl text-white opacity-20"></i>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-6 mb-8">
        <!-- Total Pendaftaran -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-4 sm:p-6">
            <div class="flex items-center justify-between mb-2">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="uil uil-users-alt text-2xl text-blue-600"></i>
                </div>
            </div>
            <p class="text-gray-500 text-xs sm:text-sm mb-1">Total Pendaftaran</p>
            <p class="text-2xl sm:text-4xl font-bold text-gray-800">{{ $totalParticipants }}</p>
        </div>

        <!-- Lomba Diikuti -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-4 sm:p-6">
            <div class="flex items-center justify-between mb-2">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="uil uil-trophy text-2xl text-purple-600"></i>
                </div>
            </div>
            <p class="text-gray-500 text-xs sm:text-sm mb-1">Lomba Diikuti</p>
            <p class="text-2xl sm:text-4xl font-bold text-gray-800">{{ $totalCompetitions }}</p>
        </div>

        <!-- Disetujui -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-4 sm:p-6">
            <div class="flex items-center justify-between mb-2">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="uil uil-check-circle text-2xl text-green-600"></i>
                </div>
            </div>
            <p class="text-gray-500 text-xs sm:text-sm mb-1">Disetujui</p>
            <p class="text-2xl sm:text-4xl font-bold text-green-600">{{ $approvedCount }}</p>
        </div>

        <!-- Menunggu -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-4 sm:p-6">
            <div class="flex items-center justify-between mb-2">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="uil uil-clock text-2xl text-yellow-600"></i>
                </div>
            </div>
            <p class="text-gray-500 text-xs sm:text-sm mb-1">Menunggu</p>
            <p class="text-2xl sm:text-4xl font-bold text-yellow-600">{{ $pendingCount }}</p>
        </div>

        <!-- Ditolak -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-4 sm:p-6">
            <div class="flex items-center justify-between mb-2">
                <div class="p-2 bg-red-100 rounded-lg">
                    <i class="uil uil-times-circle text-2xl text-red-600"></i>
                </div>
            </div>
            <p class="text-gray-500 text-xs sm:text-sm mb-1">Ditolak</p>
            <p class="text-2xl sm:text-4xl font-bold text-red-600">{{ $rejectedCount }}</p>
        </div>
    </div>

    <!-- Tombol Manajemen Pendaftaran -->
    <div class="flex justify-end mb-8">
        <a href="{{ route('peserta.pendaftaran.index') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-red-900 text-white rounded-lg hover:bg-red-800 hover:shadow-lg transition-all duration-200 font-semibold">
            <i class="uil uil-chart"></i>
            <span class="hidden sm:inline">Manajemen Pendaftaran</span>
            <span class="sm:hidden">Kelola Pendaftaran</span>
        </a>
    </div>

    <!-- Lomba Tersedia -->
    <div class="bg-white rounded-xl shadow-md" id="lomba-tersedia">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <i class="uil uil-trophy text-red-900"></i>
                Lomba Tersedia
            </h2>
            <p class="text-sm text-gray-500 mt-1">Daftar lomba yang sedang dibuka</p>
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
                                            {{ $competition->competition_date ? $competition->competition_date->format('d M Y') : 'Belum dijadwalkan' }}
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
                                class="flex-1 sm:flex-none px-5 py-2.5 bg-white border-2 border-red-900 text-red-900 rounded-lg hover:bg-red-50 transition-all duration-200 font-semibold text-center text-sm sm:text-base whitespace-nowrap">
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

                    <!-- Status Badge -->
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
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                Pendaftaran Dibuka
                            </span>
                        @elseif ($isComing)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                <i class="uil uil-clock-three mr-1"></i>
                                Akan Dibuka
                            </span>
                        @elseif ($isClosed)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 border border-gray-200">
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

            <!-- Pagination Lomba -->
            @if ($competitions->hasPages())
                <div class="mt-6 pt-4 border-t border-gray-200">
                    {{ $competitions->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Jadwal Pertandingan Saya -->
    {{-- <div class="bg-white rounded-xl shadow-md mt-8" id="jadwal-pertandingan">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="uil uil-calendar-alt text-red-900"></i>
                    Jadwal Pertandingan Saya
                </h2>
                <p class="text-sm text-gray-500 mt-1">Pertandingan yang akan datang</p>
            </div>
        </div>

        <div class="p-6">
            @forelse ($schedules as $schedule)
                @php
                    // Cek apakah user adalah participant1 atau participant2
                    $isUserParticipant1 = $schedule->participant1 && $schedule->participant1->user_id == auth()->id();
                    $isUserParticipant2 = $schedule->participant2 && $schedule->participant2->user_id == auth()->id();

                    // Cek status kemenangan
                    $isParticipant1Winner = $schedule->winner_id == $schedule->participant1_id;
                    $isParticipant2Winner = $schedule->winner_id == $schedule->participant2_id;
                    $isMatchFinished = $schedule->winner_id != null;

                    // Hitung waktu countdown
                    $daysUntil = round(now()->diffInDays($schedule->match_time, false));
                    $hoursUntil = now()->diffInHours($schedule->match_time, false);
                @endphp

                <div
                    class="border-2 border-gray-200 rounded-xl hover:border-red-300 hover:shadow-lg transition-all duration-300 overflow-hidden mb-6 last:mb-0">
                    <div class="p-6">
                        <!-- Match Header Info -->
                        <div class="flex flex-wrap items-center gap-3 mb-6">
                            <span
                                class="px-4 py-1.5 bg-gradient-to-r from-red-600 to-red-700 text-white text-xs md:text-sm font-bold rounded-full shadow-md">
                                <i class="uil uil-location-point mr-1"></i>
                                {{ $schedule->participant1->category ?? '-' }}
                            </span>
                            <span class="px-4 py-1.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-full">
                                <i class="uil uil-clock mr-1"></i>
                                {{ \Carbon\Carbon::parse($schedule->match_time)->format('d M Y, H:i') }} WIB
                            </span>
                            <span class="px-4 py-1.5 bg-blue-50 text-blue-700 text-sm font-semibold rounded-full">
                                <i class="uil uil-trophy mr-1"></i>
                                {{ $schedule->competition->name ?? '-' }}
                            </span>
                            @if ($schedule->round)
                                <span
                                    class="px-4 py-1.5 bg-purple-50 text-purple-700 text-sm font-semibold rounded-full">
                                    <i class="uil uil-layer-group mr-1"></i>
                                    Ronde {{ $schedule->round }}
                                </span>
                            @endif
                        </div>

                        <div class="flex flex-col lg:flex-row items-center gap-6">
                            <!-- Participant 1 (Kiri - Biru) -->
                            <div class="flex-1 w-full">
                                <div
                                    class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-5 {{ $isParticipant1Winner ? 'ring-4 ring-green-500 shadow-lg' : '' }} transition-all duration-300">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                                {{ strtoupper(substr($schedule->participant1->full_name ?? 'TBD', 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2 mb-1">
                                                    <p class="font-bold text-gray-900 text-lg">
                                                        {{ $schedule->participant1->full_name ?? 'TBD' }}
                                                    </p>
                                                    @if ($isUserParticipant1)
                                                        <span
                                                            class="px-2 py-0.5 bg-blue-600 text-white text-xs font-bold rounded animate-pulse">
                                                            ANDA
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-gray-600 font-semibold">
                                                    <i class="uil uil-weight"></i>
                                                    {{ $schedule->participant1->weight_class ?? '-' }}
                                                </p>
                                                @if ($schedule->participant1 && $schedule->participant1->kontingen)
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        <i class="uil uil-users-alt"></i>
                                                        {{ $schedule->participant1->kontingen }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($isParticipant1Winner)
                                            <div class="flex items-center gap-2">
                                                <i class="uil uil-trophy text-yellow-500 text-3xl animate-pulse"></i>
                                                <span
                                                    class="px-3 py-1 hidden md:block bg-green-500 text-white text-xs font-bold rounded-full">
                                                    PEMENANG
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- VS Badge -->
                            <div class="shrink-0">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-red-900 to-red-700 rounded-2xl flex items-center justify-center shadow-xl transform hover:scale-110 transition-transform duration-300">
                                    <span class="text-white font-black text-lg">VS</span>
                                </div>
                            </div>

                            <!-- Participant 2 (Kanan - Merah) -->
                            <div class="flex-1 w-full">
                                <div
                                    class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-5 {{ $isParticipant2Winner ? 'ring-4 ring-green-500 shadow-lg' : '' }} transition-all duration-300">
                                    <div class="flex items-center justify-between">
                                        @if ($isParticipant2Winner)
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">
                                                    PEMENANG
                                                </span>
                                                <i class="uil uil-trophy text-yellow-500 text-3xl animate-pulse"></i>
                                            </div>
                                        @endif
                                        <div class="flex items-center gap-4 ml-auto">
                                            <div class="text-right">
                                                <div class="flex items-center justify-end gap-2 mb-1">
                                                    @if ($isUserParticipant2)
                                                        <span
                                                            class="px-2 py-0.5 bg-red-600 text-white text-xs font-bold rounded animate-pulse">
                                                            ANDA
                                                        </span>
                                                    @endif
                                                    <p class="font-bold text-gray-900 text-lg">
                                                        {{ $schedule->participant2->full_name ?? 'TBD' }}
                                                    </p>
                                                </div>
                                                <p class="text-sm text-gray-600 font-semibold">
                                                    <i class="uil uil-weight"></i>
                                                    {{ $schedule->participant2->weight_class ?? '-' }}
                                                </p>
                                                @if ($schedule->participant2 && $schedule->participant2->kontingen)
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        <i class="uil uil-users-alt"></i>
                                                        {{ $schedule->participant2->kontingen }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div
                                                class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-700 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                                {{ strtoupper(substr($schedule->participant2->full_name ?? 'TBD', 0, 2)) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Countdown -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <!-- Status Match -->
                                <div>
                                    @if ($isMatchFinished)
                                        <div
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-100 to-green-200 text-green-800 rounded-lg font-bold shadow-sm">
                                            <i class="uil uil-check-circle mr-2 text-xl"></i>
                                            Pertandingan Selesai
                                        </div>
                                    @else
                                        <div
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-100 to-orange-200 text-orange-800 rounded-lg font-bold shadow-sm">
                                            <i class="uil uil-hourglass mr-2 text-xl"></i>
                                            Menunggu Pertandingan
                                        </div>
                                    @endif
                                </div>

                                <!-- Countdown -->
                                @if (!$isMatchFinished && $daysUntil >= 0)
                                    <div
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 border-2 border-blue-200 rounded-lg">
                                        <i class="uil uil-clock-three text-blue-600 text-xl"></i>
                                        <div class="text-sm">
                                            @if ($daysUntil == 0 && $hoursUntil > 0)
                                                <span class="font-bold text-red-600">Hari ini!</span>
                                                <span class="text-gray-600 ml-1">({{ $hoursUntil }} jam lagi)</span>
                                            @elseif($daysUntil == 0 && $hoursUntil <= 0)
                                                <span class="font-bold text-red-600 animate-pulse">Sedang
                                                    Berlangsung!</span>
                                            @elseif($daysUntil == 1)
                                                <span class="font-bold text-orange-600">Besok</span>
                                            @else
                                                <span class="font-bold text-blue-600">{{ $daysUntil }} hari
                                                    lagi</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Logo Competition -->
                        @if ($schedule->competition && $schedule->competition->competition_logo)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $schedule->competition->competition_logo) }}"
                                        alt="Logo {{ $schedule->competition->name }}"
                                        class="h-12 w-12 object-contain rounded-lg border-2 border-gray-200 bg-white p-1.5">
                                    <div class="text-sm text-gray-600">
                                        <p class="font-semibold text-gray-800">{{ $schedule->competition->name }}</p>
                                        <p class="text-xs">
                                            {{ \Carbon\Carbon::parse($schedule->competition->competition_date)->format('d F Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full mb-4">
                        <i class="uil uil-calendar-slash text-4xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 text-lg font-semibold">Belum ada jadwal pertandingan</p>
                    <p class="text-gray-400 text-sm mt-2">Fitur masih dalam pengembangan.</p>
                </div>
            @endforelse

            <!-- Pagination -->
            @if ($schedules->hasPages())
                <div class="mt-8 pt-6 border-t border-gray-200">
                    {{ $schedules->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div> --}}

    <!-- Tombol WhatsApp -->
    <a href="https://wa.me/6285172455192" target="_blank"
        class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-lg h-16 w-16 flex items-center justify-center transition transform hover:scale-110 z-50 group"
        title="Hubungi via WhatsApp">
        <i class="uil uil-whatsapp text-3xl pb-1.5"></i>
        <span
            class="absolute right-16 bg-gray-800 text-white text-xs px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
            Butuh Bantuan?
        </span>
    </a>
</x-peserta-layout>
