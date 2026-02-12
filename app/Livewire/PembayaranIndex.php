<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pembayaran;
use App\Models\Booking;

class PembayaranIndex extends Component
{
    public $booking_id, $jumlah_bayar, $metode, $status;
    public $edit_id = null;
    public $updateMode = false;
    public $showModal = false;

    public function render()
    {
        return view('livewire.pembayaran-index', [
            'pembayarans' => Pembayaran::with('booking.kamar')->latest()->get(),
            'bookings' => Booking::with('kamar')
                ->whereDoesntHave('pembayarans')
                ->latest()
                ->get()
        ]);
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function cancelModal()
    {
        $this->resetForm();
        $this->showModal = false;
    }

    public function updatedBookingId($value)
    {
        $booking = Booking::with('kamar')->find($value);

        // Hanya hitung otomatis jika jumlah_bayar belum diisi
        if ($booking && $booking->kamar && $booking->lama_sewa && empty($this->jumlah_bayar)) {
            $this->jumlah_bayar = $booking->kamar->harga_per_bulan * $booking->lama_sewa;
        }
    }

    public function store()
    {
        $this->validate([
            'booking_id' => 'required|exists:bookings,id',
            'jumlah_bayar' => 'required|numeric|min:1000',
            'metode' => 'required|string',
            'status' => 'required|string',
        ]);

        Pembayaran::create([
            'booking_id' => $this->booking_id,
            'jumlah_bayar' => $this->jumlah_bayar,
            'metode' => $this->metode,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Pembayaran berhasil disimpan!');
        $this->cancelModal();
    }

    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $this->edit_id = $pembayaran->id;
        $this->booking_id = $pembayaran->booking_id;
        $this->jumlah_bayar = $pembayaran->jumlah_bayar;
        $this->metode = $pembayaran->metode;
        $this->status = $pembayaran->status;
        $this->updateMode = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'booking_id' => 'required|exists:bookings,id',
            'jumlah_bayar' => 'required|numeric|min:1000',
            'metode' => 'required|string',
            'status' => 'required|string',
        ]);

        $pembayaran = Pembayaran::findOrFail($this->edit_id);

        $pembayaran->update([
            'booking_id' => $this->booking_id,
            'jumlah_bayar' => $this->jumlah_bayar,
            'metode' => $this->metode,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Pembayaran berhasil diperbarui!');
        $this->cancelModal();
    }

    public function delete($id)
    {
        Pembayaran::findOrFail($id)->delete();
        session()->flash('message', 'Pembayaran berhasil dihapus!');
    }

    public function resetForm()
    {
        $this->reset(['booking_id', 'jumlah_bayar', 'metode', 'status', 'edit_id']);
        $this->updateMode = false;
    }
}
