<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class pinjamBuku extends Model
{
    protected $fillable = ['user_id', 'book_id', 'tanggal_pinjam', 'tanggal_kembali','status', 'kondisi_awal'];



        public function user(): BelongsTo
        {
    
            return $this->belongsTo(User::class);
        }

        public function book(): BelongsTo
        {
            return $this->belongsTo(Book::class);
        }
}