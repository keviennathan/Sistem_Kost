<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Kamar;

class KamarIndex extends Component
{
    public $nama_kamar, $fasilitas, $harga_per_bulan, $status = 'tersedia', $keterangan, $kamar_id;
    public $updateMode = false;
    public $showModal = false;

    public function render()
    {
        return view('livewire.kamar-index', [
            'kamars' => Kamar::all(),
        ]);
    }

    public function resetInput()
    {
        $this->nama_kamar = '';
        $this->fasilitas = '';
        $this->harga_per_bulan = '';
        $this->status = 'tersedia';
        $this->keterangan = '';
        $this->kamar_id = null;
        $this->updateMode = false;
    }

    public function openCreateModal()
    {
        $this->resetInput();
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $this->edit($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->resetInput();
        $this->showModal = false;
    }

    public function store()
    {
        $this->validate([
            'nama_kamar' => 'required',
            'fasilitas' => 'required',
            'harga_per_bulan' => 'required|numeric',
            'keterangan' => 'nullable',
        ]);

        Kamar::create([
            'nama_kamar' => $this->nama_kamar,
            'fasilitas' => $this->fasilitas,
            'harga_per_bulan' => $this->harga_per_bulan,
            'status' => $this->status,
            'keterangan' => $this->keterangan,
        ]);

        session()->flash('message', 'Data kamar berhasil ditambahkan.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);
        $this->nama_kamar = $kamar->nama_kamar;
        $this->fasilitas = $kamar->fasilitas;
        $this->harga_per_bulan = $kamar->harga_per_bulan;
        $this->status = $kamar->status;
        $this->keterangan = $kamar->keterangan;
        $this->kamar_id = $kamar->id;
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'nama_kamar' => 'required',
            'fasilitas' => 'required',
            'harga_per_bulan' => 'required|numeric',
            'keterangan' => 'nullable',
        ]);

        if ($this->kamar_id) {
            $kamar = Kamar::find($this->kamar_id);
            $kamar->update([
                'nama_kamar' => $this->nama_kamar,
                'fasilitas' => $this->fasilitas,
                'harga_per_bulan' => $this->harga_per_bulan,
                'status' => $this->status,
                'keterangan' => $this->keterangan,
            ]);
            session()->flash('message', 'Data kamar berhasil diperbarui.');
            $this->closeModal();
        }
    }

    public function delete($id)
    {
        Kamar::find($id)->delete();
        session()->flash('message', 'Data kamar berhasil dihapus.');
    }
}
