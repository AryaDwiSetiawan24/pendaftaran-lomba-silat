<x-peserta-layout>
    <div class="bg-white rounded-xl shadow p-8">
        <!-- Header lomba -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div class="flex items-center space-x-4">
                @if ($competition->competition_logo)
                    <img src="{{ asset('storage/' . $competition->competition_logo) }}"
                        class="w-16 h-16 rounded-lg object-cover" alt="Logo Lomba">
                @endif
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $competition->name }}</h1>
                    <p class="text-gray-500 text-sm">
                        {{ $competition->competition_date ? $competition->competition_date->format('d M Y, H:i') : 'Belum dijadwalkan' }}
                    </p>
                </div>
            </div>
            <a href="{{ route('peserta.lomba.daftar', $competition->id) }}"
                class="mt-4 sm:mt-0 inline-block bg-red-900 hover:bg-red-800 text-white px-6 py-2 rounded-lg font-semibold transition">
                Daftar Sekarang
            </a>
        </div>

        <!-- Info dasar lomba -->
        <div class="grid sm:grid-cols-3 gap-4 mb-8 text-sm text-gray-700">
            <div class="bg-gray-50 p-4 rounded-lg border">
                <p class="font-semibold text-gray-800">Periode Pendaftaran</p>
                <p class="text-gray-600">
                    {{ $competition->registration_start_date->format('d M Y') }} –
                    {{ $competition->registration_end_date->format('d M Y') }}
                </p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg border">
                <p class="font-semibold text-gray-800">Jumlah Peserta Terdaftar</p>
                <p class="text-gray-600">{{ $competition->participants->count() }} Peserta</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg border">
                <p class="font-semibold text-gray-800">Status</p>
                <span @class([
                    'inline-block mt-1 px-3 py-1 rounded-full text-xs font-semibold',
                    'bg-green-100 text-green-800' => $competition->status === 'dibuka',
                    'bg-gray-200 text-gray-800' => $competition->status === 'ditutup',
                    'bg-yellow-100 text-yellow-800' => $competition->status === 'akan_datang',
                    'bg-blue-100 text-blue-800' => !in_array($competition->status, [
                        'dibuka',
                        'ditutup',
                        'akan_datang',
                    ]),
                ])>
                    {{ ucfirst(str_replace('_', ' ', $competition->status)) }}
                </span>
            </div>
        </div>

        <!-- Rekap kategori -->
        @php
            $categories = ['USIA DINI (SD)', 'PRA REMAJA (SMP)', 'REMAJA (SMA/K/MA)', 'DEWASA (MAHASISWA/UMUM)'];
        @endphp

        <div class="bg-white rounded-xl shadow p-6 mt-6">
            <h3 class="text-lg font-semibold mb-4">Jumlah Peserta per Kategori</h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($categories as $cat)
                    @php
                        $count = $competition->participants
                            ->filter(fn($p) => strtoupper(trim($p->category)) === strtoupper($cat))
                            ->count();
                    @endphp
                    <div class="p-4 border rounded-lg text-center">
                        <p class="text-gray-700 font-semibold">{{ $cat }}</p>
                        <p class="text-2xl font-bold text-red-800 mt-1">{{ $count }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Deskripsi lomba -->
        <div class="text-gray-700 leading-relaxed mb-10">
            {!! $competition->description !!}
        </div>

        <!-- Peserta milik user -->
        <div class="mt-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Peserta yang Anda Daftarkan</h2>

            @php
                $myParticipants = $competition->participants->where('user_id', auth()->id());
            @endphp

            @if ($myParticipants->isEmpty())
                <div class="bg-gray-50 border border-gray-200 p-6 rounded-lg text-gray-500 text-center">
                    <i class="uil uil-user-minus text-4xl mb-2"></i>
                    <p>Belum ada peserta yang Anda daftarkan untuk lomba ini.</p>
                    <a href="{{ route('peserta.lomba.daftar', $competition->id) }}"
                        class="text-red-700 hover:underline font-semibold mt-2 inline-block">
                        Tambah Peserta Sekarang
                    </a>
                </div>
            @else
                <div class="hidden sm:block">
                    <div class="overflow-x-auto bg-white border border-gray-200 rounded-xl shadow-sm">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 font-medium text-gray-600 uppercase">Nama</th>
                                    <th class="px-6 py-3 font-medium text-gray-600 uppercase">Kontingen</th>
                                    <th class="px-6 py-3 font-medium text-gray-600 uppercase">Kategori</th>
                                    <th class="px-6 py-3 font-medium text-gray-600 uppercase">Kelas Berat</th>
                                    <th class="px-6 py-3 font-medium text-gray-600 uppercase">Status</th>
                                    <th class="px-6 py-3 font-medium text-gray-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($myParticipants as $p)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-3 font-semibold text-gray-800">{{ $p->full_name }}</td>
                                        <td class="px-6 py-3 text-gray-600">{{ $p->kontingen ?? '-' }}</td>
                                        <td class="px-6 py-3 text-gray-600">{{ $p->category }}</td>
                                        <td class="px-6 py-3 text-gray-600">{{ $p->weight_class }}</td>
                                        <td class="px-6 py-3">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                                    'approved' => 'bg-green-100 text-green-700',
                                                    'rejected' => 'bg-red-100 text-red-700',
                                                ];
                                            @endphp
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$p->validation_status] ?? 'bg-gray-100 text-gray-700' }}">
                                                {{ ucfirst($p->validation_status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-3 space-x-2">
                                            <a href="{{ route('peserta.pendaftaran.show', $p->id) }}"
                                                class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
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
                </div>
                <!-- Tampilan mobile -->
                <div class="sm:hidden mt-4 space-y-4">
                    @foreach ($myParticipants as $p)
                        <div class="p-4 border border-gray-200 rounded-lg shadow-sm">
                            <div class="flex justify-between items-start mb-1">
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
                            <p class="text-gray-600 text-sm"><strong>Kategori:</strong> {{ $p->category }}</p>
                            <p class="text-gray-600 text-sm"><strong>Kelas:</strong> {{ $p->weight_class }}</p>

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
            @endif
        </div>
    </div>
</x-peserta-layout>
