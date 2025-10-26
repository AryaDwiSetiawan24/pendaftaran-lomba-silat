<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Competition extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'competition_date',
        'registration_start_date',
        'registration_end_date',
        'status',
        'competition_logo'
    ];


    /**
     * Atribut yang tipe datanya harus di-cast.
     * Ini akan mengubah string tanggal dari database menjadi objek Carbon yang powerful.
     *
     * @var array
     */
    protected $casts = [
        'competition_date' => 'datetime',
        'registration_start_date' => 'datetime',
        'registration_end_date' => 'datetime',
    ];

    /**
     * Relasi one-to-many: Satu Lomba memiliki banyak Peserta (Participant).
     */
    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class, 'competition_id');
    }

    /**
     * Relasi one-to-many: Satu Lomba memiliki banyak Pertandingan (MatchGame).
     * Nama method diubah menjadi matchGames untuk konsistensi.
     */
    public function tournamentPools()
    {
        return $this->hasMany(TournamentPool::class);
    }
    // public function matchGames(): HasMany
    // {
    //     return $this->hasMany(MatchGame::class);
    // }
}
