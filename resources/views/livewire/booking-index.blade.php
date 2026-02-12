<div class="p-6 bg-white rounded shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-blue-600">Booking Kamar</h2>

    @if (session()->has('message'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded border border-green-300">
            {{ session('message') }}
        </div>
    @endif

    <!-- Tombol Tambah Booking -->
    <button wire:click="openModal"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow mb-4">
        + Tambah Booking
    </button>

    <!-- Modal Form Booking -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
            <h3 class="text-xl font-bold mb-4 text-blue-600">
                {{ $updateMode ? 'Edit Booking' : 'Tambah Booking' }}
            </h3>

            <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Kamar</label>
                    <select wire:model="kamar_id" class="border border-gray-300 rounded w-full p-2">
                        <option value="">-- Pilih Kamar --</option>
                        @foreach($kamars as $kamar)
                            <option value="{{ $kamar->id }}">{{ $kamar->nama_kamar }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penyewa</label>
                    <input type="text" wire:model="nama_penyewa" class="border border-gray-300 rounded w-full p-2">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk</label>
                        <input type="date" wire:model="tanggal_masuk" class="border border-gray-300 rounded w-full p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Keluar</label>
                        <input type="date" wire:model="tanggal_keluar" class="border border-gray-300 rounded w-full p-2">
                    </div>
                </div>

                <div class="flex justify-end space-x-2 pt-4">
                    <button type="button" wire:click="cancelEdit"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Batal</button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        {{ $updateMode ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Daftar Booking -->
    <h3 class="text-xl font-semibold mt-10 mb-3 text-gray-700">Daftar Booking</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-gray-200 rounded overflow-hidden">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-3 py-2 border">#</th>
                    <th class="px-3 py-2 border">Kamar</th>
                    <th class="px-3 py-2 border">Nama</th>
                    <th class="px-3 py-2 border">Masuk</th>
                    <th class="px-3 py-2 border">Keluar</th>
                    <th class="px-3 py-2 border">Status</th>
                    <th class="px-3 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $index => $booking)
                    <tr class="text-gray-700 hover:bg-gray-50">
                        <td class="px-3 py-2 border text-center">{{ $index + 1 }}</td>
                        <td class="px-3 py-2 border">{{ $booking->kamar->nama_kamar }}</td>
                        <td class="px-3 py-2 border">{{ $booking->nama_penyewa }}</td>
                        <td class="px-3 py-2 border">{{ $booking->tanggal_masuk }}</td>
                        <td class="px-3 py-2 border">{{ $booking->tanggal_keluar }}</td>
                        <td class="px-3 py-2 border text-center">{{ $booking->status ?? '-' }}</td>
                        <td class="px-3 py-2 border text-center space-x-2">
                            <button wire:click="edit({{ $booking->id }})" class="text-blue-500 hover:underline">Edit</button>
                            <button wire:click="delete({{ $booking->id }})" class="text-red-500 hover:underline">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4">Belum ada data booking.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
