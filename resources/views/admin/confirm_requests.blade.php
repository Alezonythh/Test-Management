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

    <div x-data="{ open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true') }" x-init="window.addEventListener('sidebar-toggled', () => {
        open = JSON.parse(localStorage.getItem('sidebarOpen'));
    });" :class="open ? 'ml-0 sm:ml-64' : 'ml-0 sm:ml-16'"
        class="transition-all duration-300 relative">

        <!-- Konten Halaman -->
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex flex-col items-center text-center gap-4">
                <!-- Judul -->
                <h1
                    class="text-3xl md:text-4xl font-extrabold 
                    bg-gradient-to-r from-[#F1A004] via-amber-500 to-yellow-400 
                    bg-clip-text text-transparent relative inline-block">
                    Permintaan Peminjaman Barang
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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 auto-rows-fr">
                    @foreach ($paginatedUsers as $identifier)
                        @php
                            $requests = $requestsGrouped[$identifier];
                            $guestName = $requests->first()->nama_peminjam ?? null;
                            $guestSlug = $guestName ? \Illuminate\Support\Str::slug($guestName) : null;
                            $totalQty = $requests->sum(fn($r) => $r->quantity ?? 1);
                            $groupedByBook = $requests->groupBy('book_id');
                        @endphp

                        <div
                            class="bg-white dark:bg-gradient-to-br dark:from-[#3C4272]/90 dark:to-[#575FA0]/90 text-gray-800 dark:text-gray-100
                   rounded-2xl shadow-[0_8px_25px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_25px_rgba(0,0,0,0.25)]
                   overflow-hidden border border-gray-100 dark:border-white/10 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl h-full flex flex-col">

                            <!-- Header -->
                            <div class="px-6 pt-6 pb-4 text-center border-b border-gray-100 dark:border-gray-700">

                                <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-50">
                                    {{ $guestName ?? 'Guest' }}
                                </h5>
                                <p class="text-sm text-gray-600 dark:text-gray-200 mt-1">
                                    {{ $totalQty }} permintaan peminjaman
                                </p>
                            </div>

                            <!-- Daftar Buku -->
                            <div class="px-6 py-5 space-y-3 bg-[#FAFAFA] dark:bg-[#2E3261]/40 flex-1">
                                @foreach ($groupedByBook as $bookId => $items)
                                    @php
                                        $first = $items->first();
                                        $qty = $items->sum(fn($r) => $r->quantity ?? 1);
                                    @endphp
                                    <div class="flex justify-between items-center py-3 relative">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $first->book->judul_buku }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-300 mt-0.5">
                                                Qty: {{ $qty }}
                                            </p>
                                        </div>

                                        <span
                                            class="text-xs font-medium px-3 py-1 rounded-full 
        bg-[#FFF8E1]/80 dark:bg-white/10 border border-yellow-200/50 dark:border-white/10 
        text-[#C5A423] dark:text-gray-100">
                                            Item
                                        </span>

                                        <!-- Garis bawah elegan dan jelas -->
                                        <div
                                            class="absolute bottom-0 left-0 right-0 h-[1.2px]
        bg-gradient-to-r 
        from-transparent 
        via-[#E6C766] dark:via-[#6B75C1] 
        to-transparent opacity-80">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Tombol Aksi -->
                            @if ($guestSlug)
                                <div
                                    class="px-6 py-5 border-t border-gray-100 dark:border-white/10 bg-[#F9FAFB]/80 dark:bg-[#2E3261]/40 mt-auto">
                                    <div class="flex flex-col sm:flex-row gap-3">

                                        <!-- Setujui Semua -->
                                        <form
                                            action="{{ route('admin.approveAllGuestRequests', ['guestSlug' => $guestSlug]) }}"
                                            method="POST" class="flex-1">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="w-full py-3 rounded-xl text-sm font-semibold text-white
                    bg-emerald-600 hover:bg-emerald-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400/60
                    shadow-[0_4px_12px_rgba(0,0,0,0.15)] transform transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">
                                                Setujui Semua
                                            </button>
                                        </form>

                                        <!-- Tolak Semua -->
                                        <form
                                            action="{{ route('admin.rejectAllGuestRequestsByName', ['guestSlug' => $guestSlug]) }}"
                                            method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full py-3 rounded-xl text-sm font-semibold text-white
                    bg-rose-600 hover:bg-rose-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-400/60
                    shadow-[0_4px_12px_rgba(0,0,0,0.15)] transform transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">
                                                Tolak Semua
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            @endif




                        </div>
                    @endforeach
                </div>




            @endif
        </div>
    </div>
</x-app-layout>
