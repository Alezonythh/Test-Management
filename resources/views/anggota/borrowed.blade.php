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

        <!-- Konten halaman Riwayat Peminjaman -->
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-6">
                <h1
                    class="text-3xl sm:text-4xl font-extrabold 
        text-gray-900 dark:text-transparent dark:bg-clip-text 
        dark:bg-gradient-to-r dark:from-[#4F6CF2] dark:via-[#7FA9FF] dark:to-[#4F6CF2]">
                    Riwayat Peminjaman
                </h1>
                <p class="mt-2 text-gray-700 dark:text-gray-300 text-sm sm:text-base">
                    Lihat semua barang yang sudah kamu pinjam, termasuk status pengembalian dan histori lengkapnya.
                </p>
            </div>


            <!-- Notifikasi Flash Message -->
            @if (session('success'))
                <div class="flex justify-center">
                    <div
                        class="relative flex items-start gap-4 max-w-xl w-full p-5 border border-green-300 dark:border-green-700 rounded-2xl bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 text-green-800 dark:text-green-200 shadow-lg transition-all duration-300">

                        <!-- Animated icon -->
                        <div
                            class="flex-shrink-0 flex items-center justify-center w-11 h-11 rounded-full bg-green-100 dark:bg-green-700/60 animate-pulse">
                            <ion-icon name="checkmark-circle"
                                class="text-2xl text-green-600 dark:text-green-200"></ion-icon>
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <h3 class="text-base font-semibold mb-1">Sukses!</h3>
                            <p class="text-sm leading-relaxed">
                                {{ session('success') ?? 'Operasi berhasil dilakukan.' }}
                            </p>
                        </div>

                        <!-- Close button -->
                        <button type="button" onclick="this.closest('div[role=alert]')?.remove()"
                            class="absolute top-3 right-3 text-green-400 hover:text-green-600 transition-colors">
                            <ion-icon name="close-outline" class="text-xl"></ion-icon>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="relative flex items-start gap-4 p-5 mb-6 border border-red-300 dark:border-red-700 rounded-2xl bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/40 dark:to-red-800/40 shadow-lg transition-all duration-300 ease-out"
                    role="alert">

                    <!-- Icon with pulse effect -->
                    <div class="flex-shrink-0 animate-pulse">
                        <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-700 flex items-center justify-center">
                            <ion-icon name="alert-circle" class="text-2xl text-red-600 dark:text-red-200"></ion-icon>
                        </div>
                    </div>

                    <!-- Alert content -->
                    <div class="flex-1">
                        <h3 class="text-base font-semibold text-red-800 dark:text-red-200 mb-1">Oops! Terjadi Kesalahan
                        </h3>
                        <p class="text-sm text-red-700 dark:text-red-300">
                            {{ session('error') }}
                        </p>
                    </div>

                    <!-- Dismiss button -->
                    <button type="button" onclick="this.closest('div[role=alert]').remove()"
                        class="absolute top-3 right-3 text-red-500 hover:text-red-700 transition-colors">
                        <ion-icon name="close-outline" class="text-xl"></ion-icon>
                    </button>
                </div>
            @endif


            <!-- Filter Tab -->
            <!-- Filter Tab -->
            <div
                class="mb-6 flex flex-col sm:flex-col md:flex-row justify-center items-center gap-4 md:gap-6 flex-wrap">
                <form method="GET" action="{{ route('anggota.borrowedBooks') }}"
                    class="flex flex-col sm:flex-row md:flex-row gap-4 md:gap-6 w-full justify-center items-center flex-wrap">

                    <!-- Tab Dipinjam -->
                    <label class="relative cursor-pointer group w-full sm:w-auto">
                        <input type="radio" name="status" value="dipinjam" class="sr-only"
                            onchange="this.form.submit()" {{ $status == 'dipinjam' ? 'checked' : '' }}>
                        <span
                            class="block px-6 sm:px-8 py-3 font-semibold rounded-3xl
                       text-white backdrop-blur-sm bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500
                       shadow-lg shadow-indigo-400/40
                       transition-all duration-500 ease-in-out
                       hover:scale-105 hover:shadow-xl active:scale-95 relative overflow-hidden
                       text-center w-full sm:w-auto">

                            <!-- Shimmer effect -->
                            <span
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-white/25 to-transparent 
                           opacity-0 group-hover:opacity-100 translate-x-[-100%] group-hover:translate-x-[100%]
                           transition-all duration-1000 ease-in-out"></span>

                            Barang yang Dipinjam
                        </span>
                    </label>

                    <!-- Search Judul Buku -->
                    <div class="relative w-full sm:w-80 group">
                        <input type="text" name="judul_buku" id="judul_buku" value="{{ request('judul_buku') }}"
                            placeholder="Cari Nama Barang..."
                            class="w-full px-5 py-3 rounded-full bg-white/10 dark:bg-gray-800/30
                       border border-white/20 dark:border-gray-600/30
                       text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-300
                       shadow-lg shadow-black/10 dark:shadow-black/20
                       focus:outline-none focus:ring-2 focus:ring-indigo-400 dark:focus:ring-pink-400
                       focus:ring-offset-1 transition-all duration-300
                       hover:scale-[1.03] hover:shadow-2xl">

                        <!-- Search Icon -->
                        <svg class="absolute right-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-500 dark:text-gray-300
                        transition-colors duration-300 group-focus-within:text-indigo-400 dark:group-focus-within:text-pink-400"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                        </svg>
                    </div>

                    <!-- Tab Dikembalikan -->
                    <label class="relative cursor-pointer group w-full sm:w-auto">
                        <input type="radio" name="status" value="dikembalikan" class="sr-only"
                            onchange="this.form.submit()" {{ $status == 'dikembalikan' ? 'checked' : '' }}>
                        <span
                            class="block px-6 sm:px-8 py-3 font-semibold rounded-3xl
                       text-white backdrop-blur-sm bg-gradient-to-r from-pink-500 via-red-500 to-orange-500
                       shadow-lg shadow-pink-400/40
                       transition-all duration-500 ease-in-out
                       hover:scale-105 hover:shadow-xl active:scale-95 relative overflow-hidden
                       text-center w-full sm:w-auto">

                            <!-- Shimmer effect -->
                            <span
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-white/25 to-transparent 
                           opacity-0 group-hover:opacity-100 translate-x-[-100%] group-hover:translate-x-[100%]
                           transition-all duration-1000 ease-in-out"></span>

                            Barang yang Dikembalikan
                        </span>
                    </label>
                </form>
            </div>



            <!-- Tabel Buku -->
            @if ($borrowedBooks->isEmpty())
                <div class="flex justify-center">
                    <div
                        class="relative flex items-center gap-4 px-6 py-4 border border-red-300 dark:border-red-700 bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/30 dark:to-red-800/30 text-red-800 dark:text-red-200 rounded-2xl shadow-lg transition-all duration-300 max-w-lg">

                        <!-- Animated Icon -->
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-red-100 dark:bg-red-700/60 animate-pulse">
                            <ion-icon name="alert-circle" class="text-xl text-red-600 dark:text-red-200"></ion-icon>
                        </div>

                        <!-- Message -->
                        <p class="text-sm font-medium leading-relaxed">
                            Tidak ada riwayat untuk status ini.
                        </p>
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
