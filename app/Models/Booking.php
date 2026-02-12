<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi langsung (mass assignment)
    protected $fillable = [
        'kamar_id',
        'nama_penyewa',
        'tanggal_masuk',
        'tanggal_keluar',
        'lama_sewa',     // ✅ penting jika kamu simpan lama sewa ke DB
        'status',
    ];

    // Relasi: Booking milik satu Kamar
    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    // Relasi: Satu Booking bisa punya banyak Pembayaran
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
    
}
