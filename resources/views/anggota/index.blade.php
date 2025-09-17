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
                                {{ trim(str_replace(' -----', '', $book->judul_buku)) }}
                            </h5>
                            <p class="mb-2"><strong>Kategori:</strong> {{ $book->kategori }}</p>
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
