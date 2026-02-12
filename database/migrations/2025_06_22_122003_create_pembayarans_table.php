<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings');
            $table->date('tanggal_bayar')->nullable(); // Optional, atau bisa wajib tergantung kebutuhan
            $table->integer('jumlah_bayar');
            $table->string('metode'); // ganti dari 'metode_bayar'
            $table->string('status'); // tambahkan kolom status
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
