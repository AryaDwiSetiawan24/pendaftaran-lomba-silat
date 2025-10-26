<x-admin-layout>
    <div class="mb-6 flex items-center text-sm text-gray-600">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-red-900">Dashboard</a>
        <i class="uil uil-angle-right mx-2"></i>
        <a href="{{ route('admin.peserta') }}" class="hover:text-red-900">Daftar Peserta</a>
        <i class="uil uil-angle-right mx-2"></i>
        <span class="text-red-900 font-semibold">Edit Peserta</span>
    </div>

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Peserta</h2>

        <form action="{{ route('admin.peserta.update', $participant->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category" class="w-full border rounded-lg px-3 py-2">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ $participant->category == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Berat Badan (kg)</label>
                    <input type="number" step="0.01" name="body_weight"
                        value="{{ old('body_weight', $participant->body_weight) }}"
                        class="w-full border rounded-lg px-3 py-2">
                    @error('body_weight')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Validasi</label>
                    <select name="validation_status" class="w-full border rounded-lg px-3 py-2">
                        <option value="pending" {{ $participant->validation_status == 'pending' ? 'selected' : '' }}>
                            Pending</option>
                        <option value="approved" {{ $participant->validation_status == 'approved' ? 'selected' : '' }}>
                            Disetujui</option>
                        <option value="rejected" {{ $participant->validation_status == 'rejected' ? 'selected' : '' }}>
                            Ditolak</option>
                    </select>
                    @error('validation_status')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.peserta') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
