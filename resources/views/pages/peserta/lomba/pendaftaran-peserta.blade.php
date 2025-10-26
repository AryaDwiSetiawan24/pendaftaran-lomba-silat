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
            <div class="hidden sm:block">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Nama Peserta</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Kontingen</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Lomba</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Kategori</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Status Validasi</th>
                            <th class="px-6 py-3 text-center font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($participants as $p)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 font-semibold text-gray-800">{{ $p->id }}</td>
                                <td class="px-6 py-3 font-semibold text-gray-800">{{ $p->full_name }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $p->kontingen ?? '-' }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $p->competition->name }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $p->category }}</td>
                                <td class="px-6 py-3">
                                    @php
                                        $colors = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'approved' => 'bg-green-100 text-green-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $colors[$p->validation_status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($p->validation_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 space-x-2">
                                    <a href="{{ route('peserta.pendaftaran.show', $p->id) }}"
                                        class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 font-semibold text-sm">
                                        Detail
                                    </a>
                                    <a href="{{ route('peserta.pendaftaran.edit', $p->id) }}"
                                        class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 text-sm">
                                        Edit
                                    </a>
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
                            <span class="text-xs px-2 py-1 rounded-full {{ 
                                $p->validation_status === 'approved' ? 'bg-green-100 text-green-700' :
                                ($p->validation_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')
                            }}">
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
        </div>
    @endif
</x-peserta-layout>
