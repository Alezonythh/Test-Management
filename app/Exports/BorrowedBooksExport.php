<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class BorrowedBooksExport implements FromCollection, WithMapping, WithHeadings
{
    protected $borrowedBooks;

    public function __construct($borrowedBooks)
    {
        $this->borrowedBooks = $borrowedBooks;
    }

    public function collection()
    {
        return new Collection($this->borrowedBooks);
    }

    public function map($borrow): array
    {
        return [
            $borrow->book->judul_buku ?? '-',
            $borrow->user->name ?? $borrow->nama_peminjam ?? '-',
            $borrow->tanggal_pinjam ? Carbon::parse($borrow->tanggal_pinjam)->format('d-m-Y') : '-',
            $borrow->tanggal_kembali ? Carbon::parse($borrow->tanggal_kembali)->format('d-m-Y') : '-',
            ucfirst($borrow->status) ?? '-',
            $borrow->kondisi_awal ?? '-',
            $borrow->kondisi_akhir ?? '-',
        ];
    }

    public function headings(): array
    {
        return [
            'Judul Buku',
            'Peminjam',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status',
            'Kondisi Awal',
            'Kondisi Akhir'
        ];
    }
}
