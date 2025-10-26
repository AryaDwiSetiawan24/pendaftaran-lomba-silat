<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tournament_pools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')
                ->constrained('competitions')
                ->onDelete('cascade');

            $table->foreignId('participant_id')
                ->constrained('participants')
                ->onDelete('cascade');

            // Pool atau grup (misal: A, B, C)
            $table->string('pool')->nullable();

            // Posisi peserta dalam bracket (misal urutan seeding)
            $table->integer('seed_order')->nullable();

            // Nilai algoritma (misal skor hasil fuzzy/AI untuk seeding)
            $table->float('ranking_score')->nullable();

            $table->timestamps();

            $table->unique(['competition_id', 'participant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_pools');
    }
};
