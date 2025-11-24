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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kelas/Berat</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Jenis Kelamin</th>
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
                                    <span
                                        class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs font-semibold">
                                        {{ $p->weight_class ?? '-' }}
                                    </span>
                                    <span class="font-medium text-gray-800">
                                        {{ $p->body_weight ? $p->body_weight . ' kg' : '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $p->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </td>
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

                                        @php
                                            $now = now();
                                            $isRegistrationOpen =
                                                $p->competition &&
                                                $now->between(
                                                    $p->competition->registration_start_date,
                                                    $p->competition->registration_end_date,
                                                );
                                        @endphp

                                        @if ($isRegistrationOpen)
                                            <a href="{{ route('peserta.pendaftaran.edit', $p->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-amber-500 text-white rounded-md hover:bg-amber-600 text-xs font-medium shadow-sm">
                                                Edit
                                            </a>

                                            {{-- Hapus --}}
                                            <form action="{{ route('peserta.pendaftaran.destroy', $p->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Anda yakin ingin menghapus peserta ini? Tindakan ini tidak dapat dibatalkan.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 text-xs font-medium shadow-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile -->
            <div class="sm:hidden divide-y divide-gray-200 bg-white rounded-lg shadow">
                @foreach ($participants as $p)
                    <div class="p-4">
                        <!-- Header dengan Nama dan Status -->
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h3 class="text-base font-bold text-gray-900 mb-1">
                                    {{ $p->full_name }}
                                </h3>
                                <div class="flex items-center gap-2">
                                    @if ($p->gender == 'L')
                                        <span
                                            class="inline-flex items-center text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded">
                                            <i class="uil uil-mars mr-1"></i> Laki-laki
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center text-xs font-medium text-pink-600 bg-pink-50 px-2 py-0.5 rounded">
                                            <i class="uil uil-venus mr-1"></i> Perempuan
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <span
                                class="text-xs font-semibold px-2.5 py-1 rounded-full whitespace-nowrap ml-2 {{ $p->validation_status === 'approved'
                                    ? 'bg-green-100 text-green-700'
                                    : ($p->validation_status === 'pending'
                                        ? 'bg-yellow-100 text-yellow-700'
                                        : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($p->validation_status) }}
                            </span>
                        </div>

                        <!-- Info Cards -->
                        <div class="space-y-2 mb-4">
                            <div class="bg-gray-50 rounded-lg p-2.5">
                                <p class="text-xs text-gray-500 mb-0.5">Kontingen</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $p->kontingen ?? '-' }}</p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-2.5">
                                <p class="text-xs text-gray-500 mb-0.5">Lomba</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $p->competition->name }}</p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-2.5">
                                <p class="text-xs text-gray-500 mb-0.5">Kategori</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $p->category }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('peserta.pendaftaran.show', $p->id) }}"
                                class="flex-1 text-center px-3 py-2.5 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition-colors">
                                <i class="uil uil-eye"></i> Detail
                            </a>
                            <a href="{{ route('peserta.pendaftaran.edit', $p->id) }}"
                                class="flex-1 text-center px-3 py-2.5 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-semibold transition-colors">
                                <i class="uil uil-edit"></i> Edit
                            </a>
                            <form action="{{ route('peserta.pendaftaran.destroy', $p->id) }}" method="POST"
                                onsubmit="return confirm('Anda yakin ingin menghapus peserta ini? Tindakan ini tidak dapat dibatalkan.');"
                                class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full text-center px-3 py-2.5 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition-colors">
                                    <i class="uil uil-trash"></i> Hapus
                                </button>
                            </form>
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
