<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi langsung
    protected $fillable = [
        'booking_id',
        'jumlah_bayar',
        'metode',
        'status',
    ];

    // Relasi: Pembayaran milik satu Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
