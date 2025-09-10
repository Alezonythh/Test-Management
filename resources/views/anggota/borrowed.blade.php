<x-app-layout>
    <div class="container mx-auto p-4 lg:ps-64">
        <!-- Header -->
        <h1 class="text-3xl font-bold text-gray-200 mb-6 text-center">Riwayat Peminjaman Buku</h1>

        <!-- Notifikasi Flash Message -->
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filter Tab -->
        <div class="mb-4">
            <form method="GET" action="{{ route('anggota.borrowedBooks') }}">
                <div class="flex justify-center space-x-6">
                    <button type="submit" name="status" value="dipinjam" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 {{ $status == 'dipinjam' ? 'bg-blue-600' : '' }}">
                        Buku yang Dipinjam
                    </button>
                    <button type="submit" name="status" value="dikembalikan" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 {{ $status == 'dikembalikan' ? 'bg-blue-600' : '' }}">
                        Buku yang Dikembalikan
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Buku -->
        @if($borrowedBooks->isEmpty())
            <p class="text-gray-400">Tidak ada riwayat untuk status ini.</p>
        @else
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-8">
                <table class="w-full text-sm text-left text-gray-400 bg-gray-800">
                    <thead class="text-xs text-gray-300 uppercase bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3">Judul Buku</th>
                            <th scope="col" class="px-6 py-3">Penulis</th>
                            <th scope="col" class="px-6 py-3">Tanggal Pinjam</th>
                            <th scope="col" class="px-6 py-3">Tanggal Kembali</th>
                            <th scope="col" class="px-6 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrowedBooks as $borrow)
                            <tr class="bg-gray-800 border-b border-gray-700">
                                <td class="px-6 py-4 font-medium text-white">{{ $borrow->book->judul_buku }}</td>
                                <td class="px-6 py-4">{{ $borrow->book->penulis }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($borrow->tanggal_pinjam)->format('d-m-Y') }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($borrow->tanggal_kembali)->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-1 rounded-lg bg-green-600 text-green-200">
                                        {{ ucfirst($borrow->status) }}
                                    </span>
                                </td>
                            </tr>
                            @if($borrow->status == 'dipinjam')
                            @php
                                $returnDate = \Carbon\Carbon::parse($borrow->tanggal_kembali);
                                $now = \Carbon\Carbon::now();
                                $diff = $now->diff($returnDate); // Menggunakan diff untuk mendapatkan objek perbedaan
                                $daysLeft = floor($now->diffInDays($returnDate, false)); // Membulatkan ke bawah jumlah hari
                            @endphp

                            <tr class="bg-gray-700 text-white">
                                <td colspan="5" class="px-6 py-4 text-center">
                                    @if($returnDate > $now)  <!-- Masih ada waktu untuk mengembalikan buku -->
                                        @if($daysLeft > 0)  <!-- Jika lebih dari 1 hari -->
                                            <span class="text-yellow-400">
                                                Tinggal {{ $daysLeft }} hari, {{ $diff->h }} jam, {{ $diff->i }} menit lagi untuk mengembalikan buku.
                                            </span>
                                        @elseif($daysLeft == 0 && $diff->h > 0)  <!-- Jika tinggal beberapa jam -->
                                            <span class="text-yellow-400">
                                                Tinggal {{ $diff->h }} jam, {{ $diff->i }} menit lagi untuk mengembalikan buku.
                                            </span>
                                        @elseif($daysLeft == 0 && $diff->h == 0)  <!-- Jika tinggal menit -->
                                            <span class="text-yellow-400">
                                                Tinggal {{ $diff->i }} menit lagi untuk mengembalikan buku.
                                            </span>
                                        @endif
                                    @elseif($returnDate->isToday())  <!-- Buku harus dikembalikan hari ini -->
                                        <span class="text-green-400">Buku harus dikembalikan hari ini.</span>
                                    @else  <!-- Buku sudah terlambat -->
                                        <span class="text-red-500">
                                            Buku sudah terlambat {{ abs($diff->days) }} hari, {{ abs($diff->h) }} jam, {{ abs($diff->i) }} menit.
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $borrowedBooks->appends(['status' => $status])->links('pagination::tailwind') }}
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
