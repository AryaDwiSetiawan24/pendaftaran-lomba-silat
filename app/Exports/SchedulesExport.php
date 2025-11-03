<?php

namespace App\Exports;

// Pastikan Anda mengimpor model Schedule
use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SchedulesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $competitionId;

    /**
     * Konstruktor untuk menerima ID lomba
     */
    public function __construct($competitionId)
    {
        $this->competitionId = $competitionId;
    }

    /**
     * Ambil data schedule berdasarkan competition_id
     */
    public function query()
    {
        return Schedule::with(['competition', 'participant1', 'participant2'])
            ->where('competition_id', $this->competitionId)
            ->orderBy('match_time', 'asc');
    }

    /**
     * Menentukan header kolom untuk file Excel.
     */
    public function headings(): array
    {
        return [
            'ID Jadwal',
            'Nama Lomba',
            'Babak',
            'Peserta Sudut Merah',
            'Peserta Sudut Biru',
            'Pemenang',
            'Waktu Tanding',
        ];
    }

    /**
     * Memetakan data dari setiap baris ($schedule) ke kolom Excel.
     *
     * @param Schedule $schedule Instance dari model Schedule yang berisi relasi
     */
    public function map($schedule): array
    {
        return [
            // Akses 'name' dari relasi 'competition'
            // `?? 'N/A'` digunakan untuk menghindari error jika relasi kosong
            $schedule->id,
            $schedule->competition->name ?? 'Data Lomba Hilang',

            $schedule->round,
            
            // Akses 'full_name' dari relasi 'participant1'
            $schedule->participant1->full_name ?? 'Peserta 1 Tidak Ditemukan',
            
            // Akses 'full_name' dari relasi 'participant2'
            $schedule->participant2->full_name ?? 'Peserta 2 Tidak Ditemukan',
            // Tentukan pemenang berdasarkan winner_id
            $schedule->winner_id === null
                ? 'Belum Ada Pemenang'
                : ($schedule->winner_id == $schedule->participant1_id
                    ? ($schedule->participant1->full_name ?? 'Peserta 1 Tidak Ditemukan')
                    : ($schedule->winner_id == $schedule->participant2_id
                        ? ($schedule->participant2->full_name ?? 'Peserta 2 Tidak Ditemukan')
                        : 'Pemenang Tidak Diketahui'
                    )
                ),
            $schedule->match_time->format('d M Y, H:i'),
        ];
    }
}
