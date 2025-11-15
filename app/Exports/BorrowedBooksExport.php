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
            // judul buku dari relasi Book
            $borrow->book->judul_buku ?? '-',

            // nama peminjam, ambil dari relasi user atau field nama_peminjam
            $borrow->user->name ?? $borrow->nama_peminjam ?? '-',

            // tanggal pinjam
            $borrow->tanggal_pinjam
                ? Carbon::parse($borrow->tanggal_pinjam)->format('d-m-Y')
                : '-',

            // tanggal kembali
            $borrow->tanggal_kembali
                ? Carbon::parse($borrow->tanggal_kembali)->format('d-m-Y')
                : '-',

            // status peminjaman
            ucfirst($borrow->status) ?? '-',

            // catatan pengembalian
            $borrow->deskripsi_pengembalian
                ? $borrow->deskripsi_pengembalian
                : 'Selesai',
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
            'Deskripsi',
        ];
    }
}
