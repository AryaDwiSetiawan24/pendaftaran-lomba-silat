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
                        Kelola Pool
                    </a>

                    <a href="{{ route('admin.jadwal.index') }}"
                        class="px-5 py-3 bg-white/20 backdrop-blur-sm text-white rounded-xl hover:bg-white/30 transition-all duration-200 font-semibold text-sm inline-flex items-center">
                        <i class="uil uil-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Message -->
    @if (session('success'))
        <div
            class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-lg shadow-sm animate-fade-in">
            <div class="flex items-center">
                <i class="uil uil-check-circle text-2xl mr-3"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

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
    <div class="bg-white rounded-2xl shadow-md mb-8">
        <div class="border-b border-gray-200 px-6 py-4">
            <h3 class="font-bold text-gray-900 flex items-center">
                <i class="uil uil-filter text-red-900 mr-2"></i>
                Filter Pertandingan
            </h3>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('admin.jadwal.view', $competition->id) }}">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Date Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="uil uil-calendar-alt text-red-900"></i> Tanggal
                        </label>
                        <input type="date" name="date" value="{{ request('date') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-900 focus:border-transparent transition">
                    </div>

                    <!-- Round Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="uil uil-layer-group text-red-900"></i> Ronde
                        </label>
                        <select name="round"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-900 focus:border-transparent bg-white transition">
                            <option value="">Semua Ronde</option>
                            <option value="1" {{ request('round') == '1' ? 'selected' : '' }}>Ronde 1</option>
                            <option value="2" {{ request('round') == '2' ? 'selected' : '' }}>Ronde 2</option>
                            <option value="3" {{ request('round') == '3' ? 'selected' : '' }}>Ronde 3</option>
                            <option value="4" {{ request('round') == '4' ? 'selected' : '' }}>Semi Final</option>
                            <option value="5" {{ request('round') == '5' ? 'selected' : '' }}>Final</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-end gap-3 md:col-span-3">
                        <button type="submit"
                            class="flex-1 px-6 py-2.5 bg-gradient-to-r from-red-900 to-red-800 text-white rounded-xl hover:from-red-800 hover:to-red-700 transition-all duration-200 font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <i class="uil uil-search mr-2"></i>
                            Terapkan Filter
                        </button>
                        <a href="{{ route('admin.jadwal.view', $competition->id) }}"
                            class="px-5 py-2.5 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-200 font-semibold">
                            <i class="uil uil-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Jadwal per Ronde -->
    @foreach ($schedulesByRound ?? [] as $round => $matches)
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
                    @php
                        $matchesCollection = collect($matches);
                        $perPage = 10;
                        $currentPage = request()->get('page_round_' . $round, 1);
                        $paginatedMatches = $matchesCollection->forPage($currentPage, $perPage);
                        $totalPages = ceil($matchesCollection->count() / $perPage);
                    @endphp

                    @foreach ($paginatedMatches as $match)
                        <div
                            class="border-2 border-gray-200 rounded-xl hover:border-red-300 hover:shadow-lg transition-all duration-300 overflow-hidden">
                            <div class="p-6">
                                <!-- Match Header Info -->
                                <div class="flex flex-wrap items-center gap-3 mb-6">
                                    <span
                                        class="px-4 py-1.5 bg-gradient-to-r from-red-600 to-red-700 text-white text-sm font-bold rounded-full shadow-md">
                                        <i class="uil uil-location-point mr-1"></i>
                                        Arena {{ $match->arena }}
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
                @if ($totalPages > 1)
                    <div
                        class="mt-6 flex flex-col sm:flex-row items-center justify-between border-t border-gray-200 pt-6 gap-4">
                        <div class="text-sm text-gray-600">
                            Menampilkan <span class="font-semibold">{{ ($currentPage - 1) * $perPage + 1 }}</span>
                            sampai <span
                                class="font-semibold">{{ min($currentPage * $perPage, $matchesCollection->count()) }}</span>
                            dari <span class="font-semibold">{{ $matchesCollection->count() }}</span> pertandingan
                        </div>

                        <div class="flex items-center gap-2">
                            @if ($currentPage > 1)
                                <a href="{{ request()->fullUrlWithQuery(['page_round_' . $round => $currentPage - 1]) }}"
                                    class="px-3 py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold text-sm">
                                    <i class="uil uil-angle-left"></i>
                                </a>
                            @else
                                <span
                                    class="px-3 py-2 border-2 border-gray-200 text-gray-400 rounded-lg cursor-not-allowed text-sm">
                                    <i class="uil uil-angle-left"></i>
                                </span>
                            @endif

                            <div class="flex gap-1">
                                @for ($i = 1; $i <= $totalPages; $i++)
                                    @if ($i == $currentPage)
                                        <span
                                            class="px-3 py-2 bg-red-900 text-white rounded-lg font-bold text-sm min-w-10 text-center">{{ $i }}</span>
                                    @elseif($i == 1 || $i == $totalPages || abs($i - $currentPage) <= 1)
                                        <a href="{{ request()->fullUrlWithQuery(['page_round_' . $round => $i]) }}"
                                            class="px-3 py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold text-sm min-w-10 text-center">
                                            {{ $i }}
                                        </a>
                                    @elseif(abs($i - $currentPage) == 2)
                                        <span class="px-2 py-2 text-gray-400 text-sm">...</span>
                                    @endif
                                @endfor
                            </div>

                            @if ($currentPage < $totalPages)
                                <a href="{{ request()->fullUrlWithQuery(['page_round_' . $round => $currentPage + 1]) }}"
                                    class="px-3 py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold text-sm">
                                    <i class="uil uil-angle-right"></i>
                                </a>
                            @else
                                <span
                                    class="px-3 py-2 border-2 border-gray-200 text-gray-400 rounded-lg cursor-not-allowed text-sm">
                                    <i class="uil uil-angle-right"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
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

    <!-- Add/Edit Schedule Modal -->
    <div id="scheduleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-gradient-to-r from-red-900 to-orange-800 p-6 rounded-t-xl">
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <i class="uil uil-calendar-alt text-yellow-400 text-3xl mr-3"></i>
                        <span id="modalTitle">Tambah Jadwal Pertandingan</span>
                    </h3>
                    <button onclick="closeScheduleModal()" class="text-white hover:text-gray-200 transition">
                        <i class="uil uil-times text-3xl"></i>
                    </button>
                </div>
            </div>

            <form id="scheduleForm" action="{{ route('admin.jadwal.store') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="id" id="scheduleId">

                <div class="space-y-4">
                    <!-- Competition -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Lomba <span class="text-red-600">*</span>
                        </label>
                        <select name="competition_id" id="competition_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent bg-white"
                            required onchange="loadParticipants(this.value)">
                            <option value="">Pilih Lomba</option>
                            @foreach ($competitions ?? [] as $competition)
                                <option value="{{ $competition->id }}">{{ $competition->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Participant 1 -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Peserta 1 <span class="text-red-600">*</span>
                            </label>
                            <select name="participant1_id" id="participant1_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent bg-white"
                                required>
                                <option value="">Pilih Peserta</option>
                            </select>
                        </div>

                        <!-- Participant 2 -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Peserta 2 <span class="text-red-600">*</span>
                            </label>
                            <select name="participant2_id" id="participant2_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent bg-white"
                                required>
                                <option value="">Pilih Peserta</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4">
                        <!-- Round -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Ronde <span class="text-red-600">*</span>
                            </label>
                            <select name="round" id="round"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent bg-white"
                                required>
                                <option value="1">Ronde 1</option>
                                <option value="2">Ronde 2</option>
                                <option value="3">Ronde 3</option>
                                <option value="4">Semi Final</option>
                                <option value="5">Final</option>
                            </select>
                        </div>

                        <!-- Arena -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Arena <span class="text-red-600">*</span>
                            </label>
                            <input type="text" name="arena" id="arena" placeholder="Contoh: A1, B2"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent"
                                required>
                        </div>

                        <!-- Match Time -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Waktu <span class="text-red-600">*</span>
                            </label>
                            <input type="datetime-local" name="match_time" id="match_time"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent"
                                required>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                        <div class="flex">
                            <i class="uil uil-info-circle text-blue-500 text-xl mr-3"></i>
                            <p class="text-sm text-blue-700">
                                Pastikan kedua peserta berada dalam kategori dan kelas berat yang sama untuk
                                pertandingan yang adil.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                    <button type="button" onclick="closeScheduleModal()"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-3 bg-red-900 text-white rounded-lg hover:bg-red-800 transition font-semibold">
                        <i class="uil uil-check mr-2"></i>
                        Simpan Jadwal
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
        // Auto-hide alerts
        setTimeout(() => {
            const alerts = ['success', 'error'];
            alerts.forEach(id => {
                const alert = document.getElementById(id);
                if (alert) {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            });
        }, 5000);

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
            // Fetch schedule data and populate form
            fetch(`/admin/jadwal/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalTitle').textContent = 'Edit Jadwal Pertandingan';
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('scheduleForm').action = `/admin/jadwal/${id}`;
                    document.getElementById('scheduleId').value = data.id;
                    document.getElementById('competition_id').value = data.competition_id;
                    loadParticipants(data.competition_id, data.participant1_id, data.participant2_id);
                    document.getElementById('round').value = data.round;
                    document.getElementById('arena').value = data.arena;
                    document.getElementById('match_time').value = data.match_time;

                    openAddModal();
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
