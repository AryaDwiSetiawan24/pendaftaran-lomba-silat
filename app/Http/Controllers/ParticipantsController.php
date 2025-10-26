<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Participant;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ParticipantsExport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ParticipantsController extends Controller
{
    // Metode Admin
    /**
     * Menampilkan halaman daftar peserta dengan filter dan statistik.
     */
    public function peserta(Request $request)
    {
        // Ambil data untuk filter dropdown
        $competitions = Competition::orderBy('name')->get();

        // Mulai Query untuk statistik (dihitung sebelum filter)
        $totalPeserta = Participant::count();
        $pendingCount = Participant::where('validation_status', 'pending')->count();
        $approvedCount = Participant::where('validation_status', 'approved')->count();
        $rejectedCount = Participant::where('validation_status', 'rejected')->count();

        // Mulai Query utama untuk daftar peserta
        $query = Participant::with('competition'); // Eager load relasi competition

        // Terapkan Filter: Search
        $query->when($request->search, function ($q, $search) {
            $q->where(function ($subq) use ($search) {
                $subq->where('full_name', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            });
        });

        // Terapkan Filter: Competition
        $query->when($request->competition_id, function ($q, $competitionId) {
            $q->where('competition_id', $competitionId);
        });

        // Terapkan Filter: Status
        $query->when($request->status, function ($q, $status) {
            $q->where('validation_status', $status);
        });

        // Terapkan Filter: Kategori
        $query->when($request->category, function ($q, $category) {
            $q->where('category', $category);
        });

        // Terapkan Filter: Gender
        $query->when($request->gender, function ($q, $gender) {
            $q->where('gender', $gender);
        });

        // Ambil hasil dengan paginasi
        $peserta = $query->latest()->paginate(15)->withQueryString(); // withQueryString agar filter tetap ada saat ganti halaman

        return view('pages.admin.peserta', compact(
            'peserta',
            'competitions',
            'totalPeserta',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    /**
     * Menampilkan detail peserta untuk Modal (via AJAX).
     */
    public function showPeserta(Participant $participant)
    {
        $participant->load('competition');
        return view('pages.admin.pendaftar.show', compact('participant'));
    }

    /**
     * Menyetujui pendaftaran peserta.
     */
    public function approve(Participant $participant)
    {
        $participant->update(['validation_status' => 'approved']);
        return redirect()->back()->with('success', 'Pendaftaran peserta telah disetujui.');
    }

    /**
     * Menolak pendaftaran peserta.
     */
    public function reject(Participant $participant)
    {
        $participant->update(['validation_status' => 'rejected']);
        return redirect()->back()->with('success', 'Pendaftaran peserta telah ditolak.');
    }

    /**
     * Menghapus data peserta.
     */
    public function destroy(Participant $participant)
    {
        try {
            // Hapus file bukti bayar jika ada
            if ($participant->bukti_bayar) {
                Storage::delete($participant->bukti_bayar);
            }

            $participant->delete();

            return redirect()->back()->with('success', 'Data peserta telah dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function editPeserta(Participant $participant)
    {
        // $participant = Participant::with('competition')->findOrFail($id);
        $categories = [
            'USIA DINI (SD)',
            'PRA REMAJA (SMP)',
            'REMAJA (SMA/K/MA)',
            'DEWASA (MAHASISWA/UMUM)',
        ];

        return view('pages.admin.pendaftar.edit', compact('participant', 'categories'));
    }

    public function updatePeserta(Request $request, $id)
    {
        $participant = Participant::findOrFail($id);

        $validated = $request->validate([
            'category' => ['required', 'string', 'max:255'],
            'body_weight' => ['required', 'numeric', 'min:20', 'max:120'],
            'validation_status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
        ], [
            'category.required' => 'Kategori harus diisi.',
            'body_weight.required' => 'Berat badan harus diisi.',
            'validation_status.required' => 'Status validasi harus diisi.',
        ]);

        $weightClass = $this->getWeightClass(
            $validated['category'],
            $participant->gender,
            $validated['body_weight']
        );

        if (!$weightClass) {
            return back()->withInput()->withErrors([
                'body_weight' => 'Berat badan tidak sesuai dengan kategori usia yang dipilih.',
            ]);
        }

        $participant->update([
            'category' => $validated['category'],
            'body_weight' => $validated['body_weight'],
            'weight_class' => $weightClass,
            'validation_status' => $validated['validation_status'],
        ]);

        return redirect()->route('admin.peserta')
            ->with('success', 'Data peserta berhasil diperbarui.');
    }

    // export data peserta ke excel
    public function export()
    {
        return Excel::download(new ParticipantsExport, 'daftar-peserta-' . date('Y-m-d') . '.xlsx');
    }

    // Dashboard peserta
    public function index()
    {
        $participants = auth()->user()->participants()
            ->with('competition')
            ->latest()
            ->get();

        return view('pages.peserta.lomba.pendaftaran-peserta', compact('participants'));
    }

    public function showParticipant($id)
    {
        $participant = Participant::where('user_id', auth()->id())
            ->with('competition')
            ->findOrFail($id);

        return view('pages.peserta.lomba.pendaftaran-show', compact('participant'));
    }

    // Detail lomba
    public function show($competition_id)
    {
        $competition = Competition::with('participants')->findOrFail($competition_id);
        return view('pages.peserta.lomba.show', compact('competition'));
    }

    // Form pendaftaran
    public function create($competition_id)
    {
        $competition = Competition::findOrFail($competition_id);
        return view('pages.peserta.lomba.daftar', compact('competition'));
    }

    // Menyimpan data peserta baru
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'kontingen' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:L,P',
            'nik' => [
                'required',
                'digits:16',
                // NIK harus unik untuk setiap kompetisi
                Rule::unique('participants')->where(function ($query) use ($request) {
                    return $query->where('competition_id', $request->competition_id);
                }),
            ],
            'category' => 'required|string|max:255',
            'body_weight' => 'required|numeric|min:20|max:120', // Input baru
            'phone_number' => 'required|string|max:15',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            // Pesan error kustom:
            'nik.unique' => 'NIK ini sudah terdaftar pada kompetisi ini.',
            'nik.digits' => 'NIK harus berjumlah 16 digit.',
            'bukti_bayar.image' => 'File bukti bayar harus berupa gambar (jpg, jpeg, png).',
        ]);

        try {
            // 2. Tentukan Kelas Tanding berdasarkan Berat Badan
            $weightClass = $this->getWeightClass(
                $request->category,
                $request->gender,
                $request->body_weight
            );

            // 3. Handle Jika Berat Badan Tidak Masuk Kategori Manapun
            if (!$weightClass) {
                return back()->withInput()->withErrors([
                    'body_weight' => 'Berat badan tidak sesuai dengan kategori usia yang dipilih.'
                ]);
            }

            // 4. Proses Upload File Bukti Bayar
            $path = null;
            if ($request->hasFile('bukti_bayar')) {
                $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
            }

            // 5. Simpan Data ke Database
            Participant::create([
                'user_id' => auth()->id(),
                'competition_id' => $request->competition_id,
                'kontingen' => $request->kontingen,
                'full_name' => $request->full_name,
                'place_of_birth' => $request->place_of_birth,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'nik' => $request->nik,
                'category' => $request->category,
                'body_weight' => $request->body_weight,
                'weight_class' => $weightClass,
                'phone_number' => $request->phone_number,
                'bukti_bayar' => $path,
            ]);

            return redirect()->route('peserta.pendaftaran.index')
                ->with('success', 'Pendaftaran peserta berhasil disimpan.');
        } catch (\Exception $e) {
            // Jika terjadi error lain, kembalikan ke halaman sebelumnya dengan pesan error
            return back()->with('failed', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Helper function untuk menentukan kelas tanding.
     */
    private function getWeightClass(string $category, string $gender, float $weight): ?string
    {
        $class = null;
        switch ($category) {
            case 'USIA DINI (SD)':
                if ($weight >= 26 && $weight <= 28) $class = 'A';
                elseif ($weight > 28 && $weight <= 30) $class = 'B';
                elseif ($weight > 30 && $weight <= 32) $class = 'C';
                elseif ($weight > 32 && $weight <= 34) $class = 'D';
                elseif ($weight > 34 && $weight <= 36) $class = 'E';
                elseif ($weight > 36 && $weight <= 38) $class = 'F';
                elseif ($weight > 38 && $weight <= 40) $class = 'G';
                elseif ($weight > 40 && $weight <= 42) $class = 'H';
                elseif ($weight > 42 && $weight <= 44) $class = 'I';
                break;
            case 'PRA REMAJA (SMP)':
                if ($weight >= 30 && $weight <= 33) $class = 'A';
                elseif ($weight > 33 && $weight <= 36) $class = 'B';
                elseif ($weight > 36 && $weight <= 39) $class = 'C';
                elseif ($weight > 39 && $weight <= 42) $class = 'D';
                elseif ($weight > 42 && $weight <= 45) $class = 'E';
                elseif ($weight > 45 && $weight <= 48) $class = 'F';
                elseif ($weight > 48 && $weight <= 51) $class = 'G';
                elseif ($weight > 51 && $weight <= 54) $class = 'H';
                elseif ($weight > 54 && $weight <= 57) $class = 'I';
                break;
            case 'REMAJA (SMA/K/MA)':
                if ($weight >= 39 && $weight <= 43) $class = 'A';
                elseif ($weight > 43 && $weight <= 47) $class = 'B';
                elseif ($weight > 47 && $weight <= 51) $class = 'C';
                elseif ($weight > 51 && $weight <= 55) $class = 'D';
                elseif ($weight > 55 && $weight <= 59) $class = 'E';
                elseif ($weight > 59 && $weight <= 63) $class = 'F';
                elseif ($weight > 63 && $weight <= 67) $class = 'G';
                elseif ($weight > 67 && $weight <= 71) $class = 'H';
                elseif ($weight > 71 && $weight <= 75) $class = 'I';
                break;
            case 'DEWASA (MAHASISWA/UMUM)':
                if ($gender == 'L') {
                    if ($weight >= 45 && $weight <= 50) $class = 'A';
                    elseif ($weight > 50 && $weight <= 55) $class = 'B';
                    elseif ($weight > 55 && $weight <= 60) $class = 'C';
                    elseif ($weight > 60 && $weight <= 65) $class = 'D';
                    elseif ($weight > 65 && $weight <= 70) $class = 'E';
                    elseif ($weight > 70 && $weight <= 75) $class = 'F';
                    elseif ($weight > 75 && $weight <= 80) $class = 'G';
                    elseif ($weight > 80 && $weight <= 85) $class = 'H';
                    elseif ($weight > 85 && $weight <= 90) $class = 'I';
                    elseif ($weight > 90 && $weight <= 95) $class = 'J';
                } elseif ($gender == 'P') {
                    if ($weight >= 45 && $weight <= 50) $class = 'A';
                    elseif ($weight > 50 && $weight <= 55) $class = 'B';
                    elseif ($weight > 55 && $weight <= 60) $class = 'C';
                    elseif ($weight > 60 && $weight <= 65) $class = 'D';
                    elseif ($weight > 65 && $weight <= 70) $class = 'E';
                    elseif ($weight > 70 && $weight <= 75) $class = 'F';
                }
                break;
        }
        return $class;
    }

    public function edit(Participant $participant)
    {
        // Pastikan hanya user yang mendaftarkan bisa mengedit datanya
        if ($participant->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit peserta ini.');
        }

        $competitions = Competition::where('status', 'dibuka')->get();

        return view('pages.peserta.lomba.peserta-edit', compact('participant', 'competitions'));
    }

    public function update(Request $request, Participant $participant)
    {
        if ($participant->user_id !== auth()->id()) {
            abort(403);
        }

        // 1. Validasi Input (diubah ke 'body_weight')
        $validatedData = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'kontingen' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:L,P',
            'nik' => [
                'required',
                'digits:16',
                Rule::unique('participants')
                    ->where(fn($query) => $query->where('competition_id', $request->competition_id))
                    ->ignore($participant->id),
            ],
            'category' => 'required|string|max:255',
            'body_weight' => 'required|numeric|min:20|max:120', // <-- DIUBAH
            'phone_number' => 'required|string|max:15',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar pada lomba yang sama.',
        ]);

        // 2. Tentukan Ulang Kelas Tanding
        $weightClass = $this->getWeightClass(
            $request->category,
            $request->gender,
            $request->body_weight
        );

        // 3. Handle Jika Berat Badan Tidak Masuk Kategori
        if (!$weightClass) {
            return back()->withInput()->withErrors([
                'body_weight' => 'Berat badan tidak sesuai dengan kategori usia yang dipilih.'
            ]);
        }

        // 4. Proses Upload File (Logika Anda sudah benar)
        $path = $participant->bukti_bayar;
        if ($request->hasFile('bukti_bayar')) {
            if ($participant->bukti_bayar) {
                Storage::disk('public')->delete($participant->bukti_bayar);
            }
            $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
        }

        // 5. Update Data ke Database
        $participant->update([
            'competition_id' => $request->competition_id,
            'kontingen' => $request->kontingen,
            'full_name' => $request->full_name,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'nik' => $request->nik,
            'category' => $request->category,
            'body_weight' => $request->body_weight,   // <-- DITAMBAHKAN
            'weight_class' => $weightClass,          // <-- DIUBAH
            'phone_number' => $request->phone_number,
            'bukti_bayar' => $path,
        ]);

        return redirect()->route('peserta.pendaftaran.index')->with('success', 'Data peserta berhasil diperbarui.');
    }
}
