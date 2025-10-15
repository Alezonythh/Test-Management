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
            <div
                class="w-16 h-16 border-4 border-t-[#F1A004] border-r-transparent border-b-[#F1A004] border-l-transparent rounded-full animate-spin mb-4">
            </div>
            <p class="text-gray-700 dark:text-gray-300 text-lg font-semibold animate-pulse">
                Memuat permintaan peminjaman…
            </p>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                Mohon tunggu sebentar, data sedang diproses.
            </p>
        </div>

        <!-- Konten Halaman -->
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8" x-show="!loading"
            x-transition.opacity>
            <div class="mb-10 flex flex-col items-center text-center gap-4">
                <!-- Judul -->
                <h1
                    class="text-3xl md:text-4xl font-extrabold 
                    bg-gradient-to-r from-[#F1A004] via-amber-500 to-yellow-400 
                    bg-clip-text text-transparent relative inline-block">
                    Permintaan Peminjaman Buku
                </h1>

                <!-- Deskripsi -->
                <p class="text-gray-600 dark:text-gray-300 text-sm md:text-base max-w-xl">
                    Lihat daftar permintaan peminjaman dari anggota dan konfirmasi statusnya secara langsung.
                </p>
            </div>

            @if ($requests->isEmpty())
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 -translate-y-3 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    class="flex items-center gap-4 p-6 
                    bg-gradient-to-r from-yellow-50 via-white to-yellow-50 
                    dark:from-gray-800 dark:via-gray-900 dark:to-gray-800
                    border border-yellow-300 dark:border-gray-700
                    rounded-2xl shadow-lg max-w-xl mx-auto relative">
                    <div class="flex-shrink-0 bg-[#F1A004] text-white p-3 rounded-full shadow-md animate-bounce">
                        <ion-icon name="alert-circle-outline" class="text-2xl"></ion-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-900 dark:text-gray-200 text-lg font-semibold">
                            Tidak ada permintaan peminjaman
                        </p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            Semua data masih kosong. Menunggu anggota mengajukan permintaan baru.
                        </p>
                    </div>
                </div>
            @else
                <!-- Daftar Permintaan -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($requests as $request)
                        <div
                            class="relative p-6 rounded-2xl shadow-md overflow-hidden
                            bg-white dark:bg-gray-900 
                            border border-gray-200 dark:border-gray-700
                            hover:shadow-2xl hover:-translate-y-1 hover:scale-[1.02]
                            transition-all duration-500 ease-out
                            animate-[fadeIn_0.8s_ease-out]">

                            <!-- Overlay gradient halus -->
                            <div
                                class="absolute inset-0 opacity-[0.07] 
                                bg-gradient-to-br from-[#F1A004]/40 via-amber-400/40 to-yellow-300/40
                                dark:from-yellow-600/20 dark:via-yellow-700/20 dark:to-yellow-800/20
                                pointer-events-none animate-[shimmer_6s_infinite]">
                            </div>

                            <!-- Hover glow -->
                            <div
                                class="absolute inset-0 rounded-2xl bg-white/0 dark:bg-gray-900/0
                                hover:bg-white/5 dark:hover:bg-gray-800/10 transition-colors duration-500 pointer-events-none">
                            </div>

                            <!-- Konten -->
                            <div class="relative z-10">
                                <h5
                                    class="mb-3 text-xl font-extrabold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                    📖 {{ $request->book->judul_buku }}
                                </h5>

                                <p class="mb-2 text-gray-700 dark:text-gray-300 text-sm">
                                    <span class="font-semibold text-[#F1A004] dark:text-yellow-400">👤 Anggota:</span>
                                    {{ $request->user->name }}
                                </p>
                                <p class="mb-1 text-gray-700 dark:text-gray-300 text-sm">
                                    <span class="font-semibold text-[#F1A004] dark:text-yellow-400">📅 Tanggal
                                        Pinjam:</span>
                                    {{ $request->tanggal_pinjam }}
                                </p>
                                <p class="mb-4 text-gray-700 dark:text-gray-300 text-sm">
                                    <span class="font-semibold text-[#F1A004] dark:text-yellow-400">📅 Tanggal
                                        Kembali:</span>
                                    {{ $request->tanggal_kembali }}
                                </p>

                                <!-- Tombol Aksi -->
                                <div class="flex justify-between mt-4">
                                    <form action="{{ route('admin.approveRequest', $request->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-semibold text-white rounded-lg
                                            bg-gradient-to-r from-green-500 to-green-600 
                                            hover:shadow-lg hover:scale-105 transition duration-300">
                                            ✅ Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.rejectRequest', $request->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-semibold text-white rounded-lg
                                            bg-gradient-to-r from-red-500 to-red-600 
                                            hover:shadow-lg hover:scale-105 transition duration-300">
                                            ❌ Tolak
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10 flex justify-center">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
