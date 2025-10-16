<x-app-layout>
    <div x-data="{ open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true') }" x-init="window.addEventListener('sidebar-toggled', () => { open = JSON.parse(localStorage.getItem('sidebarOpen')); });" :class="open ? 'ml-64' : 'ml-16'"
        class="transition-all duration-300">

        <section class="bg-[#fff9ef] dark:bg-[#0f0f1a] min-h-screen">
            <div class="py-10 px-4 mx-auto max-w-7xl">

                <!-- Header -->
                <div
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-6 mb-6 rounded-2xl shadow-md 
                           bg-[#F1A004]/10 dark:bg-[#2C3262]/60 border border-[#F1A004]/30 dark:border-white/10 backdrop-blur-md">
                    <div>
                        <h2 class="text-2xl font-extrabold text-[#F1A004] dark:text-white">📦 Daftar Barang</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Kelola data barang dengan mudah.</p>
                    </div>
                    <div class="flex mt-4 sm:mt-0 gap-2">
                        {{-- Form Pencarian --}}
                        <form action="{{ route('books.index') }}" method="GET" class="flex">
                            <input type="text" name="search" id="table-search"
                                class="bg-white border border-[#F1A004]/50 text-gray-900 text-sm rounded-l-lg 
                                       focus:ring-[#F1A004] focus:border-[#F1A004] block w-full p-2.5 
                                       dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                placeholder="Cari barang..." value="{{ request('search') }}">
                            <button type="submit"
                                class="text-white bg-[#F1A004] hover:bg-[#d89200] px-4 rounded-r-lg transition-all">
                                Cari
                            </button>
                        </form>

                        {{-- Tombol Tambah Barang --}}
                        @if (Auth::check() && Auth::user()->role == 'admin')
                            <a href="{{ route('books.create') }}"
                                class="relative group block px-6 py-2.5 text-white font-semibold rounded-2xl
                                       bg-gradient-to-r from-[#F1A004] to-[#d89200]
                                       shadow-[0_4px_15px_rgba(241,160,4,0.5)]
                                       transition-all duration-500 ease-in-out
                                       hover:scale-110 hover:shadow-[0_8px_25px_rgba(204,134,0,0.6)]
                                       active:scale-95 overflow-hidden">
                                <span
                                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent 
                                             opacity-0 group-hover:opacity-100 -translate-x-full group-hover:translate-x-full 
                                             transition-all duration-700 ease-in-out"></span>
                                + Tambah Barang
                            </a>
                        @endif
                    </div>
                </div>

                @if (session('success'))
                    <div
                        class="my-4 p-4 text-green-800 bg-green-50 border border-green-200 rounded-lg dark:bg-green-900/30 dark:text-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Table -->
                <div
                    class="relative overflow-x-auto rounded-2xl shadow-xl border border-[#F1A004]/20 dark:border-white/10">
                    <table class="w-full text-sm text-left">
                        <thead
                            class="uppercase text-xs bg-[#F1A004]/90 text-white dark:bg-[#2C3262]/90 dark:text-gray-100">
                            <tr>
                                <th class="px-6 py-3">Nama Barang</th>
                                <th class="px-6 py-3">Kategori</th>
                                <th class="px-6 py-3">Jumlah Stok</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Deskripsi</th>
                                <th class="px-6 py-3 text-center">Kondisi Awal</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                                <th class="px-6 py-3 text-center">Pinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                                <tr
                                    class="bg-white hover:bg-[#fff3cd] border-b border-[#F1A004]/20 
                                           dark:bg-[#1c1c2e] dark:hover:bg-[#2a2a46] dark:border-gray-700 transition">
                                    <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">
                                        {{ $book->judul_buku }}</td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $book->kategori }}</td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $book->jumlah_stok }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold 
                                                   {{ $book->status ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                                            {{ $book->status ? 'Tersedia' : 'Tidak Tersedia' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        {{ Str::limit($book->deskripsi, 50) }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($book->kondisi_awal)
                                            <img src="{{ asset('storage/' . $book->kondisi_awal) }}" alt="Foto"
                                                class="w-12 h-12 object-cover rounded-lg mx-auto border border-[#F1A004]/40 shadow">
                                        @else
                                            <span class="text-gray-400 italic">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-6 text-center space-y-2">
                                        <a href="{{ route('books.edit', $book->id) }}"
                                            class="block px-5 py-2 rounded-lg font-semibold text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:scale-105 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                            class="inline delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="block px-5 py-2 rounded-lg font-semibold text-white bg-gradient-to-r from-red-500 to-red-700 hover:scale-105 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button data-modal-target="modal-{{ $book->id }}"
                                            data-modal-toggle="modal-{{ $book->id }}" @class([
                                                'px-6 py-2 rounded-lg font-semibold text-white hover:scale-105 transition disabled:opacity-50 disabled:cursor-not-allowed',
                                                $book->jumlah_stok > 0
                                                    ? 'bg-gradient-to-r from-[#F1A004] to-[#d89200]'
                                                    : 'bg-gray-400',
                                            ])
                                            @if ($book->jumlah_stok <= 0) disabled @endif>
                                            {{ $book->jumlah_stok <= 0 ? 'Habis' : 'Pinjam' }}
                                        </button>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modal -->
                @foreach ($books as $book)
                    <div id="modal-{{ $book->id }}" tabindex="-1"
                        class="fixed inset-0 z-50 hidden w-full p-4 overflow-y-auto bg-black/50 backdrop-blur-sm">
                        <div
                            class="relative mx-auto w-full max-w-md bg-white dark:bg-[#2C3262] rounded-2xl shadow-xl p-6">
                            <div class="flex justify-between items-center border-b pb-3 dark:border-gray-600">
                                <h3 class="font-bold text-lg text-[#F1A004] dark:text-white">Form Peminjaman</h3>
                                <button type="button" data-modal-hide="modal-{{ $book->id }}"
                                    class="text-[#F1A004] dark:text-white hover:opacity-70">
                                    ✕
                                </button>
                            </div>
                            <form action="{{ route('books.pinjam') }}" method="POST" class="mt-6 space-y-4">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <div>
                                    <label for="nama_peminjam" class="block text-sm font-medium">Nama Peminjam</label>
                                    <input type="text" id="nama_peminjam" name="nama_peminjam"
                                        class="w-full p-3 rounded-lg text-sm bg-gray-50 border border-[#F1A004]/40 focus:ring-2 focus:ring-[#F1A004] dark:bg-white/10 dark:text-white dark:border-white/30"
                                        placeholder="Nama peminjam..." required>
                                </div>
                                <div>
                                    <label for="tanggal_pinjam" class="block text-sm font-medium">Tanggal Pinjam</label>
                                    <input type="date" id="tanggal_pinjam" name="tanggal_pinjam"
                                        class="w-full p-3 rounded-lg text-sm bg-gray-50 border border-[#F1A004]/40 focus:ring-2 focus:ring-[#F1A004] dark:bg-white/10 dark:text-white dark:border-white/30"
                                        value="{{ now()->format('Y-m-d') }}" required>
                                </div>
                                <div>
                                    <label for="tanggal_kembali" class="block text-sm font-medium">Tanggal
                                        Kembali</label>
                                    <input type="date" id="tanggal_kembali" name="tanggal_kembali"
                                        class="w-full p-3 rounded-lg text-sm bg-gray-50 border border-[#F1A004]/40 focus:ring-2 focus:ring-[#F1A004] dark:bg-white/10 dark:text-white dark:border-white/30"
                                        value="{{ now()->addDays(7)->format('Y-m-d') }}" required>
                                </div>
                                <button type="submit"
                                    class="w-full mt-6 px-8 py-3 text-sm font-semibold text-white rounded-xl bg-gradient-to-r from-[#F1A004] to-[#d89200] hover:scale-105 transition">
                                    Pinjam
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>

<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin?',
                text: "Data buku akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    @if (session('deleted'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('deleted') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif
    @if (session('updated'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('updated') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif
    @if (session('created'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('created') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif
</script>
