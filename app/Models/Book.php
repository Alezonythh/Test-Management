<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = ['judul_buku', 'penulis', 'kategori', 'tahun_terbit', 'jumlah_stok', 'status','loan_status', 'deskripsi', 'kondisi_awal'];

    public function loans(): HasMany
    {
        return $this->hasMany(pinjamBuku::class);
    }
    public function updateStatus()
{
    if ($this->jumlah_stok > 0) {
        $this->update(['status' => true]);
    } else {
        $this->update(['status' => false]);
    }
}
}
