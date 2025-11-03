<x-admin-layout>
    <!-- Breadcrumb -->
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-red-900 transition">Dashboard</a>
            <i class="uil uil-angle-right mx-2"></i>
            <a href="{{ route('admin.jadwal.index') }}" class="hover:text-red-900 transition">Jadwal Pertandingan</a>
            <i class="uil uil-angle-right mx-2"></i>
            <span class="text-red-900 font-semibold">{{ $competition->name ?? 'Detail Jadwal' }}</span>
        </div>
    </div>

    <!-- Header -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-red-900 to-red-800 rounded-2xl shadow-xl p-8 text-white">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <i class="uil uil-trophy text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold">{{ $competition->name ?? '-' }}</h1>
                            <p class="text-red-100 mt-1">Kelola jadwal dan hasil pertandingan</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <form action="{{ route('admin.jadwal.generateMatches', $competition->id) }}" method="POST"
                        onsubmit="return confirm('Buat ulang jadwal pertandingan? Jadwal lama akan dihapus!')"
                        class="inline">
                        @csrf
                        <button type="submit"
                            class="px-5 py-3 bg-white text-red-900 rounded-xl hover:bg-red-50 transition-all duration-200 font-semibold text-sm inline-flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="uil uil-robot mr-2"></i> Generate Otomatis
                        </button>
                    </form>

                    <a href="{{ route('admin.jadwal.pool', $competition->id) }}"
                        class="px-5 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-200 font-semibold text-sm inline-flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="uil uil-sitemap mr-2"></i>
                        Kelola Grup
                    </a>

                    <a href="{{ route('admin.jadwal.export.excel', $competition->id) }}"
                        class="px-5 py-3 bg-white/20 backdrop-blur-sm text-white rounded-xl hover:bg-white/30 transition-all duration-200 font-semibold text-sm inline-flex items-center hover:-translate-y-0.5">
                        <i class="uil uil-download-alt mr-2"></i>
                        Export Jadwal
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div
            class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold mb-1">Total Pertandingan</p>
                    <p class="text-4xl font-bold text-gray-900">{{ $totalMatches ?? 0 }}</p>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="uil uil-calendar-alt text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold mb-1">Hari Ini</p>
                    <p class="text-4xl font-bold text-orange-600">{{ $todayMatches ?? 0 }}</p>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="uil uil-clock-three text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold mb-1">Selesai</p>
                    <p class="text-4xl font-bold text-green-600">{{ $completedMatches ?? 0 }}</p>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="uil uil-check-circle text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold mb-1">Belum Selesai</p>
                    <p class="text-4xl font-bold text-red-600">{{ $pendingMatches ?? 0 }}</p>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="uil uil-hourglass text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="border-b border-gray-200 px-4 sm:px-6 py-4">
            <h3 class="font-semibold text-gray-800 flex items-center">
                <i class="uil uil-filter text-red-700 mr-2"></i>
                Filter Pertandingan
            </h3>
        </div>
        <div class="p-4 sm:p-6">
            <form method="GET" action="{{ route('admin.jadwal.view', $competition->id) }}">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">

                    {{-- 🔍 Pencarian --}}
                    <div class="sm:col-span-2 lg:col-span-3 xl:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">
                            Pencarian
                        </label>
                        <div class="relative">
                            <i class="uil uil-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Nama / NIK / Kontingen"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg 
                           focus:ring-2 focus:ring-red-500 focus:border-transparent transition text-sm" />
                        </div>
                    </div>

                    {{-- 🧩 Kategori --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">
                            Kategori
                        </label>
                        <select name="category"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-white
                       focus:ring-2 focus:ring-red-500 focus:border-transparent transition text-sm">
                            <option value="">Semua</option>
                            <option value="USIA DINI (SD)"
                                {{ request('category') == 'USIA DINI (SD)' ? 'selected' : '' }}>
                                USIA DINI (SD)
                            </option>
                            <option value="PRA REMAJA (SMP)"
                                {{ request('category') == 'PRA REMAJA (SMP)' ? 'selected' : '' }}>
                                PRA REMAJA (SMP)
                            </option>
                            <option value="REMAJA (SMA/K/MA)"
                                {{ request('category') == 'REMAJA (SMA/K/MA)' ? 'selected' : '' }}>
                                REMAJA (SMA/K/MA)
                            </option>
                        </select>
                    </div>

                    {{-- 🔁 Ronde --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">
                            Ronde
                        </label>
                        <select name="round"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-white
                       focus:ring-2 focus:ring-red-500 focus:border-transparent transition text-sm">
                            <option value="">Semua</option>
                            <option value="1" {{ request('round') == '1' ? 'selected' : '' }}>Ronde 1</option>
                            <option value="2" {{ request('round') == '2' ? 'selected' : '' }}>Ronde 2</option>
                            <option value="3" {{ request('round') == '3' ? 'selected' : '' }}>Ronde 3</option>
                            <option value="4" {{ request('round') == '4' ? 'selected' : '' }}>Semi Final</option>
                            <option value="5" {{ request('round') == '5' ? 'selected' : '' }}>Final</option>
                        </select>
                    </div>

                    {{-- 📅 Tanggal --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">
                            Tanggal
                        </label>
                        <input type="date" name="date" value="{{ request('date') }}"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg 
                       focus:ring-2 focus:ring-red-500 focus:border-transparent transition text-sm">
                    </div>

                    {{-- 🏁 Status --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">
                            Status
                        </label>
                        <select name="status"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-white
                       focus:ring-2 focus:ring-red-500 focus:border-transparent transition text-sm">
                            <option value="">Semua</option>
                            <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Selesai
                            </option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai
                            </option>
                        </select>
                    </div>
                </div>

                {{-- 🔘 Tombol Aksi --}}
                <div
                    class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-2.5 bg-red-700 hover:bg-red-800 text-white rounded-lg
                   font-semibold shadow-sm transition-all duration-200">
                        <i class="uil uil-filter mr-2"></i>
                        Terapkan Filter
                    </button>

                    <a href="{{ route('admin.jadwal.view', $competition->id) }}"
                        class="inline-flex items-center justify-center px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg
                   transition-all duration-200 font-semibold">
                        <i class="uil uil-redo mr-2"></i>
                        Reset Filter
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Jadwal per Ronde -->
    @foreach ($schedules->groupBy('round') as $round => $matches)
        <div class="bg-white rounded-2xl shadow-md mb-8 overflow-hidden">
            <!-- Round Header -->
            <div class="bg-gradient-to-r from-red-900 via-red-800 to-orange-700 p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <div
                            class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mr-3">
                            <i class="uil uil-layer-group text-yellow-300"></i>
                        </div>
                        @if ($round == 1)
                            Ronde 1 - Babak Penyisihan
                        @elseif($round == 2)
                            Ronde 2 - Babak 16 Besar
                        @elseif($round == 3)
                            Ronde 3 - Perempat Final
                        @elseif($round == 4)
                            Semi Final
                        @elseif($round == 5)
                            Final
                        @else
                            Ronde {{ $round }}
                        @endif
                    </h2>
                    <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                        <span class="text-white font-bold">{{ count($matches) }} Pertandingan</span>
                    </div>
                </div>
            </div>

            <!-- Matches List -->
            <div class="p-6">
                <div class="space-y-4">
                    @foreach ($matches as $match)
                        <div
                            class="border-2 border-gray-200 rounded-xl hover:border-red-300 hover:shadow-lg transition-all duration-300 overflow-hidden">
                            <div class="p-6">
                                <!-- Match Header Info -->
                                <div class="flex flex-wrap items-center gap-3 mb-6">
                                    <span
                                        class="px-4 py-1.5 bg-gradient-to-r from-red-600 to-red-700 text-white text-sm font-bold rounded-full shadow-md">
                                        <i class="uil uil-location-point mr-1"></i>
                                        {{ $match->participant1->category ?? '-' }}
                                    </span>
                                    <span
                                        class="px-4 py-1.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-full">
                                        <i class="uil uil-clock mr-1"></i>
                                        {{ \Carbon\Carbon::parse($match->match_time)->format('d M Y, H:i') }} WIB
                                    </span>
                                    <span
                                        class="px-4 py-1.5 bg-blue-50 text-blue-700 text-sm font-semibold rounded-full">
                                        <i class="uil uil-trophy mr-1"></i>
                                        {{ $match->competition->name ?? '-' }}
                                    </span>
                                </div>

                                <div class="flex flex-col lg:flex-row items-center gap-6">
                                    <!-- Participant 1 -->
                                    <div class="flex-1 w-full">
                                        <div
                                            class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-5 {{ $match->winner_id == $match->participant1_id ? 'ring-4 ring-green-500 shadow-lg' : '' }} transition-all duration-300">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-4">
                                                    <div
                                                        class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                                        {{ strtoupper(substr($match->participant1->full_name ?? 'TBD', 0, 2)) }}
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-gray-900 text-lg">
                                                            {{ $match->participant1->full_name ?? 'TBD' }}
                                                        </p>
                                                        <p class="text-sm text-gray-600 font-semibold">
                                                            <i class="uil uil-weight"></i>
                                                            {{ $match->participant1->weight_class ?? '-' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                @if ($match->winner_id == $match->participant1_id)
                                                    <div class="flex items-center gap-2">
                                                        <i
                                                            class="uil uil-trophy text-yellow-500 text-3xl animate-pulse"></i>
                                                        <span
                                                            class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">PEMENANG</span>
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

                                    <!-- Participant 2 -->
                                    <div class="flex-1 w-full">
                                        <div
                                            class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-5 {{ $match->winner_id == $match->participant2_id ? 'ring-4 ring-green-500 shadow-lg' : '' }} transition-all duration-300">
                                            <div class="flex items-center justify-between">
                                                @if ($match->winner_id == $match->participant2_id)
                                                    <div class="flex items-center gap-2">
                                                        <span
                                                            class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">PEMENANG</span>
                                                        <i
                                                            class="uil uil-trophy text-yellow-500 text-3xl animate-pulse"></i>
                                                    </div>
                                                @endif
                                                <div class="flex items-center gap-4 ml-auto">
                                                    <div class="text-right">
                                                        <p class="font-bold text-gray-900 text-lg">
                                                            {{ $match->participant2->full_name ?? 'TBD' }}
                                                        </p>
                                                        <p class="text-sm text-gray-600 font-semibold">
                                                            <i class="uil uil-weight"></i>
                                                            {{ $match->participant2->weight_class ?? '-' }}
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-700 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                                        {{ strtoupper(substr($match->participant2->full_name ?? 'TBD', 0, 2)) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="mt-6 flex flex-wrap gap-3">
                                    @if (!$match->winner_id)
                                        <button onclick="openWinnerModal({{ $match->id }})"
                                            class="flex-1 min-w-[200px] px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-bold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 inline-flex items-center justify-center">
                                            <i class="uil uil-trophy mr-2 text-lg"></i>
                                            Tentukan Pemenang
                                        </button>
                                    @else
                                        <div
                                            class="flex-1 min-w-[200px] px-6 py-3 bg-gradient-to-r from-green-100 to-green-200 text-green-800 rounded-xl font-bold text-center shadow-md">
                                            <i class="uil uil-check-circle mr-2"></i>
                                            Pertandingan Selesai
                                        </div>
                                    @endif

                                    <button onclick="editSchedule({{ $match->id }})"
                                        class="px-6 py-3 border-2 border-blue-600 text-blue-600 rounded-xl hover:bg-blue-50 transition-all duration-200 font-semibold shadow-sm hover:shadow-md"
                                        title="Edit Jadwal">
                                        <i class="uil uil-edit mr-2"></i>
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.jadwal.destroy', $match->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-6 py-3 border-2 border-red-600 text-red-600 rounded-xl hover:bg-red-50 transition-all duration-200 font-semibold shadow-sm hover:shadow-md"
                                            onclick="return confirm('Hapus jadwal pertandingan ini?')" title="Hapus">
                                            <i class="uil uil-trash-alt mr-2"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $schedules->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    @endforeach

    <!-- Empty State -->
    @if (empty($schedulesByRound) || count($schedulesByRound) == 0)
        <div class="bg-white rounded-2xl shadow-md p-16 text-center">
            <div class="w-32 h-32 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                <i class="uil uil-calendar-slash text-6xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum Ada Jadwal Pertandingan</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                Mulai buat jadwal pertandingan dengan mengklik tombol di bawah ini. Sistem akan secara otomatis mengatur
                pertandingan.
            </p>
            <form action="{{ route('admin.jadwal.generateMatches', $competition->id) }}" method="POST"
                class="inline">
                @csrf
                <button type="submit"
                    class="px-8 py-4 bg-gradient-to-r from-red-900 to-red-800 text-white rounded-xl hover:from-red-800 hover:to-red-700 transition-all duration-200 font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-1 inline-flex items-center">
                    <i class="uil uil-robot mr-3 text-xl"></i>
                    Generate Jadwal Otomatis
                </button>
            </form>
        </div>
    @endif

    <!-- Edit Schedule Modal -->
    <div id="scheduleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full">
            <div
                class="bg-gradient-to-r from-red-900 to-orange-800 p-5 rounded-t-xl flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">
                    <i class="uil uil-calendar-alt text-yellow-400 text-2xl mr-2"></i>
                    Edit Jadwal Pertandingan
                </h3>
                <button onclick="closeScheduleModal()" class="text-white hover:text-gray-200">
                    <i class="uil uil-times text-2xl"></i>
                </button>
            </div>

            <form id="scheduleForm" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="PUT">

                <div class="space-y-4">
                    <!-- Peserta -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <p class="text-sm font-semibold text-gray-700 mb-1">Peserta 1</p>
                        <p id="participant1_name" class="font-bold text-gray-900"></p>

                        <p class="text-sm font-semibold text-gray-700 mt-3 mb-1">Peserta 2</p>
                        <p id="participant2_name" class="font-bold text-gray-900"></p>
                    </div>

                    <!-- Waktu -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Waktu Pertandingan
                        </label>
                        <input type="datetime-local" name="match_time" id="match_time"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent"
                            required>
                    </div>

                    <!-- Winner -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pemenang</label>
                        <select name="winner_id" id="winner_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-700 focus:border-transparent bg-white">
                            <option value="">Belum ada pemenang</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Kamu bisa mengosongkan pemenang untuk membatalkan status
                            pertandingan selesai.</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                    <button type="button" onclick="closeScheduleModal()"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-3 bg-red-900 text-white rounded-lg hover:bg-red-800 transition font-semibold">
                        <i class="uil uil-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Winner Modal -->
    <div id="winnerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
            <div class="bg-gradient-to-r from-green-600 to-green-700 p-6 rounded-t-xl">
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <i class="uil uil-trophy text-yellow-300 text-3xl mr-3"></i>
                        Set Pemenang
                    </h3>
                    <button onclick="closeWinnerModal()" class="text-white hover:text-gray-200 transition">
                        <i class="uil uil-times text-3xl"></i>
                    </button>
                </div>
            </div>

            <form id="winnerForm" method="POST" class="p-6">
                @csrf
                @method('PATCH')

                <p class="text-gray-600 mb-4">Pilih pemenang dari pertandingan ini:</p>

                <div id="winnerOptions" class="space-y-3">
                    <!-- Options will be loaded dynamically -->
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                    <button type="button" onclick="closeWinnerModal()"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                        <i class="uil uil-check mr-2"></i>
                        Simpan Pemenang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Schedule Modal functions
        function openAddModal() {
            document.getElementById('scheduleModal').classList.remove('hidden');
            document.getElementById('scheduleModal').classList.add('flex');
            document.getElementById('modalTitle').textContent = 'Tambah Jadwal Pertandingan';
            document.getElementById('scheduleForm').reset();
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('scheduleForm').action = "{{ route('admin.jadwal.store') }}";
        }

        function closeScheduleModal() {
            document.getElementById('scheduleModal').classList.add('hidden');
            document.getElementById('scheduleModal').classList.remove('flex');
        }

        function editSchedule(id) {
            fetch(`/admin/jadwal/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('scheduleForm').action = `/admin/jadwal/${id}`;
                    document.getElementById('match_time').value = data.match_time;

                    // Tampilkan nama peserta
                    document.getElementById('participant1_name').textContent = data.participant1?.full_name || '-';
                    document.getElementById('participant2_name').textContent = data.participant2?.full_name || '-';

                    // Isi opsi pemenang
                    const winnerSelect = document.getElementById('winner_id');
                    winnerSelect.innerHTML = `
                <option value="">Belum ada pemenang</option>
                <option value="${data.participant1?.id}" ${data.winner_id === data.participant1?.id ? 'selected' : ''}>
                    ${data.participant1?.full_name || '-'}
                </option>
                <option value="${data.participant2?.id}" ${data.winner_id === data.participant2?.id ? 'selected' : ''}>
                    ${data.participant2?.full_name || '-'}
                </option>
            `;

                    // Buka modal
                    document.getElementById('scheduleModal').classList.remove('hidden');
                    document.getElementById('scheduleModal').classList.add('flex');
                });
        }

        // Load participants based on competition
        function loadParticipants(competitionId, p1 = null, p2 = null) {
            if (!competitionId) return;

            fetch(`/admin/jadwal/participants/${competitionId}`)
                .then(response => response.json())
                .then(data => {
                    const p1Select = document.getElementById('participant1_id');
                    const p2Select = document.getElementById('participant2_id');

                    p1Select.innerHTML = '<option value="">Pilih Peserta</option>';
                    p2Select.innerHTML = '<option value="">Pilih Peserta</option>';

                    data.forEach(participant => {
                        p1Select.innerHTML +=
                            `<option value="${participant.id}" ${p1 == participant.id ? 'selected' : ''}>${participant.full_name} - ${participant.weight_class}</option>`;
                        p2Select.innerHTML +=
                            `<option value="${participant.id}" ${p2 == participant.id ? 'selected' : ''}>${participant.full_name} - ${participant.weight_class}</option>`;
                    });
                });
        }

        // Winner Modal functions
        function openWinnerModal(matchId) {
            fetch(`/admin/jadwal/${matchId}/details`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('winnerForm').action = `/admin/jadwal/${matchId}/winner`;

                    const options = `
                    <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-red-900 hover:bg-red-50 transition">
                        <input type="radio" name="winner_id" value="${data.participant1.id}" class="w-5 h-5 text-red-900" required>
                        <div class="ml-4 flex items-center flex-1">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                ${data.participant1.full_name.substring(0, 2).toUpperCase()}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">${data.participant1.full_name}</p>
                                <p class="text-sm text-gray-500">${data.participant1.weight_class} - ${data.participant1.category}</p>
                            </div>
                        </div>
                    </label>
                    
                    <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-red-900 hover:bg-red-50 transition">
                        <input type="radio" name="winner_id" value="${data.participant2.id}" class="w-5 h-5 text-red-900" required>
                        <div class="ml-4 flex items-center flex-1">
                            <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                ${data.participant2.full_name.substring(0, 2).toUpperCase()}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">${data.participant2.full_name}</p>
                                <p class="text-sm text-gray-500">${data.participant2.weight_class} - ${data.participant2.category}</p>
                            </div>
                        </div>
                    </label>
                `;

                    document.getElementById('winnerOptions').innerHTML = options;
                    document.getElementById('winnerModal').classList.remove('hidden');
                    document.getElementById('winnerModal').classList.add('flex');
                });
        }

        function closeWinnerModal() {
            document.getElementById('winnerModal').classList.add('hidden');
            document.getElementById('winnerModal').classList.remove('flex');
        }

        // Close modals on outside click
        document.getElementById('winnerModal').addEventListener('click', function(e) {
            if (e.target === this) closeWinnerModal();
        });

        // Close modals on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeWinnerModal();
            }
        });
    </script>
</x-admin-layout>
