<?php

namespace App\Http\Controllers\Admin;

use App\Models\Participant;
use App\Models\TournamentPool;
use App\Models\Schedule;
use App\Http\Controllers\Controller;

class TournamentPoolController extends Controller
{
    /**
     * Generate pool dan seed peserta (pengelompokan peserta berdasarkan kelas)
     */
    public function generate($competitionId)
    {
        // 1️⃣ Ambil semua peserta yang disetujui
        $participants = Participant::where('competition_id', $competitionId)
            ->where('validation_status', 'approved')
            ->orderBy('id')
            ->get();

        if ($participants->isEmpty()) {
            return back()->with('error', 'Tidak ada peserta dengan status approved untuk turnamen ini.');
        }

        // 2️⃣ Kelompokkan peserta berdasarkan kontingen
        $groupedByKontingen = $participants->groupBy('kontingen');

        // 3️⃣ Distribusikan peserta secara round-robin agar kontingen tersebar
        $distributedParticipants = collect();

        while ($groupedByKontingen->flatten()->isNotEmpty()) {
            foreach ($groupedByKontingen as $kontingen => $group) {
                if ($group->isNotEmpty()) {
                    $distributedParticipants->push($group->shift());
                }
            }
        }

        // 4️⃣ Tentukan jumlah pool & ukuran pool otomatis
        $totalParticipants = $distributedParticipants->count();

        // Tentukan ukuran pool (bisa kamu ubah sesuai kebutuhan)
        if ($totalParticipants <= 8) {
            $poolSize = $totalParticipants; // semua di 1 pool
        } elseif ($totalParticipants <= 16) {
            $poolSize = 8;
        } elseif ($totalParticipants <= 32) {
            $poolSize = 8;
        } elseif ($totalParticipants <= 64) {
            $poolSize = 8;
        } else {
            $poolSize = 16; // jika besar sekali
        }

        $totalPools = ceil($totalParticipants / $poolSize);

        // 5️⃣ Hapus pool lama untuk kompetisi ini
        TournamentPool::where('competition_id', $competitionId)->delete();

        // 6️⃣ Bagi peserta secara merata ke dalam pool
        $poolIndex = 1;
        $seedOrder = 1;
        $currentPoolCounts = array_fill(1, $totalPools, 0);

        foreach ($distributedParticipants as $participant) {
            TournamentPool::create([
                'competition_id' => $competitionId,
                'participant_id' => $participant->id,
                'pool' => $poolIndex,
                'seed_order' => $seedOrder++,
            ]);

            $currentPoolCounts[$poolIndex]++;

            // Geser ke pool berikutnya (round-robin)
            $poolIndex++;
            if ($poolIndex > $totalPools) {
                $poolIndex = 1;
            }
        }


        // 7️⃣ (Opsional) Cek apakah masih ada kontingen ganda di pool yang sama
        $pools = TournamentPool::where('competition_id', $competitionId)
            ->get()
            ->groupBy('pool');

        $duplicateReport = [];
        foreach ($pools as $poolNumber => $poolMembers) {
            $duplicates = $poolMembers->groupBy(fn($m) => $m->participant->kontingen)
                ->filter(fn($g) => $g->count() > 1);
            if ($duplicates->isNotEmpty()) {
                $duplicateReport[$poolNumber] = $duplicates->keys()->toArray();
            }
        }

        // 8️⃣ Sampaikan hasil
        if (!empty($duplicateReport)) {
            return redirect()->route('admin.jadwal.pool', ['competitionId' => $competitionId])->with('warning', 'Beberapa pool memiliki peserta dari kontingen sama. Sistem sudah berusaha mendistribusi sebaik mungkin.');
        }

        return redirect()->route('admin.jadwal.pool', ['competitionId' => $competitionId])->with('success', "Berhasil membentuk {$totalPools} pool dengan pembagian seimbang dan distribusi kontingen yang adil! Lanjutkan dengan membuat jadwal pertandingan.");
    }

    // fungsi membuat jadwal otomatis
    public function generateMatches($competitionId)
    {
        // 1️⃣ Ambil semua pool untuk kompetisi ini
        $pools = TournamentPool::where('competition_id', $competitionId)
            ->with('participant')
            ->get()
            ->groupBy('pool');

        if ($pools->isEmpty()) {
            return back()->with('error', 'Belum ada pool yang terbentuk untuk kompetisi ini.');
        }

        // 2️⃣ Hapus jadwal lama agar tidak duplikat
        Schedule::where('competition_id', $competitionId)->delete();

        $matchesCreated = 0;
        $round = 1;

        // 3️⃣ Loop tiap pool
        foreach ($pools as $poolName => $participants) {
            $participants = $participants->shuffle(); // acak urutan agar lebih adil

            // Jika jumlah peserta ganjil, tambahkan "bye" (peserta langsung lolos)
            if ($participants->count() % 2 !== 0) {
                $participants->push(null);
            }

            // 4️⃣ Buat pasangan pertandingan (participant1 vs participant2)
            for ($i = 0; $i < $participants->count(); $i += 2) {
                $p1 = $participants[$i];
                $p2 = $participants[$i + 1];

                // Jika ada "bye" (p2 == null)
                if (is_null($p2)) {
                    // Peserta tanpa lawan => langsung lolos ke ronde berikutnya
                    Schedule::create([
                        'competition_id' => $competitionId,
                        'pool_id' => $p1->id,
                        'participant1_id' => $p1->participant_id,
                        'participant2_id' => null,
                        'winner_id' => $p1->participant_id, // langsung menang
                        'round' => 2, // langsung ke ronde berikutnya
                        'arena' => $poolName ?? 'A',
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
                    'arena' => $poolName ?? 'A',
                    'match_time' => now()->addDays(1),
                ]);

                $matchesCreated++;
            }
        }
        return redirect()->route('admin.jadwal.view',['competitionId' => $competitionId])->with('success', "Berhasil membuat {$matchesCreated} jadwal pertandingan untuk kompetisi ini!");
    }
}
