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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->foreignId('competition_id')
                ->constrained('competitions')
                ->onDelete('cascade');

            // Peserta yang bertanding
            $table->foreignId('participant1_id')
                ->constrained('participants')
                ->onDelete('cascade');

            $table->foreignId('participant2_id')
                ->nullable()
                ->constrained('participants')
                ->onDelete('cascade');

            // Pemenang (nullable karena diisi setelah pertandingan selesai)
            $table->foreignId('winner_id')
                ->nullable()
                ->constrained('participants')
                ->onDelete('set null');

            // Relasi ke pool asal pertandingan
            $table->foreignId('pool_id')
                ->nullable()
                ->constrained('tournament_pools')
                ->onDelete('set null');

            // Match details
            $table->integer('round'); // 1, 2, 3, 4 (semi), 5 (final)
            $table->string('arena'); // sementara hanya satu arena
            $table->dateTime('match_time'); // nantinya diisi manual

            $table->timestamps();

            // Indexes for better query performance
            $table->index('competition_id');
            $table->index('match_time');
            $table->index('round');
            $table->index('winner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
