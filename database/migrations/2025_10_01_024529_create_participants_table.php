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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('competition_id')->constrained('competitions')->onDelete('cascade');

            $table->string('kontingen')->nullable(); // asal sekolah/klub
            $table->string('full_name');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->enum('gender', ['L', 'P']);
            $table->string('nik', 16);
            $table->string('category');
            $table->float('body_weight', 5, 2);
            $table->string('weight_class');
            $table->string('phone_number');
            $table->string('bukti_bayar')->nullable();
            $table->text('note')->nullable();
            $table->float('score')->nullable();
            
            $table->enum('validation_status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps();
            
            $table->unique(['competition_id', 'nik']); // nik harus unik per lomba
            $table->unique(['user_id', 'competition_id', 'nik']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
