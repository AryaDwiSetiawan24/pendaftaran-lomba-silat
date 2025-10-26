{{-- <x-admin-layout>
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-red-900 transition">Dashboard</a>
            <i class="uil uil-angle-right mx-2"></i>
            <a href="{{ route('admin.lomba') }}" class="hover:text-red-900 transition">Lomba</a>
            <i class="uil uil-angle-right mx-2"></i>
            <span class="text-red-900 font-semibold">{{ $competition->name }}</span>
        </div>
    </div>

    <div class="bg-white shadow rounded-xl p-6 space-y-4">
        <h2 class="text-xl font-bold text-red-900 mb-4">{{ $competition->name }}</h2>

        @if ($competition->competition_logo)
            <img src="{{ asset('storage/' . $competition->competition_logo) }}" alt="Logo {{ $competition->name }}"
                class="h-32 object-contain mb-4 rounded-lg border">
        @endif

        <p class="text-gray-700"><strong>Deskripsi:</strong></p>
        <p class="text-gray-600">{{ $competition->description ?? '-' }}</p>

        <div class="grid md:grid-cols-2 gap-6 mt-4">
            <div>
                <p class="font-semibold text-gray-700 mb-1">Tanggal Lomba</p>
                <p class="text-gray-600">{{ $competition->competition_date->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700 mb-1">Periode Pendaftaran</p>
                <p class="text-gray-600">
                    {{ $competition->registration_start_date->format('d M Y') }} –
                    {{ $competition->registration_end_date->format('d M Y') }}
                </p>
            </div>
        </div>

        <div class="mt-4">
            <p class="font-semibold text-gray-700 mb-1">Status</p>
            <span @class([
                'px-3 py-1 rounded-full text-xs font-semibold',
                'bg-green-100 text-green-800' => $competition->status == 'dibuka',
                'bg-gray-200 text-gray-800' => $competition->status == 'ditutup',
                'bg-yellow-100 text-yellow-800' => $competition->status == 'akan_datang',
                'bg-blue-100 text-blue-800' => !in_array($competition->status, [
                    'dibuka',
                    'ditutup',
                    'akan_datang',
                ]),
            ])>
                {{ ucfirst(str_replace('_', ' ', $competition->status)) }}
            </span>

        </div>

        <div class="pt-6 border-t flex justify-end space-x-3">
            <a href="{{ route('admin.lomba.edit', $competition->id) }}"
                class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                <i class="uil uil-pen mr-1"></i> Edit
            </a>
            <a href="{{ route('admin.lomba') }}"
                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                Kembali
            </a>
        </div>
    </div>
</x-admin-layout> --}}

<x-admin-layout>
    {{-- Breadcrumbs --}}
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-red-900 transition">Dashboard</a>
            <i class="uil uil-angle-right mx-2"></i>
            <a href="{{ route('admin.lomba') }}" class="hover:text-red-900 transition">Lomba</a>
            <i class="uil uil-angle-right mx-2"></i>
            <span class="text-red-900 font-semibold">{{ $competition->name }}</span>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="bg-white shadow rounded-xl p-6 md:p-8">

        {{-- Card Header --}}
        <h2 class="text-2xl font-bold text-red-900 mb-6">{{ $competition->name }}</h2>

        {{-- Main Grid Layout (Content & Sidebar) --}}
        <div class="grid grid-cols-1 md:grid-cols-12 md:gap-8">

            {{-- Kolom Konten Utama (Kiri) --}}
            <div class="md:col-span-8 space-y-6">

                {{-- Logo --}}
                @if ($competition->competition_logo)
                    <div class="bg-gray-50 border rounded-lg p-4 flex justify-center">
                        <img src="{{ asset('storage/' . $competition->competition_logo) }}"
                            alt="Logo {{ $competition->name }}" class="h-40 max-w-full object-contain rounded-lg">
                    </div>
                @endif

                {{-- Deskripsi --}}
                <div>
                    <p class="text-lg font-semibold text-gray-800 mb-2">Deskripsi Lomba</p>
                    <div class="prose prose-sm max-w-none text-gray-600">
                        {!! $competition->description
                            ? nl2br(e($competition->description))
                            : '<p class="text-gray-400 italic">Tidak ada deskripsi.</p>' !!}
                    </div>
                </div>
            </div>

            {{-- Kolom Sidebar (Kanan) --}}
            <div class="md:col-span-4 space-y-5 mt-6 md:mt-0">

                {{-- Status --}}
                <div>
                    <p class="font-semibold text-gray-700 mb-1">Status</p>
                    <span @class([
                        'px-3 py-1 rounded-full text-xs font-semibold',
                        'bg-green-100 text-green-800' => $competition->status == 'dibuka',
                        'bg-gray-200 text-gray-800' => $competition->status == 'ditutup',
                        'bg-yellow-100 text-yellow-800' => $competition->status == 'akan_datang',
                        'bg-blue-100 text-blue-800' => !in_array($competition->status, [
                            'dibuka',
                            'ditutup',
                            'akan_datang',
                        ]),
                    ])>
                        {{ ucfirst(str_replace('_', ' ', $competition->status)) }}
                    </span>
                </div>

                {{-- **BARU: Jumlah Peserta Terdaftar** --}}
                <div>
                    <p class="font-semibold text-gray-700 mb-1">Peserta Terdaftar</p>
                    <p class="text-3xl font-bold text-red-900">
                        {{-- Asumsi Anda memuat 'participants_count' dari controller --}}
                        {{ $competition->participants_count ?? 0 }}
                        <span class="text-xl font-medium text-gray-600">Peserta</span>
                    </p>
                </div>

                {{-- Tanggal Lomba --}}
                <div>
                    <p class="font-semibold text-gray-700 mb-1">Tanggal Lomba</p>
                    <p class="text-gray-600">{{ $competition->competition_date->format('d M Y, H:i') }} WIB</p>
                </div>

                {{-- Periode Pendaftaran --}}
                <div>
                    <p class="font-semibold text-gray-700 mb-1">Periode Pendaftaran</p>
                    <p class="text-gray-600">
                        {{ $competition->registration_start_date->format('d M Y') }} –
                        {{ $competition->registration_end_date->format('d M Y') }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Card Footer (Actions) --}}
        <div class="pt-6 border-t flex justify-end space-x-3 mt-8">
            <a href="{{ route('admin.lomba.edit', $competition->id) }}"
                class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                <i class="uil uil-pen mr-1"></i>
                Edit
            </a>
            <a href="{{ route('admin.lomba') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                Kembali
            </a>
        </div>

    </div>
</x-admin-layout>
