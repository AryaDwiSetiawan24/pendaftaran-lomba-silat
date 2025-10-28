<x-peserta-layout>
    <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
        <h2 class="text-2xl font-bold text-gray-800">Pendaftaran Saya</h2>
        <a href="{{ route('peserta.dashboard') }}" class="text-gray-600 hover:text-red-800 text-sm sm:text-base">
            <i class="uil uil-angle-left"></i> Kembali ke Dashboard
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
        <!-- Wrapper responsif -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <!-- Hanya tampil di layar besar -->
            <div class="hidden sm:block overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                <table class="w-full text-sm">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                No</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nama Peserta</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Kontingen</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Lomba</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Kategori</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($participants as $p)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">{{ $p->id }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $p->full_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600">{{ $p->kontingen ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-700">{{ $p->competition->name }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-700">{{ $p->category }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusConfig = [
                                            'pending' => [
                                                'bg' => 'bg-yellow-50',
                                                'text' => 'text-yellow-700',
                                                'border' => 'border-yellow-200',
                                            ],
                                            'approved' => [
                                                'bg' => 'bg-green-50',
                                                'text' => 'text-green-700',
                                                'border' => 'border-green-200',
                                            ],
                                            'rejected' => [
                                                'bg' => 'bg-red-50',
                                                'text' => 'text-red-700',
                                                'border' => 'border-red-200',
                                            ],
                                        ];
                                        $config = $statusConfig[$p->validation_status] ?? [
                                            'bg' => 'bg-gray-50',
                                            'text' => 'text-gray-700',
                                            'border' => 'border-gray-200',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                        {{ ucfirst($p->validation_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('peserta.pendaftaran.show', $p->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-150 font-medium text-xs shadow-sm">
                                            Detail
                                        </a>
                                        <a href="{{ route('peserta.pendaftaran.edit', $p->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-amber-500 text-white rounded-md hover:bg-amber-600 transition-colors duration-150 font-medium text-xs shadow-sm">
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tampilan mobile -->
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
                {{ $participants->links() }}
            </div>
        </div>
    @endif
</x-peserta-layout>
