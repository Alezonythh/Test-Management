     <!-- Tambahan animasi Shine -->
     <style>
         @keyframes shine {
             0% {
                 transform: translateX(-100%);
             }

             100% {
                 transform: translateX(100%);
             }
         }

         @keyframes fadeInScale {
             0% {
                 opacity: 0;
                 transform: scale(0.9);
             }

             100% {
                 opacity: 1;
                 transform: scale(1);
             }
         }

         @keyframes shine {
             0% {
                 transform: translateX(-100%);
             }

             100% {
                 transform: translateX(100%);
             }
         }

         @keyframes text-shine {
             0% {
                 background-position: 0% 50%;
             }

             100% {
                 background-position: 200% 50%;
             }
         }

         .animate-text-shine {
             background-size: 200% auto;
             animation: text-shine 3s linear infinite;
         }
     </style>

     <x-app-layout>

         @php
             $isLoggedIn = Auth::check();
         @endphp

         @endphp
         <div x-data="{ open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true'), loading: true }" x-init="window.addEventListener('sidebar-toggled', () => { open = JSON.parse(localStorage.getItem('sidebarOpen')) });
         setTimeout(() => loading = false, 1000);" :class="open ? 'ml-64' : 'ml-16'"
             class="transition-all duration-300 relative">

             <!-- Loading Overlay -->
             <div x-show="loading"
                 class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-white dark:bg-gray-900 transition-opacity duration-500"
                 x-transition.opacity>

                 <!-- Spinner -->
                 <div
                     class="w-16 h-16 border-4 border-t-indigo-500 border-r-transparent border-b-indigo-500 border-l-transparent rounded-full animate-spin mb-4">
                 </div>

                 <!-- Loading Text -->
                 <p class="text-gray-700 dark:text-gray-300 text-lg font-semibold animate-pulse">
                     Memuat daftar barang…
                 </p>
                 <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                     Mohon tunggu sebentar, semua data sedang dipersiapkan.
                 </p>
             </div>

             <!-- Konten daftar barang -->
             <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8" x-show="!loading"
                 x-transition.opacity>
                 <!-- Header -->
                 <div class="flex flex-col lg:flex-row gap-8 px-6">

                     <!-- Daftar Barang (kiri) -->
                     <div class="flex-1">
                         <h1
                             class="text-3xl font-extrabold mb-6 
            text-transparent bg-clip-text 
            bg-gradient-to-r from-[#F1A004] via-[#F1A004] to-[#F1A004]">
                             📦 Daftar Barang
                         </h1>



                         <!-- Search + Filter di bawah daftar barang -->
                         <div class="mt-8">
                             <div class="flex items-center gap-3 mb-6">
                                 <!-- Search -->
                                 <form action="{{ route('anggota.index') }}" method="GET"
                                     class="flex items-center gap-2 w-1/2">
                                     <div class="relative flex-grow">
                                         <ion-icon name="search-outline"
                                             class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-lg"></ion-icon>
                                         <input type="text" name="search" id="search"
                                             class="w-full pl-10 pr-4 py-2.5 rounded-xl text-gray-900 dark:text-gray-100 
                           placeholder-gray-400 bg-transparent border border-gray-200 dark:border-gray-700 
                           focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm sm:text-base"
                                             placeholder="Cari nama barang..." value="{{ request('search') }}">
                                     </div>

                                     <button type="submit"
                                         class="px-5 py-2.5 rounded-xl font-medium text-white 
                       bg-gradient-to-r from-[#2C3262] to-[#434a8b] 
                       hover:from-[#3a3f78] hover:to-[#2C3262]
                       transition-all duration-300 shadow-md hover:shadow-lg text-sm sm:text-base">
                                         Cari
                                     </button>
                                 </form>

                                 <!-- Badge kategori aktif -->
                                 @if (request('kategori'))
                                     <span
                                         class="px-3 py-1 rounded-full text-sm font-medium
                             bg-indigo-100 text-indigo-700 
                             dark:bg-indigo-500/20 dark:text-indigo-300 shadow-inner">
                                         {{ request('kategori') }}
                                     </span>
                                 @else
                                     <span
                                         class="px-3 py-1 rounded-full text-sm font-medium
                             bg-gray-100 text-gray-600 
                             dark:bg-gray-700 dark:text-gray-300 shadow-inner">
                                         🎯 Semua
                                     </span>
                                 @endif

                                 <!-- Filter -->
                                 <div x-data="{ open: false }" class="relative flex items-center gap-3">
                                     <button @click="open = true" type="button"
                                         class="flex items-center gap-2 px-5 py-3 rounded-xl font-semibold text-sm sm:text-base
                       text-gray-800 dark:text-gray-200 
                       bg-gradient-to-r from-indigo-50 via-white to-indigo-50 
                       dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 
                       border border-gray-200 dark:border-gray-700
                       shadow-sm hover:shadow-md hover:scale-[1.02] transition-all duration-300">
                                         <ion-icon name="pricetag-outline"
                                             class="text-indigo-600 dark:text-indigo-400 text-lg"></ion-icon>
                                         {{ request('kategori') ? request('kategori') : '🎯 Kategori' }}
                                         <ion-icon name="chevron-down-outline"
                                             class="text-indigo-600 dark:text-indigo-400 text-lg"></ion-icon>
                                     </button>



                                     <!-- Modal -->
                                     <div x-show="open" x-transition.opacity
                                         class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4">
                                         <div @click.away="open = false"
                                             class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl w-full max-w-md p-6 
                           transform transition-all duration-500 ease-out scale-95
                           border border-gray-200 dark:border-gray-700">

                                             <!-- Header -->
                                             <h2
                                                 class="text-lg sm:text-xl font-extrabold tracking-wide text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-3">
                                                 <ion-icon name="pricetag-outline"
                                                     class="text-indigo-600 dark:text-indigo-400 text-2xl"></ion-icon>
                                                 Pilih Kategori
                                             </h2>

                                             <!-- Pilihan kategori -->
                                             <form method="GET" action="{{ route('anggota.index') }}"
                                                 class="space-y-3">
                                                 <button type="submit" name="kategori" value=""
                                                     class="w-full py-3 px-5 rounded-xl bg-gradient-to-r from-gray-100 to-gray-200 
                                   dark:from-gray-800 dark:to-gray-700 
                                   hover:from-indigo-500 hover:to-indigo-600 hover:text-white 
                                   text-gray-800 dark:text-gray-200 font-semibold text-base 
                                   shadow-sm hover:shadow-md transition-all duration-300 flex items-center gap-2">
                                                     🎯 Semua Kategori
                                                 </button>
                                                 <button type="submit" name="kategori" value="Camera"
                                                     class="w-full py-3 px-5 rounded-xl bg-gradient-to-r from-gray-100 to-gray-200 
                                   dark:from-gray-800 dark:to-gray-700 
                                   hover:from-indigo-500 hover:to-indigo-600 hover:text-white 
                                   text-gray-800 dark:text-gray-200 font-semibold text-base 
                                   shadow-sm hover:shadow-md transition-all duration-300 flex items-center gap-2">
                                                     📷 Camera
                                                 </button>
                                                 <button type="submit" name="kategori" value="Headset"
                                                     class="w-full py-3 px-5 rounded-xl bg-gradient-to-r from-gray-100 to-gray-200 
                                   dark:from-gray-800 dark:to-gray-700 
                                   hover:from-indigo-500 hover:to-indigo-600 hover:text-white 
                                   text-gray-800 dark:text-gray-200 font-semibold text-base 
                                   shadow-sm hover:shadow-md transition-all duration-300 flex items-center gap-2">
                                                     🎧 Headset
                                                 </button>
                                                 <button type="submit" name="kategori" value="Proyektor"
                                                     class="w-full py-3 px-5 rounded-xl bg-gradient-to-r from-gray-100 to-gray-200 
                                   dark:from-gray-800 dark:to-gray-700 
                                   hover:from-indigo-500 hover:to-indigo-600 hover:text-white 
                                   text-gray-800 dark:text-gray-200 font-semibold text-base 
                                   shadow-sm hover:shadow-md transition-all duration-300 flex items-center gap-2">
                                                     📽️ Proyektor
                                                 </button>
                                             </form>

                                             <!-- Tombol close -->
                                             <div class="mt-6 text-right">
                                                 <button @click="open = false" type="button"
                                                     class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-red-500 to-pink-600 
                                   text-white font-semibold shadow-md hover:shadow-lg 
                                   hover:scale-105 transition-all duration-300">
                                                     Tutup
                                                 </button>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>

                     </div>

                 </div>







                 <!-- Notifikasi Flash Message -->
                 {{-- Notifikasi Sukses --}}
                 @if (session('success'))
                     <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-400"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
                         class="flex items-center gap-3 p-4 mb-4 rounded-2xl shadow-lg border border-green-300 
               bg-gradient-to-r from-green-50 via-white to-green-50 
               dark:from-green-900/30 dark:via-gray-900 dark:to-green-900/20 
               text-green-800 dark:text-green-200 relative"
                         role="alert">

                         <!-- Icon -->
                         <div class="flex-shrink-0 bg-green-500 text-white rounded-full p-2 shadow-md animate-bounce">
                             <ion-icon name="checkmark-circle-outline" class="text-2xl"></ion-icon>
                         </div>

                         <!-- Text -->
                         <div class="flex-1">
                             <p class="font-bold">Berhasil!</p>
                             <p class="text-sm">{{ session('success') }}</p>
                         </div>

                         <!-- Close button -->
                         <button @click="show = false"
                             class="ml-3 text-green-600 dark:text-green-300 hover:scale-110 transition">
                             <ion-icon name="close-outline" class="text-xl"></ion-icon>
                         </button>
                     </div>
                 @endif

                 {{-- Notifikasi Error --}}
                 @if (session('error'))
                     <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-400"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
                         class="flex items-center gap-3 p-4 mb-4 rounded-2xl shadow-lg border border-red-300 
               bg-gradient-to-r from-red-50 via-white to-red-50 
               dark:from-red-900/30 dark:via-gray-900 dark:to-red-900/20 
               text-red-800 dark:text-red-200 relative"
                         role="alert">

                         <!-- Icon -->
                         <div class="flex-shrink-0 bg-red-500 text-white rounded-full p-2 shadow-md animate-pulse">
                             <ion-icon name="alert-circle-outline" class="text-2xl"></ion-icon>
                         </div>

                         <!-- Text -->
                         <div class="flex-1">
                             <p class="font-bold">Oops! Terjadi Kesalahan</p>
                             <p class="text-sm">{{ session('error') }}</p>
                         </div>

                         <!-- Close button -->
                         <button @click="show = false"
                             class="ml-3 text-red-600 dark:text-red-300 hover:scale-110 transition">
                             <ion-icon name="close-outline" class="text-xl"></ion-icon>
                         </button>
                     </div>
                 @endif






                 <!-- Grid Layout untuk Card -->
                 <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-center">
                     @forelse ($books as $book)
                         <div
                             class="relative max-w-md bg-gradient-to-br from-[#2C3262] via-[#434A8B] to-[#2C3262] rounded-3xl shadow-2xl overflow-hidden flex flex-col text-white transform transition-all duration-500 hover:scale-[1.05]">

                             <!-- Efek Glow Animasi -->
                             <div
                                 class="absolute inset-0 bg-gradient-to-r from-[#2C3262]/40 via-[#434A8B]/40 to-[#2C3262]/40 blur-2xl animate-pulse">
                             </div>

                             <!-- Isi Card -->
                             <div class="relative p-6 flex-grow z-10">
                                 <h5 class="mb-4 text-3xl font-extrabold tracking-wide drop-shadow-md">
                                     {{ $book->judul_buku }}
                                 </h5>
                                 <p class="mb-2"><strong>Kategori:</strong> {{ $book->kategori }}</p>
                                 <p class="mb-2"><strong>Jumlah Stok:</strong>
                                     <span
                                         class="px-3 py-1 rounded-full text-sm font-bold shadow-inner 
                {{ $book->jumlah_stok > 0 ? 'bg-green-400 text-green-900' : 'bg-red-400 text-red-900' }}">
                                         {{ $book->jumlah_stok }}
                                     </span>
                                 </p>
                                 <p class="mb-2"><strong>Status:</strong>
                                     <span
                                         class="px-3 py-1 rounded-full text-sm font-bold shadow-inner
                {{ $book->status ? 'bg-green-400 text-green-900' : 'bg-red-400 text-red-900' }}">
                                         {{ $book->status ? 'Tersedia' : 'Tidak Tersedia' }}
                                     </span>
                                 </p>
                                 <p class="mt-4"><strong>Deskripsi:</strong></p>
                                 <p class="text-gray-200 text-sm italic">
                                     {{ Str::limit($book->deskripsi, 100, '...') }}
                                 </p>
                             </div>

                             <!-- Tombol Modal -->
                             <div
                                 class="relative p-4 bg-white/10 backdrop-blur-md text-center border-t border-white/20 z-10">
                                 @if ($isLoggedIn)
                                     <button data-modal-target="modal-{{ $book->id }}"
                                         data-modal-toggle="modal-{{ $book->id }}"
                                         class="relative w-full px-5 py-3 bg-gradient-to-r from-[#2C3262] via-[#434A8B] to-[#2C3262] text-white font-bold rounded-2xl shadow-lg 
                       overflow-hidden transition-all duration-500 hover:scale-105 hover:shadow-indigo-500/50 {{ $book->jumlah_stok <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                         @if ($book->jumlah_stok <= 0) disabled @endif>
                                         <span class="relative z-10 flex items-center justify-center gap-2">
                                             Pinjam Barang
                                         </span>
                                         <!-- Animasi Shine -->
                                         <span
                                             class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full animate-[shine_2s_infinite]"></span>
                                     </button>
                                 @else
                                     <button
                                         class="relative w-full px-5 py-3 bg-gradient-to-r from-[#2C3262] via-[#434A8B] to-[#2C3262] text-white font-bold rounded-2xl shadow-lg 
                       overflow-hidden transition-all duration-500 hover:scale-105 hover:shadow-indigo-500/50">
                                         <a href="{{ route('login') }}">
                                             <span class="relative z-10 flex items-center justify-center gap-2">
                                                 Pinjam Barang
                                             </span>
                                             <span
                                                 class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full animate-[shine_2s_infinite]"></span>
                                         </a>
                                     </button>
                                 @endif
                             </div>
                         </div>


                         <!-- Modal -->
                         <div id="modal-{{ $book->id }}" tabindex="-1"
                             class="fixed inset-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto bg-black/60 backdrop-blur-sm">
                             <div class="relative w-full max-w-sm mx-auto animate-[fadeInScale_0.4s_ease-out]">
                                 <div
                                     class="relative bg-gradient-to-br from-[#2C3262]/95 to-[#434A8B]/95 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden text-white">

                                     <!-- Modal Header -->
                                     <div class="flex items-start justify-between p-4 border-b border-white/20">
                                         <h3 class="text-lg font-extrabold tracking-wide">📚 Form Pinjam Barang</h3>
                                         <button type="button"
                                             class="text-white/70 hover:text-white hover:bg-white/20 rounded-lg text-xs p-2 transition"
                                             data-modal-hide="modal-{{ $book->id }}">
                                             ✖
                                         </button>
                                     </div>

                                     <!-- Modal Body -->
                                     <form action="{{ route('anggota.store') }}" method="POST"
                                         class="p-4 space-y-3 text-sm">
                                         @csrf
                                         <input type="hidden" name="book_id" value="{{ $book->id }}">

                                         @if ($errors->any())
                                             <div class="p-2 text-xs text-red-200 bg-red-500/30 rounded-lg">
                                                 <ul class="list-disc ml-4">
                                                     @foreach ($errors->all() as $error)
                                                         <li>{{ $error }}</li>
                                                     @endforeach
                                                 </ul>
                                             </div>
                                         @endif

                                         @if (Auth::check() && Auth::user()->role == 'admin')
                                             <div>
                                                 <label for="user_id" class="block mb-1 text-xs font-medium">ID
                                                     Pengguna</label>
                                                 <input type="text" id="user_id" name="user_id"
                                                     class="w-full p-2 rounded-lg bg-white/20 border border-white/30 text-white placeholder-gray-200 focus:ring-2 focus:ring-indigo-300 focus:outline-none"
                                                     placeholder="Masukkan ID Pengguna" required>
                                             </div>
                                         @endif

                                         <div>
                                             <label for="nama_peminjam" class="block mb-1 text-xs font-medium">Nama
                                                 Peminjam</label>
                                             <input type="text" id="nama_peminjam" name="nama_peminjam"
                                                 class="w-full p-2 rounded-lg bg-white/20 border border-white/30 text-white focus:ring-2 focus:ring-indigo-300 focus:outline-none"
                                                 value="{{ $isLoggedIn ? Auth::user()->name : '' }}" readonly>
                                         </div>

                                         <div>
                                             <label class="block mb-1 text-xs font-medium">Judul Barang</label>
                                             <input type="text"
                                                 class="w-full p-2 rounded-lg bg-white/20 border border-white/30 text-white focus:outline-none"
                                                 value="{{ $book->judul_buku }}" readonly>
                                         </div>



                                         <div>
                                             <label class="block mb-1 text-xs font-medium">Kategori</label>
                                             <input type="text"
                                                 class="w-full p-2 rounded-lg bg-white/20 border border-white/30 text-white focus:outline-none"
                                                 value="{{ $book->kategori }}" readonly>
                                         </div>

                                         <div>
                                             <label for="tanggal_pinjam"
                                                 class="block mb-1 text-xs font-medium">Tanggal
                                                 Peminjaman</label>
                                             <input type="date" id="tanggal_pinjam" name="tanggal_pinjam"
                                                 class="w-full p-2 rounded-lg bg-white/20 border border-white/30 text-white focus:ring-2 focus:ring-indigo-300 focus:outline-none"
                                                 required>
                                         </div>

                                         <div>
                                             <label for="tanggal_kembali"
                                                 class="block mb-1 text-xs font-medium">Tanggal
                                                 Pengembalian</label>
                                             <input type="date" id="tanggal_kembali" name="tanggal_kembali"
                                                 class="w-full p-2 rounded-lg bg-white/20 border border-white/30 text-white focus:ring-2 focus:ring-indigo-300 focus:outline-none"
                                                 required>
                                         </div>

                                         <!-- Tombol Submit -->
                                         <button type="submit"
                                             class="relative w-full px-3 py-2 rounded-lg font-bold text-white text-sm bg-gradient-to-r from-[#2C3262] via-[#434A8B] to-[#2C3262] shadow-lg overflow-hidden hover:scale-[1.02] transition-all duration-500">
                                             <span class="relative z-10">🚀 Pinjam Sekarang</span>
                                             <span
                                                 class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full animate-[shine_2s_infinite]"></span>
                                         </button>
                                     </form>
                                 </div>
                             </div>
                         </div>

                     @empty
                         <p class="text-center text-gray-700 col-span-3">Tidak ada barang yang ditemukan.
                         </p>
                     @endforelse
                 </div>

             </div>
         </div>




     </x-app-layout>
