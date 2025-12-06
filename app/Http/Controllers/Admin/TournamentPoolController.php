<?php

namespace App\Http\Controllers\Admin;

use App\Models\Schedule;
use App\Models\Participant;
use App\Models\TournamentPool;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TournamentPoolExport;

class TournamentPoolController extends Controller
{
    /**
     * Generate pool berdasarkan category, gender, dan weight_class
     */
    public function generate($competitionId)
    {
        // 1️⃣ Ambil peserta yang sudah disetujui
        $participants = Participant::where('competition_id', $competitionId)
            ->where('validation_status', 'approved')
            ->get();

        if ($participants->isEmpty()) {
            return back()->with('error', 'Tidak ada peserta approved untuk kompetisi ini.');
        }

        // 2️⃣ Tentukan kelas berat hanya untuk validasi (tanpa menyimpan ke database)
        foreach ($participants as $participant) {
            $class = $participant->weight_class; // gunakan nilai asli dari DB
            $category = $participant->category;
            $weight = $participant->weight;
            $gender = strtoupper($participant->gender);

            // Jika weight_class kosong, tentukan sementara (TIDAK DISIMPAN)
            if (empty($class) || $class === 'UNDEF') {
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
                            elseif ($weight > 54 && $weight <= 57) $class = 'I';
                        } elseif ($gender === 'P') { // PUTRI
                            if ($weight >= 30 && $weight <= 33) $class = 'A';
                            elseif ($weight > 33 && $weight <= 36) $class = 'B';
                            elseif ($weight > 36 && $weight <= 39) $class = 'C';
                            elseif ($weight > 39 && $weight <= 42) $class = 'D';
                            elseif ($weight > 42 && $weight <= 45) $class = 'E';
                            elseif ($weight > 45 && $weight <= 48) $class = 'F';
                            elseif ($weight > 48 && $weight <= 51) $class = 'G';
                            elseif ($weight > 51 && $weight <= 54) $class = 'H';
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
                     * DEWASA
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

                // Tidak menyimpan, hanya menambahkan properti sementara
                $participant->temp_weight_class = $class ?? 'UNDEF';
            } else {
                $participant->temp_weight_class = $class;
            }
        }

        // 3️⃣ Hapus pool lama
        TournamentPool::where('competition_id', $competitionId)->delete();

        // 4️⃣ Kelompokkan berdasarkan gender + category + weight_class (dari temp)
        $grouped = $participants->groupBy(fn($p) => "{$p->gender}-{$p->category}-{$p->temp_weight_class}");

        $poolCount = 0;

        foreach ($grouped as $key => $group) {
            $total = $group->count();

            // Jika <=4 peserta, langsung satu pool
            if ($total <= 4) {
                $poolCount++;
                $seedOrder = 1;

                foreach ($group as $participant) {
                    TournamentPool::create([
                        'competition_id' => $competitionId,
                        'participant_id' => $participant->id,
                        'pool' => $poolCount,
                        'seed_order' => $seedOrder++,
                    ]);
                }
                continue;
            }

            // Jika >4 peserta, bagi rata ke beberapa pool dengan max 4
            $poolTotal = ceil($total / 4); // berapa pool yang dibutuhkan
            $perPool = intdiv($total, $poolTotal); // jumlah rata-rata peserta per pool
            $sisa = $total % $poolTotal; // sisanya dibagi ke pool pertama

            $index = 0;
            for ($i = 0; $i < $poolTotal; $i++) {
                $jumlahPeserta = $perPool + ($i < $sisa ? 1 : 0); // bagi sisa secara merata
                $chunk = $group->slice($index, $jumlahPeserta);
                $index += $jumlahPeserta;

                $poolCount++;
                $seedOrder = 1;

                foreach ($chunk as $participant) {
                    TournamentPool::create([
                        'competition_id' => $competitionId,
                        'participant_id' => $participant->id,
                        'pool' => $poolCount,
                        'seed_order' => $seedOrder++,
                    ]);
                }
            }
        }

        return redirect()->route('admin.jadwal.pool', ['competitionId' => $competitionId])
            ->with('success', "Berhasil membentuk {$poolCount} pool berdasarkan gender, kategori, dan kelas berat tanpa mengubah data peserta.");
    }

    /**
     * Export pool ke Excel
     */
    public function exportPool($competitionId)
    {
        $fileName = 'pool-kompetisi-' . $competitionId . '.xlsx';
        return Excel::download(new TournamentPoolExport($competitionId), $fileName);
    }

    /**
     * Generate jadwal otomatis berdasarkan pool yang sudah terbentuk
     */
    public function generateMatches($competitionId)
    {
        // Ambil semua pool
        $pools = TournamentPool::where('competition_id', $competitionId)
            ->with('participant')
            ->get()
            ->groupBy('pool');

        if ($pools->isEmpty()) {
            return back()->with('error', 'Belum ada pool yang terbentuk untuk kompetisi ini.');
        }

        // Hapus jadwal lama
        Schedule::where('competition_id', $competitionId)->delete();

        $matchesCreated = 0;
        $round = 1;

        foreach ($pools as $poolName => $participants) {
            $participants = $participants->shuffle();

            // Jika ganjil, tambahkan bye
            if ($participants->count() % 2 !== 0) {
                $participants->push(null);
            }

            for ($i = 0; $i < $participants->count(); $i += 2) {
                $p1 = $participants[$i];
                $p2 = $participants[$i + 1];

                if (is_null($p2)) {
                    // langsung menang
                    Schedule::create([
                        'competition_id' => $competitionId,
                        'pool_id' => $p1->id,
                        'participant1_id' => $p1->participant_id,
                        'participant2_id' => null,
                        'winner_id' => $p1->participant_id,
                        'round' => $round + 1,
                        'arena' => $poolName,
                        'match_time' => now()->addDays(1),
                    ]);
                    continue;
                }

                Schedule::create([
                    'competition_id' => $competitionId,
                    'pool_id' => $p1->id,
                    'participant1_id' => $p1->participant_id,
                    'participant2_id' => $p2->participant_id,
                    'round' => $round,
                    'arena' => $poolName,
                    'match_time' => now()->addDays(1),
                ]);

                $matchesCreated++;
            }
        }

        return redirect()->route('admin.jadwal.view', ['competitionId' => $competitionId])
            ->with('success', "Berhasil membuat {$matchesCreated} jadwal pertandingan berdasarkan pool.");
    }
}
