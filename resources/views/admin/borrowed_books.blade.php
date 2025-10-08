<x-app-layout>
    <div x-data="{ open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true') }"
        x-init="window.addEventListener('sidebar-toggled', () => { open = JSON.parse(localStorage.getItem('sidebarOpen')); });"
        :class="open ? 'ml-64' : 'ml-16'"
        class="transition-all duration-300">

        <div class="container mx-auto pt-10">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                Daftar Peminjaman Buku
            </h1>

            <!-- Filter Status -->
            <div class="mb-6">
                <form method="GET" action="{{ route('admin.borrowedBooks') }}">
                    <div class="flex justify-center space-x-6">
                        <button type="submit" name="status" value="dipinjam"
                            class="block px-8 py-3 font-semibold rounded-3xl text-white backdrop-blur-sm
                                   shadow-lg transition-all duration-500 ease-in-out hover:scale-105 hover:shadow-xl active:scale-95 relative overflow-hidden
                                   {{ $status == 'dipinjam'
                                       ? 'bg-gradient-to-r from-indigo-700 via-purple-700 to-pink-700 shadow-pink-400/40'
                                       : 'bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 shadow-indigo-400/40' }}">
                            Buku yang Dipinjam
                        </button>

                        <button type="submit" name="status" value="dikembalikan"
                            class="relative py-3 px-5 rounded-xl font-semibold text-base flex items-center gap-2
                                   transition-all duration-300 shadow-sm hover:shadow-md overflow-hidden
                                   {{ $status == 'dikembalikan'
                                       ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-indigo-400/50'
                                       : 'bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 text-gray-800 dark:text-gray-200 hover:from-indigo-500 hover:to-indigo-600 hover:text-white' }}">
                            Buku yang Dikembalikan
                        </button>

                        <button type="submit" name="status" value="overdue"
                            class="block px-8 py-3 font-semibold rounded-3xl text-white backdrop-blur-sm
                                   shadow-lg transition-all duration-500 ease-in-out hover:scale-105 hover:shadow-xl active:scale-95 relative overflow-hidden
                                   {{ $status == 'overdue'
                                       ? 'bg-gradient-to-r from-pink-700 via-red-700 to-orange-700 shadow-red-400/50'
                                       : 'bg-gradient-to-r from-pink-500 via-red-500 to-orange-500 shadow-pink-400/40' }}">
                            Buku yang Sudah Waktunya Dikembalikan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tombol Export Excel -->
            @if ($status == 'dikembalikan')
                <div class="mb-4 flex justify-center">
                    <a href="{{ route('admin.borrowedBooks.exportWithStatus', ['status' => $status]) }}"
   class="relative inline-block px-7 py-3 text-white font-semibold rounded-2xl
          bg-gradient-to-r from-[#1DB954] to-[#0e8a3d]
          shadow-[0_4px_15px_rgba(29,185,84,0.6)]
          transition-all duration-500 ease-in-out
          hover:scale-110 hover:shadow-[0_8px_25px_rgba(29,185,84,0.8)]
          active:scale-95 active:shadow-inner overflow-hidden group">
    <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent
                 opacity-0 group-hover:opacity-100 translate-x-[-100%] group-hover:translate-x-[100%]
                 transition-all duration-700 ease-in-out"></span>
    Export to Excel
</a>

                </div>
            @endif

            <!-- Tabel Peminjaman -->
            @if ($borrowedBooks->isEmpty())
                <p class="text-gray-700 dark:text-gray-300 text-center">
                    Tidak ada buku dengan status '{{ $status }}'.
                </p>
            @else
                <div class="relative overflow-x-auto rounded-2xl shadow-2xl mt-6 bg-gradient-to-br from-[#2C3262] via-[#434A8B] to-[#2C3262]">
                    <!-- Gradient Background khusus tabel -->
                    <div class="absolute inset-0 bg-gradient-to-br from-[#2C3262] via-[#434A8B] to-[#2C3262] rounded-2xl"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-[#2C3262]/40 via-[#434A8B]/40 to-[#2C3262]/40 blur-2xl animate-pulse rounded-2xl"></div>

                    <div class="relative z-10">
                        <table class="w-full text-sm text-left text-white">
                            <thead class="text-xs uppercase bg-[#2C3262]/90 border-b border-white/10 text-[#F1A004]">
                                <tr>
                                    <th class="px-6 py-3">Judul Buku</th>
                                    <th class="px-6 py-3">Peminjam</th>
                                    <th class="px-6 py-3">Tanggal Pinjam</th>
                                    <th class="px-6 py-3">Tanggal Kembali</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-center">Kondisi Awal</th>
                                    <th class="px-6 py-3 text-center">Kondisi Akhir</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($borrowedBooks as $borrow)
                                    @php
                                        $returnDate = \Carbon\Carbon::parse($borrow->tanggal_kembali);
                                        $now = \Carbon\Carbon::now();
                                        $diff = $now->diffInDays($returnDate, false);
                                        $rowClass = '';
                                        if ($diff == 0 && $borrow->status == 'dipinjam') {
                                            $rowClass = 'bg-yellow-500/20';
                                        } elseif ($diff < 0 && $borrow->status == 'dipinjam') {
                                            $rowClass = 'bg-red-500/20';
                                        }
                                    @endphp
                                    <tr class="border-b border-white/10 hover:bg-[#434A8B]/40 transition-all duration-300 {{ $rowClass }}">
                                        <td class="px-6 py-4 font-medium text-white">
                                            {{ $borrow->book->judul_buku }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ app('App\Http\Controllers\anggotaController')->getBorrowerName($borrow) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($borrow->tanggal_pinjam)->format('d-m-Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($borrow->tanggal_kembali)->format('d-m-Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-lg {{ $borrow->status === 'dipinjam' ? 'bg-yellow-400/30 text-yellow-100' : 'bg-green-500/30 text-green-100' }}">
                                                {{ ucfirst($borrow->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($borrow->book->kondisi_awal)
                                                <img src="{{ asset('storage/' . $borrow->book->kondisi_awal) }}"
                                                    alt="Kondisi Awal" width="50" class="rounded-md shadow-md">
                                            @else
                                                <span class="italic text-gray-300">Tidak ada gambar</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($borrow->kondisi_akhir)
                                                <img src="{{ asset('storage/' . $borrow->kondisi_akhir) }}"
                                                    alt="Kondisi Akhir" width="50" class="rounded-md shadow-md">
                                            @else
                                                <span class="italic text-gray-300">Tidak ada gambar</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($borrow->status === 'dipinjam')
                                                <div class="flex justify-center gap-3">
                                                    <!-- Tombol Perpanjang -->
                                                    <form action="{{ route('admin.extendLoan', $borrow->id) }}" method="POST" class="inline-flex items-center gap-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="date" name="tanggal_kembali" required
                                                            class="block w-32 text-sm text-gray-900 border-gray-300 rounded-lg bg-gray-50 focus:ring-[#F1A004] focus:border-[#F1A004]">
                                                        <button type="submit"
                                                            class="px-4 py-2 rounded-xl text-white font-semibold bg-gradient-to-r from-blue-500 to-indigo-600 hover:scale-105 transition-transform">
                                                            Perpanjang
                                                        </button>
                                                    </form>

                                                    <!-- Tombol Kembalikan -->
                                                    <button data-modal-target="returnModal-{{ $borrow->id }}"
                                                        data-modal-toggle="returnModal-{{ $borrow->id }}"
                                                        class="px-4 py-2 rounded-xl text-white font-semibold bg-gradient-to-r from-red-600 to-red-800 hover:scale-105 transition-transform">
                                                        Kembalikan
                                                    </button>
                                                </div>
                                            @else
                                                <span class="text-gray-400 italic">Sudah dikembalikan</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-4 px-6 pb-4">
                            {{ $borrowedBooks->appends(['status' => $status])->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Return Modals -->
        @foreach ($borrowedBooks as $borrow)
            <div id="returnModal-{{ $borrow->id }}" tabindex="-1" aria-hidden="true"
                class="fixed inset-0 z-50 hidden w-full p-4 overflow-y-auto">
                <div class="relative w-full max-w-3xl mx-auto">
                    <div class="relative bg-gradient-to-br from-[#2C3262]/95 to-[#434A8B]/95 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden text-white">
                        <div class="flex items-center justify-between p-4 border-b border-white/20">
        <h3 class="text-lg font-extrabold tracking-wide text-[#F1A004]">
            📚 Kembalikan Buku
        </h3>
        <button type="button" data-modal-hide="returnModal-{{ $borrow->id }}"
            class="text-[#F1A004] bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-[#F1A004] dark:hover:text-white">
            ✖
        </button>
    </div>
    <div class="p-6">
                            <form action="{{ route('admin.submit_return_form', $borrow->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Kondisi Awal</label>
                                        @if ($borrow->book->kondisi_awal)
                                            <img src="{{ asset('storage/' . $borrow->book->kondisi_awal) }}" alt="Kondisi Awal" width="200">
                                        @else
                                            <p class="text-gray-500 dark:text-white">Tidak ada gambar</p>
                                        @endif
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Kondisi Akhir (Foto)</label>
                                        <input type="file" name="kondisi_akhir" required
                                            class="w-full p-2 rounded-lg bg-white/20 border border-white/30 text-white placeholder-gray-200 
                                  focus:ring-2 focus:ring-[#F1A004] focus:outline-none dark:bg-gray-700 dark:text-white">
                                    </div>
                                </div>
                                <button type="submit"
                class="mt-6 relative w-full px-4 py-2.5 rounded-lg font-bold text-white text-sm 
                       bg-gradient-to-r from-[#F1A004] to-[#CC8600] shadow-[0_4px_15px_rgba(241,160,4,0.6)]
                       transition-all duration-500 ease-in-out hover:scale-105 hover:shadow-[0_8px_25px_rgba(204,134,0,0.8)]
                       active:scale-95 active:shadow-inner overflow-hidden group">
                <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent 
                             opacity-0 group-hover:opacity-100 translate-x-[-100%] group-hover:translate-x-[100%] 
                             transition-all duration-700 ease-in-out"></span>
                Submit
            </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</x-app-layout>