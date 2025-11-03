<x-admin-layout>
    <!-- Breadcrumb -->
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-red-900 transition">Dashboard</a>
            <i class="uil uil-angle-right mx-2"></i>
            <a href="{{ route('admin.jadwal.index') }}" class="hover:text-red-900 transition">Jadwal Pertandingan</a>
            <i class="uil uil-angle-right mx-2"></i>
            <span class="text-red-900 font-semibold">Kelola Grup</span>
        </div>
    </div>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Grup Peserta</h1>
            <p class="text-gray-600 mt-2">
                Atur pembagian peserta dalam Grup sebelum membuat jadwal pertandingan.
            </p>
        </div>
    </div>

    <!-- Informasi Lomba -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6">
        <div class="flex items-start gap-4">
            <div class="flex-1">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $competition->name }}</h2>
                <p class="text-gray-600 mb-3">{{ $competition->description }}</p>
                <div class="flex items-center gap-4 text-sm">
                    <span class="inline-flex items-center text-gray-600">
                        <i class="uil uil-calendar-alt mr-1"></i>
                        {{ \Carbon\Carbon::parse($competition->competition_date)->format('d M Y') }}
                    </span>
                    <span class="inline-flex items-center text-gray-600">
                        <i class="uil uil-users-alt mr-1"></i>
                        {{ $participant_count ?? 0 }} Peserta
                    </span>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3 mt-6 pt-6 border-t border-gray-100">
            <form action="{{ route('admin.jadwal.generate-pools', $competition->id) }}" method="POST">
                @csrf
                <button type="submit"
                    class="inline-flex items-center bg-red-700 hover:bg-red-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition shadow-sm">
                    <i class="uil uil-sync mr-2"></i>
                    Generate Grup
                </button>
            </form>
            <a href="{{ route('admin.jadwal.exportPool', $competition->id) }}"
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                🧾 Export Pool (Excel)
            </a>
            <a href="{{ route('admin.jadwal.view', $competition->id) }}"
                class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-medium transition">
                <i class="uil uil-eye mr-2"></i>
                Lihat Jadwal
            </a>
        </div>
    </div>

    <!-- Jika pool sudah terbentuk -->
    @if ($poolsPaginated->isNotEmpty())
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Hasil Pembagian Grup</h2>
                <span class="text-sm text-gray-600">
                    Total {{ $poolsPaginated->total() }} Grup
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                @foreach ($poolsPaginated as $poolName => $group)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Pool Header -->
                        <div class="bg-gradient-to-r from-red-700 to-red-800 px-5 py-4">
                            <h3 class="text-lg font-bold text-white">Grup {{ $poolName }}</h3>
                            <p class="text-red-100 text-sm mt-1">{{ $group->count() }} Peserta</p>
                        </div>

                        <!-- Pool Content -->
                        <div class="p-5">
                            <div class="space-y-3">
                                @foreach ($group as $p)
                                    <div
                                        class="border border-gray-200 rounded-lg p-4 hover:border-red-300 hover:bg-red-50/30 transition">
                                        <a href="{{ route('admin.peserta.show', $p->participant->id) }}"
                                            class="block group">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4
                                                        class="font-semibold text-gray-800 group-hover:text-red-700 transition">
                                                        {{ $p->participant->full_name }}
                                                    </h4>
                                                    <div class="flex flex-wrap gap-2 mt-2">
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-medium">
                                                            <i class="uil uil-weight mr-1"></i>
                                                            {{ $p->participant->weight_class }}
                                                        </span>
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-1 rounded-md bg-purple-50 text-purple-700 text-xs font-medium">
                                                            <i class="uil uil-trophy mr-1"></i>
                                                            {{ $p->participant->category }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <i
                                                    class="uil uil-angle-right-b text-gray-400 group-hover:text-red-700 transition"></i>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($poolsPaginated->hasPages())
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <!-- Info Text -->
                        <div class="text-sm text-gray-600 text-center sm:text-left">
                            Menampilkan Grup {{ $poolsPaginated->firstItem() }} - {{ $poolsPaginated->lastItem() }}
                            dari {{ $poolsPaginated->total() }} Grup
                        </div>

                        <!-- Pagination Controls -->
                        <div class="flex items-center gap-1 sm:gap-2 flex-wrap justify-center">
                            {{-- Previous Button --}}
                            @if ($poolsPaginated->onFirstPage())
                                <span class="px-2 sm:px-3 py-2 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">
                                    <i class="uil uil-angle-left"></i>
                                </span>
                            @else
                                <a href="{{ $poolsPaginated->previousPageUrl() }}"
                                    class="px-2 sm:px-3 py-2 rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-red-50 hover:border-red-300 transition">
                                    <i class="uil uil-angle-left"></i>
                                </a>
                            @endif

                            {{-- Page Numbers --}}
                            @php
                                $currentPage = $poolsPaginated->currentPage();
                                $lastPage = $poolsPaginated->lastPage();
                                $start = max(1, $currentPage - 1);
                                $end = min($lastPage, $currentPage + 1);
                            @endphp

                            {{-- First Page (Mobile: show if not in range) --}}
                            @if ($start > 1)
                                <a href="{{ $poolsPaginated->url(1) }}"
                                    class="hidden sm:inline-block px-3 sm:px-4 py-2 rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-red-50 hover:border-red-300 transition">
                                    1
                                </a>
                                @if ($start > 2)
                                    <span class="hidden sm:inline-block px-2 text-gray-400">...</span>
                                @endif
                            @endif

                            {{-- Page Range --}}
                            @for ($page = $start; $page <= $end; $page++)
                                @if ($page == $currentPage)
                                    <span
                                        class="px-3 sm:px-4 py-2 rounded-lg bg-red-700 text-white font-semibold text-sm sm:text-base">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $poolsPaginated->url($page) }}"
                                        class="px-3 sm:px-4 py-2 rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-red-50 hover:border-red-300 transition text-sm sm:text-base">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endfor

                            {{-- Last Page (Mobile: show if not in range) --}}
                            @if ($end < $lastPage)
                                @if ($end < $lastPage - 1)
                                    <span class="hidden sm:inline-block px-2 text-gray-400">...</span>
                                @endif
                                <a href="{{ $poolsPaginated->url($lastPage) }}"
                                    class="hidden sm:inline-block px-3 sm:px-4 py-2 rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-red-50 hover:border-red-300 transition">
                                    {{ $lastPage }}
                                </a>
                            @endif

                            {{-- Next Button --}}
                            @if ($poolsPaginated->hasMorePages())
                                <a href="{{ $poolsPaginated->nextPageUrl() }}"
                                    class="px-2 sm:px-3 py-2 rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-red-50 hover:border-red-300 transition">
                                    <i class="uil uil-angle-right"></i>
                                </a>
                            @else
                                <span class="px-2 sm:px-3 py-2 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">
                                    <i class="uil uil-angle-right"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Button -->
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800 mb-1">Siap membuat jadwal pertandingan?</h3>
                        <p class="text-sm text-gray-600">Grup sudah terbentuk dan siap untuk dibuatkan jadwal
                            pertandingan.</p>
                    </div>
                    <form action="{{ route('admin.jadwal.generateMatches', $competition->id) }}" method="POST"
                        onsubmit="return confirm('Buat jadwal pertandingan? Jika sudah ada jadwal sebelumnya, maka akan dihapus dan diganti dengan yang baru.')"
                        class="w-full md:w-auto">
                        @csrf
                        <button type="submit"
                            class="w-full md:w-auto inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition font-semibold shadow-sm">
                            <i class="uil uil-plus-circle mr-2"></i>
                            Buat Jadwal Pertandingan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white p-12 rounded-2xl shadow-sm border border-gray-100 text-center">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="uil uil-layers-slash text-4xl text-red-700"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Grup</h3>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                Grup peserta belum dibuat. Klik tombol "Generate Grup" untuk membuat pembagian Grup secara otomatis.
            </p>
        </div>
    @endif
</x-admin-layout>
