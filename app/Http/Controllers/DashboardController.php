<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Participant;
use Illuminate\Support\Carbon;
use App\Models\Schedule;

class DashboardController extends Controller
{
    public function index()
    {
        $competitions = Competition::where('status', 'dibuka')
            ->orderBy('competition_date', 'asc')
            ->get();
        return view('layouts.guest', compact('competitions'));
    }

    public function adminDashboard()
    {
        // 1. Data untuk Kartu Statistik
        $totalLomba = Competition::count();
        $lombaAktif = Competition::where('status', 'dibuka')->count();

        // Asumsi 'Participant' adalah model untuk semua peserta
        $totalPeserta = Participant::count();

        // Asumsi 'jadwal' adalah kompetisi yang tanggalnya HARI INI
        $jadwalHariIni = Competition::whereDate('competition_date', Carbon::today())->count();

        // 2. Data untuk Tabel Ringkasan (ambil 5 lomba terbaru)
        $recentCompetitions = Competition::withCount('participants')
            ->latest() // Mengurutkan dari yang terbaru
            ->take(5)  // Hanya ambil 5
            ->get();

        // 3. Kirim semua data ke view 'admin.dashboard'
        return view('pages.admin.dashboard', compact(
            'totalLomba',
            'lombaAktif',
            'totalPeserta',
            'jadwalHariIni',
            'recentCompetitions'
        ));
    }

    public function pesertaDashboard()
    {
        $user = auth()->user();

        // 1️⃣ Ambil data partisipasi + kompetisi terkait
        $myCompetitionsQuery = Participant::with(['competition:id,name,competition_date,location'])
            ->where('user_id', $user->id);

        // 2️⃣ Hitung statistik peserta
        $statistics = (clone $myCompetitionsQuery)
            ->selectRaw('
            COUNT(*) as total_participants,
            COUNT(DISTINCT competition_id) as total_competitions,
            SUM(CASE WHEN validation_status = "approved" THEN 1 ELSE 0 END) as approved_count,
            SUM(CASE WHEN validation_status = "pending" THEN 1 ELSE 0 END) as pending_count,
            SUM(CASE WHEN validation_status = "rejected" THEN 1 ELSE 0 END) as rejected_count
        ')
            ->first();

        // 3️⃣ Ambil daftar lomba yang masih dibuka
        $competitions = Competition::where('status', 'dibuka')
            ->orderBy('registration_start_date', 'desc')
            ->paginate(5, ['*'], 'lomba_page');

        // 4️⃣ Ambil jadwal pertandingan user (UPDATED)
        // Cari ID participant user yang sudah approved
        $participantIds = Participant::where('user_id', $user->id)
            ->where('validation_status', 'approved')
            ->pluck('id');

        // Ambil jadwal dimana user adalah participant1 ATAU participant2
        $schedules = Schedule::with([
            'competition:id,name,competition_date,competition_logo,visible_schedule',
            'participant1:id,full_name,weight_class,category,nik,kontingen',
            'participant2:id,full_name,weight_class,category,nik,kontingen',
            'winner:id,full_name'
        ])
            ->where(function ($q) use ($participantIds) {
                $q->whereIn('participant1_id', $participantIds)
                    ->orWhereIn('participant2_id', $participantIds);
            })
            ->whereHas('competition', function ($q) {
                $q->where('visible_schedule', true)
                    ->whereNotNull('competition_date')
                    ->where('status', 'dibuka');
            })
            ->orderBy('match_time', 'asc')
            ->paginate(5, ['*'], 'schedule_page');

        // 5️⃣ Kumpulkan statistik
        $stats = [
            'total_participants' => $statistics->total_participants ?? 0,
            'total_competitions' => $statistics->total_competitions ?? 0,
            'approved_count' => $statistics->approved_count ?? 0,
            'pending_count' => $statistics->pending_count ?? 0,
            'rejected_count' => $statistics->rejected_count ?? 0,
        ];

        // 6️⃣ Kirim ke view
        return view('pages.peserta.dashboard', compact('competitions', 'schedules', 'stats'));
    }
}
