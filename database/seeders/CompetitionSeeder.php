<?php

namespace Database\Seeders;

use App\Models\Competition;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('competitions')->insert([
            [
                'name' => 'Lomba Silat 2025',
                'description' => 'Kompetisi antar sekolah untuk menguji pengetahuan sains tingkat SMA sederajat.',
                'competition_date' => Carbon::parse('2025-12-15 09:00:00'),
                'registration_start_date' => Carbon::parse('2025-10-20 00:00:00'),
                'registration_end_date' => Carbon::parse('2025-12-10 23:59:59'),
                'status' => 'dibuka',
                'competition_logo' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lomba Silat Internasional 2025',
                'description' => 'Ajang kreativitas siswa dalam mendesain poster digital bertema lingkungan.',
                'competition_date' => Carbon::parse('2025-11-25 08:30:00'),
                'registration_start_date' => Carbon::parse('2025-10-01 00:00:00'),
                'registration_end_date' => Carbon::parse('2025-11-20 23:59:59'),
                'status' => 'akan_datang',
                'competition_logo' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lomba Silat Nasional 2025',
                'description' => 'Kompetisi untuk menumbuhkan minat sastra dan ekspresi seni membaca puisi.',
                'competition_date' => Carbon::parse('2025-10-30 10:00:00'),
                'registration_start_date' => Carbon::parse('2025-09-01 00:00:00'),
                'registration_end_date' => Carbon::parse('2025-10-15 23:59:59'),
                'status' => 'ditutup',
                'competition_logo' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
