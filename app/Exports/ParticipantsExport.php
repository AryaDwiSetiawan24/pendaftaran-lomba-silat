<?php

namespace App\Exports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ParticipantsExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Database\Query\Builder
    */
    public function query()
    {
        // 1. Tentukan query untuk mengambil data yang akan diekspor
        // Kita juga mengambil relasi 'competition' agar bisa menampilkan nama lomba
        return Participant::query()->with('competition');
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        // 2. Tentukan nama header untuk setiap kolom di file Excel
        return [
            'Nama Lengkap',
            'NIK',
            'No. Telepon',
            'kontingen',
            'Lomba',
            'Kategori',
            'Kelas Tanding',
            'Jenis Kelamin',
            'Status Validasi',
        ];
    }

    /**
    * @param Participant $participant
    * @return array
    */
    public function map($participant): array
    {
        // 3. Inilah bagian untuk memilih kolom yang akan dicetak
        // Urutannya harus sama dengan urutan di headings()
        return [
            $participant->full_name,
            "'" . $participant->nik, // Tambahkan ' di depan NIK agar tidak jadi scientific notation
            $participant->phone_number,
            $participant->kontingen,
            $participant->competition->name ?? '-', // Gunakan ?? '-' untuk jaga-jaga jika relasi kosong
            $participant->category ?? '-',
            $participant->weight_class,
            $participant->gender == 'L' ? 'Laki-laki' : 'Perempuan',
            ucfirst($participant->validation_status), // 'pending' -> 'Pending'
        ];
    }
}