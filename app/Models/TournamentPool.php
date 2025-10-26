<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentPool extends Model
{
    use HasFactory;

    protected $fillable = [
        'competition_id',
        'participant_id',
        'pool',
        'seed_order',
        'ranking_score',
    ];

    // Relasi ke Competition
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    // Relasi ke Participant
    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
