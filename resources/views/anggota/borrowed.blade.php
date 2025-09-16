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
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <h1 class="text-3xl font-bold text-gray-200 mb-6 text-center">Riwayat Peminjaman Barang</h1>

            <!-- Notifikasi Flash Message -->
            @if (session('success'))
                <div class="flex items-center p-4 mb-4 text-sm text-green-700 bg-green-50 dark:bg-green-900/30 border border-green-300 dark:border-green-700 rounded-xl shadow-sm"
                    role="alert">
                    <ion-icon name="checkmark-circle-outline"
                        class="text-xl mr-2 text-green-600 dark:text-green-400"></ion-icon>
                    <span class="font-medium">Sukses!</span>
                    <span class="ml-1">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="flex items-center p-4 mb-4 text-sm text-red-700 bg-red-50 dark:bg-red-900/30 border border-red-300 dark:border-red-700 rounded-xl shadow-sm"
                    role="alert">
                    <ion-icon name="alert-circle-outline"
                        class="text-xl mr-2 text-red-600 dark:text-red-400"></ion-icon>
                    <span class="font-medium">Error!</span>
                    <span class="ml-1">{{ session('error') }}</span>
                </div>
            @endif


            <!-- Filter Tab -->
            <!-- Filter Tab -->
            <div class="mb-6 flex justify-center">
                <form method="GET" action="{{ route('anggota.borrowedBooks') }}" class="flex space-x-6">

                    <!-- Tab Dipinjam -->
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="status" value="dipinjam" class="sr-only"
                            onchange="this.form.submit()" {{ $status == 'dipinjam' ? 'checked' : '' }}>
                        <span
                            class="block px-7 py-3 text-white font-semibold rounded-2xl
                       bg-gradient-to-r from-[#2C3262] to-[#6a5acd]
                       shadow-[0_4px_15px_rgba(44,50,98,0.6)]
                       transition-all duration-500 ease-in-out
                       group-hover:scale-110 group-hover:shadow-[0_8px_25px_rgba(44,50,98,0.8)]
                       active:scale-95 active:shadow-inner relative overflow-hidden">
                            <span
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent 
                           opacity-0 group-hover:opacity-100 translate-x-[-100%] group-hover:translate-x-[100%] 
                           transition-all duration-700 ease-in-out">
                            </span>
                            Buku yang Dipinjam
                        </span>
                    </label>

                    <!-- Tab Dikembalikan -->
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="status" value="dikembalikan" class="sr-only"
                            onchange="this.form.submit()" {{ $status == 'dikembalikan' ? 'checked' : '' }}>
                        <span
                            class="block px-7 py-3 text-white font-semibold rounded-2xl
                       bg-gradient-to-r from-[#ff6a5a] to-[#d92c6f]
                       shadow-[0_4px_15px_rgba(217,44,111,0.6)]
                       transition-all duration-500 ease-in-out
                       group-hover:scale-110 group-hover:shadow-[0_8px_25px_rgba(217,44,111,0.8)]
                       active:scale-95 active:shadow-inner relative overflow-hidden">
                            <span
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent 
                           opacity-0 group-hover:opacity-100 translate-x-[-100%] group-hover:translate-x-[100%] 
                           transition-all duration-700 ease-in-out">
                            </span>
                            Buku yang Dikembalikan
                        </span>
                    </label>

                </form>
            </div>



            <!-- Tabel Buku -->
            @if ($borrowedBooks->isEmpty())
                <div class="flex justify-center">
                    <div
                        class="flex items-center gap-3 bg-yellow-50 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-300 border border-yellow-300 dark:border-yellow-700 rounded-xl px-5 py-4 shadow-md">
                        <ion-icon name="alert-circle-outline" class="text-2xl"></ion-icon>
                        <p class="text-sm font-medium">Tidak ada riwayat untuk status ini.</p>
                    </div>
                </div>
            @else
                <div
                    class="overflow-hidden bg-white dark:bg-gray-900 shadow-2xl rounded-2xl border border-gray-200 dark:border-gray-700">
                    <!-- Judul -->
                    <div
                        class="relative overflow-hidden 
            bg-gradient-to-r from-[#2C3262] via-[#3d4a92] to-[#1a1c3f] 
            text-white text-center py-4 rounded-t-2xl">

                        <!-- Efek cahaya berjalan -->
                        <span
                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-shimmer"></span>

                        <h2 class="relative text-lg font-bold tracking-wide">Riwayat Peminjaman</h2>
                    </div>

                    <!-- Tabel -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead
                                class="text-xs uppercase bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                <tr>
                                    <th class="px-6 py-4">Nama Barang</th>
                                    <th class="px-6 py-4">Penulis</th>
                                    <th class="px-6 py-4">Tanggal Pinjam</th>
                                    <th class="px-6 py-4">Tanggal Kembali</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($borrowedBooks as $borrow)
                                    <tr
                                        class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                            {{ $borrow->book->judul_buku }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                            {{ $borrow->book->penulis }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                            {{ \Carbon\Carbon::parse($borrow->tanggal_pinjam)->format('d-m-Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                            {{ \Carbon\Carbon::parse($borrow->tanggal_kembali)->format('d-m-Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="px-3 py-1 rounded-full font-bold shadow-sm text-xs
                                    {{ $borrow->status == 'dipinjam'
                                        ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-400'
                                        : 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400' }}">
                                                {{ ucfirst($borrow->status) }}
                                            </span>
                                        </td>
                                    </tr>

                                    <!-- Info batas waktu -->
                                    @if ($borrow->status == 'dipinjam')
                                        @php
                                            $returnDate = \Carbon\Carbon::parse($borrow->tanggal_kembali);
                                            $now = \Carbon\Carbon::now();
                                            $diff = $now->diff($returnDate);
                                            $daysLeft = floor($now->diffInDays($returnDate, false));
                                        @endphp
                                        <tr>
                                            <td colspan="5"
                                                class="px-6 py-3 text-center text-sm font-medium bg-gray-50 dark:bg-gray-800">
                                                @if ($returnDate > $now)
                                                    @if ($daysLeft > 0)
                                                        <span class="text-yellow-600 dark:text-yellow-400">
                                                            ⏳ Tinggal {{ $daysLeft }} hari, {{ $diff->h }}
                                                            jam, {{ $diff->i }} menit.
                                                        </span>
                                                    @elseif($daysLeft == 0 && $diff->h > 0)
                                                        <span class="text-yellow-600 dark:text-yellow-400">
                                                            ⏳ Tinggal {{ $diff->h }} jam, {{ $diff->i }}
                                                            menit.
                                                        </span>
                                                    @elseif($daysLeft == 0 && $diff->h == 0)
                                                        <span class="text-yellow-600 dark:text-yellow-400">
                                                            ⏳ Tinggal {{ $diff->i }} menit lagi.
                                                        </span>
                                                    @endif
                                                @elseif($returnDate->isToday())
                                                    <span class="text-green-600 dark:text-green-400">
                                                        📅 Barang harus dikembalikan hari ini.
                                                    </span>
                                                @else
                                                    <span class="text-red-600 dark:text-red-400">
                                                        ⚠️ Terlambat {{ abs($diff->days) }} hari, {{ abs($diff->h) }}
                                                        jam, {{ abs($diff->i) }} menit.
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="p-4 flex justify-center">
                        {{ $borrowedBooks->appends(['status' => $status])->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif


        </div>

    </div>
</x-app-layout>
