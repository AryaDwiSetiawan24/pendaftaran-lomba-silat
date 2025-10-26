<x-peserta-layout>
    <h2 class="text-2xl font-bold text-red-900 mb-6">Edit Data Peserta</h2>

    <form action="{{ route('peserta.pendaftaran.update', $participant->id) }}" method="POST" enctype="multipart/form-data"
        class="bg-white shadow rounded-xl p-6 space-y-4">
        @csrf
        @method('PUT')

        <!-- Pilih Lomba -->
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Lomba</label>
            <select name="competition_id"
                class="w-full border rounded-lg px-3 py-2 @error('competition_id') border-red-500 @enderror">
                @foreach ($competitions as $competition)
                    <option value="{{ $competition->id }}"
                        {{ old('competition_id', $participant->competition_id) == $competition->id ? 'selected' : '' }}>
                        {{ $competition->name }}
                    </option>
                @endforeach
            </select>
            @error('competition_id')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nama Lengkap -->
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Nama Lengkap</label>
            <input type="text" name="full_name" value="{{ old('full_name', $participant->full_name) }}"
                class="w-full border rounded-lg px-3 py-2 @error('full_name') border-red-500 @enderror">
            @error('full_name')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kontingen -->
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Asal Sekolah / Klub (Kontingen)</label>
            <input type="text" name="kontingen" value="{{ old('kontingen', $participant->kontingen) }}"
                class="w-full border rounded-lg px-3 py-2 @error('kontingen') border-red-500 @enderror">
            @error('kontingen')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Tempat Lahir</label>
                <input type="text" name="place_of_birth"
                    value="{{ old('place_of_birth', $participant->place_of_birth) }}"
                    class="w-full border rounded-lg px-3 py-2 @error('place_of_birth') border-red-500 @enderror">
                @error('place_of_birth')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Tanggal Lahir</label>
                <input type="date" name="date_of_birth"
                    value="{{ old('date_of_birth', $participant->date_of_birth->format('Y-m-d')) }}"
                    class="w-full border rounded-lg px-3 py-2 @error('date_of_birth') border-red-500 @enderror">
                @error('date_of_birth')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Jenis Kelamin</label>
                <select name="gender"
                    class="w-full border rounded-lg px-3 py-2 @error('gender') border-red-500 @enderror">
                    <option value="L" {{ old('gender', $participant->gender) == 'L' ? 'selected' : '' }}>
                        Laki-laki</option>
                    <option value="P" {{ old('gender', $participant->gender) == 'P' ? 'selected' : '' }}>
                        Perempuan</option>
                </select>
                @error('gender')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">NIK</label>
                <input type="text" name="nik" value="{{ old('nik', $participant->nik) }}"
                    class="w-full border rounded-lg px-3 py-2 @error('nik') border-red-500 @enderror">
                @error('nik')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Kategori</label>
                <input type="text" name="category" value="{{ old('category', $participant->category) }}"
                    class="w-full border rounded-lg px-3 py-2 @error('category') border-red-500 @enderror">
                @error('category')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Berat Badan (kg)</label>
                    <input type="number" step="0.01" name="body_weight"
                        value="{{ old('body_weight', $participant->body_weight) }}" placeholder="Contoh: 55.3"
                        class="w-full border rounded-lg px-3 py-2 @error('body_weight') border-red-500 @enderror"
                        required>
                    @error('body_weight')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Kelas Tanding Saat Ini</label>
                    {{-- Ini hanya untuk tampilan, tidak akan dikirim --}}
                    <input type="text" value="{{ $participant->weight_class }}"
                        class="w-full border rounded-lg px-3 py-2 bg-gray-100" readonly>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-1">Nomor HP</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', $participant->phone_number) }}"
                class="w-full border rounded-lg px-3 py-2 @error('phone_number') border-red-500 @enderror">
            @error('phone_number')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-1">Bukti Bayar</label>
            @if ($participant->bukti_bayar)
                <p class="text-sm text-gray-600 mb-2">File saat ini:</p>
                <img src="{{ asset('storage/' . $participant->bukti_bayar) }}" class="h-32 rounded-lg mb-2"
                    alt="Bukti bayar">
            @endif
            <input type="file" name="bukti_bayar"
                class="w-full border rounded-lg px-3 py-2 @error('bukti_bayar') border-red-500 @enderror">
            @error('bukti_bayar')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end pt-4 space-x-3">
            <a href="{{ route('peserta.pendaftaran.index') }}"
                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100">Batal</a>
            <button type="submit" class="px-4 py-2 bg-red-900 text-white rounded-lg hover:bg-red-800">Simpan
                Perubahan</button>
        </div>
    </form>
</x-peserta-layout>
