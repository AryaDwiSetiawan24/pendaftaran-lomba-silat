<x-peserta-layout>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header Bar -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Detail Peserta</h2>
                        <p class="text-blue-100 text-sm mt-1">Informasi lengkap pendaftaran lomba</p>
                    </div>
                    @php
                        $statusConfig = [
                            'pending' => [
                                'bg' => 'bg-yellow-100',
                                'text' => 'text-yellow-700',
                                'border' => 'border-yellow-300',
                                'icon' => 'uil-clock',
                            ],
                            'approved' => [
                                'bg' => 'bg-green-100',
                                'text' => 'text-green-700',
                                'border' => 'border-green-300',
                                'icon' => 'uil-check-circle',
                            ],
                            'rejected' => [
                                'bg' => 'bg-red-100',
                                'text' => 'text-red-700',
                                'border' => 'border-red-300',
                                'icon' => 'uil-times-circle',
                            ],
                        ];
                        $status = $statusConfig[$participant->validation_status] ?? [
                            'bg' => 'bg-gray-100',
                            'text' => 'text-gray-700',
                            'border' => 'border-gray-300',
                            'icon' => 'uil-question-circle',
                        ];
                    @endphp
                    <div
                        class="flex items-center gap-2 px-4 py-2 rounded-lg border-2 {{ $status['bg'] }} {{ $status['border'] }}">
                        <i class="uil {{ $status['icon'] }} text-xs lg:text-lg {{ $status['text'] }}"></i>
                        <span class="font-semibold {{ $status['text'] }}">
                            {{ ucfirst($participant->validation_status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Informasi Peserta -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="uil uil-user text-blue-600"></i>
                        Informasi Peserta
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nama
                                Lengkap</label>
                            <p class="text-gray-900 font-semibold text-lg">{{ $participant->full_name }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">NIK</label>
                            <p class="text-gray-900 font-semibold">{{ $participant->nik ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kontingen</label>
                            <p class="text-gray-900 font-semibold">{{ $participant->kontingen ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nomor HP</label>
                            <p class="text-gray-900 font-semibold">{{ $participant->phone_number }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Jenis
                                Kelamin</label>
                            <p class="text-gray-900 font-semibold">
                                {{ $participant->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tanggal
                                Lahir</label>
                            <p class="text-gray-900 font-semibold">
                                {{ \Carbon\Carbon::parse($participant->birth_date)->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 my-8"></div>

                <!-- Informasi Lomba -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="uil uil-trophy text-blue-600"></i>
                        Informasi Lomba
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nama Lomba</label>
                            <p class="text-gray-900 font-semibold">{{ $participant->competition->name }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kategori</label>
                            <p class="text-gray-900 font-semibold">{{ $participant->category }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Berat Badan</label>
                            <p class="text-gray-900 font-semibold">{{ $participant->body_weight }} kg</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kelas Berat</label>
                            <p class="text-gray-900 font-semibold">{{ $participant->weight_class }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bukti Pembayaran -->
                {{-- @if ($participant->bukti_bayar)
                    <div class="border-t border-gray-200 pt-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="uil uil-receipt text-blue-600"></i>
                            Bukti Pembayaran
                        </h3>
                        <div class="bg-gray-50 rounded-lg p-4 inline-block">
                            <img src="{{ asset('storage/' . $participant->bukti_bayar) }}" alt="Bukti Pembayaran"
                                class="max-w-md w-full rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 cursor-pointer"
                                onclick="window.open(this.src, '_blank')">
                            <p class="text-xs text-gray-500 mt-2 text-center">Klik gambar untuk memperbesar</p>
                        </div>
                    </div>
                @else
                    <div class="border-t border-gray-200 pt-8">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <i class="uil uil-exclamation-triangle text-yellow-600 text-xl mt-0.5"></i>
                                <div>
                                    <p class="font-semibold text-yellow-800">Bukti Pembayaran Belum Diunggah</p>
                                    <p class="text-sm text-yellow-700 mt-1">Silakan unggah bukti pembayaran untuk
                                        memproses pendaftaran Anda.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif --}}

                <!-- Action Buttons -->
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ url()->previous() }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-150 font-medium">
                        <i class="uil uil-arrow-left"></i>
                        Kembali
                    </a>
                    <a href="{{ route('peserta.pendaftaran.edit', $participant->id) }}"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-150 font-semibold shadow-sm">
                        <i class="uil uil-edit"></i>
                        Edit Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-peserta-layout>
