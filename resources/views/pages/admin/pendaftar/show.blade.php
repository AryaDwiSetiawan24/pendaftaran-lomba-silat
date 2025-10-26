<x-admin-layout>
    <div class="mb-6 flex items-center text-sm text-gray-600">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-red-900">Dashboard</a>
        <i class="uil uil-angle-right mx-2"></i>
        <a href="{{ route('admin.peserta') }}" class="hover:text-red-900">Daftar Peserta</a>
        <i class="uil uil-angle-right mx-2"></i>
        <span class="text-red-900 font-semibold">Detail Peserta</span>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Detail Peserta</h2>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <p><strong>Nama Lengkap:</strong> {{ $participant->full_name }}</p>
                <p><strong>NIK:</strong> {{ $participant->nik }}</p>
                <p><strong>No. HP:</strong> {{ $participant->phone_number }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ $participant->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                <p><strong>Kelas:</strong> {{ $participant->weight_class }}</p>
            </div>
            <div>
                <p><strong>Lomba:</strong> {{ $participant->competition->name ?? '-' }}</p>
                <p><strong>Kategori:</strong> {{ $participant->category }}</p>
                <p><strong>Status:</strong>
                    @if ($participant->validation_status == 'approved')
                        <span class="text-green-600 font-semibold">Disetujui</span>
                    @elseif ($participant->validation_status == 'rejected')
                        <span class="text-red-600 font-semibold">Ditolak</span>
                    @else
                        <span class="text-yellow-600 font-semibold">Pending</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold text-gray-800 mb-2">Bukti Pembayaran</h3>
            @if ($participant->payment_proof)
                <img src="{{ asset('storage/' . $participant->payment_proof) }}" alt="Bukti Bayar"
                    class="rounded-lg max-w-sm border">
            @else
                <p class="text-gray-500">Belum ada bukti pembayaran</p>
            @endif
        </div>

        <div class="mt-6 flex gap-3">
            <a href="{{ route('admin.peserta.edit', $participant->id) }}"
                class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                Edit
            </a>
            <a href="{{ route('admin.peserta') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Kembali
            </a>
        </div>
    </div>
</x-admin-layout>
