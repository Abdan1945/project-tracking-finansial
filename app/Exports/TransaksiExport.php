<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Transaksi::with(['kategori_keuangan', 'akun_keuangan', 'user'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Jenis',
            'Kategori',
            'Akun',
            'Jumlah',
            'Keterangan',
            'User'
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->tanggal,
            $row->jenis,
            $row->kategori_keuangan->nama_kategori ?? '-',
            $row->akun_keuangan->nama_akun ?? '-',
            $row->jumlah,
            $row->keterangan,
            $row->user->name ?? '-'
        ];
    }
}