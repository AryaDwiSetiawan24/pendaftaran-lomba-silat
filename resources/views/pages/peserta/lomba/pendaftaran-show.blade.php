<x-peserta-layout>
    <div class="bg-white rounded-xl shadow p-8">
        <h2 class="text-2xl font-bold mb-6">Detail Peserta</h2>

        <div class="grid grid-cols-2 gap-4">
            <p><strong>Nama Lengkap:</strong> {{ $participant->full_name }}</p>
            <p><strong>Kontingen:</strong> {{ $participant->kontingen ?? '-' }}</p>
            <p><strong>Lomba:</strong> {{ $participant->competition->name }}</p>
            <p><strong>Kategori:</strong> {{ $participant->category }}</p>
            <p><strong>Berat Badan:</strong> {{ $participant->body_weight }}</p>
            <p><strong>Kelas Berat:</strong> {{ $participant->weight_class }}</p>
            <p><strong>Nomor HP:</strong> {{ $participant->phone_number }}</p>
            <p><strong>Status:</strong>
                <span
                    class="font-semibold text-{{ $participant->validation_status == 'approved' ? 'green' : ($participant->validation_status == 'pending' ? 'yellow' : 'red') }}-600">
                    {{ ucfirst($participant->validation_status) }}
                </span>
            </p>
        </div>

        @if ($participant->bukti_bayar)
            <div class="mt-6">
                <p class="font-semibold text-gray-700 mb-2">Bukti Pembayaran:</p>
                <img src="{{ asset('storage/' . $participant->bukti_bayar) }}" class="w-64 rounded-lg shadow">
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('peserta.pendaftaran.index') }}" class="text-gray-600 hover:text-red-700">
                <i class="uil uil-angle-left"></i> Kembali
            </a>
        </div>
    </div>
</x-peserta-layout>
