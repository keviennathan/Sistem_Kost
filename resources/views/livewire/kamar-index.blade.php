<div class="p-6 bg-white rounded shadow-md" x-data="{ showModal: false }">
    <h2 class="text-2xl font-bold mb-6 text-blue-600">Manajemen Kamar</h2>

    @if (session()->has('message'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Tombol Tambah -->
    <div class="mb-4">
        <button @click="showModal = true; $wire.resetInput()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            + Tambah Kamar
        </button>
    </div>

    <!-- Modal -->
    <div x-show="showModal" x-cloak
        class="fixed inset-0 flex items-center justify-center backdrop-blur-sm bg-white/30 z-50">
        <div class="bg-white rounded shadow-lg w-full max-w-lg p-6" @click.away="showModal = false">
            <h3 class="text-xl font-semibold mb-4 text-blue-600">
                {{ $updateMode ? 'Edit Kamar' : 'Tambah Kamar' }}
            </h3>

            <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}" class="space-y-4">
                <input type="text" wire:model="nama_kamar" placeholder="Nama Kamar"
                    class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200">

                <textarea wire:model="fasilitas" placeholder="Fasilitas"
                    class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200"></textarea>

                <input type="number" wire:model="harga_per_bulan" placeholder="Harga Per Bulan"
                    class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200">

                <select wire:model="status"
                    class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200">
                    <option value="tersedia">Tersedia</option>
                    <option value="terisi">Terisi</option>
                </select>

                <textarea wire:model="keterangan" placeholder="Keterangan"
                    class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200"></textarea>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="showModal = false; $wire.resetInput()"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                        {{ $updateMode ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Kamar -->
    <h3 class="text-xl font-semibold mt-10 mb-4 text-gray-700">Daftar Kamar</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 text-sm rounded overflow-hidden">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Fasilitas</th>
                    <th class="px-4 py-2 border">Harga</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Keterangan</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kamars as $index => $kamar)
                    <tr class="hover:bg-gray-50 text-gray-800">
                        <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $kamar->nama_kamar }}</td>
                        <td class="px-4 py-2 border">{{ $kamar->fasilitas }}</td>
                        <td class="px-4 py-2 border">Rp{{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 border text-center">
                            <span class="inline-block px-2 py-1 rounded
                                {{ $kamar->status === 'tersedia' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                {{ ucfirst($kamar->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border">{{ $kamar->keterangan }}</td>
                        <td class="px-4 py-2 border text-center space-x-2">
                            <button @click="showModal = true; $wire.edit({{ $kamar->id }})"
                                class="text-blue-600 hover:underline">Edit</button>
                            <button wire:click="delete({{ $kamar->id }})"
                                class="text-red-600 hover:underline">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4">Belum ada data kamar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
