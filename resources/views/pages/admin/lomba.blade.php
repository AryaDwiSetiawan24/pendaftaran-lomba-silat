<x-admin-layout>
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-red-900 transition">Dashboard</a>
            <i class="uil uil-angle-right mx-2"></i>
            <span class="text-red-900 font-semibold">Manajemen Lomba</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between gap-4 sm:items-center">
            <h2 class="text-lg sm:text-xl font-bold">Manajemen Lomba</h2>
            <a href="{{ route('admin.add-lomba') }}"
                class="w-full sm:w-auto px-4 py-2 bg-red-900 text-white rounded-lg hover:bg-red-800 transition flex items-center justify-center text-sm">
                <span class="h-4 w-4 mr-2"><i class="uil uil-plus"></i></span> Tambah Lomba
            </a>
        </div>

        <div class="p-4 space-y-4">
            <form method="GET" action="{{ route('admin.lomba') }}">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="uil uil-search"></i>
                        </span>
                        <input type="text" name="search" placeholder="Cari lomba..." value="{{ $search ?? '' }}"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent text-sm" />
                    </div>
                    <button type="submit"
                        class="w-full sm:w-auto px-4 py-2 bg-red-900 text-white rounded-lg hover:bg-red-800 transition text-sm">
                        Cari
                    </button>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Nama Lomba</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Tanggal Lomba</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Pendaftaran</th>
                            {{-- <- INI HEADER YANG HILANG --}}
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Peserta</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($competitions as $competition)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-800">
                                    {{ $competition->name }}
                                </td>

                                <td class="px-4 py-3 text-gray-600">
                                    @if ($competition->competition_date)
                                        {{ $competition->competition_date->format('d M Y, H:i') }}
                                    @else
                                        <span class="text-gray-400 italic">Belum dijadwalkan</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-gray-600">
                                    {{ $competition->registration_start_date->format('d M Y') }}
                                    –
                                    {{ $competition->registration_end_date->format('d M Y') }}
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

                                <td class="px-4 py-3 justify-center">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.lomba.show', $competition->id) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-200 rounded">
                                            <i class="uil uil-eye text-2xl"></i>
                                        </a>
                                        <a href="{{ route('admin.lomba.edit', $competition->id) }}"
                                            class="p-2 text-yellow-600 hover:bg-yellow-200 rounded">
                                            <i class="uil uil-pen text-2xl"></i>
                                        </a>
                                        <form action="{{ route('admin.lomba.destroy', $competition->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus lomba ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-200 rounded">
                                                <i class="uil uil-trash-alt text-2xl"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    @if (!empty($search))
                                        Lomba dengan nama "{{ $search }}" tidak ditemukan.
                                    @else
                                        Belum ada data lomba.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pt-4">
                {{ $competitions->links() }}
            </div>

        </div>
    </div>
</x-admin-layout>
