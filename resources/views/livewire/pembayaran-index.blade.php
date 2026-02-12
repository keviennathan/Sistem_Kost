<div class="p-6 bg-white rounded shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-blue-600">Pembayaran</h2>

    @if (session()->has('message'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded border border-green-300">
            {{ session('message') }}
        </div>
    @endif

    <!-- Tombol Tambah -->
    <button wire:click="openModal"
        class="mb-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
        + Tambah Pembayaran
    </button>

    <!-- Modal Pop Up -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/40">
        <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold text-blue-600 mb-4">
                {{ $updateMode ? 'Edit Pembayaran' : 'Tambah Pembayaran' }}
            </h3>

            <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}" class="space-y-5">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Booking</label>
                    <select wire:model="booking_id"
                        class="w-full border border-gray-300 rounded p-2 bg-white shadow-sm">
                        <option value="">-- Pilih Booking --</option>
                        @foreach($bookings as $booking)
                            <option value="{{ $booking->id }}">
                                {{ $booking->nama_penyewa }} ({{ $booking->kamar->nama_kamar ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Bayar</label>
                    <input type="number" wire:model="jumlah_bayar" placeholder="Jumlah Bayar"
                        class="w-full border border-gray-300 rounded p-2 bg-white shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                    <input type="text" wire:model="metode" placeholder="Contoh: Transfer"
                        class="w-full border border-gray-300 rounded p-2 bg-white shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select wire:model="status"
                        class="w-full border border-gray-300 rounded p-2 bg-white shadow-sm">
                        <option value="">-- Status --</option>
                        <option value="lunas">Lunas</option>
                        <option value="pending">Pending</option>
                        <option value="gagal">Gagal</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" wire:click="cancelModal"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
                        {{ $updateMode ? 'Update' : 'Simpan' }}
                    </button>
                </div>

            </form>
        </div>
    </div>
    @endif

    <!-- DAFTAR PEMBAYARAN -->
    <h3 class="text-xl font-semibold mb-4 text-gray-700">Daftar Pembayaran</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 text-sm rounded">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border px-3 py-2">#</th>
                    <th class="border px-3 py-2">Penyewa</th>
                    <th class="border px-3 py-2">Kamar</th>
                    <th class="border px-3 py-2">Jumlah</th>
                    <th class="border px-3 py-2">Metode</th>
                    <th class="border px-3 py-2">Status</th>
                    <th class="border px-3 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayarans as $index => $pembayaran)
                    <tr class="hover:bg-gray-50 text-gray-800">
                        <td class="border px-3 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="border px-3 py-2">{{ $pembayaran->booking->nama_penyewa }}</td>
                        <td class="border px-3 py-2">{{ $pembayaran->booking->kamar->nama_kamar ?? '-' }}</td>
                        <td class="border px-3 py-2 text-right">
                            Rp{{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                        </td>
                        <td class="border px-3 py-2">{{ $pembayaran->metode }}</td>
                        <td class="border px-3 py-2 text-center">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $pembayaran->status === 'lunas' ? 'bg-green-200 text-green-800' :
                                   ($pembayaran->status === 'pending' ? 'bg-yellow-200 text-yellow-800' :
                                   'bg-red-200 text-red-800') }}">
                                {{ ucfirst($pembayaran->status) }}
                            </span>
                        </td>
                        <td class="border px-3 py-2 text-center space-x-2">
                            <button wire:click="edit({{ $pembayaran->id }})"
                                class="text-blue-600 hover:underline">Edit</button>
                            <button wire:click="delete({{ $pembayaran->id }})"
                                onclick="return confirm('Yakin ingin menghapus pembayaran ini?')"
                                class="text-red-600 hover:underline">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4">Belum ada pembayaran tercatat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
