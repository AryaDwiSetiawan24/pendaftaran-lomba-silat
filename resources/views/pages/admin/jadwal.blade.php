<x-admin-layout>
    <!-- Breadcrumb -->
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-red-900 transition">Dashboard</a>
            <i class="uil uil-angle-right mx-2"></i>
            <span class="text-red-900 font-semibold">Jadwal Pertandingan</span>
        </div>
    </div>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Jadwal Pertandingan</h1>
            <p class="text-gray-600 mt-2">Atur jadwal dan hasil pertandingan lomba silat</p>
        </div>
        {{-- <button onclick="openAddModal()"
            class="px-6 py-3 bg-red-900 text-white rounded-lg hover:bg-red-800 transition font-semibold shadow-lg inline-flex items-center justify-center">
            <i class="uil uil-plus mr-2"></i>
            Tambah Jadwal Baru
        </button> --}}
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Total Pertandingan</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalMatches ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="uil uil-calendar-alt text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Hari Ini</p>
                    <p class="text-3xl font-bold text-orange-600 mt-1">{{ $todayMatches ?? 0 }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-lg">
                    <i class="uil uil-clock-three text-orange-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Selesai</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $completedMatches ?? 0 }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="uil uil-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-semibold">Belum Selesai</p>
                    <p class="text-3xl font-bold text-red-600 mt-1">{{ $pendingMatches ?? 0 }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-lg">
                    <i class="uil uil-hourglass text-red-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.jadwal.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Competition Filter -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="uil uil-trophy"></i> Lomba
                        </label>
                        <select name="competition_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent bg-white">
                            <option value="">Semua Lomba</option>
                            @foreach ($competitions ?? [] as $competition)
                                <option value="{{ $competition->id }}"
                                    {{ request('competition_id') == $competition->id ? 'selected' : '' }}>
                                    {{ $competition->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="uil uil-calendar-alt"></i> Tanggal
                        </label>
                        <input type="date" name="date" value="{{ request('date') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent">
                    </div>

                    <!-- Round Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="uil uil-layer-group"></i> Ronde
                        </label>
                        <select name="round"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent bg-white">
                            <option value="">Semua Ronde</option>
                            <option value="1" {{ request('round') == '1' ? 'selected' : '' }}>Ronde 1</option>
                            <option value="2" {{ request('round') == '2' ? 'selected' : '' }}>Ronde 2</option>
                            <option value="3" {{ request('round') == '3' ? 'selected' : '' }}>Ronde 3</option>
                            <option value="4" {{ request('round') == '4' ? 'selected' : '' }}>Semi Final</option>
                            <option value="5" {{ request('round') == '5' ? 'selected' : '' }}>Final</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-red-900 text-white rounded-lg hover:bg-red-800 transition font-semibold">
                            <i class="uil uil-search mr-2"></i>
                            Filter
                        </button>
                        <a href="{{ route('admin.jadwal.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            <i class="uil uil-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Schedule by Round -->
    @foreach ($schedulesByRound ?? [] as $round => $matches)
        <div class="bg-white rounded-xl shadow-lg mb-6 overflow-hidden">
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-red-900 to-orange-800">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="uil uil-layer-group text-yellow-400 text-2xl mr-3"></i>
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
                    <span class="ml-auto text-yellow-400 font-bold">{{ count($matches) }} Pertandingan</span>
                </h2>
            </div>

            <div class="p-6">
                <div class="grid gap-4">
                    @foreach ($matches as $match)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <!-- Match Info -->
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">
                                            Arena {{ $match->arena }}
                                        </span>
                                        <span class="text-sm text-gray-600">
                                            <i class="uil uil-clock"></i>
                                            {{ \Carbon\Carbon::parse($match->match_time)->format('d M Y, H:i') }} WIB
                                        </span>
                                        <span class="text-sm text-gray-600">
                                            <i class="uil uil-trophy"></i>
                                            {{ $match->competition->name ?? '-' }}
                                        </span>
                                    </div>

                                    <!-- Participants -->
                                    <div class="flex items-center gap-4">
                                        <!-- Participant 1 -->
                                        <div class="flex-1">
                                            <div
                                                class="flex items-center justify-between bg-gray-50 rounded-lg p-3 {{ $match->winner_id == $match->participant1_id ? 'ring-2 ring-green-500 bg-green-50' : '' }}">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                                        {{ strtoupper(substr($match->participant1->full_name ?? 'TBD', 0, 2)) }}
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-gray-900">
                                                            {{ $match->participant1->full_name ?? 'TBD' }}</p>
                                                        <p class="text-xs text-gray-500">
                                                            {{ $match->participant1->weight_class ?? '-' }}</p>
                                                    </div>
                                                </div>
                                                @if ($match->winner_id == $match->participant1_id)
                                                    <i class="uil uil-trophy text-yellow-500 text-2xl"></i>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- VS -->
                                        <div class="shrink-0">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-r from-red-900 to-orange-800 rounded-full flex items-center justify-center">
                                                <span class="text-white font-bold text-sm">VS</span>
                                            </div>
                                        </div>

                                        <!-- Participant 2 -->
                                        <div class="flex-1">
                                            <div
                                                class="flex items-center justify-between bg-gray-50 rounded-lg p-3 {{ $match->winner_id == $match->participant2_id ? 'ring-2 ring-green-500 bg-green-50' : '' }}">
                                                @if ($match->winner_id == $match->participant2_id)
                                                    <i class="uil uil-trophy text-yellow-500 text-2xl"></i>
                                                @endif
                                                <div class="flex items-center gap-3">
                                                    <div>
                                                        <p class="font-semibold text-gray-900 text-right">
                                                            {{ $match->participant2->full_name ?? 'TBD' }}</p>
                                                        <p class="text-xs text-gray-500 text-right">
                                                            {{ $match->participant2->weight_class ?? '-' }}</p>
                                                    </div>
                                                    <div
                                                        class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center text-white font-bold">
                                                        {{ strtoupper(substr($match->participant2->full_name ?? 'TBD', 0, 2)) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex flex-col gap-2">
                                    @if (!$match->winner_id)
                                        <button onclick="openWinnerModal({{ $match->id }})"
                                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold text-sm inline-flex items-center justify-center">
                                            <i class="uil uil-trophy mr-2"></i>
                                            Set Pemenang
                                        </button>
                                    @else
                                        <span
                                            class="px-4 py-2 bg-green-100 text-green-800 rounded-lg font-semibold text-sm text-center">
                                            <i class="uil uil-check-circle mr-1"></i>
                                            Selesai
                                        </span>
                                    @endif

                                    <div class="flex gap-2">
                                        <button onclick="editSchedule({{ $match->id }})"
                                            class="flex-1 px-3 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition text-sm"
                                            title="Edit">
                                            <i class="uil uil-edit"></i>
                                        </button>
                                        
                                        <form action="{{ route('admin.jadwal.destroy', $match->id) }}" method="POST"
                                            class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full px-3 py-2 border border-red-600 text-red-600 rounded-lg hover:bg-red-50 transition text-sm"
                                                onclick="return confirm('Hapus jadwal pertandingan ini?')"
                                                title="Hapus">
                                                <i class="uil uil-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    @if (empty($schedulesByRound) || count($schedulesByRound) == 0)
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <i class="uil uil-calendar-slash text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg font-semibold">Belum ada jadwal pertandingan</p>
            <p class="text-gray-400 text-sm mt-1 mb-6">Klik tombol "Tambah Jadwal Baru" untuk membuat jadwal
                pertandingan</p>
            <button onclick="openAddModal()"
                class="px-6 py-3 bg-red-900 text-white rounded-lg hover:bg-red-800 transition font-semibold inline-flex items-center">
                <i class="uil uil-plus mr-2"></i>
                Tambah Jadwal Baru
            </button>
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

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center z-50"
            id="successAlert">
            <i class="uil uil-check-circle text-2xl mr-3"></i>
            <div>
                <p class="font-semibold">Berhasil!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <i class="uil uil-times text-xl"></i>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center z-50"
            id="errorAlert">
            <i class="uil uil-exclamation-triangle text-2xl mr-3"></i>
            <div>
                <p class="font-semibold">Error!</p>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <i class="uil uil-times text-xl"></i>
            </button>
        </div>
    @endif

    <script>
        // Auto-hide alerts
        setTimeout(() => {
            const alerts = ['successAlert', 'errorAlert'];
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
        document.getElementById('scheduleModal').addEventListener('click', function(e) {
            if (e.target === this) closeScheduleModal();
        });

        document.getElementById('winnerModal').addEventListener('click', function(e) {
            if (e.target === this) closeWinnerModal();
        });

        // Close modals on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeScheduleModal();
                closeWinnerModal();
            }
        });

        // Form validation
        document.getElementById('scheduleForm').addEventListener('submit', function(e) {
            const p1 = document.getElementById('participant1_id').value;
            const p2 = document.getElementById('participant2_id').value;

            if (p1 === p2) {
                e.preventDefault();
                alert('Peserta 1 dan Peserta 2 tidak boleh sama!');
                return false;
            }
        });
    </script>
</x-admin-layout>
