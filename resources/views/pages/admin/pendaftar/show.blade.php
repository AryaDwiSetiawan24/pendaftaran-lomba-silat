<x-admin-layout>
    <!-- Breadcrumb -->
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-red-900 transition">Dashboard</a>
            <i class="uil uil-angle-right mx-2"></i>
            <a href="{{ route('admin.peserta') }}" class="hover:text-red-900 transition">Daftar Peserta</a>
            <i class="uil uil-angle-right mx-2"></i>
            <span class="text-red-900 font-semibold">Detail Peserta</span>
        </div>
    </div>

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detail Peserta</h1>
        <p class="text-gray-600 mt-2">Informasi lengkap peserta lomba</p>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Main Info Card -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-red-700 to-red-800 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <i class="uil uil-user mr-2"></i>
                        Informasi Pribadi
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nama
                                Lengkap</label>
                            <p class="text-gray-800 font-semibold mt-1">{{ $participant->full_name }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kontingen</label>
                            <p class="text-gray-800 font-semibold mt-1">{{ $participant->kontingen }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">NIK</label>
                            <p class="text-gray-800 font-semibold mt-1">{{ $participant->nik }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">No. Telepon</label>
                            <p class="text-gray-800 font-semibold mt-1 flex items-center">
                                <i class="uil uil-phone mr-1 text-gray-400"></i>
                                {{ $participant->phone_number }}
                            </p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Jenis
                                Kelamin</label>
                            <p class="text-gray-800 font-semibold mt-1">
                                @if ($participant->gender == 'L')
                                    <span class="inline-flex items-center">
                                        <i class="uil uil-mars text-blue-600 mr-1"></i>
                                        Laki-laki
                                    </span>
                                @else
                                    <span class="inline-flex items-center">
                                        <i class="uil uil-venus text-pink-600 mr-1"></i>
                                        Perempuan
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Competition Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-700 to-purple-800 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <i class="uil uil-trophy mr-2"></i>
                        Informasi Lomba
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nama Lomba</label>
                            <p class="text-gray-800 font-semibold mt-1">{{ $participant->competition->name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kategori</label>
                            <p class="text-gray-800 font-semibold mt-1">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-lg bg-purple-50 text-purple-700">
                                    {{ $participant->category }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kelas Berat</label>
                            <p class="text-gray-800 font-semibold mt-1">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-50 text-blue-700">
                                    <i class="uil uil-weight mr-1"></i>
                                    {{ $participant->weight_class }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Status
                                Validasi</label>
                            <p class="mt-1">
                                @if ($participant->validation_status == 'approved')
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg bg-green-50 text-green-700 font-semibold">
                                        <i class="uil uil-check-circle mr-1"></i>
                                        Disetujui
                                    </span>
                                @elseif ($participant->validation_status == 'rejected')
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg bg-red-50 text-red-700 font-semibold">
                                        <i class="uil uil-times-circle mr-1"></i>
                                        Ditolak
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg bg-yellow-50 text-yellow-700 font-semibold">
                                        <i class="uil uil-clock mr-1"></i>
                                        Pending
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Proof -->
            {{-- <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-700 to-green-800 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <i class="uil uil-receipt mr-2"></i>
                        Bukti Pembayaran
                    </h2>
                </div>
                <div class="p-6">
                    @if ($participant->payment_proof)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $participant->payment_proof) }}" alt="Bukti Pembayaran"
                                class="rounded-lg w-full max-w-md border-2 border-gray-200 shadow-sm hover:shadow-md transition">
                            <a href="{{ asset('storage/' . $participant->payment_proof) }}" target="_blank"
                                class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm hover:bg-white p-2 rounded-lg shadow-md transition opacity-0 group-hover:opacity-100">
                                <i class="uil uil-external-link-alt text-gray-700"></i>
                            </a>
                        </div>
                        <a href="{{ asset('storage/' . $participant->payment_proof) }}" target="_blank"
                            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 font-medium mt-3">
                            <i class="uil uil-eye mr-1"></i>
                            Lihat ukuran penuh
                        </a>
                    @else
                        <div class="text-center py-8">
                            <div
                                class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="uil uil-image-slash text-3xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada bukti pembayaran</p>
                        </div>
                    @endif
                </div>
            </div> --}}
        </div>

        <!-- Sidebar Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-6">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="uil uil-setting mr-2 text-gray-600"></i>
                    Aksi
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.peserta.edit', $participant->id) }}"
                        class="w-full inline-flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-3 rounded-lg transition font-medium shadow-sm">
                        <i class="uil uil-edit mr-2"></i>
                        Edit Peserta
                    </a>
                    <a href="{{ url()->previous() }}"
                        class="w-full inline-flex items-center justify-center bg-gray-500 hover:bg-gray-600 text-white px-4 py-3 rounded-lg transition font-medium shadow-sm">
                        <i class="uil uil-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>

                <!-- Additional Info -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Informasi Tambahan</h4>
                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="uil uil-calendar-alt mr-2 text-gray-400"></i>
                            <span>Terdaftar: {{ $participant->created_at->format('d M Y H:i:s') }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="uil uil-clock mr-2 text-gray-400"></i>
                            <span>Update: {{ $participant->updated_at->format('d M Y H:i:s') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
