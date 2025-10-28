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
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Manajemen Jadwal Pertandingan</h1>
                <p class="text-gray-600 mt-2">Atur jadwal dan hasil pertandingan lomba silat</p>
            </div>

            <!-- Filter/Search Area (Optional) -->
            {{-- <div class="flex gap-3">
                <select
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent text-sm">
                    <option value="">Semua Status</option>
                    <option value="dibuka">Dibuka</option>
                    <option value="akan_datang">Akan Datang</option>
                    <option value="ditutup">Ditutup</option>
                </select>
            </div> --}}
        </div>
    </div>

    <!-- Competition Cards Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse ($competitions as $competition)
            <div
                class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-red-900 to-red-800 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold mb-2">{{ $competition->name }}</h3>
                            <div class="flex items-center text-red-100 text-sm">
                                <i class="uil uil-calendar-alt mr-2"></i>
                                <span>{{ \Carbon\Carbon::parse($competition->competition_date)->format('d M Y') }}</span>
                            </div>
                        </div>
                        @php
                            $statusMap = [
                                'dibuka' => ['class' => 'bg-green-500', 'label' => 'Dibuka'],
                                'ditutup' => ['class' => 'bg-gray-500', 'label' => 'Ditutup'],
                                'akan_datang' => ['class' => 'bg-yellow-500', 'label' => 'Akan Datang'],
                            ];
                            $status = $statusMap[$competition->status] ?? [
                                'class' => 'bg-blue-500',
                                'label' => ucfirst($competition->status),
                            ];
                        @endphp
                        <span
                            class="px-3 py-1.5 rounded-full text-xs font-bold {{ $status['class'] }} text-white shadow-lg">
                            {{ $status['label'] }}
                        </span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <!-- Description -->
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                        {{ Str::limit($competition->description, 120) }}
                    </p>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="flex items-center justify-center mb-2">
                                <i class="uil uil-users-alt text-2xl text-red-900"></i>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">{{ $competition->participants_count ?? 0 }}</p>
                            <p class="text-xs text-gray-600 mt-1">Peserta</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="flex items-center justify-center mb-2">
                                <i class="uil uil-trophy text-2xl text-yellow-600"></i>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalMatches[$competition->id] ?? 0 }}</p>
                            <p class="text-xs text-gray-600 mt-1">Pertandingan</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-2 gap-3">
                        <!-- Kelola Pool -->
                        <a href="{{ route('admin.jadwal.pool', $competition->id) }}"
                            class="flex items-center justify-center px-4 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white rounded-lg transition-all duration-200 text-sm font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <i class="uil uil-sitemap mr-2 text-base"></i>
                            <span>Kelola Grup</span>
                        </a>

                        <!-- Lihat Jadwal -->
                        <a href="{{ route('admin.jadwal.view', $competition->id) }}"
                            class="flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all duration-200 text-sm font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <i class="uil uil-eye mr-2 text-base"></i>
                            <span>Lihat Jadwal</span>
                        </a>
                    </div>

                    <!-- Additional Quick Actions -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex items-center justify-between text-xs">
                            <a href="{{ route('admin.jadwal.export.excel') }}"
                                class="text-gray-600 hover:text-red-900 transition flex items-center">
                                <i class="uil uil-download-alt mr-1"></i>
                                Export Jadwal
                            </a>
                            <form action="{{ route('admin.lomba.toggleVisibility', $competition->id) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="px-3 py-1 rounded {{ $competition->visible_schedule ? 'bg-gray-300 text-gray-800' : 'bg-green-600 text-white' }}">
                                    {{ $competition->visible_schedule ? 'Sembunyikan Jadwal' : 'Tampilkan ke Peserta' }}
                                </button>
                            </form>
                            {{-- <a href="#" class="text-gray-600 hover:text-red-900 transition flex items-center">
                                <i class="uil uil-print mr-1"></i>
                                Cetak
                            </a>
                            <a href="#" class="text-gray-600 hover:text-red-900 transition flex items-center">
                                <i class="uil uil-chart-line mr-1"></i>
                                Statistik
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="col-span-full">
                <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="uil uil-calendar-slash text-5xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ada Lomba</h3>
                    <p class="text-gray-600 mb-6">Belum ada lomba yang tersedia untuk saat ini.</p>
                    <a href="{{ route('admin.lomba.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-red-900 hover:bg-red-800 text-white rounded-lg transition font-semibold">
                        <i class="uil uil-plus mr-2"></i>
                        Tambah Lomba Baru
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</x-admin-layout>
