<x-app-layout>
    <style>
        @keyframes silhouette {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(200%);
            }
        }

        .animate-silhouette {
            animation: silhouette 5s infinite linear alternate;
        }
    </style>


    <div x-data="{
        open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true'),
    }" x-init="window.addEventListener('sidebar-toggled', () => {
        open = JSON.parse(localStorage.getItem('sidebarOpen'));
    });" :class="open ? 'ml-64' : 'ml-16'"
        class="transition-all duration-300">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8">
            <h1
                class="text-3xl font-extrabold mb-3 text-center 
           bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 
           bg-clip-text text-transparent">
                Status Pengajuan Peminjaman
            </h1>

            <p class="text-center text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                Lihat riwayat dan perkembangan pengajuan peminjaman barang kamu.
            </p>


            @if ($requests->isEmpty())
                <div
                    class="flex items-center justify-center p-10 
                   bg-white dark:bg-gray-900 rounded-2xl shadow-lg 
                   border border-gray-200 dark:border-gray-700">
                    <p class="text-gray-600 dark:text-gray-300 text-lg font-medium">
                        Tidak ada pengajuan peminjaman.
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($requests as $request)
                        <div
                            class="relative p-6 rounded-2xl shadow-xl overflow-hidden 
                   bg-white dark:bg-gray-800 
                   border border-gray-200 dark:border-gray-700 
                   hover:shadow-2xl hover:scale-[1.02] 
                   transition-all duration-300">

                            <!-- Accent gradient background -->
                            <div
                                class="absolute inset-0 opacity-10 
                       bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 
                       dark:from-indigo-400 dark:via-purple-400 dark:to-pink-400 
                       pointer-events-none">
                            </div>

                            <!-- Silhouette shimmer -->
                            <!-- Shimmer siluet bolak-balik -->
                            <div
                                class="absolute top-0 left-0 h-full w-1/2 
           bg-gradient-to-r from-transparent via-white/5 to-transparent 
           dark:via-gray-100/5
           animate-silhouette pointer-events-none">
                            </div>

                            <div class="relative z-10">
                                <h5 class="mb-3 text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $request->book->judul_buku }}
                                </h5>
                                <p class="mb-2 text-gray-700 dark:text-gray-300 text-sm">
                                    <span class="font-semibold">Tanggal Pinjam:</span> {{ $request->tanggal_pinjam }}
                                </p>
                                <p class="mb-4 text-gray-700 dark:text-gray-300 text-sm">
                                    <span class="font-semibold">Tanggal Kembali:</span> {{ $request->tanggal_kembali }}
                                </p>

                                <!-- Status badge -->
                                <p>
                                    @if ($request->status === 'menunggu konfirmasi')
                                        <span
                                            class="px-3 py-1 text-sm font-semibold rounded-full 
                                   bg-yellow-200 text-yellow-800 dark:bg-yellow-400/20 dark:text-yellow-300">
                                            Menunggu Konfirmasi
                                        </span>
                                    @elseif ($request->status === 'disetujui')
                                        <span
                                            class="px-3 py-1 text-sm font-semibold rounded-full 
                                   bg-green-200 text-green-800 dark:bg-green-400/20 dark:text-green-300">
                                            Disetujui
                                        </span>
                                    @elseif ($request->status === 'ditolak')
                                        <span
                                            class="px-3 py-1 text-sm font-semibold rounded-full 
                                   bg-red-200 text-red-800 dark:bg-red-400/20 dark:text-red-300">
                                            Ditolak
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
