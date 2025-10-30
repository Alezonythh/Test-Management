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

         <div x-data="{ open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true') }" x-init="window.addEventListener('sidebar-toggled', () => {
             open = JSON.parse(localStorage.getItem('sidebarOpen'));
         });" :class="open ? 'ml-0 sm:ml-64' : 'ml-0 sm:ml-16'"
             class="transition-all duration-300 relative">



             <!-- Konten daftar barang -->
             <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8">
                 <!-- Header -->
                 <div class="flex flex-col lg:flex-row gap-8 px-6">

                     <!-- Daftar Barang (kiri) -->
                     <div class="flex-1">
                         <div class="mb-6">
                             <h1
                                 class="text-3xl sm:text-4xl font-extrabold mb-2
        text-transparent bg-clip-text 
        bg-gradient-to-r from-[#F1A004] via-[#F1A004] to-[#F1A004] 
        dark:from-indigo-500 dark:via-purple-600 dark:to-indigo-700">
                                 Daftar Barang
                             </h1>
                             <p class="text-gray-700 dark:text-gray-300 text-sm sm:text-base">
                                 Berikut adalah daftar barang yang tersedia untuk dipinjam.
                             </p>
                         </div>




                         <!-- Search + Filter di bawah daftar barang -->
                         <div class="mt-6 sm:mt-8">
                             <div class="flex flex-col sm:flex-row sm:items-center sm:gap-3 mb-6">

                                 <!-- Search -->
                                 <form action="{{ route('anggota.index') }}" method="GET"
                                     class="flex w-full sm:w-1/2 gap-2 mb-3 sm:mb-0">

                                     <div class="relative flex-grow">
                                         <!-- Icon -->
                                         <ion-icon name="search-outline"
                                             class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 text-lg"></ion-icon>

                                         <!-- Input -->
                                         <input type="text" name="search" id="search"
                                             class="w-full pl-10 pr-4 py-2.5 rounded-xl
            text-gray-900 dark:text-gray-100 placeholder-gray-400
            bg-gradient-to-r from-yellow-50 to-pink-50 dark:from-gray-800 dark:to-gray-900
            border border-gray-300 dark:border-gray-700
            focus:outline-none focus:ring-2 focus:ring-pink-500 dark:focus:ring-yellow-400
            shadow-sm hover:shadow-md transition-all duration-300
            text-sm sm:text-base"
                                             placeholder="Cari nama barang..." value="{{ request('search') }}">
                                     </div>

                                     <button type="submit"
                                         class="px-4 sm:px-5 py-2.5 sm:py-2 rounded-xl font-medium text-white
                bg-gradient-to-r from-[#2C3262] to-[#434a8b]
                hover:from-[#3a3f78] hover:to-[#2C3262]
                transition-all duration-300 shadow-md hover:shadow-lg text-sm sm:text-base">
                                         Cari
                                     </button>
                                 </form>

                                 <!-- Badge kategori aktif -->



                                 <!-- Filter -->
                                 <div x-data="{ open: false }"
                                     class="relative mt-3 sm:mt-0 sm:ml-3 flex items-center gap-3">
                                     <button @click="open = true" type="button"
                                         class="flex items-center gap-2 px-4 sm:px-5 py-2.5 rounded-xl font-semibold text-sm sm:text-base
    text-gray-800 dark:text-gray-100
    bg-gradient-to-r from-indigo-100 via-white to-indigo-100
    dark:from-gray-700 dark:via-gray-900 dark:to-gray-800
    border border-gray-300 dark:border-gray-600
    shadow-sm hover:shadow-md hover:scale-105 transition-all duration-300
    focus:outline-none focus:ring-2 focus:ring-indigo-400 dark:focus:ring-yellow-400">

                                         <!-- Icon kategori -->
                                         <ion-icon name="pricetag-outline"
                                             class="text-indigo-600 dark:text-yellow-400 text-lg sm:text-xl"></ion-icon>

                                         <!-- Label -->
                                         <span class="truncate max-w-[120px] sm:max-w-[200px]">
                                             {{ request('kategori') ? request('kategori') : '🎯 Kategori' }}
                                         </span>

                                         <!-- Icon panah -->
                                         <ion-icon name="chevron-down-outline"
                                             class="text-indigo-600 dark:text-yellow-400 text-lg sm:text-xl"></ion-icon>
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
                                                 @foreach (['', 'Camera', 'Headset', 'Proyektor'] as $cat)
                                                     <button type="submit" name="kategori" value="{{ $cat }}"
                                                         class="w-full py-3 px-5 rounded-xl bg-gradient-to-r from-gray-100 to-gray-200
                            dark:from-gray-800 dark:to-gray-700
                            hover:from-indigo-500 hover:to-indigo-600 hover:text-white
                            text-gray-800 dark:text-gray-200 font-semibold text-base
                            shadow-sm hover:shadow-md transition-all duration-300 flex items-center gap-2">
                                                         {{ $cat === '' ? '🎯 Semua Kategori' : ($cat === 'Camera' ? '📷 Camera' : ($cat === 'Headset' ? '🎧 Headset' : '📽️ Proyektor')) }}
                                                     </button>
                                                 @endforeach
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
                             class="relative max-w-sm w-full rounded-3xl shadow-xl border border-gray-200 dark:border-white/10 overflow-hidden 
    bg-white dark:bg-gradient-to-br dark:from-[#2C3262] dark:via-[#434A8B] dark:to-[#2C3262]
    text-gray-900 dark:text-white transform transition-all duration-500 hover:scale-[1.03] hover:shadow-2xl">

                             <!-- Header / Logo Placeholder -->
                             <div
                                 class="flex items-center justify-between p-5 border-b border-gray-100 dark:border-white/10">
                                 <div class="flex items-center space-x-3">
                                     <div
                                         class="w-10 h-10 rounded-full bg-gradient-to-r from-[#F1A004] to-[#d89200] flex items-center justify-center text-white font-bold text-lg shadow-md">
                                         {{ strtoupper(substr($book->judul_buku, 0, 1)) }}
                                     </div>
                                     <div>
                                         <h5 class="font-extrabold text-xl tracking-wide">{{ $book->judul_buku }}</h5>
                                         <p class="text-sm opacity-70">Kategori: {{ $book->kategori }}</p>
                                     </div>
                                 </div>
                                 <button class="text-gray-400 hover:text-[#F1A004] transition">
                                     <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             d="M5 13l4 4L19 7" />
                                     </svg>
                                 </button>
                             </div>

                             <!-- Isi Card -->
                             <div class="relative p-6 space-y-3">
                                 <div class="flex items-center justify-between">
                                     <p class="text-sm font-semibold">Jumlah Stok:</p>
                                     <span
                                         class="px-3 py-1 rounded-full text-xs font-bold shadow-inner 
                {{ $book->jumlah_stok > 0 ? 'bg-green-400/30 text-green-900 dark:text-green-200' : 'bg-red-400/30 text-red-900 dark:text-red-200' }}">
                                         {{ $book->jumlah_stok }}
                                     </span>
                                 </div>

                                 <div class="flex items-center justify-between">
                                     <p class="text-sm font-semibold">Status:</p>
                                     <span
                                         class="px-3 py-1 rounded-full text-xs font-bold shadow-inner
                {{ $book->status ? 'bg-green-400/30 text-green-900 dark:text-green-200' : 'bg-red-400/30 text-red-900 dark:text-red-200' }}">
                                         {{ $book->status ? 'Tersedia' : 'Tidak Tersedia' }}
                                     </span>
                                 </div>

                                 <div class="pt-3 border-t border-gray-200 dark:border-white/10">
                                     <p class="text-sm font-semibold mb-1">Deskripsi:</p>
                                     <p class="text-gray-700 dark:text-gray-200 text-sm italic leading-snug">
                                         {{ Str::limit($book->deskripsi, 100, '...') }}
                                     </p>
                                 </div>
                             </div>

                             <!-- Tombol -->
                             <div
                                 class="p-5 border-t border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-transparent">
                                 <form id="addToCartForm-{{ $book->id }}"
                                     action="{{ route('keranjang.add', $book->id) }}" method="POST">
                                     @csrf
                                     <button type="button" onclick="confirmAddToCart({{ $book->id }})"
                                         {{ $book->jumlah_stok <= 0 ? 'disabled' : '' }}
                                         class="w-full py-2.5 font-semibold rounded-lg transition 
                {{ $book->jumlah_stok > 0
                    ? 'bg-gradient-to-r from-[#F1A004] to-[#d89200] hover:opacity-90 text-white'
                    : 'bg-gray-400 cursor-not-allowed text-gray-200' }}">
                                         {{ $book->jumlah_stok > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
                                     </button>
                                 </form>
                             </div>
                         </div>


                         <!-- Tombol Keranjang -->
                         <button onclick="toggleCart()"
                             class="fixed bottom-5 right-5 flex items-center justify-center w-14 h-14 rounded-full 
           shadow-lg transition-all duration-300 z-50
           bg-[#F1A004] hover:bg-[#d68c00] dark:bg-[#2C3262] dark:hover:bg-[#3b4180]">
                             <!-- Icon Keranjang -->
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="2" stroke="white" class="w-7 h-7">
                                 <path stroke-linecap="round" stroke-linejoin="round"
                                     d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.3 5.2a1 1 0 001 1.3h12.6a1 1 0 001-1.3L17 13M7 13l1.5-5h7L17 13M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                             </svg>
                         </button>


                         <!-- 🧺 Modal Keranjang -->
                         <div id="cartModal"
                             class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-all duration-300">
                             <div
                                 class="bg-white dark:bg-[#2C3262] rounded-2xl w-[95%] sm:w-[420px] max-h-[85vh] shadow-2xl flex flex-col overflow-hidden animate-fadeIn">

                                 <!-- Header -->
                                 <div
                                     class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-white/20">
                                     <h2
                                         class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                                         🛒 Keranjang Buku
                                     </h2>
                                     <button onclick="toggleCart()"
                                         class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition">✖</button>
                                 </div>

                                 <!-- Isi -->
                                 <!-- Isi Cart -->
                                 <div class="flex-1 overflow-y-auto p-4 space-y-3">
                                     @php $cart = session('cart', []); @endphp

                                     @if (count($cart) > 0)
                                         <form action="{{ route('keranjang.checkout') }}" method="POST"
                                             id="cartForm">
                                             @csrf
                                             <!-- Global borrower name (applies to all items) -->
                                             <div
                                                 class="mb-3 p-3 rounded-lg bg-yellow-50 border border-yellow-200 dark:bg-white/10 dark:border-white/20">
                                                 <label for="global-borrower-name"
                                                     class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama
                                                     Peminjam (sekali isi)</label>
                                                 <input type="text" id="global-borrower-name"
                                                     placeholder="Nama Peminjam" required
                                                     value="{{ Auth::user()->name ?? '' }}"
                                                     class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 dark:bg-transparent dark:text-white">
                                                 <p class="mt-1 text-xs text-gray-600 dark:text-gray-300">Nama ini akan
                                                     diterapkan ke semua barang di keranjang.</p>
                                             </div>
                                             <!-- Global borrow dates (apply to all items) -->
                                             <div
                                                 class="mb-3 p-3 rounded-lg bg-blue-50 border border-blue-200 dark:bg-white/10 dark:border-white/20">
                                                 <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                     <div>
                                                         <label for="global-borrow-date"
                                                             class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tanggal
                                                             Pinjam</label>
                                                         <input type="date" id="global-borrow-date"
                                                             value="{{ now()->format('Y-m-d') }}"
                                                             class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-transparent dark:text-white">
                                                     </div>
                                                     <div>
                                                         <label for="global-return-date"
                                                             class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tanggal
                                                             Kembali</label>
                                                         <input type="date" id="global-return-date"
                                                             value="{{ now()->addDays(7)->format('Y-m-d') }}"
                                                             class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-transparent dark:text-white">
                                                     </div>
                                                 </div>
                                                 <p class="mt-1 text-xs text-gray-600 dark:text-gray-300">Tanggal akan
                                                     diterapkan ke semua barang di keranjang.</p>
                                             </div>
                                             @foreach ($cart as $id => $item)
                                                 <div
                                                     class="flex items-center gap-4 bg-white dark:bg-gradient-to-br dark:from-[#2C3262] dark:via-[#434A8B] dark:to-[#2C3262]
    rounded-2xl p-4 shadow-md hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-white/10">



                                                     <!-- Info Buku -->
                                                     <div class="flex-1 space-y-1">
                                                         <p
                                                             class="font-bold text-gray-900 dark:text-white text-base leading-tight">
                                                             {{ $item['judul_buku'] }}
                                                         </p>
                                                         <p class="text-xs text-gray-600 dark:text-gray-300">
                                                             Kategori: <span
                                                                 class="font-medium">{{ $item['kategori'] }}</span>
                                                         </p>

                                                         <p class="text-xs text-gray-600 dark:text-gray-300">
                                                             Status:
                                                             @if ($item['status'] === 1)
                                                                 <span
                                                                     class="font-semibold text-green-700 bg-green-100 dark:bg-green-900/30 dark:text-green-300 px-2 py-0.5 rounded-full text-[11px] shadow-inner">
                                                                     Tersedia
                                                                 </span>
                                                             @else
                                                                 <span
                                                                     class="font-semibold text-red-700 bg-red-100 dark:bg-red-900/30 dark:text-red-300 px-2 py-0.5 rounded-full text-[11px] shadow-inner">
                                                                     Tidak Tersedia
                                                                 </span>
                                                             @endif
                                                         </p>

                                                         <!-- Hidden Inputs -->
                                                         <input type="hidden"
                                                             name="cart[{{ $id }}][nama_peminjam]"
                                                             class="cart-item-borrower-name">
                                                         <input type="hidden"
                                                             name="cart[{{ $id }}][tanggal_pinjam]"
                                                             class="cart-item-tanggal-pinjam">
                                                         <input type="hidden"
                                                             name="cart[{{ $id }}][tanggal_kembali]"
                                                             class="cart-item-tanggal-kembali">

                                                         <!-- Jumlah -->
                                                         <div class="mt-3 flex items-center gap-3">
                                                             <button type="button"
                                                                 onclick="updateQty(this, -1, {{ $id }})"
                                                                 class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 dark:border-white/20
                bg-gray-100 dark:bg-white/10 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-white/20 transition">
                                                                 −
                                                             </button>

                                                             <input type="number"
                                                                 name="cart[{{ $id }}][quantity]"
                                                                 value="{{ $item['quantity'] }}" min="1"
                                                                 max="{{ $item['jumlah_stok'] }}"
                                                                 data-max="{{ $item['jumlah_stok'] }}"
                                                                 class="w-14 text-center text-sm font-semibold rounded-lg border border-gray-300 dark:border-white/20 
                bg-white dark:bg-white/10 text-gray-800 dark:text-white focus:ring-2 focus:ring-[#F1A004] outline-none">

                                                             <button type="button"
                                                                 onclick="updateQty(this, 1, {{ $id }})"
                                                                 class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 dark:border-white/20
                bg-gray-100 dark:bg-white/10 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-white/20 transition">
                                                                 ＋
                                                             </button>
                                                         </div>

                                                         <!-- Tombol Hapus -->
                                                         <div class="mt-3 flex justify-end">
                                                             <button type="button"
                                                                 onclick="removeFromCart({{ $id }})"
                                                                 class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold
                bg-gradient-to-r from-red-500 to-red-600 text-white hover:opacity-90 shadow-md transition-all duration-300">
                                                                 <svg xmlns="http://www.w3.org/2000/svg"
                                                                     class="w-3.5 h-3.5" fill="none"
                                                                     viewBox="0 0 24 24" stroke="currentColor"
                                                                     stroke-width="2">
                                                                     <path stroke-linecap="round"
                                                                         stroke-linejoin="round"
                                                                         d="M6 18L18 6M6 6l12 12" />
                                                                 </svg>
                                                                 Hapus
                                                             </button>
                                                         </div>
                                                     </div>
                                                 </div>
                                             @endforeach

                                             <!-- Tombol Checkout -->
                                             <button type="submit"
                                                 class="mt-4 w-full bg-[#22C55E] hover:bg-[#16A34A] text-white py-3 rounded-xl font-semibold text-sm transition">
                                                 Pinjam Semua
                                             </button>
                                         </form>
                                     @else
                                         <p class="text-center text-gray-500 dark:text-gray-300 mt-10">Keranjang masih
                                             kosong</p>
                                     @endif
                                 </div>
                             </div>
                         </div>


                     @empty
                         <p class="text-center text-gray-500 dark:text-gray-300 col-span-full mt-10">Tidak ada Barang
                             ditemukan.</p>
                     @endforelse


                 </div>

     </x-app-layout>
     <script>
         function toggleCart() {
             document.getElementById('cartModal').classList.toggle('hidden');
         }

         // Sync global borrower name to all cart items
         function syncBorrowerName() {
             const globalInput = document.getElementById('global-borrower-name');
             if (!globalInput) return;
             const val = globalInput.value || '';
             document.querySelectorAll('#cartForm input[name$="[nama_peminjam]"]').forEach(el => {
                 el.value = val;
             });
         }
         // Sync global dates to all cart items
         function syncBorrowDates() {
             const borrow = document.getElementById('global-borrow-date');
             const back = document.getElementById('global-return-date');
             if (borrow) {
                 const v = borrow.value || '';
                 document.querySelectorAll('#cartForm input[name$="[tanggal_pinjam]"]').forEach(el => el.value = v);
             }
             if (back) {
                 const v2 = back.value || '';
                 document.querySelectorAll('#cartForm input[name$="[tanggal_kembali]"]').forEach(el => el.value = v2);
             }
             if (borrow && back) back.min = borrow.value || '';
         }
         document.addEventListener('DOMContentLoaded', () => {
             const globalInput = document.getElementById('global-borrower-name');
             if (globalInput) {
                 syncBorrowerName();
                 globalInput.addEventListener('input', syncBorrowerName);
             }
             // initial sync for dates and listeners
             syncBorrowDates();
             const gBorrow = document.getElementById('global-borrow-date');
             const gReturn = document.getElementById('global-return-date');
             if (gBorrow) gBorrow.addEventListener('change', syncBorrowDates);
             if (gReturn) gReturn.addEventListener('change', syncBorrowDates);
             const cartForm = document.getElementById('cartForm');
             if (cartForm) {
                 cartForm.addEventListener('submit', () => {
                     syncBorrowerName();
                     syncBorrowDates();
                 });
             }
         });

         function updateQty(btn, diff, id) {
             const input = btn.parentElement.querySelector('input[type=number]');
             let val = parseInt(input.value) + diff;
             const max = parseInt(input.dataset.max); // pakai data-max
             const min = parseInt(input.min);

             if (val < min) val = min;
             if (val > max) val = max;

             input.value = val;
             updateQuantity(id, val);
         }

         // Update otomatis tanpa reload
         function updateQuantity(id, quantity) {
             fetch(`/keranjang/update/${id}`, {
                     method: 'PATCH',
                     headers: {
                         'Content-Type': 'application/json',
                         'X-CSRF-TOKEN': '{{ csrf_token() }}'
                     },
                     body: JSON.stringify({
                         quantity
                     })
                 })
                 .then(res => res.json())
                 .then(data => console.log('Updated:', data))
                 .catch(err => console.error(err));
         }


         function confirmAddToCart(id) {
             Swal.fire({
                 title: 'Tambah ke Keranjang?',
                 text: 'Apakah kamu yakin ingin menambahkan barang ini ke keranjang?',
                 icon: 'question',
                 showCancelButton: true,
                 confirmButtonColor: '#F1A004',
                 cancelButtonColor: '#6B7280',
                 confirmButtonText: 'Ya, tambahkan',
                 cancelButtonText: 'Batal',
                 background: document.documentElement.classList.contains('dark') ? '#2C3262' : '#fff',
                 color: document.documentElement.classList.contains('dark') ? '#fff' : '#000',
             }).then((result) => {
                 if (result.isConfirmed) {
                     document.getElementById(`addToCartForm-${id}`).submit();
                 }
             });
         }

         function confirmCheckout() {
             Swal.fire({
                 title: 'Konfirmasi Peminjaman',
                 text: 'Apakah kamu yakin ingin meminjam semua barang ini sekaligus?',
                 icon: 'question',
                 showCancelButton: true,
                 confirmButtonColor: '#22C55E',
                 cancelButtonColor: '#6B7280',
                 confirmButtonText: 'Ya, pinjam semua',
                 cancelButtonText: 'Batal',
                 background: document.documentElement.classList.contains('dark') ? '#2C3262' : '#fff',
                 color: document.documentElement.classList.contains('dark') ? '#fff' : '#000',
             }).then((result) => {
                 if (result.isConfirmed) {
                     document.getElementById('checkoutForm').submit();
                 }
             });
         }

         function removeFromCart(id) {
             fetch(`/keranjang/remove/${id}`, {
                     method: 'DELETE',
                     headers: {
                         'X-CSRF-TOKEN': '{{ csrf_token() }}',
                         'Accept': 'application/json',
                     },
                 }).then(res => res.json())
                 .then(data => {
                     if (data.success) location.reload();
                 });
         }
     </script>


     <style>
         @keyframes fadeIn {
             from {
                 opacity: 0;
                 transform: translateY(-10px);
             }

             to {
                 opacity: 1;
                 transform: translateY(0);
             }
         }

         .animate-fadeIn {
             animation: fadeIn 0.3s ease-in-out;
         }
     </style>
