<x-app-layout>
    <!-- Animations -->
    <style>
        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>


    <div x-data="{ open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true'), loading: true }" x-init="window.addEventListener('sidebar-toggled', () => { open = JSON.parse(localStorage.getItem('sidebarOpen')) });
    setTimeout(() => loading = false, 1500);" :class="open ? 'ml-64' : 'ml-16'"
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
                Memuat informasi peminjaman…
            </p>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                Mohon tunggu sebentar, semua data sedang dipersiapkan.
            </p>
        </div>

        <!-- Konten halaman Informasi Peminjaman -->
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8" x-show="!loading"
            x-transition.opacity>
            <div class="mb-10 flex flex-col items-center text-center gap-4">
                <!-- Judul -->
                <h1
                    class="text-3xl md:text-4xl font-extrabold 
        bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 
        bg-clip-text text-transparent relative inline-block max-w-full 
        ">
                    Status Pengajuan Peminjaman
                </h1>

                <!-- Badge / Info ringkas -->
                <div class="flex flex-wrap justify-center gap-3 mt-2">
                    <span
                        class="px-4 py-2 bg-green-100 dark:bg-green-700/30 text-green-700 dark:text-green-200 rounded-full text-sm font-medium shadow-sm flex items-center gap-1">
                        <ion-icon name="checkmark-done-outline" class="animate-bounce"></ion-icon> Disetujui
                    </span>
                    <span
                        class="px-4 py-2 bg-yellow-100 dark:bg-yellow-700/30 text-yellow-700 dark:text-yellow-200 rounded-full text-sm font-medium shadow-sm flex items-center gap-1">
                        <ion-icon name="time-outline" class="animate-pulse"></ion-icon> Menunggu
                    </span>
                    <span
                        class="px-4 py-2 bg-red-100 dark:bg-red-700/30 text-red-700 dark:text-red-200 rounded-full text-sm font-medium shadow-sm flex items-center gap-1">
                        <ion-icon name="close-outline" class="animate-shake"></ion-icon> Ditolak
                    </span>
                </div>

                <!-- Subtitle / Deskripsi -->
                <p class="text-gray-600 dark:text-gray-300 text-sm md:text-base max-w-xl">
                    Lihat riwayat dan perkembangan pengajuan peminjaman barang kamu secara realtime.
                    <span class="inline-flex items-center gap-1 text-indigo-500 dark:text-indigo-400 font-semibold">
                        <ion-icon name="timer-outline" class="animate-pulse"></ion-icon>
                        Terupdate setiap saat
                    </span>
                </p>
            </div>




            @if ($requests->isEmpty())
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 -translate-y-3 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-400"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-3 scale-95"
                    class="flex items-center gap-4 p-6 
            bg-gradient-to-r from-indigo-50 via-white to-indigo-50 
            dark:from-gray-800 dark:via-gray-900 dark:to-gray-800
            border border-indigo-200 dark:border-gray-700
            rounded-2xl shadow-lg max-w-xl mx-auto relative">

                    <!-- Icon -->
                    <div class="flex-shrink-0 bg-indigo-500 text-white p-3 rounded-full shadow-md animate-bounce">
                        <ion-icon name="information-circle-outline" class="text-2xl"></ion-icon>
                    </div>

                    <!-- Text -->
                    <div class="flex-1">
                        <p class="text-gray-800 dark:text-gray-200 text-lg font-semibold">
                            Tidak ada pengajuan peminjaman
                        </p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            Semua data saat ini masih kosong. Silakan buat pengajuan baru 📄
                        </p>
                    </div>


                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($requests as $request)
                        <div
                            class="relative p-6 rounded-2xl shadow-md overflow-hidden
            bg-white dark:bg-gray-900 
            border border-gray-200 dark:border-gray-700
            hover:shadow-2xl hover:-translate-y-1 hover:scale-[1.02]
            transition-all duration-500 ease-out
            animate-[fadeIn_0.8s_ease-out]">

                            <!-- Subtle professional gradient overlay -->
                            <div
                                class="absolute inset-0 opacity-[0.08] 
                bg-gradient-to-br from-indigo-500/30 via-purple-500/30 to-pink-500/30
                dark:from-indigo-700/30 dark:via-purple-700/30 dark:to-pink-700/30
                pointer-events-none animate-[pulseGradient_8s_infinite]">
                            </div>

                            <!-- Shimmer halus -->
                            <div
                                class="absolute top-0 left-0 h-full w-2/3 
                bg-gradient-to-r from-transparent via-white/5 to-transparent
                dark:via-gray-100/5
                animate-[shimmer_6s_infinite] pointer-events-none">
                            </div>

                            <!-- Hover glow -->
                            <div
                                class="absolute inset-0 rounded-2xl bg-white/0 dark:bg-gray-900/0
                pointer-events-none hover:bg-white/5 dark:hover:bg-gray-800/20 transition-colors duration-500">
                            </div>

                            <!-- Content -->
                            <div class="relative z-10">
                                <h5
                                    class="mb-3 text-xl font-extrabold text-gray-900 dark:text-gray-100 tracking-wide flex items-center gap-2">
                                    📚 {{ $request->book->judul_buku }}
                                    @if ($request->status === 'menunggu konfirmasi')
                                        <ion-icon name="time-outline" class="text-yellow-500 animate-pulse"></ion-icon>
                                    @elseif($request->status === 'disetujui')
                                        <ion-icon name="checkmark-circle-outline"
                                            class="text-green-500 animate-bounce"></ion-icon>
                                    @elseif($request->status === 'ditolak')
                                        <ion-icon name="close-circle-outline"
                                            class="text-red-500 animate-shake"></ion-icon>
                                    @endif
                                </h5>
                                @if ($request->book->jumlah_stok <= 0)
                                    <div
                                        class="absolute top-3 right-3 flex items-center gap-1 bg-red-100 border border-red-300 
        text-red-700 text-xs font-semibold px-2 py-1 rounded-full shadow-sm">
                                        Stok habis
                                    </div>
                                @endif
                                <p class="mb-2 text-gray-700 dark:text-gray-300 text-sm">
                                    <span class="font-semibold">📅 Tanggal Pinjam:</span> {{ $request->tanggal_pinjam }}
                                </p>
                                <p class="mb-4 text-gray-700 dark:text-gray-300 text-sm">
                                    <span class="font-semibold">📅 Tanggal Kembali:</span>
                                    {{ $request->tanggal_kembali }}
                                </p>

                                <!-- Status badge profesional -->
                                <p class="flex gap-2 items-center">
                                    @if ($request->status === 'menunggu konfirmasi')
                                        <span
                                            class="px-4 py-1.5 text-sm font-semibold rounded-full 
                            bg-yellow-200/50 text-yellow-800 dark:bg-yellow-600/30 dark:text-yellow-200
                            shadow-md flex items-center gap-2">
                                            ⏳ Menunggu Konfirmasi
                                            <span class="w-2 h-2 bg-yellow-500 rounded-full animate-ping"></span>
                                        </span>
                                    @elseif ($request->status === 'disetujui')
                                        <span
                                            class="px-4 py-1.5 text-sm font-semibold rounded-full 
                            bg-green-200/50 text-green-800 dark:bg-green-600/30 dark:text-green-200
                            shadow-md flex items-center gap-2">
                                            ✅ Disetujui
                                            <span class="w-2 h-2 bg-green-500 rounded-full animate-ping"></span>
                                        </span>
                                    @elseif ($request->status === 'ditolak')
                                        <span
                                            class="px-4 py-1.5 text-sm font-semibold rounded-full 
                            bg-red-200/50 text-red-800 dark:bg-red-600/30 dark:text-red-200
                            shadow-md flex items-center gap-2">
                                            ❌ Ditolak
                                            <span class="w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>





                <div class="mt-8 flex justify-center">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
