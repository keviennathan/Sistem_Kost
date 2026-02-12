<?php

namespace App\Livewire;

use Livewire\Component;

class HalamanIndex extends Component
{
    public $activeTab = 'booking';

    public function render()
    {
        return view('livewire.halaman-index');
    }
}
