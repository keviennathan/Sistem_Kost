<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;

class Kamar extends Model
{
    use HasFactory;

    // Biar bisa create/update dengan mass assignment
    protected $fillable = [
        'nama_kamar',
        'fasilitas',
        'harga_per_bulan',
        'status',
        'keterangan', // Tambahkan ini
    ];

    // Relasi: satu kamar punya banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // (Opsional) Relasi tidak langsung ke pembayaran lewat bookings
    public function pembayarans()
    {
        return $this->hasManyThrough(
            \App\Models\Pembayaran::class,
            Booking::class,
            'kamar_id',    // Foreign key di tabel bookings
            'booking_id',  // Foreign key di tabel pembayarans
            'id',          // Local key di tabel kamars
            'id'           // Local key di tabel bookings
        );
    }
}
