<?php

namespace App\Exports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ParticipantsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Database\Query\Builder
    */
    public function query()
    {
        // ambil relasi 'competition' agar bisa menampilkan nama lomba
        return Participant::query()->with('competition');
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIK',
            'No. Telepon',
            'kontingen',
            'Lomba',
            'Kategori',
            'Berat Badan',
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
        return [
            $participant->full_name,
            "'" . $participant->nik, // Tambahkan ' di depan NIK agar tidak jadi scientific notation
            $participant->phone_number,
            $participant->kontingen,
            $participant->competition->name ?? '-', // Gunakan ?? '-' untuk jaga-jaga jika relasi kosong
            $participant->category ?? '-',
            $participant->body_weight,
            $participant->weight_class,
            $participant->gender == 'L' ? 'Laki-laki' : 'Perempuan',
            ucfirst($participant->validation_status), // 'pending' -> 'Pending'
        ];
    }
}