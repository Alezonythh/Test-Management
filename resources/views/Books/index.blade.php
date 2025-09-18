<x-app-layout>
    <div x-data="{open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true'),}" 
            x-init="window.addEventListener('sidebar-toggled', () => {open = JSON.parse(localStorage.getItem('sidebarOpen'));
        });"
        :class="open ? 'ml-64' : 'ml-16'" class="transition-all duration-300">
        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-7xl">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Barang</h2>
                    @if (Auth::check() && Auth::user()->role == 'admin')
                    <a href="{{ route('books.create') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:bg-[#F1A004] dark:hover:bg-[#CC8600] dark:focus:ring-blue-800">
                        Tambah Barang
                    </a>
                    @endif
                </div>
                <div class="flex items-center justify-between mb-4">
                    <form action="{{ route('books.index') }}" method="GET" class="w-full max-w-md">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 5a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" name="search" id="table-search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search">
                        </div>
                    </form>
                </div>
                @if(session('success'))
                <div
                    class="mb-4 p-4 text-green-800 bg-green-50 border border-green-200 rounded-lg dark:bg-gray-800 dark:text-green-400 dark:border-green-900">
                    {{ session('success') }}
                </div>
                @endif

                <div class="shadow-md sm:rounded-lg w-full overflow-x-auto">
                    <table class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama Barang</th>
                                <th scope="col" class="px-6 py-3">Kategori</th>
                                <th scope="col" class="px-6 py-3">Jumlah Stok</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Deskripsi</th>
                                <th scope="col" class="px-6 py-3 text-center">Kondisi Awal</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                                <th scope="col" class="px-6 py-3">Pinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 ">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $book->judul_buku }}</td>
                                <td class="px-6 py-4">{{ $book->kategori }}</td>
                                <td class="px-6 py-4">{{ $book->jumlah_stok }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight {{ $book->status ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100' }} rounded-full">
                                        {{ $book->status ? 'Tersedia' : 'Tidak Tersedia' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ Str::limit($book->deskripsi, 50) }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($book->kondisi_awal)
                                        <a data-fancybox="gallery" href="{{ asset('images/' . $book->kondisi_awal) }}">
                                            <img src="{{ asset('images/' . $book->kondisi_awal) }}" alt="Kondisi Awal" width="50">
                                        </a>
                                    @else
                                        Tidak ada gambar
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('books.edit', $book->id) }}"
                                        class="text-blue-600 dark:text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-600">Edit</a>
                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-600"
                                            onclick="return confirm('Yakin mau hapus Barang ini?')">Delete</button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        class="font-medium text-blue-600 dark:text-[#F1A004] hover:text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-white dark:hover:bg-[#F1A004] dark:focus:ring-[#F1A004]"
                                        data-modal-target="modal-{{ $book->id }}"
                                        data-modal-toggle="modal-{{ $book->id }}">Pinjam
                                    </button>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modal -->
                @foreach($books as $book)
                <div id="modal-{{ $book->id }}" tabindex="-1"
                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <div class="relative bg-[#2C3262] rounded-lg shadow">
                            <!-- Modal Header -->
                            <div class="flex items-start justify-between p-4 border-b dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Form Peminjaman Barang
                                </h3>
                                <button type="button" 
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                                        data-modal-hide="modal-{{ $book->id }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                </button>
                            </div>

                            <!-- Modal body -->
                            <form action="{{ route('books.pinjam') }}" method="POST" class="p-6">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <!-- Nama Peminjam -->
                                <div class="mb-4">
                                    <label for="nama_peminjam"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Nama Peminjam
                                    </label>
                                    <input type="text" id="nama_peminjam" name="nama_peminjam"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Nama Peminjam" required>
                                </div>

                                <!-- Tanggal Peminjaman -->
                                <div class="mb-4">
                                    <label for="tanggal_pinjam"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                                        Peminjaman</label>
                                    <input type="date" id="tanggal_pinjam" name="tanggal_pinjam"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required value="{{ now()->format('Y-m-d') }}">
                                </div>

                                <!-- Tanggal Pengembalian -->
                                <div class="mb-4">
                                    <label for="tanggal_kembali"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                                        Pengembalian</label>
                                    <input type="date" id="tanggal_kembali" name="tanggal_kembali"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required value="{{ now()->addDays(7)->format('Y-m-d') }}">
                                </div>

                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 mt-10 text-center dark:bg-[#F1A004] dark:hover:bg-[#CC8600] dark:focus:ring-[#CC8600]">Pinjam</button>
                            </form>
                        </div>
                    </div>
                </div>
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

    function setBookId(bookId) {
    }

    document.addEventListener('click', function(event) {
        if (event.target.matches('[data-modal-hide]')) {
            const modalId = event.target.getAttribute('data-modal-hide');
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
        }
    });
</script>
