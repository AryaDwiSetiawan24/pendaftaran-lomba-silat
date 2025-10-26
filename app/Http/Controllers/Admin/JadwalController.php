<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\Competition;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Models\TournamentPool;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class JadwalController extends Controller
{
    /**
     * Display a listing of the schedules.
     */
    public function index(Request $request)
    {
        // Ambil semua lomba yang status-nya "dibuka" beserta jumlah peserta
        $competitions = Competition::withCount('participants')
            ->where('status', 'dibuka')
            ->orderBy('competition_date', 'desc')
            ->get();

        return view('pages.admin.jadwal', compact('competitions'));
    }

    public function index1(Request $request)
    {
        $query = Schedule::with(['competition', 'participant1', 'participant2', 'winner']);

        // Filters
        if ($request->competition_id) {
            $query->where('competition_id', $request->competition_id);
        }

        if ($request->date) {
            $query->whereDate('match_time', $request->date);
        }

        if ($request->round) {
            $query->where('round', $request->round);
        }

        // Get schedules grouped by round
        $schedules = $query->orderBy('match_time', 'asc')->get();
        $schedulesByRound = $schedules->groupBy('round')->sortKeys();

        // Statistics
        $totalMatches = Schedule::count();
        $todayMatches = Schedule::whereDate('match_time', Carbon::today())->count();
        $completedMatches = Schedule::whereNotNull('winner_id')->count();
        $pendingMatches = Schedule::whereNull('winner_id')->count();

        // Get all competitions for filter
        $competitions = Competition::where('status', '!=', 'selesai')->get();

        return view('pages.admin.jadwal2', compact(
            'schedulesByRound',
            'totalMatches',
            'todayMatches',
            'completedMatches',
            'pendingMatches',
            'competitions'
        ));
    }

    public function pool($competitionId)
    {
        $competition = Competition::findOrFail($competitionId);
        $participants = Participant::where('competition_id', $competitionId)->get();
        $pools = TournamentPool::with('participant')->where('competition_id', $competitionId)->get();

        return view('pages.admin.jadwal.pool', compact('competition', 'participants', 'pools'));
    }

    public function view(Request $request, $competitionId)
    {
        // Pastikan kompetisi ditemukan
        $competition = Competition::findOrFail($competitionId);

        // Query dasar jadwal untuk kompetisi ini
        $query = Schedule::with(['competition', 'participant1', 'participant2', 'winner'])
            ->where('competition_id', $competitionId);

        // 🔍 Filter berdasarkan tanggal
        if ($request->filled('date')) {
            $query->whereDate('match_time', $request->date);
        }

        // 🔍 Filter berdasarkan ronde
        if ($request->filled('round')) {
            $query->where('round', $request->round);
        }

        // Ambil semua jadwal terfilter
        $schedules = $query->orderBy('match_time', 'asc')->get();

        // Grupkan berdasarkan ronde
        $schedulesByRound = $schedules->groupBy('round')->sortKeys();

        // 🧮 Statistik untuk kompetisi ini saja
        $totalMatches = Schedule::where('competition_id', $competitionId)->count();
        $todayMatches = Schedule::where('competition_id', $competitionId)
            ->whereDate('match_time', Carbon::today())
            ->count();
        $completedMatches = Schedule::where('competition_id', $competitionId)
            ->whereNotNull('winner_id')
            ->count();
        $pendingMatches = Schedule::where('competition_id', $competitionId)
            ->whereNull('winner_id')
            ->count();

        // Data untuk dropdown kompetisi (opsional)
        $competitions = Competition::where('status', '!=', 'selesai')->get();

        // Kirim ke view lengkap dengan data filter dan statistik
        return view('pages.admin.jadwal.view', compact(
            'competition',
            'competitions',
            'schedulesByRound',
            'totalMatches',
            'todayMatches',
            'completedMatches',
            'pendingMatches'
        ));
    }

    /**
     * Store a newly created schedule.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'participant1_id' => 'required|exists:participants,id',
            'participant2_id' => 'required|exists:participants,id|different:participant1_id',
            'round' => 'required|integer|min:1',
            'arena' => 'required|string|max:10',
            'match_time' => 'required|date|after:now',
        ], [
            'participant2_id.different' => 'Peserta 1 dan Peserta 2 harus berbeda',
            'match_time.after' => 'Waktu pertandingan harus di masa depan',
        ]);

        // Check if both participants are in the same competition
        $participant1 = Participant::findOrFail($request->participant1_id);
        $participant2 = Participant::findOrFail($request->participant2_id);

        if (
            $participant1->competition_id != $request->competition_id ||
            $participant2->competition_id != $request->competition_id
        ) {
            return back()->with('error', 'Peserta harus terdaftar di lomba yang sama!');
        }

        // Check if participants are approved
        if (
            $participant1->validation_status != 'approved' ||
            $participant2->validation_status != 'approved'
        ) {
            return back()->with('error', 'Hanya peserta yang sudah disetujui yang bisa dijadwalkan!');
        }

        Schedule::create($validated);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal pertandingan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified schedule.
     */
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);

        return response()->json([
            'id' => $schedule->id,
            'competition_id' => $schedule->competition_id,
            'participant1_id' => $schedule->participant1_id,
            'participant2_id' => $schedule->participant2_id,
            'round' => $schedule->round,
            'arena' => $schedule->arena,
            'match_time' => Carbon::parse($schedule->match_time)->format('Y-m-d\TH:i'),
        ]);
    }

    /**
     * Update the specified schedule.
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $validated = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'participant1_id' => 'required|exists:participants,id',
            'participant2_id' => 'required|exists:participants,id|different:participant1_id',
            'round' => 'required|integer|min:1',
            'arena' => 'required|string|max:10',
            'match_time' => 'required|date',
        ], [
            'participant2_id.different' => 'Peserta 1 dan Peserta 2 harus berbeda',
        ]);

        $schedule->update($validated);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal pertandingan berhasil diupdate!');
    }

    /**
     * Remove the specified schedule.
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);

        if ($schedule->winner_id) {
            return back()->with('error', 'Tidak dapat menghapus jadwal yang sudah ada pemenangnya!');
        }

        $schedule->delete();

        return redirect()->route('admin.jadwal.view', ['competitionId' => $schedule->competition_id])
            ->with('success', 'Jadwal pertandingan berhasil dihapus!');
    }

    /**
     * Get match details for setting winner.
     */
    public function getMatchDetails($id)
    {
        $schedule = Schedule::with(['participant1', 'participant2'])->findOrFail($id);

        return response()->json([
            'participant1' => [
                'id' => $schedule->participant1->id,
                'full_name' => $schedule->participant1->full_name,
                'weight_class' => $schedule->participant1->weight_class,
                'category' => $schedule->participant1->category,
            ],
            'participant2' => [
                'id' => $schedule->participant2->id,
                'full_name' => $schedule->participant2->full_name,
                'weight_class' => $schedule->participant2->weight_class,
                'category' => $schedule->participant2->category,
            ],
        ]);
    }

    /**
     * Get match details for setting winner.
     */
    public function details($id)
    {
        $match = Schedule::with(['participant1', 'participant2'])->findOrFail($id);

        return response()->json([
            'participant1' => [
                'id' => $match->participant1->id,
                'full_name' => $match->participant1->full_name,
                'weight_class' => $match->participant1->weight_class ?? '-',
                'category' => $match->participant1->category ?? '-',
            ],
            'participant2' => [
                'id' => $match->participant2->id,
                'full_name' => $match->participant2->full_name,
                'weight_class' => $match->participant2->weight_class ?? '-',
                'category' => $match->participant2->category ?? '-',
            ],
        ]);
    }

    /**
     * Set winner for a match.
     */
    public function setWinner(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $validated = $request->validate([
            'winner_id' => 'required|exists:participants,id',
        ]);

        // Validate winner is one of the participants
        if (
            $validated['winner_id'] != $schedule->participant1_id &&
            $validated['winner_id'] != $schedule->participant2_id
        ) {
            return back()->with('error', 'Pemenang harus salah satu dari peserta yang bertanding!');
        }

        $schedule->update(['winner_id' => $validated['winner_id']]);

        return redirect()->route('admin.jadwal.view', ['competitionId' => $schedule->competition_id])
            ->with('success', 'Pemenang pertandingan berhasil disimpan!');
    }

    /**
     * Generate bracket automatically (optional feature).
     */
    public function generateBracket(Request $request)
    {
        $validated = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'start_date' => 'required|date|after:now',
            'arena' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // Get all approved participants for the competition
            $participants = Participant::where('competition_id', $validated['competition_id'])
                ->where('validation_status', 'approved')
                ->inRandomOrder()
                ->get();

            if ($participants->count() < 2) {
                return back()->with('error', 'Minimal 2 peserta diperlukan untuk membuat bracket!');
            }

            // Generate Round 1 matches
            $matchTime = Carbon::parse($validated['start_date']);
            $matches = [];

            for ($i = 0; $i < $participants->count() - 1; $i += 2) {
                if (isset($participants[$i + 1])) {
                    $matches[] = [
                        'competition_id' => $validated['competition_id'],
                        'participant1_id' => $participants[$i]->id,
                        'participant2_id' => $participants[$i + 1]->id,
                        'round' => 1,
                        'arena' => $validated['arena'],
                        'match_time' => $matchTime->copy()->addMinutes(30 * count($matches)),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            Schedule::insert($matches);

            DB::commit();

            return redirect()->route('admin.jadwal.index')
                ->with('success', 'Bracket pertandingan berhasil digenerate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal generate bracket: ' . $e->getMessage());
        }
    }
}
