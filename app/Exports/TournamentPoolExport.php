<?php

namespace App\Exports;

use App\Models\TournamentPool;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TournamentPoolExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $competitionId;

    public function __construct($competitionId)
    {
        $this->competitionId = $competitionId;
    }

    // 1️⃣ Ambil data pool + relasi peserta
    public function collection()
    {
        return TournamentPool::with(['participant'])
            ->where('competition_id', $this->competitionId)
            ->orderBy('pool')
            ->orderBy('seed_order')
            ->get();
    }

    // 2️⃣ Tentukan kolom yang ditampilkan
    public function headings(): array
    {
        return [
            'Pool ID',
            'Nama Peserta',
            'Kontingen',
            'Kategori',
            'Kelas Berat',
            'Berat Badan (kg)',
        ];
    }

    // 3️⃣ Mapping setiap baris data ke kolom Excel
    public function map($pool): array
    {
        return [
            $pool->pool,
            $pool->participant->full_name ?? '-',
            $pool->participant->kontingen ?? '-',
            $pool->participant->category ?? '-',
            $pool->participant->weight_class ?? '-',
            $pool->participant->body_weight ?? '-',
        ];
    }
}
