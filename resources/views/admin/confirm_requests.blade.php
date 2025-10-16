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

            @if ($requestsGrouped->isEmpty())
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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($paginatedUsers as $userId)
                        @php
                            $userRequests = $requestsGrouped[$userId];
                        @endphp

                        <div
                            class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg overflow-hidden relative hover:shadow-2xl transition-all duration-300">

                            <!-- Header User -->
                            <div
                                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-yellow-400 to-yellow-300 dark:from-yellow-600 dark:to-yellow-500">
                                <h5 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                    👤 {{ $userRequests->first()->user->name }}
                                </h5>
                                <p class="text-sm text-gray-800 dark:text-gray-200 mt-1">Permintaan Peminjaman:
                                    {{ $userRequests->count() }} Barang</p>
                            </div>

                            <!-- List Buku -->
                            <div class="p-6 space-y-4">
                                @foreach ($userRequests as $request)
                                    <div
                                        class="p-4 rounded-xl bg-gray-50 dark:bg-gray-800 shadow-sm hover:shadow-md transition flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold text-gray-800 dark:text-gray-100">📖
                                                {{ $request->book->judul_buku }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-300">📅 Pinjam:
                                                {{ $request->tanggal_pinjam }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-300">📅 Kembali:
                                                {{ $request->tanggal_kembali }}</p>
                                            @if ($request->book->jumlah_stok <= 0)
                                                <span class="text-red-500 text-xs font-semibold">⚠️ Stok Habis</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Footer Actions -->
                            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex gap-3">
                                <!-- Approve Semua -->
                                <form action="{{ route('admin.approveAllRequests', $userId) }}" method="POST"
                                    class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="w-full py-2 rounded-lg text-white font-semibold bg-gradient-to-r from-green-500 to-green-600 hover:shadow-lg hover:scale-105 transition transform duration-300">
                                        Setujui Semua
                                    </button>
                                </form>

                                <!-- Reject Semua -->
                                <form action="{{ route('admin.rejectAllRequests', $userId) }}" method="POST"
                                    class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full py-2 rounded-lg text-white font-semibold bg-gradient-to-r from-red-500 to-red-600 hover:shadow-lg hover:scale-105 transition transform duration-300">
                                        Tolak Semua
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    {{ $paginatedUsers->links() }}
                </div>


            @endif
        </div>
    </div>
</x-app-layout>
