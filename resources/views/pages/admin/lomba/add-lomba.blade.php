<x-admin-layout>
    <!-- Breadcrumb -->
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-red-900 transition">Dashboard</a>
            <i class="uil uil-angle-right mx-2"></i>
            <a href="{{ route('admin.lomba') }}" class="hover:text-red-900 transition">Lomba</a>
            <i class="uil uil-angle-right mx-2"></i>
            <span class="text-red-900 font-semibold">Tambah Lomba Baru</span>
        </div>
    </div>

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Lomba Baru</h1>
        <p class="text-gray-600 mt-2">Isi informasi lengkap tentang lomba silat yang akan diselenggarakan</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-red-900 to-orange-800">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="uil uil-trophy text-yellow-400 text-2xl mr-3"></i>
                Informasi Lomba
            </h2>
        </div>

        <form action="{{ route('admin.store-lomba') }}" method="POST" class="p-6" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <!-- Nama Lomba -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lomba <span class="text-red-600">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        placeholder="Contoh: Kejuaraan Nasional Silat 2025"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent transition"
                        required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="uil uil-exclamation-triangle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Berikan nama yang jelas dan menarik untuk lomba</p>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi Lomba
                    </label>
                    <textarea id="description" name="description" rows="6"
                        placeholder="Jelaskan detail lomba, kategori yang dilombakan, persyaratan peserta, hadiah, dll."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent transition resize-none">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="uil uil-exclamation-triangle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Opsional - Berikan informasi detail tentang lomba untuk calon
                        peserta</p>
                </div>

                <!-- Tanggal Lomba -->
                <div>
                    <label for="competition_date" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal Lomba <span class="text-red-600">*</span>
                    </label>
                    <input type="datetime-local" id="competition_date" name="competition_date"
                        value="{{ old('competition_date', isset($competition) ? $competition->competition_date->format('Y-m-d\TH:i') : '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 transition" required>
                    @error('competition_date')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="uil uil-exclamation-triangle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Tanggal/ waktu pelaksanaan lomba.</p>
                </div>

                <!-- Tanggal Pendaftaran -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Tanggal Mulai -->
                    <div>
                        <label for="registration_start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="uil uil-calendar-alt text-red-900"></i>
                            Tanggal Mulai Pendaftaran <span class="text-red-600">*</span>
                        </label>
                        <input type="datetime-local" id="registration_start_date" name="registration_start_date"
                            value="{{ old('registration_start_date') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent transition"
                            required>
                        @error('registration_start_date')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="uil uil-exclamation-triangle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tanggal Akhir -->
                    <div>
                        <label for="registration_end_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="uil uil-calendar-alt text-red-900"></i>
                            Tanggal Akhir Pendaftaran <span class="text-red-600">*</span>
                        </label>
                        <input type="datetime-local" id="registration_end_date" name="registration_end_date"
                            value="{{ old('registration_end_date') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent transition"
                            required>
                        @error('registration_end_date')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="uil uil-exclamation-triangle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="uil uil-info-circle text-red-900"></i>
                        Status Lomba <span class="text-red-600">*</span>
                    </label>
                    <select id="status" name="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent transition"
                        required>
                        <option value="akan_datang" {{ old('status') == 'akan_datang' ? 'selected' : '' }}>
                            Akan Datang
                        </option>
                        <option value="dibuka" {{ old('status') == 'dibuka' ? 'selected' : '' }}>
                            Dibuka
                        </option>
                        <option value="ditutup" {{ old('status') == 'ditutup' ? 'selected' : '' }}>
                            Ditutup
                        </option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="uil uil-exclamation-triangle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Pilih status awal lomba yang akan dibuat</p>
                </div>

                <!-- Upload Logo Lomba -->
                <div>
                    <label for="competition_logo" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="uil uil-image text-red-900"></i>
                        Logo Lomba
                    </label>
                    <input type="file" id="competition_logo" name="competition_logo" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-900 focus:border-transparent transition">

                    @error('competition_logo')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="uil uil-exclamation-triangle mr-1"></i> {{ $message }}
                        </p>
                    @enderror

                    <p class="mt-1 text-xs text-gray-500">
                        Opsional — unggah logo lomba (format JPG, JPEG, atau PNG, maksimal 2MB).
                    </p>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="uil uil-lightbulb-alt text-blue-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-blue-800 mb-1">Tips Pendaftaran</h3>
                            <p class="text-sm text-blue-700">
                                Pastikan periode pendaftaran dibuka cukup lama (minimal 2-4 minggu) untuk memberikan
                                waktu
                                calon peserta mempersiapkan diri dan dokumen yang diperlukan.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.lomba') }}"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold text-center inline-flex items-center justify-center">
                        <i class="uil uil-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-red-900 text-white rounded-lg hover:bg-red-800 transition font-semibold inline-flex items-center justify-center shadow-lg hover:shadow-xl">
                        <i class="uil uil-check mr-2"></i>
                        Simpan Lomba
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Success Message (if exists) -->
    @if (session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center z-50"
            id="successAlert">
            <i class="uil uil-check-circle text-2xl mr-3"></i>
            <div>
                <p class="font-semibold">Berhasil!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
            <button onclick="document.getElementById('successAlert').remove()"
                class="ml-4 text-white hover:text-gray-200">
                <i class="uil uil-times text-xl"></i>
            </button>
        </div>

        <script>
            setTimeout(() => {
                const alert = document.getElementById('successAlert');
                if (alert) {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            }, 5000);
        </script>
    @endif

    <!-- Client-side Validation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const startDate = document.getElementById('registration_start_date');
            const endDate = document.getElementById('registration_end_date');

            // Validate dates on change
            endDate.addEventListener('change', function() {
                if (startDate.value && endDate.value) {
                    if (new Date(endDate.value) <= new Date(startDate.value)) {
                        endDate.setCustomValidity('Tanggal akhir harus setelah tanggal mulai');
                        endDate.reportValidity();
                    } else {
                        endDate.setCustomValidity('');
                    }
                }
            });

            startDate.addEventListener('change', function() {
                if (endDate.value) {
                    endDate.dispatchEvent(new Event('change'));
                }
            });

            // Form submission confirmation
            form.addEventListener('submit', function(e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    return;
                }

                // Optional: Add confirmation dialog
                // if (!confirm('Apakah Anda yakin ingin menyimpan lomba ini?')) {
                //     e.preventDefault();
                // }
            });
        });
    </script>
</x-admin-layout>
