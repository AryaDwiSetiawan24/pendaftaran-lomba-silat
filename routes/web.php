<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\ParticipantsController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Admin\CompetitionController;
use App\Http\Controllers\Admin\TournamentPoolController;

// Guest Route
Route::get('/', [DashboardController::class, 'index'])->name('welcome');

// Auth Routes
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Google OAuth Routes
Route::get('/auth/google/redirect', [AuthController::class, 'googleRedirect'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'googleCallback'])->name('auth.google.callback');


// Check Status Route
Route::group(['middleware' => ['auth', 'check_role:peserta']], function () {
    Route::get('/verify', [VerificationController::class, 'index']);
    Route::post('/verify', [VerificationController::class, 'store']);
    Route::get('/verify/{unique_id}', [VerificationController::class, 'show']);
    Route::put('/verify/{unique_id}', [VerificationController::class, 'update']);
});

// admin
Route::group(['middleware' => ['auth', 'check_role:admin']], function () {
    // Admin Routes
    Route::get('/admin', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/peserta', [ParticipantsController::class, 'peserta'])->name('admin.peserta');

    // Routes untuk Admin - Lomba
    Route::get('/admin/lomba', [CompetitionController::class, 'index'])->name('admin.lomba');
    Route::get('/admin/lomba/add', [CompetitionController::class, 'create'])->name('admin.add-lomba');
    Route::post('/admin/lomba/store', [CompetitionController::class, 'store'])->name('admin.store-lomba');
    Route::get('/admin/lomba/show/{id}', [CompetitionController::class, 'show'])->name('admin.lomba.show');
    Route::get('/admin/lomba/edit/{id}', [CompetitionController::class, 'edit'])->name('admin.lomba.edit');
    Route::put('/admin/lomba/edit/{id}', [CompetitionController::class, 'update'])->name('admin.lomba.update');
    Route::delete('/admin/lomba/destroy/{id}', [CompetitionController::class, 'destroy'])->name('admin.lomba.destroy');
    Route::patch('/admin/lomba/{id}/toggle-visibility', [CompetitionController::class, 'toggleVisibility'])->name('admin.lomba.toggleVisibility');

    // Routes untuk Admin - Peserta
    Route::get('/admin/peserta/{participant}', [ParticipantsController::class, 'showPeserta'])->name('admin.peserta.show');
    Route::patch('/admin/peserta/{participant}/approve', [ParticipantsController::class, 'approve'])->name('admin.peserta.approve');
    Route::patch('/admin/peserta/{participant}/reject', [ParticipantsController::class, 'reject'])->name('admin.peserta.reject');
    Route::delete('/admin/peserta/{participant}/delete', [ParticipantsController::class, 'destroy'])->name('admin.peserta.destroy');
    Route::get('/admin/peserta/{participant}/edit', [ParticipantsController::class, 'editPeserta'])->name('admin.peserta.edit');
    Route::put('/admin/peserta/{participant}/update', [ParticipantsController::class, 'updatePeserta'])->name('admin.peserta.update');
    Route::get('/admin/peserta/export', [ParticipantsController::class, 'export'])->name('admin.peserta.export');

    // Routes untuk Admin - Jadwal Pertandingan
    Route::get('/admin/jadwal', [JadwalController::class, 'index'])->name('admin.jadwal.index');
    Route::get('/admin/jadwal1', [JadwalController::class, 'index1'])->name('admin.jadwal.index1');
    Route::get('/admin/jadwal/pool/{competitionId}', [JadwalController::class, 'pool'])->name('admin.jadwal.pool');
    Route::get('/admin/jadwal/view/{competitionId}', [JadwalController::class, 'view'])->name('admin.jadwal.view');

    // Pembuatan jadwal otomatis berdasarkan pool dan peserta
    Route::post('/admin/jadwal/{id}/generate-pools', [TournamentPoolController::class, 'generate'])->name('admin.jadwal.generate-pools');
    Route::post('/admin/jadwal/{competitionId}/generate-matches', [TournamentPoolController::class, 'generateMatches'])->name('admin.jadwal.generateMatches');

    // Export jadwal pertandingan ke Excel
    Route::get('/admin/jadwal/{competitionId}/export-excel', [JadwalController::class, 'exportExcel'])
        ->name('admin.jadwal.export.excel');
    Route::get('/admin/jadwal/{competitionId}/export-pool', [TournamentPoolController::class, 'exportPool'])
        ->name('admin.jadwal.exportPool');

    // Routes untuk Admin - Jadwal Pertandingan (lama)
    Route::get('/admin/jadwal/{id}/details', [JadwalController::class, 'details']);
    Route::post('/admin/jadwal/{id}/winner', [JadwalController::class, 'setWinner'])->name('admin.jadwal.winner');
    Route::post('/admin/jadwal', [JadwalController::class, 'store'])->name('admin.jadwal.store');
    Route::get('/admin/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('admin.jadwal.edit');
    Route::put('/admin/jadwal/{id}', [JadwalController::class, 'update'])->name('admin.jadwal.update');
    Route::delete('/admin/jadwal/{id}', [JadwalController::class, 'destroy'])->name('admin.jadwal.destroy');

    // Get participants by competition
    Route::get('/admin/jadwal/participants/{competition_id}', [JadwalController::class, 'getParticipants'])->name('jadwal.participants');
    // Get match details
    Route::get('/admin/jadwal/{id}/details', [JadwalController::class, 'getMatchDetails'])->name('jadwal.details');
    // Set winner
    Route::patch('/admin/jadwal/{id}/winner', [JadwalController::class, 'setWinner'])->name('jadwal.winner');
    // Generate bracket (optional)
    Route::post('/admin/jadwal/generate-bracket', [JadwalController::class, 'generateBracket'])->name('jadwal.generate');
});

// peserta
Route::group(['middleware' => ['auth', 'check_role:peserta', 'check_status']], function () {
    // Peserta Routes
    Route::get('/peserta', [DashboardController::class, 'pesertaDashboard'])->name('peserta.dashboard');

    // Competition Routes
    Route::get('/peserta/lomba/{competition}', [ParticipantsController::class, 'show'])->name('peserta.lomba.show');
    Route::get('/peserta/lomba/{competition}/daftar', [ParticipantsController::class, 'create'])->name('peserta.lomba.daftar');
    Route::post('/peserta/lomba/{competition}/daftar', [ParticipantsController::class, 'store'])->name('peserta.lomba.store');

    // Pendaftaran Saya Routes
    Route::get('/peserta/pendaftaran-saya', [ParticipantsController::class, 'index'])->name('peserta.pendaftaran.index');
    Route::get('/peserta/pendaftaran-saya/{participant}', [ParticipantsController::class, 'showParticipant'])->name('peserta.pendaftaran.show');
    Route::get('/peserta/pendaftaran/{participant}/edit', [ParticipantsController::class, 'edit'])->name('peserta.pendaftaran.edit');
    Route::put('/peserta/pendaftaran/{participant}', [ParticipantsController::class, 'update'])->name('peserta.pendaftaran.update');
    Route::delete('/peserta/pendaftaran/{participant}/destroy', [ParticipantsController::class, 'participantDestroy'])->name('peserta.pendaftaran.destroy');
});
