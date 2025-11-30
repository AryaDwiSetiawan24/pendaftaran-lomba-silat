<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Competition;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Exports\ParticipantsExport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ParticipantsController extends Controller
{
    // Metode Admin
    // Menampilkan halaman daftar peserta dengan filter dan statistik.
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
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhere('kontingen', 'like', "%{$search}%");
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
        $peserta = $query->oldest()->paginate(15)->withQueryString();

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
        // Ambil data lomba terkait
        $competition = $participant->competition;

        // Cek apakah waktu kompetisi sudah berakhir
        $now = now();
        if ($now->gt($competition->registration_end_date)) {
            return redirect()->back()->with('failed', 'Data peserta tidak dapat dihapus karena lomba sudah selesai.');
        }

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
        // Ambil data lomba terkait
        $competition = $participant->competition;

        // Cek apakah waktu kompetisi sudah berakhir
        $now = now();
        if ($now->gt($competition->registration_end_date)) {
            return redirect()->back()->with('failed', 'Data peserta tidak dapat diubah karena lomba sudah selesai.');
        }

        $categories = [
            'USIA DINI 1 (SD)',
            'USIA DINI 2 (SD)',
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
    public function index(Request $request)
    {
        $search = $request->input('search');

        $participants = auth()->user()->participants()
            ->with('competition')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'LIKE', "%{$search}%")
                        ->orWhere('nik', 'LIKE', "%{$search}%")
                        ->orWhere('phone_number', 'LIKE', "%{$search}%")
                        ->orWhere('kontingen', 'LIKE', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20);

        return view('pages.peserta.lomba.pendaftaran-peserta', compact('participants'));
    }


    public function showParticipant($id)
    {
        $participant = Participant::where('user_id', auth()->id())
            ->with('competition')
            ->findOrFail($id);

        return view('pages.peserta.lomba.pendaftaran-show', compact('participant'));
    }

    // Detail lomba dan peserta saya
    public function show(Request $request, $competition_id)
    {
        // Query untuk mengambil data lomba dan statistik peserta
        $competition = Competition::withCount('participants')->findOrFail($competition_id);
        $categoryCounts = Participant::where('competition_id', $competition_id)
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->pluck('total', 'category');

        // Ambil input pencarian
        $search = $request->input('search');

        // Mulai query untuk peserta milik user
        $myParticipantsQuery = Participant::where('competition_id', $competition_id)
            ->where('user_id', auth()->id());

        // Jika ada input pencarian, tambahkan kondisi WHERE
        if ($search) {
            $myParticipantsQuery->where(function ($query) use ($search) {
                $query->where('full_name', 'LIKE', "%{$search}%")
                    ->orWhere('nik', 'LIKE', "%{$search}%")
                    ->orWhere('phone_number', 'LIKE', "%{$search}%")
                    ->orWhere('kontingen', 'LIKE', "%{$search}%");
            });
        }

        // Terapkan urutan dan paginasi, lalu tambahkan query string ke link paginasi
        $myParticipants = $myParticipantsQuery->latest()->paginate(10, ['*'], 'peserta_page')
            ->appends($request->query());

        return view('pages.peserta.lomba.show', compact(
            'competition',
            'myParticipants',
            'categoryCounts'
        ));
    }

    // Form pendaftaran
    public function create($competition_id)
    {
        $competition = Competition::findOrFail($competition_id);

        // 🔒 Pembatasan waktu pendaftaran
        $now = Carbon::now();

        if ($now->lt($competition->registration_start_date)) {
            return redirect()->back()->with('failed', 'Pendaftaran belum dibuka.');
        }

        if ($now->gt($competition->registration_end_date)) {
            return redirect()->back()->with('failed', 'Pendaftaran sudah ditutup.');
        }

        return view('pages.peserta.lomba.daftar', compact('competition'));
    }

    // Simpan data pendaftaran
    public function store(Request $request)
    {
        $competition = Competition::findOrFail($request->competition_id);
        $now = Carbon::now();

        // 🔒 Pembatasan waktu
        if ($now->lt($competition->registration_start_date)) {
            return back()->with('failed', 'Pendaftaran belum dibuka.');
        }

        if ($now->gt($competition->registration_end_date)) {
            return back()->with('failed', 'Pendaftaran sudah ditutup.');
        }

        // ✅ 1. Validasi Input
        $validated = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'kontingen' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:L,P',
            'nik' => [
                'required',
                'digits:16',
                Rule::unique('participants')->where(function ($query) use ($request) {
                    return $query->where('competition_id', $request->competition_id);
                }),
            ],
            'category' => 'required|string|max:255',
            'body_weight' => 'required|numeric|min:20|max:120',
            'phone_number' => 'required|string|max:15',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'note' => 'nullable|string|max:1000',
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar pada kompetisi ini.',
            'nik.digits' => 'NIK harus berjumlah 16 digit.',
            'bukti_bayar.image' => 'File bukti bayar harus berupa gambar (jpg, jpeg, png).',
        ]);

        try {
            // ✅ 2. Cek apakah ada input mencurigakan (mengandung tag HTML)
            foreach ($validated as $key => $value) {
                if (is_string($value) && preg_match('/<[^>]*>/', $value)) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            $key => 'Input pada kolom "' . str_replace('_', ' ', $key) . '" mengandung karakter tidak valid.'
                        ])
                        ->with('failed', 'Input tidak valid: harap hapus tanda < atau > dari form.');
                }
            }

            // ✅ 3. Tentukan Kelas Tanding
            $weightClass = $this->getWeightClass(
                $request->category,
                $request->gender,
                $request->body_weight
            );

            if (!$weightClass) {
                return back()->withInput()->withErrors([
                    'body_weight' => 'Berat badan tidak sesuai dengan kategori usia yang dipilih.'
                ]);
            }

            // ✅ 4. Upload File (jika ada)
            $path = null;
            if ($request->hasFile('bukti_bayar')) {
                $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
            }

            // ✅ 5. Simpan ke Database (jika aman semua)
            Participant::create([
                'user_id'        => Auth::id(),
                'competition_id' => $validated['competition_id'],
                'kontingen'      => $validated['kontingen'] ?? null,
                'full_name'      => $validated['full_name'],
                'place_of_birth' => $validated['place_of_birth'],
                'date_of_birth'  => $validated['date_of_birth'],
                'gender'         => $validated['gender'],
                'nik'            => $validated['nik'],
                'category'       => $validated['category'],
                'body_weight'    => $validated['body_weight'],
                'weight_class'   => $weightClass,
                'phone_number'   => $validated['phone_number'],
                'bukti_bayar'    => $path,
                'note'           => $validated['note'] ?? null,
            ]);

            return redirect()->route('peserta.pendaftaran.index')
                ->with('success', 'Pendaftaran peserta berhasil disimpan.');
        } catch (\Exception $e) {
            // report($e);
            return back()->with('failed', 'Terjadi kesalahan sistem. Silakan coba lagi nanti.');
        }
    }

    /**
     * Helper function untuk menentukan kelas tanding.
     */
    private function getWeightClass(string $category, string $gender, float $weight): ?string
    {
        $class = null;

        switch ($category) {

            /** ===============================
             *  SD (Usia Dini) – Putra/Putri
             *  Kelas A s/d G
             *  Start 26–28, kelipatan 2 kg
             * =============================== */
            case 'USIA DINI 1 (SD)':
            case 'USIA DINI 2 (SD)':
                if ($weight >= 26 && $weight <= 28) $class = 'A';
                elseif ($weight > 28 && $weight <= 30) $class = 'B';
                elseif ($weight > 30 && $weight <= 32) $class = 'C';
                elseif ($weight > 32 && $weight <= 34) $class = 'D';
                elseif ($weight > 34 && $weight <= 36) $class = 'E';
                elseif ($weight > 36 && $weight <= 38) $class = 'F';
                elseif ($weight > 38 && $weight <= 40) $class = 'G';
                // Tidak ada H dan I untuk SD
                break;

            /** ====================================
             *  SMP Putra vs Putri berbeda kelas:
             *
             *  Putra: A – I   (9 kelas)
             *  Putri: A – H   (8 kelas)
             *
             *  Start: 30–33, kelipatan 3 kg
             * ==================================== */
            case 'PRA REMAJA (SMP)':

                if ($gender === 'L') { // PUTRA
                    if ($weight >= 30 && $weight <= 33) $class = 'A';
                    elseif ($weight > 33 && $weight <= 36) $class = 'B';
                    elseif ($weight > 36 && $weight <= 39) $class = 'C';
                    elseif ($weight > 39 && $weight <= 42) $class = 'D';
                    elseif ($weight > 42 && $weight <= 45) $class = 'E';
                    elseif ($weight > 45 && $weight <= 48) $class = 'F';
                    elseif ($weight > 48 && $weight <= 51) $class = 'G';
                    elseif ($weight > 51 && $weight <= 54) $class = 'H';
                    elseif ($weight > 54 && $weight <= 57) $class = 'I'; // Putra memiliki kelas I
                } elseif ($gender === 'P') { // PUTRI
                    if ($weight >= 30 && $weight <= 33) $class = 'A';
                    elseif ($weight > 33 && $weight <= 36) $class = 'B';
                    elseif ($weight > 36 && $weight <= 39) $class = 'C';
                    elseif ($weight > 39 && $weight <= 42) $class = 'D';
                    elseif ($weight > 42 && $weight <= 45) $class = 'E';
                    elseif ($weight > 45 && $weight <= 48) $class = 'F';
                    elseif ($weight > 48 && $weight <= 51) $class = 'G';
                    elseif ($weight > 51 && $weight <= 54) $class = 'H';
                    // Putri tidak memiliki kelas I
                }
                break;

            /** ================================================
             *  SMA Putra vs Putri:
             *
             *  Putra: A – H (8 kelas)
             *  Putri: A – G (7 kelas)
             *
             *  Start 39–43, kelipatan 4 kg
             * ================================================ */
            case 'REMAJA (SMA/K/MA)':

                if ($gender === 'L') { // PUTRA
                    if ($weight >= 39 && $weight <= 43) $class = 'A';
                    elseif ($weight > 43 && $weight <= 47) $class = 'B';
                    elseif ($weight > 47 && $weight <= 51) $class = 'C';
                    elseif ($weight > 51 && $weight <= 55) $class = 'D';
                    elseif ($weight > 55 && $weight <= 59) $class = 'E';
                    elseif ($weight > 59 && $weight <= 63) $class = 'F';
                    elseif ($weight > 63 && $weight <= 67) $class = 'G';
                    elseif ($weight > 67 && $weight <= 71) $class = 'H';
                } elseif ($gender === 'P') { // PUTRI
                    if ($weight >= 39 && $weight <= 43) $class = 'A';
                    elseif ($weight > 43 && $weight <= 47) $class = 'B';
                    elseif ($weight > 47 && $weight <= 51) $class = 'C';
                    elseif ($weight > 51 && $weight <= 55) $class = 'D';
                    elseif ($weight > 55 && $weight <= 59) $class = 'E';
                    elseif ($weight > 59 && $weight <= 63) $class = 'F';
                    elseif ($weight > 63 && $weight <= 67) $class = 'G';
                    // Tidak ada kelas H dan I
                }
                break;

            /** =============================
             * DEWASA (sudah benar)
             * ============================= */
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
                } else { // P
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

        // Ambil data kompetisi terkait
        $competition = Competition::findOrFail($participant->competition_id);

        // 🔒 Pembatasan waktu (berdasarkan status lomba atau waktu)
        if ($competition->status !== 'dibuka') {
            return redirect()->back()->with('failed', 'Pendaftaran untuk lomba ini sudah ditutup.');
        }

        // Jika ingin tambahan pembatasan waktu (opsional)
        if ($competition->registration_end_date && now()->greaterThan($competition->registration_end_date)) {
            return redirect()->back()->with('failed', 'Waktu pendaftaran untuk lomba ini telah berakhir.');
        }

        // 1) prioritas ke old() (nilai dari submit terakhir)
        $old = old('date_of_birth');

        if ($old) {
            // jika old dalam format Y-m-d, konversi ke d/m/Y supaya konsisten di UI
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $old)) {
                try {
                    $displayDate = Carbon::createFromFormat('Y-m-d', $old)->format('d/m/Y');
                } catch (\Exception $e) {
                    $displayDate = $old; // fallback
                }
            } else {
                // kalau sudah dalam d/m/Y atau bentuk lain, pakai apa adanya
                $displayDate = $old;
            }
        } else {
            // 2) tidak ada old() -> gunakan model value
            if (!empty($participant->date_of_birth)) {
                // kalau sudah instance Carbon (karena casts), langsung format
                if ($participant->date_of_birth instanceof \Carbon\Carbon) {
                    $displayDate = $participant->date_of_birth->format('d/m/Y');
                } else {
                    // jika string Y-m-d, konversi
                    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $participant->date_of_birth)) {
                        try {
                            $displayDate = Carbon::createFromFormat(
                                'Y-m-d',
                                $participant->date_of_birth,
                            )->format('d/m/Y');
                        } catch (\Exception $e) {
                            $displayDate = $participant->date_of_birth;
                        }
                    } else {
                        $displayDate = $participant->date_of_birth;
                    }
                }
            } else {
                $displayDate = '';
            }
        }

        $competitions = Competition::where('status', 'dibuka')->get();

        return view('pages.peserta.lomba.peserta-edit', compact('participant', 'competitions', 'displayDate'));
    }

    // update data pendaftaran oleh peserta itu sendiri
    public function update(Request $request, Participant $participant)
    {
        if ($participant->user_id !== auth()->id()) {
            abort(403);
        }

        // Ambil data kompetisi
        $competition = Competition::findOrFail($participant->competition_id);

        // 🔒 Cek status lomba
        if ($competition->status !== 'dibuka') {
            return redirect()->route('peserta.pendaftaran.index')
                ->with('failed', 'Lomba ini sudah ditutup, data tidak dapat diubah.');
        }

        // 🔒 Cek batas waktu pendaftaran
        if ($competition->registration_end_date && now()->greaterThan($competition->registration_end_date)) {
            return redirect()->route('peserta.pendaftaran.index')
                ->with('failed', 'Waktu pendaftaran telah berakhir, data tidak dapat diubah.');
        }

        // ✅ Validasi input normal
        $request->validate([
            'kontingen' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:L,P',
            'nik' => [
                'required',
                'digits:16',
                Rule::unique('participants')
                    ->where(fn($query) => $query->where('competition_id', $participant->competition_id))
                    ->ignore($participant->id),
            ],
            'category' => 'required|string|max:255',
            'body_weight' => 'required|numeric|min:20|max:120',
            'phone_number' => 'required|string|max:15',
            'bukti_bayar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'note' => 'nullable|string',
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar pada lomba yang sama.',
        ]);

        // ✅ Validasi tambahan: Deteksi input tidak wajar (anti-XSS)
        $fieldsToCheck = [
            'kontingen',
            'full_name',
            'place_of_birth',
            'category',
            'phone_number',
            'note'
        ];

        foreach ($fieldsToCheck as $field) {
            $value = $request->input($field);
            if ($value && preg_match('/<[^>]*script|onerror|onload|<[^>]+>/i', $value)) {
                return back()
                    ->withInput()
                    ->with('failed', 'Input tidak valid terdeteksi pada kolom "' . $field . '". Harap masukkan data yang wajar tanpa tag HTML.');
            }
        }

        try {
            // ✅ Tentukan ulang kelas tanding
            $weightClass = $this->getWeightClass(
                $request->category,
                $request->gender,
                $request->body_weight
            );

            if (!$weightClass) {
                return back()->withInput()->withErrors([
                    'body_weight' => 'Berat badan tidak sesuai dengan kategori usia yang dipilih.'
                ]);
            }

            // ✅ Proses upload file baru jika ada
            $path = $participant->bukti_bayar;
            if ($request->hasFile('bukti_bayar')) {
                if ($participant->bukti_bayar) {
                    Storage::disk('public')->delete($participant->bukti_bayar);
                }
                $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
            }

            // Ambil raw input
            $rawDob = $request->input('date_of_birth');

            // Jika kosong, biarkan null (atau validasi akan menolak)
            if ($rawDob) {
                // jika format dd/mm/YYYY
                if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $rawDob)) {
                    $normalizedDob = Carbon::createFromFormat('d/m/Y', $rawDob)->format('Y-m-d');
                }
                // jika format YYYY-mm-dd
                elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $rawDob)) {
                    $normalizedDob = $rawDob;
                } else {
                    // coba parse permissive (fallback) atau set null dan biarkan validasi menolak
                    try {
                        $normalizedDob = Carbon::parse($rawDob)->format('Y-m-d');
                    } catch (\Exception $e) {
                        $normalizedDob = null; // nanti validasi/penanganan error
                    }
                }
            } else {
                $normalizedDob = null;
            }

            // ✅ Update data peserta
            $participant->update([
                'kontingen' => $request->kontingen,
                'full_name' => $request->full_name,
                'place_of_birth' => $request->place_of_birth,
                'date_of_birth' => $normalizedDob,
                'gender' => $request->gender,
                'nik' => $request->nik,
                'category' => $request->category,
                'body_weight' => $request->body_weight,
                'weight_class' => $weightClass,
                'phone_number' => $request->phone_number,
                'bukti_bayar' => $path,
                'note' => $request->note,
            ]);

            return redirect()->route('peserta.pendaftaran.index')
                ->with('success', 'Data peserta berhasil diperbarui.');
        } catch (\Exception $e) {
            // Simpan detail error ke log untuk developer
            // Log::error('Update peserta gagal: ' . $e->getMessage(), [
            //     'user_id' => auth()->id(),
            //     'participant_id' => $participant->id ?? null,
            // ]);
            
            return back()->with('failed', 'Terjadi kesalahan sistem. Silakan coba lagi nanti.');
        }
    }

    // hapus pendaftaran peserta oleh peserta itu sendiri
    public function participantDestroy(Participant $participant)
    {
        try {
            // Pastikan hanya user yang mendaftarkan bisa menghapus datanya
            if ($participant->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki izin untuk menghapus peserta ini.');
            }

            // Ambil data lomba terkait
            $competition = $participant->competition;

            // Jika kompetisi tidak ditemukan
            if (!$competition) {
                return redirect()->back()->with('error', 'Data lomba tidak ditemukan.');
            }

            // Cek apakah waktu kompetisi sudah berakhir
            if ($competition->registration_end_date && now()->greaterThan($competition->registration_end_date)) {
                return redirect()->back()->with('failed', 'Waktu pendaftaran telah berakhir, data tidak dapat dihapus.');
            }

            // Hapus file bukti bayar jika ada
            if ($participant->bukti_bayar) {
                Storage::disk('public')->delete($participant->bukti_bayar);
            }

            // Hapus data peserta
            $participant->delete();

            return redirect()->back()->with('success', 'Data peserta telah dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
