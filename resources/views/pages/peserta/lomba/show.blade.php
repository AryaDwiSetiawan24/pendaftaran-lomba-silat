<x-peserta-layout>
    <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
        <h2 class="text-2xl font-bold text-gray-800">Detail Lomba</h2>
        <a href="{{ route('peserta.dashboard') }}" class="text-gray-600 hover:text-red-800 text-sm sm:text-base">
            <i class="uil uil-angle-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 pb-6 border-b">
            <div class="flex items-center space-x-4">
                @if ($competition->competition_logo)
                    <img src="{{ asset('storage/' . $competition->competition_logo) }}"
                        class="w-16 h-16 rounded-lg object-contain border p-1 bg-gray-50" alt="Logo Lomba">
                @endif
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $competition->name }}</h1>
                    <p class="text-gray-500 text-sm">
                        {{ $competition->competition_date ? $competition->competition_date->format('d M Y, H:i') : 'Belum dijadwalkan' }}
                    </p>
                </div>
            </div>

            <a href="{{ route('peserta.lomba.daftar', $competition->id) }}"
                class="mt-4 sm:mt-0 inline-block bg-red-900 hover:bg-red-800 text-white px-6 py-2 rounded-lg font-semibold transition text-center">
                Daftar Sekarang
            </a>
        </div>

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
                <p class="text-gray-600">{{ $competition->participants_count }} Peserta</p>
            </div>
            <!-- Status Badge -->
            @php
                $now = now();
                $isOpen = $now->between($competition->registration_start_date, $competition->registration_end_date);
                $isComing = $now->lt($competition->registration_start_date);
                $isClosed = $now->gt($competition->registration_end_date);
            @endphp

            <div class="bg-gray-50 p-4 rounded-lg border">
                <p class="font-semibold text-gray-800">Status</p>
                <div class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-semibold">
                    @if ($isOpen)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            Pendaftaran Dibuka
                        </span>
                    @elseif ($isComing)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                            <i class="uil uil-clock-three mr-1"></i>
                            Akan Dibuka
                        </span>
                    @elseif ($isClosed)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 border border-gray-200">
                            <i class="uil uil-lock mr-1"></i>
                            Pendaftaran Ditutup
                        </span>
                    @endif
                </div>

                {{-- <span @class([
                    'inline-block mt-1 px-3 py-1 rounded-full text-xs font-semibold',
                    'bg-green-100 text-green-800' => $competition->status === 'dibuka',
                    'bg-gray-200 text-gray-800' => $competition->status === 'ditutup',
                    'bg-yellow-100 text-yellow-800' => $competition->status === 'akan_datang',
                ])>
                    {{ ucfirst(str_replace('_', ' ', $competition->status)) }}
                </span> --}}
            </div>
        </div>

        <div class="prose max-w-none text-gray-700 leading-relaxed mb-10">
            {!! $competition->description !!}
        </div>

        @php
            $categories = ['USIA DINI 1 (SD)', 'USIA DINI 2 (SD)', 'PRA REMAJA (SMP)', 'REMAJA (SMA/K/MA)'];
        @endphp
        <div class="bg-white rounded-xl shadow-sm border p-6 mt-6">
            <h3 class="text-lg font-semibold mb-4">Jumlah Peserta per Kategori</h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($categories as $cat)
                    <div class="p-4 border bg-gray-50 rounded-lg text-center">
                        <p class="text-gray-700 font-semibold">{{ $cat }}</p>
                        {{-- DIUBAH: Mengambil data langsung dari array, jika tidak ada, tampilkan 0 --}}
                        <p class="text-2xl font-bold text-red-800 mt-1">{{ $categoryCounts[$cat] ?? 0 }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-10">
            <div class="flex items-center justify-between mb-4 flex-wrap gap-y-2">
                <h2 class="text-xl font-bold text-gray-800">Peserta yang Anda Daftarkan</h2>
                <form action="{{ url()->current() }}" method="GET" class="w-full sm:w-auto">
                    <div class="flex items-center gap-2">
                        <input type="text" name="search"
                            class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                            placeholder="Cari nama, NIK, dll..." value="{{ request('search') }}">

                        <button type="submit"
                            class="px-4 py-2 bg-red-800 text-white rounded-lg hover:bg-red-700 font-semibold transition">
                            Cari
                        </button>

                        {{-- Tombol Reset hanya muncul jika ada pencarian aktif --}}
                        @if (request('search'))
                            <a href="{{ url()->current() }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            @php
                $statusStyles = [
                    'approved' => 'bg-green-100 text-green-800 border-green-200',
                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                    'rejected' => 'bg-red-100 text-red-800 border-red-200',
                    'default' => 'bg-gray-100 text-gray-800 border-gray-200',
                ];
            @endphp

            @forelse ($myParticipants as $participant)
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 sm:p-5 mb-4 hover:shadow-md transition-shadow duration-300">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <h3 class="text-lg font-bold text-red-900 truncate pr-4">{{ $participant->full_name }}
                                </h3>
                                <span
                                    class="sm:hidden inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusStyles[$participant->validation_status] ?? $statusStyles['default'] }}">
                                    {{ ucfirst($participant->validation_status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">
                                Kontingen: <span
                                    class="font-medium text-gray-700">{{ $participant->kontingen ?? '-' }}</span>
                            </p>
                        </div>
                        <div class="hidden sm:flex items-center gap-6 text-sm text-center">
                            <div>
                                <div class="text-gray-500 text-xs">Kategori</div>
                                <div class="font-semibold text-gray-800">{{ $participant->category }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500 text-xs">Kelas Berat</div>
                                <div class="font-semibold text-gray-800">{{ $participant->weight_class }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500 text-xs">Status</div>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full font-semibold {{ $statusStyles[$participant->validation_status] ?? $statusStyles['default'] }}">
                                    {{ ucfirst($participant->validation_status) }}
                                </span>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-end gap-2 border-t sm:border-t-0 pt-3 sm:pt-0 mt-3 sm:mt-0">
                            <a href="{{ route('peserta.pendaftaran.show', $participant->id) }}"
                                class="px-3 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-sm font-semibold transition"
                                title="Lihat Detail">
                                <i class="uil uil-eye"></i> <span class="hidden sm:inline">Detail</span>
                            </a>
                            @if ($participant->validation_status != 'approved')
                                <a href="{{ route('peserta.pendaftaran.edit', $participant->id) }}"
                                    class="px-3 py-2 bg-yellow-500 text-white hover:bg-yellow-600 rounded-lg text-sm font-semibold transition"
                                    title="Edit Pendaftaran">
                                    <i class="uil uil-edit-alt"></i> <span class="hidden sm:inline">Edit</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="sm:hidden grid grid-cols-2 gap-3 mt-4 pt-3 border-t border-gray-100 text-sm">
                        <div>
                            <p class="text-gray-500 text-xs">Kategori</p>
                            <p class="font-semibold text-gray-800">{{ $participant->category }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Kelas Berat</p>
                            <p class="font-semibold text-gray-800">{{ $participant->weight_class }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-gray-50 border-2 border-dashed border-gray-200 p-8 rounded-lg text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                        <i class="uil uil-user-minus text-4xl text-red-600"></i>
                    </div>
                    <p class="text-lg font-semibold text-gray-700">Anda belum mendaftarkan peserta.</p>
                    <p class="text-gray-500 mt-1">Klik tombol "Daftar Sekarang" di atas untuk menambahkan peserta baru.
                    </p>
                </div>
            @endforelse

            @if ($myParticipants->hasPages())
                <div class="mt-6">
                    {{ $myParticipants->links() }}
                </div>
            @endif
        </div>
    </div>
</x-peserta-layout>
