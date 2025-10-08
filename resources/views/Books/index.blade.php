<x-app-layout>
    <div x-data="{ open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true') }"
        x-init="window.addEventListener('sidebar-toggled', () => { open = JSON.parse(localStorage.getItem('sidebarOpen')); });"
        :class="open ? 'ml-64' : 'ml-16'"
        class="transition-all duration-300">

        <section class="bg-white dark:bg-gray-900 min-h-screen">
            <div class="py-8 px-4 mx-auto max-w-7xl">

                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-6 border-b dark:border-gray-700">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Daftar Barang</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data barang dengan mudah.</p>
                    </div>
                    <div class="flex mt-4 sm:mt-0 gap-2">
                        {{-- Form Pencarian --}}
                        <form action="{{ route('books.index') }}" method="GET" class="flex">
                            <input type="text" name="search" id="table-search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-[#F1A004] focus:border-[#F1A004] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Cari barang..." value="{{ request('search') }}">
                            <button type="submit"
                                class="text-white bg-[#2C3262] hover:bg-[#1e244a] px-4 rounded-r-lg transition-all">
                                Cari
                            </button>
                        </form>

                        {{-- Tombol Tambah Barang (admin) --}}
                        @if (Auth::check() && Auth::user()->role == 'admin')
                            <a href="{{ route('books.create') }}"
                                class="relative group block px-6 py-2.5 text-white font-semibold rounded-2xl
                                       bg-gradient-to-r from-[#F1A004] to-[#CC8600]
                                       shadow-[0_4px_15px_rgba(241,160,4,0.6)]
                                       transition-all duration-500 ease-in-out
                                       hover:scale-110 hover:shadow-[0_8px_25px_rgba(204,134,0,0.8)]
                                       active:scale-95 active:shadow-inner overflow-hidden">
                                <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent 
                                             opacity-0 group-hover:opacity-100 -translate-x-full group-hover:translate-x-full 
                                             transition-all duration-700 ease-in-out"></span>
                                Tambah Barang
                            </a>
                        @endif
                    </div>
                </div>

                @if (session('success'))
                    <div class="my-4 p-4 text-green-800 bg-green-50 border border-green-200 rounded-lg dark:bg-gray-800 dark:text-green-400 dark:border-green-900">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Table dengan gradasi -->
                <div class="relative overflow-x-auto rounded-2xl shadow-2xl mt-6">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#2C3262] via-[#434A8B] to-[#2C3262] rounded-2xl"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-[#2C3262]/40 via-[#434A8B]/40 to-[#2C3262]/40 blur-2xl animate-pulse rounded-2xl"></div>

                    <div class="relative z-10">
                        <table class="w-full text-sm text-left text-white">
                            <thead class="text-xs uppercase bg-[#2C3262]/90 border-b border-white/10">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Barang</th>
                                    <th scope="col" class="px-6 py-3">Kategori</th>
                                    <th scope="col" class="px-6 py-3">Jumlah Stok</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Deskripsi</th>
                                    <th scope="col" class="px-6 py-3 text-center">Kondisi Awal</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                    <th scope="col" class="px-6 py-3 text-center">Pinjam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($books as $book)
                                    <tr class="bg-white/10 border-b border-white/10 hover:bg-white/20 transition">
                                        <td class="px-6 py-4 font-medium text-white">{{ $book->judul_buku }}</td>
                                        <td class="px-6 py-4">{{ $book->kategori }}</td>
                                        <td class="px-6 py-4">{{ $book->jumlah_stok }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight {{ $book->status ? 'text-green-200 bg-green-700/40' : 'text-red-200 bg-red-700/40' }} rounded-full">
                                                {{ $book->status ? 'Tersedia' : 'Tidak Tersedia' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">{{ Str::limit($book->deskripsi, 50) }}</td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($book->kondisi_awal)
                                                <a data-fancybox="gallery" href="{{ asset('images/' . $book->kondisi_awal) }}">
                                                    <img src="{{ asset('storage/' . $book->kondisi_awal) }}" alt="Kondisi Awal" width="50" class="rounded-md shadow-md">
                                                </a>
                                            @else
                                                Tidak ada gambar
                                            @endif
                                        </td>
                                        <td class="px-6 py-6 text-center space-y-2">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('books.edit', $book->id) }}"
                                                class="block px-5 py-2 rounded-xl font-semibold text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:scale-105 transition-transform">
                                                Edit
                                            </a>

                                            <!-- Tombol Delete -->
                                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Yakin mau hapus Barang ini?')"
                                                    class="block px-5 py-2 rounded-xl font-semibold text-white bg-gradient-to-r from-red-600 to-red-800 hover:scale-105 transition-transform">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <!-- Tombol Pinjam -->
                                            <button data-modal-target="modal-{{ $book->id }}" data-modal-toggle="modal-{{ $book->id }}"
                                                class="px-6 py-2 rounded-xl font-semibold text-white bg-gradient-to-r from-[#ff6a5a] to-[#d92c6f] hover:scale-105 transition-transform">
                                                Pinjam
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal --> 
                @foreach ($books as $book) <div id="modal-{{ $book->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"> <div class="relative w-full max-w-md max-h-full"> <div class="relative bg-[#2C3262] rounded-lg shadow"> 
                    <!-- Modal Header --> 
                    <div class="flex items-start justify-between p-4 border-b dark:border-gray-600"> <h3 class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#2C3262] to-[#6a5acd] dark:from-[#F1A004] dark:to-[#CC8600]"> Form Peminjaman Barang </h3> <button type="button" class="text-[#F1A004] bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-[#F1A004] dark:hover:text-white" data-modal-hide="modal-{{ $book->id }}"> <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path> </svg> </button> 
                    </div> 
                    <!-- Modal body --> 
                    <form action="{{ route('books.pinjam') }}" method="POST" class="p-6"> @csrf <input type="hidden" name="book_id" value="{{ $book->id }}"> <!-- Nama Peminjam --> <div class="mb-4"> <label for="nama_peminjam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Nama Peminjam </label> <input type="text" id="nama_peminjam" name="nama_peminjam" class="w-full p-3 rounded-xl text-sm bg-white/20 border border-white/30 text-white focus:ring-2 focus:ring-[#F1A004] focus:border-[#F1A004] focus:outline-none" placeholder="Nama Peminjam" required> </div> <!-- Tanggal Peminjaman --> <div class="mb-4"> <label for="tanggal_pinjam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Peminjaman</label> <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" class="w-full p-3 rounded-xl text-sm bg-white/20 border border-white/30 text-white focus:ring-2 focus:ring-[#F1A004] focus:border-[#F1A004] focus:outline-none" required value="{{ now()->format('Y-m-d') }}"> </div> <!-- Tanggal Pengembalian --> <div class="mb-4"> <label for="tanggal_kembali" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pengembalian</label> <input type="date" id="tanggal_kembali" name="tanggal_kembali" class="w-full p-3 rounded-xl text-sm bg-white/20 border border-white/30 text-white focus:ring-2 focus:ring-[#F1A004] focus:border-[#F1A004] focus:outline-none" required value="{{ now()->addDays(7)->format('Y-m-d') }}"> </div> <button type="submit" class="mt-8 relative inline-flex items-center px-8 py-3 text-sm font-semibold text-white rounded-xl bg-gradient-to-r from-[#F1A004] to-[#CC8600] shadow-[0_4px_15px_rgba(241,160,4,0.6)] transition-all duration-500 ease-in-out hover:scale-105 hover:shadow-[0_8px_25px_rgba(204,134,0,0.8)] active:scale-95 active:shadow-inner overflow-hidden group"> <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent opacity-0 group-hover:opacity-100 translate-x-[-100%] group-hover:translate-x-[100%] transition-all duration-700 ease-in-out"></span> Pinjam</button> </form> </div> </div> </div> 
                @endforeach


            </div>
        </section>
    </div>
</x-app-layout>


<script>
    function openModal(bookId) {
        const modal = document.getElementById(`modal-${bookId}`);
        modal.classList.remove('hidden');
    }

    function setBookId(bookId) {}

    document.addEventListener('click', function(event) {
        if (event.target.matches('[data-modal-hide]')) {
            const modalId = event.target.getAttribute('data-modal-hide');
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
        }
    });

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // hentikan submit default
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
                if (result.isConfirmed) {
                    form.submit(); // kalau setuju, submit form
                }
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
