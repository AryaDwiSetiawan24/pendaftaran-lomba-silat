<x-peserta-layout>
    <!-- Header dengan search -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Pendaftaran Saya</h2>
            <p class="text-sm text-gray-500">Daftar peserta yang telah Anda daftarkan dalam lomba ini.</p>
        </div>

        <!-- Form Pencarian -->
        <form action="{{ url()->current() }}" method="GET" class="w-full sm:w-auto">
            <div class="flex items-center gap-2">
                <input type="text" name="search"
                    class="w-full sm:w-64 pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                    placeholder="Cari nama, NIK, kontingen..." value="{{ request('search') }}">

                <button type="submit"
                    class="px-4 py-2 bg-red-800 text-white rounded-lg hover:bg-red-700 font-semibold text-sm transition">
                    <i class="uil uil-search"></i>
                    <span class="hidden sm:inline ml-1">Cari</span>
                </button>

                @if (request('search'))
                    <a href="{{ url()->current() }}"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold text-sm transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="mb-4">
        <a href="{{ route('peserta.dashboard') }}"
            class="inline-flex items-center text-gray-600 hover:text-red-800 text-sm font-medium transition">
            <i class="uil uil-angle-left mr-1"></i> Kembali ke Dashboard
        </a>
    </div>

    @if ($participants->isEmpty())
        <div class="bg-white p-10 rounded-xl shadow text-center text-gray-500">
            <i class="uil uil-invoice text-5xl mb-2"></i>
            <p>Belum ada peserta yang didaftarkan.</p>
            <a href="{{ route('peserta.dashboard') }}"
                class="text-red-700 font-semibold hover:underline mt-2 inline-block">
                Daftar Lomba Sekarang
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <!-- Desktop table -->
            <div class="hidden sm:block overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                <table class="w-full text-sm">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama Peserta
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kontingen</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Lomba</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($participants as $index => $p)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                    {{ $participants->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    {{ $p->full_name }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $p->kontingen ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $p->competition->name }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $p->category }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                            'approved' => 'bg-green-50 text-green-700 border-green-200',
                                            'rejected' => 'bg-red-50 text-red-700 border-red-200',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $statusConfig[$p->validation_status] ?? 'bg-gray-50 text-gray-700 border-gray-200' }}">
                                        {{ ucfirst($p->validation_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('peserta.pendaftaran.show', $p->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-xs font-medium shadow-sm">
                                            Detail
                                        </a>
                                        <a href="{{ route('peserta.pendaftaran.edit', $p->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-amber-500 text-white rounded-md hover:bg-amber-600 text-xs font-medium shadow-sm">
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile -->
            <div class="sm:hidden divide-y divide-gray-200">
                @foreach ($participants as $p)
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $p->full_name }}</h3>
                            <span
                                class="text-xs px-2 py-1 rounded-full {{ $p->validation_status === 'approved'
                                    ? 'bg-green-100 text-green-700'
                                    : ($p->validation_status === 'pending'
                                        ? 'bg-yellow-100 text-yellow-700'
                                        : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($p->validation_status) }}
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm"><strong>Kontingen:</strong> {{ $p->kontingen ?? '-' }}</p>
                        <p class="text-gray-600 text-sm"><strong>Lomba:</strong> {{ $p->competition->name }}</p>
                        <p class="text-gray-600 text-sm"><strong>Kategori:</strong> {{ $p->category }}</p>

                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('peserta.pendaftaran.show', $p->id) }}"
                                class="flex-1 text-center px-3 py-2 text-sm bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 font-semibold">
                                Detail
                            </a>
                            <a href="{{ route('peserta.pendaftaran.edit', $p->id) }}"
                                class="flex-1 text-center px-3 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-semibold">
                                Edit
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $participants->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    @endif
</x-peserta-layout>
