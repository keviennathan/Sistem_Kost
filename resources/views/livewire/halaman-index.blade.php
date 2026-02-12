<div class="mt-6">
    @if ($activeTab === 'kamar')
        @livewire('kamar-index')
    @elseif ($activeTab === 'booking')
        @livewire('booking-index')
    @elseif ($activeTab === 'pembayaran')
        @livewire('pembayaran-index')
    @endif
</div>
