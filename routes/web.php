<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

use App\Livewire\KamarIndex;
use App\Livewire\BookingIndex;
use App\Livewire\PembayaranIndex;
use App\Livewire\HalamanIndex;

Route::get('/', HalamanIndex::class)->name('home');
Route::get('/kamar', KamarIndex::class)->name('kamar');
Route::get('/booking', BookingIndex::class)->name('booking');
Route::get('/pembayaran', PembayaranIndex::class)->name('pembayaran');
