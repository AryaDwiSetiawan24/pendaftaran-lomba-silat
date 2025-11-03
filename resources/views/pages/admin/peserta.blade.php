<x-admin-layout>
    <!-- Breadcrumb -->
    <div class="mb-6 flex items-center text-sm text-gray-600">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-red-900 transition">Dashboard</a>
        <i class="uil uil-angle-right mx-2"></i>
        <span class="text-red-900 font-semibold">Daftar Peserta</span>
    </div>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">Manajemen Peserta Lomba</h1>
        <p class="text-gray-500 mt-1 text-sm">Kelola dan validasi pendaftaran peserta lomba silat</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        @php
            $stats = [
                [
                    'label' => 'Total Peserta',
                    'count' => $totalPeserta ?? 0,
                    'color' => 'blue',
                    'icon' => 'uil-users-alt',
                ],
                ['label' => 'Pending', 'count' => $pendingCount ?? 0, 'color' => 'yellow', 'icon' => 'uil-clock'],
                [
                    'label' => 'Disetujui',
                    'count' => $approvedCount ?? 0,
                    'color' => 'green',
                    'icon' => 'uil-check-circle',
                ],
                ['label' => 'Ditolak', 'count' => $rejectedCount ?? 0, 'color' => 'red', 'icon' => 'uil-times-circle'],
            ];
        @endphp

        @foreach ($stats as $s)
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">{{ $s['label'] }}</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $s['count'] }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-{{ $s['color'] }}-100">
                        <i class="uil {{ $s['icon'] }} text-{{ $s['color'] }}-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-md p-6 mb-8 border border-gray-100">
        <form method="GET" action="{{ route('admin.peserta') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        <i class="uil uil-search mr-1"></i> Cari Peserta
                    </label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Nama, NIK, No. Telepon, Kontingen..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
                </div>

                <!-- Lomba -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        <i class="uil uil-trophy mr-1"></i> Lomba
                    </label>
                    <select name="competition_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-red-800">
                        <option value="">Semua Lomba</option>
                        @foreach ($competitions ?? [] as $competition)
                            <option value="{{ $competition->id }}"
                                {{ request('competition_id') == $competition->id ? 'selected' : '' }}>
                                {{ $competition->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        <i class="uil uil-filter mr-1"></i> Status
                    </label>
                    <select name="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-red-800">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui
                        </option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak
                        </option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        <i class="uil uil-tag-alt mr-1"></i> Kategori
                    </label>
                    <select name="category"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-red-800">
                        <option value="">Semua Kategori</option>
                        <option value="USIA DINI 1 (SD)" {{ request('category') == 'USIA DINI (SD)' ? 'selected' : '' }}>
                            USIA DINI 1 (SD)</option>
                        <option value="USIA DINI 2 (SD)" {{ request('category') == 'USIA DINI (SD)' ? 'selected' : '' }}>
                            USIA DINI 2 (SD)</option>
                        <option value="PRA REMAJA (SMP)"
                            {{ request('category') == 'PRA REMAJA (SMP)' ? 'selected' : '' }}>PRA REMAJA (SMP)
                        </option>
                        <option value="REMAJA (SMA/K/MA)"
                            {{ request('category') == 'REMAJA (SMA/K/MA)' ? 'selected' : '' }}>REMAJA (SMA/K/MA)
                        </option>
                        {{-- <option value="DEWASA (MAHASISWA/UMUM)"
                            {{ request('category') == 'DEWASA (MAHASISWA/UMUM)' ? 'selected' : '' }}>DEWASA
                            (Mahasiswa/Umum)</option> --}}
                    </select>
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        <i class="uil uil-user mr-1"></i> Jenis Kelamin
                    </label>
                    <select name="gender"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-red-800">
                        <option value="">Semua</option>
                        <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Tombol -->
                <div class="md:col-span-2 flex items-end gap-2">
                    <!-- submit filter -->
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-red-800 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                        <i class="uil uil-filter mr-2"></i> Terapkan
                    </button>

                    <!-- reset filter -->
                    <a href="{{ route('admin.peserta') }}"
                        class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-100 transition"
                        title="Reset Filter">
                        <i class="uil uil-redo"></i>
                    </a>

                    <!-- trash -->
                    {{-- <button type="button" onclick="window.print()"
                        class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-100 transition"
                        title="Cetak">
                        <i class="uil uil-print"></i>
                    </button> --}}

                    <!-- export excel -->
                    <a href="{{ route('admin.peserta.export') }}"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                        title="Export ke Excel">
                        <i class="uil uil-file-download-alt"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-red-900 to-orange-700">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="uil uil-list-ul text-yellow-400 text-2xl mr-2"></i> Daftar Peserta
            </h2>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full text-sm text-gray-700 border-collapse">
                <thead class="bg-gray-100 text-xs uppercase font-semibold text-gray-600 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left whitespace-nowrap">No</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Lomba</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Kategori</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Kelas</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">JK</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Bukti</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peserta ?? [] as $index => $p)
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition">
                            <td class="px-4 py-3 whitespace-nowrap">{{ $peserta->firstItem() + $index }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-900">{{ Str::limit($p->full_name, 15) }}</p>
                                        <p class="text-xs text-gray-500"><i class="uil uil-postcard"></i>
                                            {{ $p->nik }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ Str::limit($p->competition->name ?? '-', 15) }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-xs">{{ Str::limit($p->category, 15) }}</span>
                                <p class="text-xs text-gray-500"><i class="uil uil-bag"></i>
                                    {{ Str::limit($p->kontingen, 15) }}</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs font-semibold">
                                    {{ $p->weight_class }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                @if ($p->gender == 'L')
                                    <span class="text-blue-600 font-semibold"><i class="uil uil-mars"></i></span>
                                @else
                                    <span class="text-pink-600 font-semibold"><i class="uil uil-venus"></i></span>
                                @endif
                            </td>
                            <td>
                                @if ($p->bukti_bayar)
                                    <a href="{{ asset('storage/' . $p->bukti_bayar) }}" target="_blank"
                                        class="hover:text-blue-600 hover:underline">Lihat</a>
                                @else
                                    <span>Belum ada</span>
                                @endif

                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if ($p->validation_status == 'pending')
                                    <span
                                        class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">Pending</span>
                                @elseif ($p->validation_status == 'approved')
                                    <span
                                        class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">Disetujui</span>
                                @else
                                    <span
                                        class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex gap-2">
                                    @if ($p->validation_status == 'pending')
                                        <form action="{{ route('admin.peserta.approve', $p->id) }}" method="POST"
                                            onsubmit="return confirm('Setujui peserta ini?')">
                                            @csrf @method('PATCH')
                                            <button class="text-green-600 hover:text-green-800">
                                                <i class="uil uil-check text-lg"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.peserta.reject', $p->id) }}" method="POST"
                                            onsubmit="return confirm('Tolak peserta ini?')">
                                            @csrf @method('PATCH')
                                            <button class="text-red-600 hover:text-red-800">
                                                <i class="uil uil-times text-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.peserta.show', $p->id) }}"
                                        class="text-blue-600 hover:text-blue-800" title="Lihat">
                                        <i class="uil uil-eye text-lg"></i>
                                    </a>
                                    <a href="{{ route('admin.peserta.edit', $p->id) }}"
                                        class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                        <i class="uil uil-pen text-lg"></i>
                                    </a>
                                    <form action="{{ route('admin.peserta.destroy', $p->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus peserta ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-gray-500 hover:text-gray-800">
                                            <i class="uil uil-trash-alt text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-10 text-center text-gray-500">
                                <i class="uil uil-inbox text-5xl mb-3 text-gray-300"></i><br>
                                Tidak ada data peserta
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile/Tablet Card View -->
        <div class="lg:hidden">
            @forelse ($peserta ?? [] as $index => $p)
                <div class="border-b border-gray-200 p-3 sm:p-4 hover:bg-gray-50 transition">
                    <!-- Header Card -->
                    <div class="flex items-start justify-between mb-3 gap-2">
                        <div class="flex items-center gap-2 sm:gap-3 flex-1 min-w-0">
                            <div
                                class="h-10 w-10 sm:h-12 sm:w-12 bg-red-900 text-white rounded-full flex items-center justify-center font-semibold flex-shrink-0 text-sm sm:text-base">
                                {{ strtoupper(substr($p->full_name, 0, 2)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-gray-900 text-sm sm:text-base truncate">
                                    {{ $p->full_name }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    <i class="uil uil-phone"></i> {{ $p->phone_number }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    <i class="uil uil-id-card"></i> {{ $p->nik }}
                                </p>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-600 ml-1 flex-shrink-0">
                            #{{ $peserta->firstItem() + $index }}
                        </span>
                    </div>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-2 sm:gap-3 mb-3">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">
                                <i class="uil uil-trophy"></i> Lomba
                            </p>
                            <p class="text-xs sm:text-sm font-semibold text-gray-800 truncate">
                                {{ $p->competition->name ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">
                                <i class="uil uil-tag-alt"></i> Kategori
                            </p>
                            <p class="text-xs sm:text-sm font-semibold text-gray-800 truncate">
                                {{ Str::limit($p->category, 20) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">
                                <i class="uil uil-weight"></i> Kelas
                            </p>
                            <span
                                class="inline-block bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs font-semibold">
                                {{ $p->weight_class }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">
                                <i class="uil uil-user"></i> Jenis Kelamin
                            </p>
                            <p class="text-xs sm:text-sm font-semibold">
                                @if ($p->gender == 'L')
                                    <span class="text-blue-600"><i class="uil uil-mars"></i> Laki-laki</span>
                                @else
                                    <span class="text-pink-600"><i class="uil uil-venus"></i> Perempuan</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Status & Actions -->
                    <div
                        class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-0 pt-3 border-t border-gray-200">
                        <div>
                            @if ($p->validation_status == 'pending')
                                <span
                                    class="inline-block bg-yellow-100 text-yellow-800 px-2.5 py-1 rounded-full text-xs font-semibold">
                                    <i class="uil uil-clock"></i> Pending
                                </span>
                            @elseif ($p->validation_status == 'approved')
                                <span
                                    class="inline-block bg-green-100 text-green-800 px-2.5 py-1 rounded-full text-xs font-semibold">
                                    <i class="uil uil-check-circle"></i> Disetujui
                                </span>
                            @else
                                <span
                                    class="inline-block bg-red-100 text-red-800 px-2.5 py-1 rounded-full text-xs font-semibold">
                                    <i class="uil uil-times-circle"></i> Ditolak
                                </span>
                            @endif
                        </div>
                        <div class="flex gap-1.5 sm:gap-2">
                            @if ($p->validation_status == 'pending')
                                <form action="{{ route('admin.peserta.approve', $p->id) }}" method="POST"
                                    onsubmit="return confirm('Setujui peserta ini?')">
                                    @csrf @method('PATCH')
                                    <button class="p-1.5 sm:p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                                        title="Setujui">
                                        <i class="uil uil-check text-lg sm:text-xl"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.peserta.reject', $p->id) }}" method="POST"
                                    onsubmit="return confirm('Tolak peserta ini?')">
                                    @csrf @method('PATCH')
                                    <button class="p-1.5 sm:p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                        title="Tolak">
                                        <i class="uil uil-times text-lg sm:text-xl"></i>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.peserta.show', $p->id) }}"
                                class="p-1.5 sm:p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                title="Lihat">
                                <i class="uil uil-eye text-lg sm:text-xl"></i>
                            </a>
                            <a href="{{ route('admin.peserta.edit', $p->id) }}"
                                class="p-1.5 sm:p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                title="Edit">
                                <i class="uil uil-pen text-lg sm:text-xl"></i>
                            </a>
                            <form action="{{ route('admin.peserta.destroy', $p->id) }}" method="POST"
                                onsubmit="return confirm('Hapus peserta ini?')">
                                @csrf @method('DELETE')
                                <button class="p-1.5 sm:p-2 text-gray-500 hover:bg-gray-100 rounded-lg transition"
                                    title="Hapus">
                                    <i class="uil uil-trash-alt text-lg sm:text-xl"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 sm:px-6 py-10 text-center text-gray-500">
                    <i class="uil uil-inbox text-4xl sm:text-5xl mb-3 text-gray-300"></i><br>
                    <span class="text-sm sm:text-base">Tidak ada data peserta</span>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if (isset($peserta) && $peserta->hasPages())
            <div class="mt-6 px-3 sm:px-4 md:px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Info Text -->
                    <div class="text-xs sm:text-sm text-gray-600">
                        Menampilkan
                        <span class="font-semibold text-gray-900">{{ $peserta->firstItem() }}</span>
                        sampai
                        <span class="font-semibold text-gray-900">{{ $peserta->lastItem() }}</span>
                        dari
                        <span class="font-semibold text-gray-900">{{ $peserta->total() }}</span>
                        peserta
                    </div>

                    <!-- Pagination Controls -->
                    <div class="flex items-center gap-2">
                        {{-- Previous Button --}}
                        @if ($peserta->onFirstPage())
                            <span
                                class="px-3 py-2 border-2 border-gray-200 text-gray-400 rounded-lg cursor-not-allowed text-sm">
                                <i class="uil uil-angle-left"></i>
                            </span>
                        @else
                            <a href="{{ $peserta->previousPageUrl() }}"
                                class="px-3 py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold text-sm">
                                <i class="uil uil-angle-left"></i>
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        <div class="hidden sm:flex gap-1">
                            @for ($i = 1; $i <= $peserta->lastPage(); $i++)
                                @if ($i == $peserta->currentPage())
                                    <span
                                        class="px-3 py-2 bg-red-900 text-white rounded-lg font-bold text-sm min-w-10 text-center">
                                        {{ $i }}
                                    </span>
                                @elseif($i == 1 || $i == $peserta->lastPage() || abs($i - $peserta->currentPage()) <= 1)
                                    <a href="{{ $peserta->url($i) }}"
                                        class="px-3 py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold text-sm min-w-10 text-center">
                                        {{ $i }}
                                    </a>
                                @elseif(abs($i - $peserta->currentPage()) == 2)
                                    <span class="px-2 py-2 text-gray-400 text-sm">...</span>
                                @endif
                            @endfor
                        </div>

                        {{-- Mobile Page Display --}}
                        <span
                            class="sm:hidden px-3 py-2 bg-red-900 text-white rounded-lg font-bold text-sm min-w-16 text-center">
                            {{ $peserta->currentPage() }} / {{ $peserta->lastPage() }}
                        </span>

                        {{-- Next Button --}}
                        @if ($peserta->hasMorePages())
                            <a href="{{ $peserta->nextPageUrl() }}"
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
            </div>
        @endif
    </div>
</x-admin-layout>
