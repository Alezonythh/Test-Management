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
                     class="text-4xl font-extrabold text-center
   text-transparent bg-clip-text 
   bg-gradient-to-r from-[#2C3262] via-[#434A8B] to-[#2C3262] 
   animate-text-shine drop-shadow-lg">
                     Daftar Barang
                 </h1>

                 <p
                     class="text-center max-w-xl mx-auto text-lg font-semibold mb-8 
   text-transparent bg-clip-text 
   bg-gradient-to-r from-[#434A8B] via-indigo-400 to-[#2C3262] 
   animate-text-shine drop-shadow">
                     Pilih barang studiomu, kembangkan ide, dan tunjukkan kreativitasmu di SMK Pesat! 🔥
                 </p>



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
                                             Pinjam Buku
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
                                                 Pinjam Buku
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
                                         <h3 class="text-lg font-extrabold tracking-wide">📚 Form Pinjam Buku</h3>
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
                                             <label class="block mb-1 text-xs font-medium">Judul Buku</label>
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
                                             <label for="tanggal_pinjam" class="block mb-1 text-xs font-medium">Tanggal
                                                 Peminjaman</label>
                                             <input type="date" id="tanggal_pinjam" name="tanggal_pinjam"
                                                 class="w-full p-2 rounded-lg bg-white/20 border border-white/30 text-white focus:ring-2 focus:ring-indigo-300 focus:outline-none"
                                                 required>
                                         </div>

                                         <div>
                                             <label for="tanggal_kembali" class="block mb-1 text-xs font-medium">Tanggal
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
                         <p class="text-center text-gray-700 col-span-3">Tidak ada buku yang ditemukan.
                         </p>
                     @endforelse
                 </div>

             </div>
         </div>




     </x-app-layout>
