<x-app-layout>
        <div 
    x-data="{
        open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true'),
    }"
    x-init="
        window.addEventListener('sidebar-toggled', () => {
            open = JSON.parse(localStorage.getItem('sidebarOpen'));
        });
    "
    :class="open ? 'ml-64' : 'ml-16'"
    class="transition-all duration-300"
>

    <body class="bg-gray-100 font-roboto " >
        <div class="p-6">
            <!-- Header -->
      <div class="flex justify-between items-center mb-6  dark:bg-gray-800 p-4 rounded-lg ">

    <!-- Tengah: Search Bar -->
  <div class="w-1/2 relative">
    <ion-icon 
        name="search-outline" 
        class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-300 text-lg">
    </ion-icon>
    <input 
        type="text" 
        placeholder="Pencarian ..." 
        class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-600 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
    >
</div>

    <!-- Kanan: Tanggal + Auth User -->
<div class="flex items-center space-x-4">
    

      <!-- Notifikasi -->
<button class="relative inline-block">
    <!-- Icon Notifikasi Lonceng -->
    <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a2 2 0 002-2H8a2 2 0 002 2z" />
    </svg>

    <!-- Badge Notifikasi -->
    <span class="absolute top-0 right-0 inline-block w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
</button>

    <!-- Tanggal -->
    <span class="text-gray-700 dark:text-gray-300">
        {{ now()->format('l, M Y') }}
    </span>

  

    <!-- Auth User -->
    <div class="flex items-center p-3 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-300">
        <img src="" alt="">
        <p class="text-sm text-gray-500 dark:text-gray-400"></p>
    </div>
</div>

</div>

            <!-- Dashboard Info Section -->
         <div class="rounded-xl">
     <!-- Title Dashboard -->
    <div class="mb-2">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-300">Dashboard Manajemen Studio</h1>
        <div class="mt-3 border-b border-gray-200"></div>
    </div>
    <div class="flex flex-col lg:flex-row items-center gap-8">
                      
                        @auth
                        @if (Auth::user()->role == 'admin')

                             
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 w-full">

                            <!-- Card 1 -->
                            <div class="relative bg-gradient-to-br from-[#2C3262] to-purple-500 rounded-xl p-6 shadow-lg overflow-hidden text-white 
                                        dark:from-[#3a3f63] dark:to-[#5a4fa3] dark:text-gray-100 dark:shadow-gray-900 transition-colors duration-500">
                                <div class="mb-4">
                                    <ion-icon name="cube-outline" class="text-2xl"></ion-icon>
                                </div>
                                <h4 class="text-sm opacity-90">Barang Tersedia</h4>
                                <p class="text-3xl font-bold mt-1">{{ $totalBuku }}</p>
                                <p class="text-sm mt-2 opacity-90">+10 hari ini</p>
                                <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 dark:bg-white/5 rounded-full transform translate-x-12 -translate-y-12"></div>
                                <div class="absolute bottom-0 right-0 w-32 h-32 bg-white/10 dark:bg-white/5 rounded-full transform translate-x-8 translate-y-8"></div>
                            </div>

                            <!-- Card 2 -->
                            <div class="relative bg-gradient-to-br from-[#F1A004] to-orange-300 rounded-xl p-6 shadow-lg overflow-hidden text-white 
                                        dark:from-[#a8681a] dark:to-[#d9842b] dark:text-gray-100 dark:shadow-gray-900 transition-colors duration-500">
                                <div class="mb-4">
                                    <ion-icon name="repeat-outline" class="text-2xl"></ion-icon>
                                </div>
                                <h4 class="text-sm opacity-90">Barang Dipinjam</h4>
                                <p class="text-3xl font-bold mt-1">{{ $totalPinjam }}</p>
                                <p class="text-sm mt-2 opacity-90">+5 hari ini</p>
                                <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 dark:bg-white/5 rounded-full transform translate-x-12 -translate-y-12"></div>
                                <div class="absolute bottom-0 right-0 w-32 h-32 bg-white/10 dark:bg-white/5 rounded-full transform translate-x-8 translate-y-8"></div>
                            </div>

                            <!-- Card 3 -->
                            <div class="relative bg-gradient-to-br from-green-400 to-green-500 rounded-xl p-6 shadow-lg overflow-hidden text-white 
                                        dark:from-[#2f6e44] dark:to-[#3e8e57] dark:text-gray-100 dark:shadow-gray-900 transition-colors duration-500">
                                <div class="mb-4">
                                    <ion-icon name="checkmark-done-outline" class="text-2xl"></ion-icon>
                                </div>
                                <h4 class="text-sm opacity-90">Barang Dikembalikan</h4>
                                <p class="text-3xl font-bold mt-1">120</p>
                                <p class="text-sm mt-2 opacity-90">+8 hari ini</p>
                                <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 dark:bg-white/5 rounded-full transform translate-x-12 -translate-y-12"></div>
                                <div class="absolute bottom-0 right-0 w-32 h-32 bg-white/10 dark:bg-white/5 rounded-full transform translate-x-8 translate-y-8"></div>
                            </div>

                            <!-- Card 4 -->
                            <div class="relative bg-gradient-to-br from-red-400 to-red-500 rounded-xl p-6 shadow-lg overflow-hidden text-white 
                                        dark:from-[#8b2e2e] dark:to-[#b23a3a] dark:text-gray-100 dark:shadow-gray-900 transition-colors duration-500">
                                <div class="mb-4">
                                    <ion-icon name="alert-circle-outline" class="text-2xl"></ion-icon>
                                </div>
                                <h4 class="text-sm opacity-90">Barang Rusak</h4>
                                <p class="text-3xl font-bold mt-1">7</p>
                                <p class="text-sm mt-2 opacity-90">+1 hari ini</p>
                                <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 dark:bg-white/5 rounded-full transform translate-x-12 -translate-y-12"></div>
                                <div class="absolute bottom-0 right-0 w-32 h-32 bg-white/10 dark:bg-white/5 rounded-full transform translate-x-8 translate-y-8"></div>
                            </div>

                            </div>
                        </div>

                            @endif
                            @if (Auth::user()->role == 'anggota')
                            <a href="{{route('anggota.index')}}">
                                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-red-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        PINJAM BUKU
                                    </span>
                                </button>
                            </a>
                            <a href="{{route('anggota.borrowed')}}">
                                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-red-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        RIWAYAT PEMINJAMAN
                                    </span>
                                </button>
                            </a>
                            @endif
                            @endauth
                        </div>


 <section class="py-8 bg-gray-50 dark:bg-gray-900 w-full">
        <div class="max-w-full ">

 <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">
  Info Dashboard Peminjaman Barang Studio
</h2>
<p class="text-gray-600 dark:text-gray-300 mb-6">List nama peminjaman barang</p>

<div class="grid grid-cols-1 md:grid-cols-6 gap-6">
  <!-- Bagian Kiri: Card -->
  <div class="md:col-span-4 grid grid-cols-2 md:grid-cols-4 gap-6 h-20">
    <!-- Card 1 -->


@foreach($dataPeminjam as $item)
<div class="flex flex-col items-center rounded-2xl shadow-lg p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300 
            bg-gradient-to-br from-blue-50 to-white dark:from-gray-900 dark:to-gray-800 backdrop-blur-lg">
  <div class="w-16 h-16 flex items-center justify-center rounded-xl bg-blue-100 text-blue-500 dark:bg-blue-800/60 dark:text-blue-300 mb-3 shadow-inner">
    <ion-icon name="cube-outline" class="text-3xl"></ion-icon>
  </div>
  <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $item->nama_barang }}</p>
  <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $item->total }}</h2>
  <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
    Peminjam: {{ $item->peminjam }}
  </p>
