<x-admin-layout>
    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 border border-green-300">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Lomba</p>
                    <p class="text-2xl sm:text-3xl font-bold mt-2">{{ $totalLomba }}</p>
                </div>
                <div class="bg-blue-500 p-3 rounded-lg">
                    <div class="h-6 w-6 text-center text-white"><i class="uil uil-trophy"></i></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Peserta</p>
                    <p class="text-2xl sm:text-3xl font-bold mt-2">{{ $totalPeserta }}</p>
                </div>
                <div class="bg-green-500 p-3 rounded-lg">
                    <div class="h-6 w-6 text-center text-white"><i class="uil uil-users-alt"></i></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Lomba Aktif</p>
                    <p class="text-2xl sm:text-3xl font-bold mt-2">{{ $lombaAktif }}</p>
                </div>
                <div class="bg-yellow-500 p-3 rounded-lg">
                    <div class="h-6 w-6 text-center text-white"><i class="uil uil-medal"></i></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Jadwal Hari Ini</p>
                    <p class="text-2xl sm:text-3xl font-bold mt-2">{{ $jadwalHariIni }}</p>
                </div>
                <div class="bg-red-500 p-3 rounded-lg">
                    <div class="h-6 w-6 text-center text-white"><i class="uil uil-schedule"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between gap-4 sm:items-center">
            <h2 class="text-lg sm:text-xl font-bold">Lomba Terbaru</h2>
            <a href="{{ route('admin.lomba') }}"
                class="w-full sm:w-auto px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition flex items-center justify-center text-sm">
                Lihat Semua Lomba
                <span class="h-4 w-4 ml-2 mb-1.5"><i class="uil uil-arrow-right"></i></span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Nama Lomba</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Peserta</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($recentCompetitions as $competition)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $competition->name }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                @if ($competition->competition_date)
                                    {{ $competition->competition_date->format('d M Y') }}
                                @else
                                    <span class="text-gray-400 italic">Belum dijadwalkan</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $competition->participants_count ?? 0 }}
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusColors = [
                                        'akan_datang' => 'bg-yellow-100 text-yellow-800',
                                        'dibuka' => 'bg-green-100 text-green-800',
                                        'ditutup' => 'bg-gray-200 text-gray-800',
                                        'selesai' => 'bg-blue-100 text-blue-800',
                                    ];
                                @endphp
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$competition->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst(str_replace('_', ' ', $competition->status)) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                Belum ada data lomba.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
