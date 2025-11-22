<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     * Menggunakan skema terbaru yang Anda berikan.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'competition_id',
        'kontingen',
        'full_name',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'nik',
        'category',
        'body_weight',
        'weight_class',
        'phone_number',
        'bukti_bayar',
        'validation_status',
    ];

    /**
     * Atribut yang tipe datanya harus di-cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'date_of_birth' => 'date',
    ];

    /**
     * Relasi Invers (kebalikan): Satu data Pendaftaran (Participant) dimiliki oleh satu (belongsTo) User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Kenapa hasOne? Karena 1 peserta hanya punya 1 entri di tournament_pools untuk 1 kompetisi.
    public function tournamentPool()
    {
        return $this->hasOne(TournamentPool::class);
    }


    /**
     * Relasi Invers: Satu data Pendaftaran (Participant) dimiliki oleh satu (belongsTo) Lomba (Competition).
     */
    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }
}
