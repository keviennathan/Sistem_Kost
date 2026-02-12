<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kamar_id')->constrained('kamars')->onDelete('cascade');
            $table->string('nama_penyewa');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar');
            $table->integer('lama_sewa')->nullable();
            $table->string('status')->default('aktif'); // ✅ Tambahkan ini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
