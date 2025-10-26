<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Participant;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $competitions = Competition::orderBy('competition_date', 'asc')->get();
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

        // Lomba yang sedang dibuka
        $competitions = Competition::where('status', 'dibuka')->get();

        // Lomba yang diikuti oleh user saat ini
        $myCompetitions = \App\Models\Participant::with('competition')
            ->where('user_id', $user->id)
            ->get();

        // Hitung jumlah lomba unik yang diikuti user ini
        $registeredCompetitions = $myCompetitions->pluck('competition_id')->unique()->count();

        return view('pages.peserta.dashboard', compact('competitions', 'myCompetitions', 'registeredCompetitions'));
    }
}
