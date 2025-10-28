<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Participant;
use App\Models\User;
use App\Models\Competition;
use Faker\Factory as Faker;

class ParticipantSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Pastikan sudah ada user dan competition di database
        $userIds = User::pluck('id')->all();
        $competitionIds = Competition::pluck('id')->all();

        if (empty($userIds) || empty($competitionIds)) {
            $this->command->error("Tabel User atau Competition masih kosong. Jalankan seeder-nya terlebih dahulu.");
            return;
        }

        $categories = [
            'USIA DINI (SD)',
            'PRA REMAJA (SMP)',
            'REMAJA (SMA/K/MA)',
            'DEWASA (MAHASISWA/UMUM)'
        ];

        $statuses = ['pending', 'approved', 'rejected'];

        for ($i = 0; $i < 200; $i++) { // Membuat 200 data peserta
            $gender = $faker->randomElement(['L', 'P']);
            $category = $faker->randomElement($categories);
            $weight = $this->generateWeightForCategory($category, $faker);
            $weightClass = $this->getWeightClass($category, $weight, $gender);

            // Jika berat badan tidak masuk ke kelas manapun, lewati iterasi ini
            if ($weightClass === 'N/A') {
                continue;
            }

            Participant::create([
                'user_id' => '2 && 3',
                'competition_id' => '1',
                // 'user_id' => $faker->randomElement($userIds),
                // 'competition_id' => $faker->randomElement($competitionIds),
                'kontingen' => 'Kontingen ' . $faker->city,
                'full_name' => $faker->name($gender == 'L' ? 'male' : 'female'),
                'place_of_birth' => $faker->city,
                'date_of_birth' => $faker->dateTimeBetween('-30 years', '-10 years')->format('Y-m-d'),
                'gender' => $gender,
                'nik' => $faker->unique()->numerify('################'),
                'category' => $category,
                'body_weight' => $weight,
                'weight_class' => $weightClass,
                'phone_number' => $faker->phoneNumber,
                'bukti_bayar' => null, // Biarkan kosong untuk seeder
                // 'validation_status' => $faker->randomElement($statuses),
                'validation_status' => 'approved',
            ]);
        }
    }

    /**
     * Menghasilkan berat badan acak berdasarkan kategori.
     */
    private function generateWeightForCategory($category, $faker)
    {
        switch ($category) {
            case 'USIA DINI (SD)':
                return $faker->randomFloat(2, 26, 44);
            case 'PRA REMAJA (SMP)':
                return $faker->randomFloat(2, 30, 57);
            case 'REMAJA (SMA/K/MA)':
                return $faker->randomFloat(2, 39, 75);
            case 'DEWASA (MAHASISWA/UMUM)':
                return $faker->randomFloat(2, 45, 95);
            default:
                return $faker->randomFloat(2, 30, 90);
        }
    }

    /**
     * Menentukan kelas berat berdasarkan kategori, berat, dan gender.
     */
    private function getWeightClass($category, $weight, $gender)
    {
        $class = 'N/A'; // Default jika tidak ada yang cocok

        switch ($category) {
            case 'USIA DINI (SD)':
                if ($weight >= 26 && $weight <= 28) $class = 'A';
                elseif ($weight > 28 && $weight <= 30) $class = 'B';
                elseif ($weight > 30 && $weight <= 32) $class = 'C';
                elseif ($weight > 32 && $weight <= 34) $class = 'D';
                elseif ($weight > 34 && $weight <= 36) $class = 'E';
                elseif ($weight > 36 && $weight <= 38) $class = 'F';
                elseif ($weight > 38 && $weight <= 40) $class = 'G';
                elseif ($weight > 40 && $weight <= 42) $class = 'H';
                elseif ($weight > 42 && $weight <= 44) $class = 'I';
                break;
            case 'PRA REMAJA (SMP)':
                if ($weight >= 30 && $weight <= 33) $class = 'A';
                elseif ($weight > 33 && $weight <= 36) $class = 'B';
                elseif ($weight > 36 && $weight <= 39) $class = 'C';
                elseif ($weight > 39 && $weight <= 42) $class = 'D';
                elseif ($weight > 42 && $weight <= 45) $class = 'E';
                elseif ($weight > 45 && $weight <= 48) $class = 'F';
                elseif ($weight > 48 && $weight <= 51) $class = 'G';
                elseif ($weight > 51 && $weight <= 54) $class = 'H';
                elseif ($weight > 54 && $weight <= 57) $class = 'I';
                break;
            case 'REMAJA (SMA/K/MA)':
                if ($weight >= 39 && $weight <= 43) $class = 'A';
                elseif ($weight > 43 && $weight <= 47) $class = 'B';
                elseif ($weight > 47 && $weight <= 51) $class = 'C';
                elseif ($weight > 51 && $weight <= 55) $class = 'D';
                elseif ($weight > 55 && $weight <= 59) $class = 'E';
                elseif ($weight > 59 && $weight <= 63) $class = 'F';
                elseif ($weight > 63 && $weight <= 67) $class = 'G';
                elseif ($weight > 67 && $weight <= 71) $class = 'H';
                elseif ($weight > 71 && $weight <= 75) $class = 'I';
                break;
            case 'DEWASA (MAHASISWA/UMUM)':
                if ($gender == 'L') {
                    if ($weight >= 45 && $weight <= 50) $class = 'A';
                    elseif ($weight > 50 && $weight <= 55) $class = 'B';
                    elseif ($weight > 55 && $weight <= 60) $class = 'C';
                    elseif ($weight > 60 && $weight <= 65) $class = 'D';
                    elseif ($weight > 65 && $weight <= 70) $class = 'E';
                    elseif ($weight > 70 && $weight <= 75) $class = 'F';
                    elseif ($weight > 75 && $weight <= 80) $class = 'G';
                    elseif ($weight > 80 && $weight <= 85) $class = 'H';
                    elseif ($weight > 85 && $weight <= 90) $class = 'I';
                    elseif ($weight > 90 && $weight <= 95) $class = 'J';
                } elseif ($gender == 'P') {
                    if ($weight >= 45 && $weight <= 50) $class = 'A';
                    elseif ($weight > 50 && $weight <= 55) $class = 'B';
                    elseif ($weight > 55 && $weight <= 60) $class = 'C';
                    elseif ($weight > 60 && $weight <= 65) $class = 'D';
                    elseif ($weight > 65 && $weight <= 70) $class = 'E';
                    elseif ($weight > 70 && $weight <= 75) $class = 'F';
                }
                break;
        }
        return $class;
    }
}