</div>
@endforeach




    
  </div>

  <!-- Bagian Kanan: Progress -->
  <div class="md:col-span-2 rounded-2xl shadow-lg p-6 
              bg-gradient-to-br from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 backdrop-blur-lg">
    <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Progress Data Barang</h2>

@foreach($dataBuku as $buku)
    @php
        $sisa = $buku->jumlah_stok - $buku->dipinjam;
        $persen = $buku->jumlah_stok > 0 ? ($buku->dipinjam / $buku->jumlah_stok) * 100 : 0;
    @endphp

    <div class="mb-5">
        <!-- Judul Buku + Jumlah -->
        <p class="text-gray-600 dark:text-gray-300 text-sm mb-1">
            {{ $buku->judul_buku }} ({{ $buku->jumlah_stok }})
        </p>

        <!-- Progress Bar -->
        <div class="w-full bg-gray-200/60 dark:bg-gray-700/60 rounded-full h-3 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-3 rounded-full transition-all duration-500"
                 style="width: {{ $persen }}%">
            </div>
        </div>

        <!-- Detail Info -->
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            Dipinjam: {{ $buku->dipinjam }} | Sisa: {{ $sisa }}
        </p>
    </div>
@endforeach

  </div>
</div>





    <div class="mt-6 flex justify-end">
            <a href="/peminjaman"
        class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-orange-500 to-pink-500 text-white font-semibold text-sm rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-300">
        Lihat Semua
        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
        </svg>
        </a>
    </div>





    </section>

                    </div>
             

            <!-- Cards Section -->
            <!-- Dashboard Info -->
   
        </div>
    </body>
    </div>
            </div>
                </div>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</x-app-layout>
