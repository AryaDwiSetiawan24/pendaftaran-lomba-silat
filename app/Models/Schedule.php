<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = [
        'competition_id',
        'pool_id',
        'participant1_id',
        'participant2_id',
        'winner_id',
        'round',
        'arena',
        'match_time',
    ];

    protected $casts = [
        'match_time' => 'datetime',
    ];

    /**
     * Relationship: Schedule belongs to Pool
     */
    public function pool()
    {
        return $this->belongsTo(TournamentPool::class);
    }


    /**
     * Relationship: Schedule belongs to Competition
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id');
    }

    /**
     * Relationship: Participant 1
     */
    public function participant1()
    {
        return $this->belongsTo(Participant::class, 'participant1_id');
    }

    /**
     * Relationship: Participant 2
     */
    public function participant2()
    {
        return $this->belongsTo(Participant::class, 'participant2_id');
    }

    /**
     * Relationship: Winner
     */
    public function winner()
    {
        return $this->belongsTo(Participant::class, 'winner_id');
    }

    /**
     * Accessor: Get round name
     */
    public function getRoundNameAttribute()
    {
        $roundNames = [
            1 => 'Ronde 1 - Babak Penyisihan',
            2 => 'Ronde 2 - Babak 16 Besar',
            3 => 'Ronde 3 - Perempat Final',
            4 => 'Semi Final',
            5 => 'Final',
        ];

        return $roundNames[$this->round] ?? "Ronde {$this->round}";
    }

    /**
     * Accessor: Check if match is completed
     */
    public function getIsCompletedAttribute()
    {
        return !is_null($this->winner_id);
    }

    /**
     * Accessor: Check if match is today
     */
    public function getIsTodayAttribute()
    {
        return $this->match_time->isToday();
    }

    /**
     * Accessor: Check if match is upcoming
     */
    public function getIsUpcomingAttribute()
    {
        return $this->match_time->isFuture();
    }

    /**
     * Accessor: Check if match has started
     */
    public function getHasStartedAttribute()
    {
        return $this->match_time->isPast();
    }

    /**
     * Accessor: Get formatted match time
     */
    public function getFormattedMatchTimeAttribute()
    {
        return $this->match_time->format('d M Y, H:i') . ' WIB';
    }

    /**
     * Scope: Filter by competition
     */
    public function scopeByCompetition($query, $competitionId)
    {
        return $query->where('competition_id', $competitionId);
    }

    /**
     * Scope: Filter by round
     */
    public function scopeByRound($query, $round)
    {
        return $query->where('round', $round);
    }

    /**
     * Scope: Filter by date
     */
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('match_time', $date);
    }

    /**
     * Scope: Get today's matches
     */
    public function scopeToday($query)
    {
        return $query->whereDate('match_time', Carbon::today());
    }

    /**
     * Scope: Get completed matches
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('winner_id');
    }

    /**
     * Scope: Get pending matches
     */
    public function scopePending($query)
    {
        return $query->whereNull('winner_id');
    }

    /**
     * Scope: Get upcoming matches
     */
    public function scopeUpcoming($query)
    {
        return $query->where('match_time', '>', now());
    }

    /**
     * Get the loser of the match
     */
    public function getLoser()
    {
        if (!$this->winner_id) {
            return null;
        }

        if ($this->winner_id == $this->participant1_id) {
            return $this->participant2;
        }

        return $this->participant1;
    }

    /**
     * Check if a participant won
     */
    public function isWinner($participantId)
    {
        return $this->winner_id == $participantId;
    }

    /**
     * Check if match can be edited
     */
    public function canBeEdited()
    {
        // Can only edit if no winner set and match hasn't started
        return is_null($this->winner_id) && $this->match_time->isFuture();
    }

    /**
     * Check if match can be deleted
     */
    public function canBeDeleted()
    {
        // Can only delete if no winner set
        return is_null($this->winner_id);
    }
}
