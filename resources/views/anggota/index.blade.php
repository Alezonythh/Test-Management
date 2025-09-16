<x-app-layout>

    @php
        $isLoggedIn = Auth::check();
    @endphp

    @endphp
    <div x-data="{
        open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true'),
    }" x-init="window.addEventListener('sidebar-toggled', () => {
        open = JSON.parse(localStorage.getItem('sidebarOpen'));
    });" :class="open ? 'ml-64' : 'ml-16'"
        class="transition-all duration-300">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8">
            <!-- Form Pencarian -->
            <div class="flex justify-center p-2">
                <form action="{{ route('anggota.index') }}" method="GET"
                    class="flex w-full max-w-5xl bg-white dark:bg-gray-900 rounded-2xl shadow-xl overflow-hidden ring-1 ring-gray-200 dark:ring-gray-700">

                    <!-- Input -->
                    <input type="text" name="search" id="search"
                        class="flex-grow px-4 py-2.5 text-gray-900 dark:text-gray-100 placeholder-gray-400 
           bg-transparent focus:outline-none text-base"
                        placeholder="Cari judul atau penulis..." value="{{ request('search') }}">

                    <!-- Tombol -->
                    <button type="submit"
                        class="px-6 py-2.5 font-medium text-white 
           bg-gradient-to-r from-[#2C3262] to-[#434a8b] 
           hover:from-[#3a3f78] hover:to-[#2C3262]
           transition-all duration-300 rounded-l-none rounded-r-2xl 
           shadow-md hover:shadow-lg text-base">
                        Cari
                    </button>
                </form>
            </div>



            <!-- Notifikasi Flash Message -->
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Header -->
            <h1
                class="text-3xl font-extrabold text-center pt-2 
           bg-gradient-to-r from-[#2C3262] via-[#4a56a6] to-[#2C3262] 
           bg-clip-text text-transparent drop-shadow-lg mb-3">
                Daftar Peminjaman Barang
            </h1>

            <p class="text-center text-gray-600 dark:text-gray-300 
          max-w-2xl mx-auto mb-8 leading-relaxed">
                Berikut adalah daftar semua barang yang tersedia untuk dipinjam.
                Silakan pilih sesuai kebutuhan Anda.
            </p>


            <!-- Grid Layout untuk Card -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-center">
                @forelse ($books as $book)
                    <div
                        class="max-w-md bg-gradient-to-br from-[#2C3262] via-[#3d4a92] to-[#1a1c3f] border border-gray-700 rounded-2xl shadow-xl overflow-hidden flex flex-col transition transform duration-500 hover:scale-[1.02] hover:shadow-2xl">

                        <!-- Informasi Buku -->
                        <div class="p-6 flex-grow text-white">
                            <h5 class="mb-4 text-2xl font-bold tracking-wide">
                                {{ $book->judul_buku }}
                            </h5>
                            <p class="mb-2"><strong>Penulis:</strong> {{ $book->penulis }}</p>
                            <p class="mb-2"><strong>Kategori:</strong> {{ $book->kategori }}</p>
                            <p class="mb-2"><strong>Tahun Terbit:</strong> {{ $book->tahun_terbit }}</p>
                            <p class="mb-2"><strong>Jumlah Stok:</strong>
                                <span
                                    class="px-2 py-1 rounded-lg font-semibold
                        {{ $book->jumlah_stok > 0 ? 'bg-green-500/20 text-green-300 border border-green-400/40' : 'bg-red-500/20 text-red-300 border border-red-400/40' }}">
                                    {{ $book->jumlah_stok }}
                                </span>
                            </p>
                            <p class="mb-2"><strong>Status:</strong>
                                <span
                                    class="px-2 py-1 rounded-lg font-semibold
                        {{ $book->status ? 'bg-green-500/20 text-green-300 border border-green-400/40' : 'bg-red-500/20 text-red-300 border border-red-400/40' }}">
                                    {{ $book->status ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </p>
                            <p class="mt-4"><strong>Deskripsi:</strong></p>
                            <p class="text-gray-300 text-sm italic">{{ Str::limit($book->deskripsi, 100, '...') }}</p>
                        </div>

                        <!-- Tombol Modal -->
                        <div class="p-4 bg-[#1a1c3f] border-t border-gray-700">
                            @if ($isLoggedIn)
                                <button data-modal-target="modal-{{ $book->id }}"
                                    data-modal-toggle="modal-{{ $book->id }}"
                                    class="w-full px-5 py-3 font-bold text-white text-lg
               relative overflow-hidden rounded-2xl shadow-lg
               bg-gradient-to-r from-[#6a5acd] to-[#2C3262]
               transform transition-all duration-300
               hover:scale-105 hover:shadow-2xl
               active:scale-95 active:shadow-inner
               group
               {{ $book->jumlah_stok <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    @if ($book->jumlah_stok <= 0) disabled @endif>

                                    <!-- Shimmer Effect -->
                                    <span
                                        class="absolute inset-0 bg-white/20 blur-md opacity-0 group-hover:opacity-30 transition-opacity duration-500 rounded-2xl"></span>
                                    <span
                                        class="absolute left-0 top-0 w-0 h-full bg-white/10 skew-x-[-20deg] transition-all duration-500 group-hover:w-full"></span>

                                    Pinjam Buku
                                </button>
                            @else
                                <a href="{{ route('login') }}"
                                    class="w-full px-4 py-2 bg-gradient-to-r from-[#6a5acd] to-[#2C3262] text-white font-semibold rounded-lg shadow-md hover:shadow-lg hover:brightness-110 transition">
                                    Pinjam Buku
                                </a>
                            @endif
                        </div>



                    </div>


                    <!-- Modal -->
                    <div id="modal-{{ $book->id }}" tabindex="-1"
                        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full
           backdrop-blur-sm bg-black/30">

                        <div class="relative w-full max-w-md max-h-full mx-auto">
                            <div
                                class="relative bg-gradient-to-br from-[#2C3262] to-[#434a8b] rounded-3xl shadow-2xl overflow-hidden border border-gray-700">

                                <!-- Modal Header -->
                                <div class="flex items-center justify-between p-5 border-b border-gray-600">
                                    <h3 class="text-xl font-bold text-white tracking-wide">
                                        Form Pinjam Barang
                                    </h3>
                                    <button type="button"
                                        class="text-white hover:text-gray-200 hover:bg-white/20 rounded-full p-2 transition"
                                        data-modal-hide="modal-{{ $book->id }}">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414 1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <form action="{{ route('anggota.store') }}" method="POST" class="p-6 space-y-4">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">

                                    @if ($errors->any())
                                        <div class="bg-red-100 text-red-700 p-2 rounded-lg text-sm">
                                            <ul class="list-disc list-inside">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if (Auth::check() && Auth::user()->role == 'admin')
                                        <div>
                                            <label for="user_id" class="block mb-1 text-sm font-semibold text-white">
                                                ID Pengguna
                                            </label>
                                            <input type="text" id="user_id" name="user_id"
                                                class="w-full p-2.5 text-gray-900 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#2C3262]"
                                                placeholder="Masukkan ID Pengguna" required>
                                        </div>
                                    @endif

                                    <div>
                                        <label for="nama_peminjam" class="block mb-1 text-sm font-semibold text-white">
                                            Nama Peminjam
                                        </label>
                                        <input type="text" id="nama_peminjam" name="nama_peminjam"
                                            class="w-full p-2.5 text-gray-900 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#2C3262]"
                                            value="{{ $isLoggedIn ? Auth::user()->name : '' }}" readonly>
                                    </div>

                                    <div>
                                        <label class="block mb-1 text-sm font-semibold text-white">Judul Buku</label>
                                        <input type="text"
                                            class="w-full p-2.5 text-gray-900 rounded-lg border border-gray-300"
                                            value="{{ $book->judul_buku }}" readonly>
                                    </div>

                                    <div>
                                        <label class="block mb-1 text-sm font-semibold text-white">Penulis</label>
                                        <input type="text"
                                            class="w-full p-2.5 text-gray-900 rounded-lg border border-gray-300"
                                            value="{{ $book->penulis }}" readonly>
                                    </div>

                                    <div>
                                        <label class="block mb-1 text-sm font-semibold text-white">Kategori</label>
                                        <input type="text"
                                            class="w-full p-2.5 text-gray-900 rounded-lg border border-gray-300"
                                            value="{{ $book->kategori }}" readonly>
                                    </div>

                                    <div>
                                        <label for="tanggal_pinjam" class="block mb-1 text-sm font-semibold text-white">
                                            Tanggal Peminjaman
                                        </label>
                                        <input type="date" id="tanggal_pinjam" name="tanggal_pinjam"
                                            class="w-full p-2.5 text-gray-900 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#2C3262]"
                                            required>
                                    </div>

                                    <div>
                                        <label for="tanggal_kembali"
                                            class="block mb-1 text-sm font-semibold text-white">
                                            Tanggal Pengembalian
                                        </label>
                                        <input type="date" id="tanggal_kembali" name="tanggal_kembali"
                                            class="w-full p-2.5 text-gray-900 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#2C3262]"
                                            required>
                                    </div>

                                    <button type="submit"
                                        class="w-full py-3 font-bold text-white text-lg
           bg-gradient-to-r from-[#FF6B6B] to-[#FF8E53] 
           rounded-2xl shadow-lg shadow-[#FF6B6B]/50
           hover:from-[#FF8787] hover:to-[#FFA17F]
           hover:scale-105 transform transition-all duration-300
           relative overflow-hidden">

                                        <span
                                            class="absolute inset-0 bg-white/10 blur-md opacity-0 hover:opacity-30 transition-opacity duration-300 rounded-2xl"></span>
                                        Pinjam
                                    </button>


                                </form>
                            </div>
                        </div>
                    </div>

                @empty
                    <p class="text-center text-gray-700 col-span-3">Tidak ada buku yang ditemukan.</p>
                @endforelse
            </div>


            <!-- Pagination -->
            <div class="mt-6 pb-6">
                {{ $books->links('pagination::tailwind') }}
            </div>

        </div>
    </div>

</x-app-layout>
