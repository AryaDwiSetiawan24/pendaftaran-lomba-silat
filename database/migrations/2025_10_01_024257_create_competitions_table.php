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
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->dateTime('competition_date');
            $table->dateTime('registration_start_date');
            $table->dateTime('registration_end_date');
            $table->enum('status', ['akan_datang', 'dibuka', 'ditutup', 'selesai'])->default('akan_datang');
            $table->boolean('visible_schedule')->default(false);
            $table->string('competition_logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
