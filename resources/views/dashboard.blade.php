<x-app-layout>
    <style>
        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            50% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .animate-shimmer {
            animation: shimmer 6s linear infinite;
        }
    </style>
    <div x-data="{
        open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true'),
    }" x-init="window.addEventListener('sidebar-toggled', () => {
        open = JSON.parse(localStorage.getItem('sidebarOpen'));
    });" :class="open ? 'ml-64' : 'ml-16'"
        class="transition-all duration-300">

        <body class="bg-gray-100 font-roboto ">
            <div class="p-6">
                <!-- Header -->

                @auth
                    <div
                        class="flex justify-between items-center mb-6 
                bg-white/60 dark:bg-gray-900/60 backdrop-blur-xl 
                border border-gray-200/30 dark:border-gray-700/30 
                p-5 rounded-3xl shadow-lg transition-all duration-500">

                        <!-- Search Bar -->
                        <div class="w-1/2 relative group mb-6">
                            <form method="GET" action="{{ route('dashboard') }}"
                                class="flex w-full 
        rounded-2xl border-2 border-yellow-400 bg-white dark:bg-gray-900 shadow-lg overflow-hidden">

                                <!-- Icon -->
                                <span
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-300 text-lg">
                                    <ion-icon name="search-outline"></ion-icon>
                                </span>

                                <!-- Input -->
                                <input type="text" name="search" placeholder="✨ Cari nama peminjam..."
                                    value="{{ request('search') }}"
                                    class="flex-1 pl-10 pr-4 py-3 bg-transparent
                   text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500
                   focus:outline-none transition-all duration-500 ease-in-out">

                                <!-- Tombol Submit -->
                                <button type="submit"
                                    class="px-4 py-3 bg-[#F1A004] text-white rounded-r-2xl font-semibold
                   hover:bg-yellow-400 transition-all duration-300 shadow-md hover:shadow-lg">
                                    Cari
                                </button>
                            </form>
                        </div>






                        <!-- Right Section -->
                        <div class="flex items-center space-x-6">


                            <!-- Auth User -->
                            @if (Auth::check() && Auth::user()->role == 'admin')
                                <!-- Notifikasi -->
                                <button
                                    class="relative w-11 h-11 flex items-center justify-center 
                                        rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 
                                        text-white shadow-lg hover:scale-110 transition-all duration-500">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a2 2 0 002-2H8a2 2 0 002 2z" />
                                    </svg>
                                    <span
                                        class="absolute top-2 right-2 w-2.5 h-2.5 
                                            bg-red-500 rounded-full border-2 border-white dark:border-gray-900 
                                            animate-ping"></span>
                                    <span
                                        class="absolute top-2 right-2 w-2.5 h-2.5 
                                            bg-red-500 rounded-full border-2 border-white dark:border-gray-900"></span>
                                </button>
                            @endif


                            <!-- Date -->
                            <span
                                class="relative inline-block px-4 py-2 rounded-2xl text-sm font-semibold 
                                bg-gradient-to-r from-pink-500 via-orange-400 to-yellow-500 
                                text-white shadow-lg shadow-pink-500/40
                                backdrop-blur-sm bg-white/10 dark:bg-gray-800/20
                                hover:scale-105 hover:shadow-2xl hover:shadow-pink-500/50
                                transition-all duration-500 ease-in-out">
                                {{ now()->format('l, M d Y') }}
                            </span>


                            <div
                                class="flex items-center space-x-3 px-3 py-2 rounded-2xl 
                                        bg-gradient-to-r from-indigo-500/90 to-purple-600/90 
                                        hover:scale-105 cursor-pointer shadow-lg 
                                        transition-all duration-500">
                                <img src="https://ui-avatars.com/api/?name=User&background=6366F1&color=fff"
                                    alt="User Avatar" class="w-10 h-10 rounded-full border-2 border-white shadow-md">
                                <p class="text-sm font-bold text-white">
                                    {{ Auth::user()->name ?? 'Guest' }}
                                </p>
                            </div>

                        </div>
                    </div>
                @endauth



                <!-- Dashboard Info Section -->
                <div class="rounded-xl">
                    <!-- Title Dashboard -->


                    @auth
                        @if (Auth::user()->role == 'admin')
                            <div class="mb-2">
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-300">Dashboard Manajemen Studio
                                </h1>
                                <div class="mt-3 border-b border-gray-200"></div>
                            </div>
                            <div class="flex flex-col lg:flex-row items-center gap-8">

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 w-full mt-6">

                                    <!-- Card 1: Barang Tersedia -->
                                    <div
                                        class="relative rounded-2xl p-6 shadow-xl overflow-hidden 
                                    bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-500 
                                    text-white dark:from-indigo-700 dark:via-indigo-600 dark:to-purple-700
                                    border border-white/10 dark:border-gray-700
                                    transition-all duration-500 hover:-translate-y-1 hover:scale-[1.03] hover:shadow-2xl hover:shadow-indigo-500/40">

                                        <!-- Glow Overlay -->
                                        <div
                                            class="absolute inset-0 bg-gradient-to-tr from-white/10 via-white/5 to-transparent blur-2xl pointer-events-none">
                                        </div>

                                        <!-- Icon with shine -->
                                        <div
                                            class="relative mb-4 flex items-center justify-center w-12 h-12 rounded-xl bg-white/20 group-hover:animate-pulse">
                                            <ion-icon name="cube-outline" class="text-2xl"></ion-icon>
                                            <div
                                                class="absolute inset-0 rounded-xl bg-white/10 blur-sm animate-pulse pointer-events-none">
                                            </div>
                                        </div>

                                        <h4 class="text-sm opacity-90">Barang Tersedia</h4>
                                        <p
                                            class="text-3xl font-extrabold mt-1 bg-clip-text text-transparent 
                                    bg-gradient-to-r from-white to-yellow-200">
                                            {{ $totalBuku }}</p>
                                    </div>

                                    <!-- Card 2: Barang Dipinjam -->
                                    <div
                                        class="relative rounded-2xl p-6 shadow-xl overflow-hidden 
                                    bg-gradient-to-br from-orange-500 via-yellow-400 to-amber-400 
                                    text-white dark:from-orange-600 dark:via-amber-500 dark:to-yellow-500
                                    border border-white/10 dark:border-gray-700
                                    transition-all duration-500 hover:-translate-y-1 hover:scale-[1.03] hover:shadow-2xl hover:shadow-orange-400/40">

                                        <div
                                            class="absolute inset-0 bg-gradient-to-tr from-white/10 via-white/5 to-transparent blur-2xl pointer-events-none">
                                        </div>
                                        <div
                                            class="relative mb-4 flex items-center justify-center w-12 h-12 rounded-xl bg-white/20 group-hover:animate-pulse">
                                            <ion-icon name="repeat-outline" class="text-2xl"></ion-icon>
                                            <div
                                                class="absolute inset-0 rounded-xl bg-white/10 blur-sm animate-pulse pointer-events-none">
                                            </div>
                                        </div>

                                        <h4 class="text-sm opacity-90">Barang Dipinjam</h4>
                                        <p
                                            class="text-3xl font-extrabold mt-1 bg-clip-text text-transparent 
                                    bg-gradient-to-r from-white to-yellow-200">
                                            {{ $totalPinjam }}</p>
                                    </div>

                                    <!-- Card 3: Barang Dikembalikan -->
                                    <div
                                        class="relative rounded-2xl p-6 shadow-xl overflow-hidden 
                                    bg-gradient-to-br from-green-400 via-green-500 to-emerald-500 
                                    text-white dark:from-green-600 dark:via-emerald-600 dark:to-green-700
                                    border border-white/10 dark:border-gray-700
                                    transition-all duration-500 hover:-translate-y-1 hover:scale-[1.03] hover:shadow-2xl hover:shadow-green-400/40">

                                        <div
                                            class="absolute inset-0 bg-gradient-to-tr from-white/10 via-white/5 to-transparent blur-2xl pointer-events-none">
                                        </div>
                                        <div
                                            class="relative mb-4 flex items-center justify-center w-12 h-12 rounded-xl bg-white/20 group-hover:animate-pulse">
                                            <ion-icon name="checkmark-done-outline" class="text-2xl"></ion-icon>
                                            <div
                                                class="absolute inset-0 rounded-xl bg-white/10 blur-sm animate-pulse pointer-events-none">
                                            </div>
                                        </div>

                                        <h4 class="text-sm opacity-90">Barang Dikembalikan</h4>
                                        <p
                                            class="text-3xl font-extrabold mt-1 bg-clip-text text-transparent 
                                    bg-gradient-to-r from-white to-yellow-200">
                                            {{ $dataBukuDikembalikan }}</p>
                                    </div>

                                    <!-- Card 4: Barang Rusak -->
                                    <div
                                        class="relative rounded-2xl p-6 shadow-xl overflow-hidden 
                                    bg-gradient-to-br from-red-400 via-rose-500 to-pink-500 
                                    text-white dark:from-red-600 dark:via-rose-600 dark:to-pink-700
                                    border border-white/10 dark:border-gray-700
                                    transition-all duration-500 hover:-translate-y-1 hover:scale-[1.03] hover:shadow-2xl hover:shadow-red-400/40">

                                        <div
                                            class="absolute inset-0 bg-gradient-to-tr from-white/10 via-white/5 to-transparent blur-2xl pointer-events-none">
                                        </div>
                                        <div
                                            class="relative mb-4 flex items-center justify-center w-12 h-12 rounded-xl bg-white/20 group-hover:animate-pulse">
                                            <ion-icon name="alert-circle-outline" class="text-2xl"></ion-icon>
                                            <div
                                                class="absolute inset-0 rounded-xl bg-white/10 blur-sm animate-pulse pointer-events-none">
                                            </div>
                                        </div>

                                        <h4 class="text-sm opacity-90">Barang Rusak</h4>
                                        <p
                                            class="text-3xl font-extrabold mt-1 bg-clip-text text-transparent 
                                    bg-gradient-to-r from-white to-yellow-200">
                                            7</p>
                                    </div>

                                </div>
                        @endif
                        @if (Auth::user()->role == 'anggota')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
                                <!-- Card 1: PINJAM BARANG -->
                                <div
                                    class="relative rounded-3xl shadow-2xl overflow-hidden hover:scale-105 transition-transform duration-500
                bg-gradient-to-r from-[#4F6CF2] to-[#7FA9FF]">

                                    <!-- Efek shimmer lebih terang -->
                                    <span
                                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent animate-shimmer"></span>

                                    <div
                                        class="p-10 bg-white/90 dark:bg-gray-900/80 rounded-3xl backdrop-blur-md flex flex-col gap-6 relative z-10">
                                        <div class="flex items-center gap-3">
                                            <ion-icon name="cube-outline" class="text-3xl text-white"></ion-icon>
                                            <h2 class="text-2xl font-bold text-white">PINJAM BARANG</h2>
                                        </div>
                                        <p class="text-white/90">
                                            Pilih barang yang ingin dipinjam dengan mudah. Sistem kami cepat, aman, dan
                                            nyaman digunakan.
                                        </p>
                                        <a href="{{ route('anggota.index') }}" class="w-full">
                                            <button
                                                class="relative w-full px-6 py-3 font-semibold rounded-xl text-white
               bg-gradient-to-r from-[#4F6CF2] to-[#7FA9FF]
               shadow-md hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden">
                                                <span
                                                    class="absolute inset-0 bg-white opacity-10 rounded-xl blur-xl animate-pulse"></span>
                                                <span class="relative">MULAI PINJAM</span>
                                            </button>
                                        </a>

                                    </div>
                                </div>

                                <!-- Card 2: RIWAYAT PEMINJAMAN -->
                                <div
                                    class="relative rounded-3xl shadow-2xl overflow-hidden hover:scale-105 transition-transform duration-500
                bg-gradient-to-r from-[#4AC97A] to-[#A8FF7F]">

                                    <!-- Efek shimmer lebih terang -->
                                    <span
                                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent animate-shimmer"></span>

                                    <div
                                        class="p-10 bg-white/90 dark:bg-gray-900/80 rounded-3xl backdrop-blur-md flex flex-col gap-6 relative z-10">
                                        <div class="flex items-center gap-3">
                                            <ion-icon name="time-outline" class="text-3xl text-white"></ion-icon>
                                            <h2 class="text-2xl font-bold text-white">RIWAYAT PEMINJAMAN</h2>
                                        </div>
                                        <p class="text-white/90">
                                            Lihat semua barang yang sudah kamu pinjam, status pengembalian, dan histori
                                            lengkapnya dengan mudah.
                                        </p>
                                        <a href="{{ route('anggota.borrowed') }}" class="w-full">
                                            <button
                                                class="relative w-full px-6 py-3 font-semibold rounded-xl text-white
               bg-gradient-to-r from-[#4AC97A] to-[#A8FF7F]
               shadow-md hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden">
                                                <span
                                                    class="absolute inset-0 bg-white opacity-10 rounded-xl blur-xl animate-pulse"></span>
                                                <span class="relative">LIHAT RIWAYAT</span>
                                            </button>
                                        </a>

                                    </div>
                                </div>
                            </div>
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
                            <div class="md:col-span-4 grid grid-cols-2 md:grid-cols-4 gap-6">

                                @foreach ($dataPeminjam as $item)
                                    <div
                                        class="relative flex flex-col items-center text-center rounded-3xl p-6
                bg-white/80 dark:bg-gray-900/80 
                backdrop-blur-xl border border-gray-200/40 dark:border-gray-700/40
                shadow-lg hover:shadow-2xl hover:-translate-y-2
                transition-all duration-500 ease-out group">

                                        <!-- Decorative Glow -->
                                        <div
                                            class="absolute inset-0 rounded-3xl bg-gradient-to-br from-blue-500/20 via-purple-500/10 to-pink-500/20 opacity-0 group-hover:opacity-100 blur-xl transition duration-700">
                                        </div>

                                        <!-- Icon Box -->
                                        <div
                                            class="relative w-20 h-20 flex items-center justify-center rounded-2xl 
                  bg-gradient-to-br from-blue-500 to-indigo-600 
                  dark:from-indigo-500 dark:to-purple-600
                  shadow-md mb-5 overflow-hidden group-hover:scale-110 transition-transform duration-500">
                                            <img src="{{ Storage::url($item->foto_awal_barang) }}" alt="Kondisi Awal"
                                                class="w-full h-full object-cover rounded-2xl">


                                        </div>

                                        <!-- Nama Barang -->
                                        <p
                                            class="relative text-sm font-medium text-gray-700 dark:text-gray-300 
                group-hover:text-blue-600 dark:group-hover:text-purple-400 transition-colors">
                                            {{ $item->nama_barang }}
                                        </p>

                                        <!-- Total -->
                                        <h2
                                            class="relative text-3xl font-extrabold mt-2 
                  bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 
                  bg-clip-text text-transparent">
                                            {{ $item->total }}
                                        </h2>

                                        <!-- Info Peminjam -->
                                        <p
                                            class="relative text-xs mt-3 text-gray-500 dark:text-gray-400 
                group-hover:text-purple-500 dark:group-hover:text-pink-400 transition-colors">
                                            👤 Peminjam: <span class="font-semibold">{{ $item->peminjam }}</span>
                                        </p>
                                    </div>
                                @endforeach

                            </div>
                            <!-- Bagian Kanan: Progress -->
                            <div
                                class="md:col-span-2 rounded-2xl shadow-xl p-6 
            bg-gradient-to-br from-gray-50 to-white 
            dark:from-gray-900 dark:to-gray-800 
            backdrop-blur-lg border border-gray-200/50 dark:border-gray-700/50">
                                <h2
                                    class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-2">
                                    <ion-icon name="bar-chart-outline"
                                        class="text-blue-500 dark:text-blue-400"></ion-icon>
                                    Progress Data Barang
                                </h2>

                                @foreach ($dataBuku as $buku)
                                    @php
                                        $sisa = max(0, $buku->jumlah_stok - $buku->dipinjam);
                                        $persen =
                                            $buku->jumlah_stok > 0
                                                ? min(100, ($buku->dipinjam / $buku->jumlah_stok) * 100)
                                                : 0;

                                        // Warna progress bar berdasarkan persentase
                                        if ($persen >= 80) {
                                            $warna =
                                                'from-red-400 via-red-500 to-red-600 shadow-[0_0_8px_rgba(239,68,68,0.6)] dark:shadow-[0_0_12px_rgba(220,38,38,0.8)]';
                                        } elseif ($persen >= 50) {
                                            $warna =
                                                'from-yellow-400 via-yellow-500 to-yellow-600 shadow-[0_0_8px_rgba(234,179,8,0.6)] dark:shadow-[0_0_12px_rgba(202,138,4,0.8)]';
                                        } else {
                                            $warna =
                                                'from-blue-400 via-indigo-500 to-purple-500 shadow-[0_0_8px_rgba(59,130,246,0.6)] dark:shadow-[0_0_12px_rgba(99,102,241,0.8)]';
                                        }
                                    @endphp

                                    <div class="mb-6">
                                        <!-- Judul Buku -->
                                        <div class="flex justify-between items-center mb-2">
                                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                {{ $buku->judul_buku }}
                                            </p>
                                            <span
                                                class="text-xs px-2 py-1 rounded-full 
                         bg-blue-100 text-blue-700 
                         dark:bg-blue-900/50 dark:text-blue-300">
                                                Stok: {{ $buku->jumlah_stok }}
                                            </span>
                                        </div>

                                        <!-- Progress Bar -->
                                        <div
                                            class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                            <div class="h-3 rounded-full transition-all duration-700 ease-out
                        bg-gradient-to-r {{ $warna }}"
                                                style="width: {{ $persen }}%">
                                            </div>
                                        </div>

                                        <!-- Detail Info -->
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                            Dipinjam: <span
                                                class="font-medium text-blue-600 dark:text-blue-400">{{ $buku->dipinjam }}</span>
                                        </p>
                                    </div>
                                @endforeach

                            </div>

                        </div>



                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('admin.borrowedBooks') }}"
                                class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-orange-500 to-pink-500 text-white font-semibold text-sm rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-300">
                                Lihat Semua
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
