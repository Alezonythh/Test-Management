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
    <div x-data="{ open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true') }" x-init="window.addEventListener('sidebar-toggled', () => {
        open = JSON.parse(localStorage.getItem('sidebarOpen'));
    });" :class="open ? 'ml-0 sm:ml-64' : 'ml-0 sm:ml-16'"
        class="transition-all duration-300 relative">




        <body class="bg-gray-100 font-roboto">
            <div class="p-6">
                <!-- Header -->


                @guest
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-4 sm:p-6">

                        <!-- Card 1: PINJAM BARANG -->
                        <div
                            class="relative rounded-3xl shadow-2xl overflow-hidden transform transition-all duration-500 hover:scale-105
                bg-gradient-to-r from-[#4F6CF2] to-[#7FA9FF] dark:bg-gradient-to-r dark:from-[#4F6CF2] dark:to-[#7FA9FF]">

                            <span
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent dark:via-white/10 animate-shimmer pointer-events-none"></span>

                            <div class="p-6 sm:p-8 flex flex-col gap-4 relative z-10">
                                <div class="flex items-center gap-3">
                                    <ion-icon name="cube-outline" class="text-3xl text-white"></ion-icon>
                                    <h2 class="text-xl sm:text-2xl font-bold text-white">PINJAM BARANG</h2>
                                </div>
                                <p class="text-white/90 text-sm sm:text-base">
                                    Pilih barang yang ingin dipinjam dengan mudah. Sistem kami cepat, aman, dan
                                    nyaman digunakan.
                                </p>
                                <a href="{{ route('anggota.index') }}" class="w-full mt-auto">
                                    <button
                                        class="relative w-full px-5 py-3 font-semibold rounded-xl
                                bg-white/10 dark:bg-gradient-to-r dark:from-[#4F6CF2] dark:to-[#7FA9FF]
                                text-white shadow-md hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden">
                                        <span
                                            class="absolute inset-0 bg-white opacity-10 rounded-xl blur-xl animate-pulse"></span>
                                        <span class="relative">MULAI PINJAM</span>
                                    </button>
                                </a>
                            </div>
                        </div>

                        <!-- Card 2: RIWAYAT PEMINJAMAN -->
                        <div
                            class="relative rounded-3xl shadow-2xl overflow-hidden transform transition-all duration-500 hover:scale-105
                bg-gradient-to-r from-[#06D6A0] to-[#4AE58E] dark:bg-gradient-to-r dark:from-[#4AC97A] dark:to-[#A8FF7F]">

                            <span
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent dark:via-white/10 animate-shimmer pointer-events-none"></span>

                            <div class="p-6 sm:p-8 flex flex-col gap-4 relative z-10">
                                <div class="flex items-center gap-3">
                                    <ion-icon name="time-outline" class="text-3xl text-white"></ion-icon>
                                    <h2 class="text-xl sm:text-2xl font-bold text-white">RIWAYAT PEMINJAMAN</h2>
                                </div>
                                <p class="text-white/90 text-sm sm:text-base">
                                    Lihat semua barang yang sudah kamu pinjam, status pengembalian, dan histori
                                    lengkapnya dengan mudah.
                                </p>
                                <a href="{{ route('anggota.borrowed') }}" class="w-full mt-auto">
                                    <button
                                        class="relative w-full px-5 py-3 font-semibold rounded-xl
                                bg-white/10 dark:bg-gradient-to-r dark:from-[#4AC97A] dark:to-[#A8FF7F]
                                text-white shadow-md hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden">
                                        <span
                                            class="absolute inset-0 bg-white opacity-10 rounded-xl blur-xl animate-pulse"></span>
                                        <span class="relative">LIHAT RIWAYAT</span>
                                    </button>
                                </a>
                            </div>
                        </div>

                    </div>

                    <section class="py-8 bg-gray-50 dark:bg-gray-900 w-full">
                        <div class="max-w-full ">

                            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">
                                Info Peminjaman Barang
                            </h2>
                            <p class="text-gray-600 dark:text-gray-300 mb-6">List nama peminjaman barang</p>
                            <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
                                <!-- Bagian Kiri: Card -->
                                <div class="md:col-span-4 grid grid-cols-2 md:grid-cols-4 gap-6 h-10">
                                    @foreach ($dataPeminjam as $item)
                                        <div
                                            class="relative flex flex-col items-center text-center rounded-3xl p-6
            bg-white dark:bg-[#1E2130]
            border border-gray-200/60 dark:border-gray-700/60
            shadow-lg hover:shadow-xl hover:-translate-y-1.5
            transition-all duration-500 ease-out">

                                            <!-- Foto Profil / Icon Box -->
                                            <div
                                                class="w-24 h-24 rounded-full overflow-hidden ring-4 ring-gray-100 dark:ring-gray-800 shadow-md mb-4">
                                                <img src="{{ asset('storage/' . $item->kondisi_awal) }}" alt="Kondisi Awal"
                                                    class="w-full h-full object-cover">
                                            </div>

                                            <!-- Nama Peminjam -->
                                            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100">
                                                {{ $item->peminjam }}
                                            </h3>

                                            <!-- Detail Statistik -->
                                            <div class="mt-3 w-full space-y-2 text-sm">
                                                <div
                                                    class="flex items-center justify-center gap-2 text-gray-600 dark:text-gray-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-4 h-4 text-indigo-500 dark:text-indigo-400" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>Meminjam {{ $item->total_pinjam }} barang</span>
                                                </div>
                                            </div>

                                            <!-- Garis halus pemisah -->
                                            <div class="my-4 w-16 h-[1px] bg-gray-200 dark:bg-gray-700"></div>


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

                                    @foreach ($dataKategori as $kat)
                                        @php
                                            $totalStok = $kat->jumlah_stok_total ?? 0;
                                            $dipinjam = $kat->dipinjam_total ?? 0;

                                            // logika persen
                                            if ($totalStok == 0 && $dipinjam > 0) {
                                                $persen = 100;
                                            } else {
                                                $dipinjam = min($dipinjam, $totalStok);
                                                $persen = $totalStok > 0 ? ($dipinjam / $totalStok) * 100 : 0;
                                                $persen = min(100, max(0, $persen));
                                            }

                                            // warna sesuai persen
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


                                        <div class="mb-6 flex flex-col justify-between h-28">
                                            <div class="flex justify-between items-center mb-1">
                                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                    {{ $kat->kategori }}</p>

                                            </div>

                                            <div class="flex justify-between items-center mb-1">
                                                <span class="text-xs font-medium text-gray-600 dark:text-gray-300">
                                                    Dipinjam: {{ $dipinjam }}</span>
                                                <span
                                                    class="text-xs font-medium text-gray-600 dark:text-gray-300">{{ round($persen) }}%</span>
                                            </div>

                                            <div
                                                class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                                <div class="h-3 rounded-full bg-gradient-to-r {{ $warna }} transition-[width] duration-1000 ease-out"
                                                    style="width: {{ $persen }}%"></div>
                                            </div>
                                        </div>
                                    @endforeach








                                </div>


                            </div>




                        </div>


                    </section>
                @endguest





                @auth
                    <div
                        class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 
    bg-white/60 dark:bg-gray-900/60 backdrop-blur-xl 
    border border-gray-200/30 dark:border-gray-700/30 
    p-5 rounded-3xl shadow-lg transition-all duration-500 gap-4">

                        <!-- Search Bar -->
                        <div class="w-full md:w-1/2 relative group">
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
                        <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 w-full md:w-auto">

                            @if (Auth::check() && Auth::user()->role == 'admin')
                                <!-- Notifikasi -->
                                <div class="relative">
                                    <button id="notification-button" @click="$dispatch('open-modal', 'notification-modal')"
                                        class="relative w-11 h-11 flex items-center justify-center 
                    rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 
                    text-white shadow-lg hover:scale-110 transition-all duration-500">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a2 2 0 002-2H8a2 2 0 002 2z" />
                                        </svg>
                                        @if (isset($overdueBooksCount) && isset($pendingRequestsCount) && $overdueBooksCount + $pendingRequestsCount > 0)
                                            <span
                                                class="absolute top-2 right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                                                {{ $overdueBooksCount + $pendingRequestsCount }}
                                            </span>
                                        @endif
                                    </button>
                                </div>
                            @endif

                            <!-- Date -->
                            <span
                                class="relative inline-block px-4 py-2 rounded-2xl text-sm font-semibold 
            bg-gradient-to-r from-pink-500 via-orange-400 to-yellow-500 
            text-white shadow-lg shadow-pink-500/40
            backdrop-blur-sm bg-white/10 dark:bg-gray-800/20
            hover:scale-105 hover:shadow-2xl hover:shadow-pink-500/50
            transition-all duration-500 ease-in-out w-full md:w-auto text-center">
                                {{ now()->format('l, M d Y') }}
                            </span>

                            <!-- User -->
                            <div
                                class="flex items-center space-x-3 px-3 py-2 rounded-2xl 
            bg-gradient-to-r from-indigo-500/90 to-purple-600/90 
            hover:scale-105 cursor-pointer shadow-lg 
            transition-all duration-500 w-full md:w-auto justify-center">
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
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-300"> Manajemen
                                    Studio
                                </h1>
                                <div class="mt-3 border-b border-gray-200"></div>
                            </div>
                            <div class="flex flex-col lg:flex-row items-center gap-8">

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 w-full mt-6">


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

                                </div>
                        @endif




                    @endauth
                </div>

                @auth
                    <section class="py-8 bg-gray-50 dark:bg-gray-900 w-full">
                        <div class="max-w-full ">

                            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">
                                Info Peminjaman Barang
                            </h2>
                            <p class="text-gray-600 dark:text-gray-300 mb-6">List nama peminjaman barang</p>
                            <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
                                <!-- Bagian Kiri: Card -->
                                <div class="md:col-span-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 h-10">
                                    @foreach ($dataPeminjam as $item)
                                        <div
                                            class="relative flex flex-col items-center text-center rounded-3xl p-6
            bg-white dark:bg-[#1E2130]
            border border-gray-200/60 dark:border-gray-700/60
            shadow-lg hover:shadow-xl hover:-translate-y-1.5
            transition-all duration-500 ease-out">

                                            <!-- Foto Profil / Icon Box -->
                                            <div
                                                class="w-24 h-24 rounded-full overflow-hidden ring-4 ring-gray-100 dark:ring-gray-800 shadow-md mb-4">
                                                <img src="{{ asset('storage/' . $item->kondisi_awal) }}"
                                                    alt="Kondisi Awal" class="w-full h-full object-cover">
                                            </div>

                                            <!-- Nama Peminjam -->
                                            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100">
                                                {{ $item->peminjam }}
                                            </h3>

                                            <!-- Detail Statistik -->
                                            <div class="mt-3 w-full space-y-2 text-sm">
                                                <div
                                                    class="flex items-center justify-center gap-2 text-gray-600 dark:text-gray-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-4 h-4 text-indigo-500 dark:text-indigo-400"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>Meminjam {{ $item->total_pinjam }} barang</span>
                                                </div>
                                            </div>

                                            <!-- Garis halus pemisah -->
                                            <div class="my-4 w-16 h-[1px] bg-gray-200 dark:bg-gray-700"></div>

                                            <!-- Tombol Aksi -->
                                            <div class="flex justify-center gap-2 mt-1">
                                                <a href="{{ route('admin.borrowedBooks') }}"
                                                    class="px-4 py-2 rounded-xl text-sm font-medium text-white 
                    bg-gradient-to-r from-indigo-500 to-indigo-600 
                    hover:from-indigo-400 hover:to-indigo-500 
                    shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                                                    Lihat Detail
                                                </a>
                                            </div>
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

                                    @foreach ($dataKategori as $kat)
                                        @php
                                            $totalStok = $kat->jumlah_stok_total ?? 0;
                                            $dipinjam = $kat->dipinjam_total ?? 0;

                                            // logika persen
                                            if ($totalStok == 0 && $dipinjam > 0) {
                                                $persen = 100;
                                            } else {
                                                $dipinjam = min($dipinjam, $totalStok);
                                                $persen = $totalStok > 0 ? ($dipinjam / $totalStok) * 100 : 0;
                                                $persen = min(100, max(0, $persen));
                                            }

                                            // warna sesuai persen
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


                                        <div class="mb-6 flex flex-col justify-between h-28">
                                            <div class="flex justify-between items-center mb-1">
                                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                    {{ $kat->kategori }}</p>

                                            </div>

                                            <div class="flex justify-between items-center mb-1">
                                                <span class="text-xs font-medium text-gray-600 dark:text-gray-300">
                                                    Dipinjam: {{ $dipinjam }}</span>
                                                <span
                                                    class="text-xs font-medium text-gray-600 dark:text-gray-300">{{ round($persen) }}%</span>
                                            </div>

                                            <div
                                                class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                                <div class="h-3 rounded-full bg-gradient-to-r {{ $warna }} transition-[width] duration-1000 ease-out"
                                                    style="width: {{ $persen }}%"></div>
                                            </div>
                                        </div>
                                    @endforeach








                                </div>


                            </div>




                        </div>


                    </section>
                @endauth

            </div>


            <!-- Cards Section -->
            <!-- Dashboard Info -->

    </div>
    </body>
    <x-modal name="notification-modal" maxWidth="md">
        <div class="bg-[#282E5A] rounded-lg shadow-xl p-6">
            <div class="flex justify-between items-center pb-3">
                <h2 class="text-lg font-medium text-white">Notifications</h2>
                <button @click="$dispatch('close')" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto max-h-96">
                @if (isset($overdueBooks) && count($overdueBooks) > 0)
                    <h6 class="px-6 py-2 font-semibold text-gray-300">Overdue Books</h6>
                    @foreach ($overdueBooks as $borrow)
                        <div class="px-6 py-3 text-sm text-gray-300 hover:bg-gray-700 transition-colors duration-200">
                            <span class="font-semibold">{{ $borrow->book->judul_buku }}</span>
                            <span class="text-gray-400">- Due:
                                {{ \Carbon\Carbon::parse($borrow->tanggal_kembali)->format('d-m-Y') }}</span>
                            <br>
                            <span class="text-xs text-gray-400">By: {{ $borrow->user->name }}</span>
                        </div>
                    @endforeach
                @endif

                @if (isset($pendingRequests) && count($pendingRequests) > 0)
                    <h6 class="px-6 py-2 font-semibold text-gray-300">Pending Requests</h6>
                    @foreach ($pendingRequests as $requests)
                        @php
                            $borrower = optional($requests->first()->user)->name ?? ($requests->first()->nama_peminjam ?? 'Guest');
                            $bookTitles = $requests
                                ->map(function ($item) {
                                    return optional($item->book)->judul_buku;
                                })
                                ->filter()
                                ->unique();
                        @endphp
                        <div class="px-6 py-3 text-sm text-gray-300 hover:bg-gray-700 transition-colors duration-200">
                            <span class="font-semibold">{{ $borrower }}</span>
                            <span class="text-gray-400">
                                - {{ $bookTitles->implode(', ') }}
                                @if ($requests->count() > 1)
                                    ({{ $requests->count() }} permintaan)
                                @endif
                            </span>
                        </div>
                    @endforeach
                @endif

                @if (isset($overdueBooks) && count($overdueBooks) == 0 && (isset($pendingRequests) && count($pendingRequests) == 0))
                    <span class="block px-6 py-3 text-sm text-gray-300">No notifications</span>
                @endif
            </div>
        </div>
    </x-modal>
    </div>
    </body>
    <x-modal name="notification-modal" maxWidth="md">
        <div class="bg-[#282E5A] rounded-lg shadow-xl p-6">
            <div class="flex justify-between items-center pb-3">
                <h2 class="text-lg font-medium text-white">Notifications</h2>
                <button @click="$dispatch('close')" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto max-h-96">
                @if (isset($overdueBooks) && count($overdueBooks) > 0)
                    <h6 class="px-6 py-2 font-semibold text-gray-300">Overdue Books</h6>
                    @foreach ($overdueBooks as $borrow)
                        <div class="px-6 py-3 text-sm text-gray-300 hover:bg-gray-700 transition-colors duration-200">
                            <span class="font-semibold">{{ $borrow->book->judul_buku }}</span>
                            <span class="text-gray-400">- Due:
                                {{ \Carbon\Carbon::parse($borrow->tanggal_kembali)->format('d-m-Y') }}</span>
                            <br>
                            <span class="text-xs text-gray-400">By: {{ $borrow->user->name }}</span>
                        </div>
                    @endforeach
                @endif

                @if (isset($pendingRequests) && count($pendingRequests) > 0)
                    <h6 class="px-6 py-2 font-semibold text-gray-300">Pending Requests</h6>
                    @foreach ($pendingRequests as $requests)
                        @php
                            $borrower = optional($requests->first()->user)->name ?? ($requests->first()->nama_peminjam ?? 'Guest');
                            $bookTitles = $requests
                                ->map(function ($item) {
                                    return optional($item->book)->judul_buku;
                                })
                                ->filter()
                                ->unique();
                        @endphp
                        <div class="px-6 py-3 text-sm text-gray-300 hover:bg-gray-700 transition-colors duration-200">
                            <span class="font-semibold">{{ $borrower }}</span>
                            <span class="text-gray-400">
                                - {{ $bookTitles->implode(', ') }}
                                @if ($requests->count() > 1)
                                    ({{ $requests->count() }} permintaan)
                                @endif
                            </span>
                        </div>
                    @endforeach
                @endif


                @if (isset($overdueBooks) && count($overdueBooks) == 0 && (isset($pendingRequests) && count($pendingRequests) == 0))
                    <span class="block px-6 py-3 text-sm text-gray-300">No notifications</span>
                @endif
            </div>
        </div>
    </x-modal>
    </div>
    </div>
    </div>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationButton = document.getElementById('notification-button');
            const notificationDropdown = document.getElementById('notification-dropdown');

            notificationButton.addEventListener('click', function() {
                //notificationDropdown.classList.toggle('hidden');
                Livewire.dispatch('openModal', {
                    modal: 'notification-modal'
                })
            });

            document.addEventListener('click', function(event) {
                if (!notificationButton.contains(event.target) && !notificationDropdown.contains(event
                        .target)) {
                    //  notificationDropdown.classList.add('hidden');
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const notificationButton = document.getElementById('notification-button');
            const notificationDropdown = document.getElementById('notification-dropdown');

            notificationButton.addEventListener('click', function() {
                //notificationDropdown.classList.toggle('hidden');
                Livewire.dispatch('openModal', {
                    modal: 'notification-modal'
                })
            });

            document.addEventListener('click', function(event) {
                if (!notificationButton.contains(event.target) && !notificationDropdown.contains(event
                        .target)) {
                    //  notificationDropdown.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>
