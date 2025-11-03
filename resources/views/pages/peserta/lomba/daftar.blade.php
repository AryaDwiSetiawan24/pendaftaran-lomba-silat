<x-peserta-layout>
    <h2 class="text-2xl font-bold text-red-900 mb-6">Form Pendaftaran</h2>
    

    <div class="bg-white rounded-xl shadow p-8">
        <h2 class="text-2xl font-bold mb-6">{{ $competition->name }}</h2>

        <form action="{{ route('peserta.lomba.store', $competition->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Terjadi Kesalahan!</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <input type="hidden" name="competition_id" value="{{ $competition->id }}">

            <div>
                <label class="block text-sm font-medium text-gray-700">Asal Sekolah / Klub (Kontingen) <span
                        class="text-red-600">*</span></label>
                <input type="text" name="kontingen" class="w-full mt-1 border rounded-lg p-2"
                    value="{{ old('kontingen') }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap <span
                        class="text-red-600">*</span></label>
                <input type="text" name="full_name" value="{{ old('full_name') }}"
                    class="w-full mt-1 border rounded-lg p-2" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tempat Lahir <span
                            class="text-red-600">*</span></label>
                    <input type="text" name="place_of_birth" value="{{ old('place_of_birth') }}"
                        class="w-full mt-1 border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir <span
                            class="text-red-600">*</span></label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                        class="w-full mt-1 border rounded-lg p-2" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin <span
                            class="text-red-600">*</span></label>
                    <select name="gender" class="w-full mt-1 border rounded-lg p-2" required>
                        <option value="">Pilih</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="nik" class="block text-gray-700 font-semibold mb-1">NIK <span
                            class="text-red-600">*</span></label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-red-300 @error('nik') border-red-500 @enderror">
                    @error('nik')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kategori Usia <span
                            class="text-red-600">*</span></label>
                    <select name="category" class="w-full mt-1 border rounded-lg p-2" required>
                        <option value="">Pilih</option>
                        <option>USIA DINI 1 (SD)</option>
                        <option>USIA DINI 2 (SD)</option>
                        <option>PRA REMAJA (SMP)</option>
                        <option>REMAJA (SMA/K/MA)</option>
                        {{-- <option>DEWASA (MAHASISWA/UMUM)</option> --}}
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Berat Badan (kg) <span
                            class="text-red-600">*</span></label>
                    <input type="number" step="0.01" name="body_weight" value="{{ old('body_weight') }}"
                        placeholder="Contoh: 55.3" class="w-full mt-1 border rounded-lg p-2" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nomor Telepon / WA <span
                        class="text-red-600">*</span></label>
                <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                    class="w-full mt-1 border rounded-lg p-2" required>
            </div>

            {{-- <div>
                <label class="block text-sm font-medium text-gray-700">Upload Bukti Pembayaran</label>
                <input type="file" name="bukti_bayar" class="mt-1 w-full border rounded-lg p-2">
            </div> --}}

            {{-- <div>
                <label class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
                <textarea name="note" value="{{ old('notes') }}" rows="3" class="w-full mt-1 border rounded-lg p-2"></textarea>
            </div> --}}

            <div class="flex justify-end pt-4 space-x-3">
                <a href="{{ url()->previous() }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100">Batal</a>
                <button type="submit" class="px-4 py-2 bg-red-900 text-white rounded-lg hover:bg-red-800">Kirim
                    Pendaftaran</button>
            </div>
        </form>
    </div>
</x-peserta-layout>
