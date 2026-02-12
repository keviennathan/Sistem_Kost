<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Kamar;
use Carbon\Carbon;

class BookingIndex extends Component
{
    public $kamar_id, $nama_penyewa, $tanggal_masuk, $tanggal_keluar;
    public $edit_id = null;
    public $updateMode = false;
    public $showModal = false;

    public function render()
    {
        return view('livewire.booking-index', [
            'bookings' => Booking::with('kamar')->latest()->get(),
            'kamars' => $this->updateMode
                ? Kamar::all()
                : Kamar::where('status', 'tersedia')->get(),
        ]);
    }

    public function openModal()
    {
        $this->resetInput();
        $this->showModal = true;
    }

    public function cancelEdit()
    {
        $this->resetInput();
        $this->showModal = false;
    }

    public function store()
    {
        $this->validate([
            'kamar_id' => 'required|exists:kamars,id',
            'nama_penyewa' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'required|date|after:tanggal_masuk',
        ]);

        $kamar = Kamar::findOrFail($this->kamar_id);

        if ($kamar->status === 'terisi') {
            session()->flash('message', 'Kamar sudah dibooking dan tidak tersedia!');
            return;
        }

        $lamaSewa = Carbon::parse($this->tanggal_masuk)->diffInDays(Carbon::parse($this->tanggal_keluar));

        Booking::create([
            'kamar_id' => $this->kamar_id,
            'nama_penyewa' => $this->nama_penyewa,
            'tanggal_masuk' => $this->tanggal_masuk,
            'tanggal_keluar' => $this->tanggal_keluar,
            'lama_sewa' => $lamaSewa,
            'status' => 'aktif',
        ]);

        $kamar->update(['status' => 'terisi']);

        session()->flash('message', 'Booking berhasil ditambahkan!');
        $this->resetInput();
        $this->showModal = false;
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);

        $this->edit_id = $booking->id;
        $this->kamar_id = $booking->kamar_id;
        $this->nama_penyewa = $booking->nama_penyewa;
        $this->tanggal_masuk = $booking->tanggal_masuk;
        $this->tanggal_keluar = $booking->tanggal_keluar;
        $this->updateMode = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'kamar_id' => 'required|exists:kamars,id',
            'nama_penyewa' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'required|date|after:tanggal_masuk',
        ]);

        $lamaSewa = Carbon::parse($this->tanggal_masuk)->diffInDays(Carbon::parse($this->tanggal_keluar));
        $booking = Booking::findOrFail($this->edit_id);

        if ($booking->kamar_id != $this->kamar_id) {
            $newKamar = Kamar::findOrFail($this->kamar_id);

            if ($newKamar->status === 'terisi') {
                session()->flash('message', 'Kamar baru yang dipilih sudah dibooking!');
                return;
            }

            Kamar::where('id', $booking->kamar_id)->update(['status' => 'tersedia']);
            Kamar::where('id', $this->kamar_id)->update(['status' => 'terisi']);
        }

        $booking->update([
            'kamar_id' => $this->kamar_id,
            'nama_penyewa' => $this->nama_penyewa,
            'tanggal_masuk' => $this->tanggal_masuk,
            'tanggal_keluar' => $this->tanggal_keluar,
            'lama_sewa' => $lamaSewa,
        ]);

        session()->flash('message', 'Booking berhasil diupdate!');
        $this->resetInput();
        $this->showModal = false;
    }

    public function delete($id)
    {
        $booking = Booking::findOrFail($id);
        $kamarId = $booking->kamar_id;

        $booking->delete();
        Kamar::where('id', $kamarId)->update(['status' => 'tersedia']);

        session()->flash('message', 'Booking berhasil dihapus!');
    }

    public function resetInput()
    {
        $this->edit_id = null;
        $this->updateMode = false;
        $this->kamar_id = '';
        $this->nama_penyewa = '';
        $this->tanggal_masuk = '';
        $this->tanggal_keluar = '';
    }
}
