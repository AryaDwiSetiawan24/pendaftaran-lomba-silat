<x-admin-layout>
    <!-- Breadcrumb -->
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-red-900 transition">Dashboard</a>
            <i class="uil uil-angle-right mx-2"></i>
            <a href="{{ route('admin.jadwal.index') }}" class="hover:text-red-900 transition">Jadwal Pertandingan</a>
            <i class="uil uil-angle-right mx-2"></i>
            <span class="text-red-900 font-semibold">Kelola Pool</span>
        </div>
    </div>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Pool Peserta</h1>
            <p class="text-gray-600 mt-2">
                Atur pembagian peserta dalam pool sebelum membuat jadwal pertandingan.
            </p>
        </div>
    </div>

    <!-- Informasi Lomba -->
    <div class="bg-white p-6 rounded-2xl shadow mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $competition->name }}</h2>
        <p class="text-gray-600">{{ $competition->description }}</p>
        <p class="text-sm text-gray-500 mt-2">
            Tanggal Lomba: {{ \Carbon\Carbon::parse($competition->competition_date)->format('d M Y') }}
        </p>
        <div class="flex items-center justify-between mt-4">
            <form action="{{ route('admin.jadwal.generate-pools', $competition->id) }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    Generate Pool
                </button>
            </form>
        </div>
    </div>

    <!-- Daftar Peserta -->
    {{-- <div class="bg-white p-6 rounded-2xl shadow mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Peserta</h2>
            
        </div>

        @if ($participants->isEmpty())
            <p class="text-gray-500 text-sm">Belum ada peserta yang terdaftar dalam lomba ini.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border-b text-left">No</th>
                            <th class="px-4 py-2 border-b text-left">Nama Peserta</th>
                            <th class="px-4 py-2 border-b text-left">Kontingen</th>
                            <th class="px-4 py-2 border-b text-left">Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($participants as $index => $participant)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border-b">{{ $participant->full_name }}</td>
                                <td class="px-4 py-2 border-b">{{ $participant->kontingen ?? '-' }}</td>
                                <td class="px-4 py-2 border-b">{{ ucfirst($participant->gender) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div> --}}

    <!-- Jika pool sudah terbentuk -->
    @if ($pools->isNotEmpty())
        <div class="bg-white p-6 rounded-2xl shadow mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Hasil Pembagian Pool</h2>

            @foreach ($pools->groupBy('pool') as $poolName => $group)
                <div class="mb-6">
                    <h3 class="text-md font-semibold text-red-800 mb-2">Pool {{ $poolName }}</h3>
                    <ul class="list-disc list-inside text-gray-700">
                        @foreach ($group as $p)
                            <li>{{ $p->participant->full_name }} : {{ $p->participant->weight_class }} : {{ $p->participant->category }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            <form action="{{ route('admin.jadwal.generateMatches', $competition->id) }}" method="POST"
                onsubmit="return confirm('Buat ulang jadwal pertandingan? Jadwal lama akan dihapus!')">
                @csrf
                <button type="submit"
                    class="inline-flex items-center bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-lg transition text-sm font-semibold">
                    <i class="uil uil-plus mr-2"></i> Lanjut Buat Jadwal Pertandingan
                </button>
            </form>
        </div>
    @endif
</x-admin-layout>
