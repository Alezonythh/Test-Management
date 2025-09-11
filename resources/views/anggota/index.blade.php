<x-app-layout>
   
@php
$isLoggedIn = Auth::check();
@endphp
  
    @endphp
    <div class="container mx-auto lg:ps-64">
        <!-- Form Pencarian -->
        <div class="items-center p-4">
            <form action="{{ route('anggota.index') }}" method="GET" class="flex">
                <input type="text" name="search" id="search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                    placeholder="Cari berdasarkan judul atau penulis" value="{{ request('search') }}">
                <button type="submit"
                    class="ml-2 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2.5">
                    Cari
                </button>
            </form>
        </div>

        <!-- Notifikasi Flash Message -->
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Header -->
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 text-center pt-10 text-white">Daftar Buku</h1>

        <!-- Grid Layout untuk Card -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-center">
            @forelse ($books as $book)
                <div class="max-w-md bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden flex flex-col">

                    <!-- Informasi Buku -->
                    <div class="p-6 flex-grow">
                        <h5 class="mb-4 text-2xl font-semibold tracking-tight text-gray-900">
                            {{ $book->judul_buku }}
                        </h5>
                        <p class="text-gray-700 mb-2"><strong>Penulis:</strong> {{ $book->penulis }}</p>
                        <p class="text-gray-700 mb-2"><strong>Kategori:</strong> {{ $book->kategori }}</p>
                        <p class="text-gray-700 mb-2"><strong>Tahun Terbit:</strong> {{ $book->tahun_terbit }}</p>
                        <p class="text-gray-700 mb-2"><strong>Jumlah Stok:</strong> 
                            <span class="px-2 py-1 rounded-lg {{ $book->jumlah_stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $book->jumlah_stok }}
                            </span>
                        </p>
                        <p class="text-gray-700 mb-2"><strong>Status:</strong> 
                            <span class="px-2 py-1 rounded-lg {{ $book->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $book->status ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </p>
                        <p class="text-gray-700 mt-4"><strong>Deskripsi:</strong></p>
                        <p class="text-gray-600 text-sm italic">{{ Str::limit($book->deskripsi, 100, '...') }}</p>
                    </div>

                    <!-- Tombol Modal -->
                    <div class="p-4 bg-gray-100 border-t border-gray-200">
                        @if($isLoggedIn)
                        <button
                            data-modal-target="modal-{{ $book->id }}"
                            data-modal-toggle="modal-{{ $book->id }}"
                            class="w-full px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition
                            {{ $book->jumlah_stok <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                            @if ($book->jumlah_stok <= 0) disabled @endif>
                            Pinjam Buku
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="w-full px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition">
                            Pinjam Buku
                        </a>
                        @endif
                    </div>
                </div>
            <!-- Modal -->
            <div id="modal-{{ $book->id }}" tabindex="-1" 
                class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">   
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal Header -->
                        <div class="flex items-start justify-between p-4 border-b">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Form Pinjam Buku
                            </h3>
                            <button type="button" 
                                    class="text-gray-400 hover:text-gray-900 hover:bg-gray-200 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" 
                                    data-modal-hide="modal-{{ $book->id }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" 
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414 1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" 
                                        clip-rule="evenodd">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <form action="{{ route('anggota.store') }}" method="POST" class="p-6">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (Auth::check() && Auth::user()->role == 'admin')
                            <!-- Input User ID -->
                            <div class="mb-4">
                                <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900">
                                    ID Pengguna
                                </label>
                                <input type="text" id="user_id" name="user_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                    placeholder="Masukkan ID Pengguna" required>
                            </div>
                            @endif
                    
                            <!-- Nama Peminjam -->
                            <div class="mb-4">
                                <label for="nama_peminjam"
                                    class="block mb-2 text-sm font-medium text-gray-900">
                                    Nama Peminjam
                                </label>
                                <input type="text" id="nama_peminjam" name="nama_peminjam"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                    value="{{ $isLoggedIn ? Auth::user()->name : '' }}" readonly>
                            </div>

                            <!-- Informasi YBuku -->
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-900">Judul Buku</label>
                                <input type="text" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                                    value="{{ $book->judul_buku }}" readonly>
                            </div>
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-900">Penulis</label>
                                <input type="text" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                                    value="{{ $book->penulis }}" readonly>
                            </div>
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                                <input type="text" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                                    value="{{ $book->kategori }}" readonly>
                            </div>

                            <!-- Input Tanggal Peminjaman -->
                            <div class="mb-4">
                                <label for="tanggal_pinjam" class="block mb-2 text-sm font-medium text-gray-900">
                                    Tanggal Peminjaman
                                </label>
                                <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                                    required>
                            </div>

                            <!-- Input Tanggal Pengembalian -->
                            <div class="mb-4">
                                <label for="tanggal_kembali" class="block mb-2 text-sm font-medium text-gray-900">
                                    Tanggal Pengembalian
                                </label>
                                <input type="date" id="tanggal_kembali" name="tanggal_kembali" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                                    required>
                            </div>
                            
                            
                            <!-- Tombol Submit -->
                            <button type="submit" 
                                    class="w-full px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm">
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

</x-app-layout>
