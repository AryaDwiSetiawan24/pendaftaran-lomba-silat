<x-admin-layout>
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-red-900 transition">Dashboard</a>
            <i class="uil uil-angle-right mx-2"></i>
            <a href="{{ route('admin.lomba') }}" class="hover:text-red-900 transition">Lomba</a>
            <i class="uil uil-angle-right mx-2"></i>
            <span class="text-red-900 font-semibold">Edit Lomba</span>
        </div>
    </div>

    <div class="bg-white shadow rounded-xl p-6">
        <h2 class="text-xl font-bold text-red-900 mb-4">Edit Data Lomba</h2>

        <form action="{{ route('admin.lomba.update', $competition->id) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lomba</label>
                <input type="text" name="name" value="{{ old('name', $competition->name) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent"
                    required>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="5"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent">{{ old('description', $competition->description) }}</textarea>
            </div>

            <!-- Tanggal -->
            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Lomba</label>
                    <input type="datetime-local" name="competition_date"
                        value="{{ old('competition_date', $competition->competition_date->format('Y-m-d\TH:i')) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pendaftaran Mulai</label>
                    <input type="datetime-local" name="registration_start_date"
                        value="{{ old('registration_start_date', $competition->registration_start_date->format('Y-m-d\TH:i')) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pendaftaran Berakhir</label>
                    <input type="datetime-local" name="registration_end_date"
                        value="{{ old('registration_end_date', $competition->registration_end_date->format('Y-m-d\TH:i')) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900"
                        required>
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <select name="status"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900">
                    @foreach (['akan_datang', 'dibuka', 'ditutup', 'selesai'] as $status)
                        <option value="{{ $status }}"
                            {{ old('status', $competition->status) == $status ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Logo Lomba -->
            <div>
                <label for="competition_logo" class="block text-sm font-semibold text-gray-700 mb-2">
                    Logo Lomba
                </label>

                <!-- Input file -->
                <input type="file" id="competition_logo" name="competition_logo" accept="image/*"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent">

                @error('competition_logo')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="uil uil-exclamation-triangle mr-1"></i> {{ $message }}
                    </p>
                @enderror

                <!-- Tampilkan logo lama jika ada -->
                @if ($competition->competition_logo)
                    <div class="mt-3">
                        <p class="text-sm text-gray-600 mb-1">Logo saat ini:</p>
                        <img src="{{ asset('storage/' . $competition->competition_logo) }}" alt="Logo Lomba"
                            class="h-24 rounded-lg shadow-md border border-gray-200">
                    </div>
                @endif

                <p class="mt-1 text-xs text-gray-500">Opsional — unggah logo baru jika ingin mengganti.</p>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.lomba') }}"
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit"
                    class="px-6 py-3 bg-red-900 text-white rounded-lg hover:bg-red-800 shadow-lg hover:shadow-xl">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
