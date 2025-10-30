<x-app-layout>
    <div x-data="{ open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true') }" x-init="window.addEventListener('sidebar-toggled', () => {
        open = JSON.parse(localStorage.getItem('sidebarOpen'));
    });" :class="open ? 'ml-0 sm:ml-64' : 'ml-0 sm:ml-16'"
        class="transition-all duration-300 relative p-4">



        <div class="container mx-auto pt-10">
            <h1 <h1
                class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-gray-100 
           mb-8 text-center relative after:content-[''] after:block after:w-24 after:h-1 
           after:bg-gradient-to-r from-blue-500 to-indigo-500 after:rounded-full after:mt-3 after:mx-auto">
                📦Daftar Peminjaman Barang
            </h1>

            <!-- Filter Status -->
            <!-- Filter Status -->
            <div class="mb-6">
                <form method="GET" action="{{ route('admin.borrowedBooks') }}">
                    <div class="flex flex-wrap justify-center gap-4">
                        @php
                            $filters = [
                                [
                                    'value' => 'dipinjam',
                                    'label' => '📦 Barang Dipinjam',
                                    'color' => 'from-blue-500 to-indigo-600',
                                ],
                                [
                                    'value' => 'dikembalikan',
                                    'label' => '✅ Barang Dikembalikan',
                                    'color' => 'from-green-500 to-emerald-600',
                                ],
                                [
                                    'value' => 'overdue',
                                    'label' => '⏰ Waktunya Dikembalikan',
                                    'color' => 'from-rose-500 to-orange-500',
                                ],
                            ];
                        @endphp

                        @foreach ($filters as $btn)
                            <button type="submit" name="status" value="{{ $btn['value'] }}"
                                class="group relative inline-flex items-center justify-center px-6 py-3 font-semibold rounded-xl text-white transition-all duration-300
                           @if ($status == $btn['value']) bg-gradient-to-r {{ $btn['color'] }} shadow-[0_0_20px_rgba(255,255,255,0.3)]
                           @else
                               bg-gray-800 hover:bg-gradient-to-r {{ $btn['color'] }} hover:shadow-[0_0_20px_rgba(255,255,255,0.3)] mb-5 @endif
                           overflow-hidden backdrop-blur-md hover:scale-[1.05] active:scale-95">
                                <span class="relative z-10">{{ $btn['label'] }}</span>
                                <span
                                    class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                            </button>
                        @endforeach
                    </div>
                </form>
            </div>


            <!-- Tombol Export Excel -->
            @if ($status == 'dikembalikan')
                <div class="mb-4 flex justify-center">
                    <a href="{{ route('admin.borrowedBooks.exportWithStatus', ['status' => $status]) }}"
                        class="group relative inline-flex items-center gap-2 px-7 py-3 text-white font-bold rounded-xl
                  bg-gradient-to-r from-emerald-500 to-green-600 shadow-[0_0_25px_rgba(16,185,129,0.5)]
                  transition-all duration-500 ease-in-out hover:scale-105 active:scale-95 overflow-hidden">
                        <span
                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent opacity-0 group-hover:opacity-100 translate-x-[-100%] group-hover:translate-x-[100%] transition-all duration-700 ease-in-out"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16l4 4 4-4m-4-12v16" />
                        </svg>
                        Export Excel
                    </a>
                </div>
            @endif


            <!-- Tabel Peminjaman -->
            @if ($borrowedBooks->isEmpty())
                <div class="flex justify-center">
                    <div
                        class="group relative overflow-hidden px-6 py-5 w-full max-w-2xl rounded-2xl
               bg-gradient-to-br from-gray-100 via-white to-gray-200
               dark:from-gray-800 dark:via-gray-900 dark:to-gray-800
               border border-gray-200 dark:border-gray-700
               shadow-[0_0_25px_rgba(0,0,0,0.08)] dark:shadow-[0_0_25px_rgba(255,255,255,0.05)]
               text-center transition-all duration-500 hover:scale-[1.02] hover:shadow-lg hover:shadow-indigo-400/20">

                        <!-- Animated Gradient Shine -->
                        <span
                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent
                   opacity-0 group-hover:opacity-100 translate-x-[-100%] group-hover:translate-x-[100%]
                   transition-all duration-1000 ease-in-out"></span>

                        <!-- Icon -->
                        <div class="flex justify-center mb-3">
                            <div
                                class="relative w-14 h-14 rounded-full flex items-center justify-center
                       bg-gradient-to-r from-indigo-500 to-purple-600 text-white
                       shadow-[0_0_15px_rgba(99,102,241,0.5)] group-hover:shadow-[0_0_25px_rgba(139,92,246,0.6)]
                       transition-all duration-300 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.8" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8v4m0 4h.01m6.938-2A9 9 0 1 0 3.062 12a9 9 0 0 0 15.876 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Text -->
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                            Tidak ada barang dengan status
                            <span
                                class="text-indigo-600 dark:text-indigo-400 font-extrabold">'{{ $status }}'</span>.
                        </h2>

                        <p class="mt-2 text-gray-600 dark:text-gray-300 text-sm">
                            📦 Sepertinya semua barang sedang dalam kondisi berbeda. Yuk cek kategori lainnya!
                        </p>

                        <!-- Decorative Glow -->
                        <div
                            class="absolute -bottom-12 left-1/2 -translate-x-1/2 w-48 h-48 rounded-full
                    bg-indigo-500/10 blur-3xl group-hover:opacity-80 opacity-50 transition-all duration-700">
                        </div>
                    </div>
                </div>
            @else
                <div
                    class="relative overflow-x-auto rounded-2xl shadow-2xl mt-6 bg-gradient-to-br from-[#2C3262] via-[#434A8B] to-[#2C3262]">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-[#2C3262] via-[#434A8B] to-[#2C3262] rounded-2xl">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-[#2C3262]/40 via-[#434A8B]/40 to-[#2C3262]/40 blur-2xl animate-pulse rounded-2xl">
                    </div>

                    <div class="relative z-10 p-4">
                        @foreach ($borrowedBooks as $guestName => $borrows)
                            <h2 class="text-lg font-semibold text-[#F1A004] mb-3">
                                Peminjam: {{ $guestName ?? '-' }}
                            </h2>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-white mb-8">
                                    <thead
                                        class="text-xs uppercase bg-[#2C3262]/90 border-b border-white/10 text-[#F1A004]">
                                        <tr>
                                            <th class="px-6 py-3">Judul Barang</th>
                                            <th class="px-6 py-3">Tanggal Pinjam</th>
                                            <th class="px-6 py-3">Tanggal Kembali</th>
                                            <th class="px-6 py-3">Status</th>
                                            <th class="px-6 py-3 text-center">Jumlah</th>
                                            <th class="px-6 py-3 text-center">Kondisi Awal</th>
                                            <th class="px-6 py-3 text-center">Kondisi Akhir</th>
                                            <th class="px-6 py-3 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $groups = $borrows->groupBy('book_id'); @endphp
                                        @foreach ($groups as $bookId => $items)
                                            @php
                                                $first = $items->first();
                                                $qty = $items->sum(function ($r) {
                                                    return $r->quantity ?? 1;
                                                });
                                                $minPinjam = \Carbon\Carbon::parse(
                                                    $items->min('tanggal_pinjam'),
                                                )->format('d-m-Y');
                                                $maxKembali = \Carbon\Carbon::parse(
                                                    $items->max('tanggal_kembali'),
                                                )->format('d-m-Y');
                                                $anyDipinjam = $items->contains(function ($r) {
                                                    return $r->status === 'dipinjam';
                                                });
                                                $statusText = $anyDipinjam ? 'dipinjam' : 'dikembalikan';
                                                $dipinjamCount = $items->where('status', 'dipinjam')->count();
                                                $returnDate = \Carbon\Carbon::parse($items->max('tanggal_kembali'));
                                                $now = \Carbon\Carbon::now();
                                                $diff = $now->diffInDays($returnDate, false);
                                                $rowClass = '';
                                                if ($diff == 0 && $anyDipinjam) {
                                                    $rowClass = 'bg-yellow-500/20';
                                                } elseif ($diff < 0 && $anyDipinjam) {
                                                    $rowClass = 'bg-red-500/20';
                                                }
                                                $groupId =
                                                    'grp-' . $bookId . '-' . $loop->parent->index . '-' . $loop->index;
                                            @endphp

                                            <tr
                                                class="border-b border-white/10 hover:bg-[#434A8B]/40 transition-all duration-300 {{ $rowClass }}">
                                                <td class="px-6 py-4 font-medium text-white">
                                                    {{ $first->book->judul_buku }}</td>
                                                <td class="px-6 py-4">{{ $minPinjam }}</td>
                                                <td class="px-6 py-4">{{ $maxKembali }}</td>
                                                <td class="px-6 py-4">
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium rounded-lg {{ $anyDipinjam ? 'bg-yellow-400/30 text-yellow-100' : 'bg-green-500/30 text-green-100' }}">{{ ucfirst($statusText) }}</span>
                                                </td>
                                                <td class="px-6 py-4 text-center">{{ $qty }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    @if ($first->book->kondisi_awal)
                                                        <img src="{{ asset('storage/' . $first->book->kondisi_awal) }}"
                                                            alt="Kondisi Awal" width="50"
                                                            class="rounded-md shadow-md">
                                                    @else
                                                        <span class="italic text-gray-300">Tidak ada gambar</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    @if ($first->kondisi_akhir)
                                                        <img src="{{ asset('storage/' . $first->kondisi_akhir) }}"
                                                            alt="Kondisi Akhir" width="50"
                                                            class="rounded-md shadow-md">
                                                    @else
                                                        <span class="italic text-gray-300">—</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <button type="button"
                                                        onclick="document.getElementById('{{ $groupId }}').classList.toggle('hidden')"
                                                        class="group relative px-5 py-2.5 rounded-xl text-white font-semibold bg-gradient-to-r from-blue-500 to-indigo-600 shadow-[0_0_15px_rgba(79,70,229,0.5)] transition-all duration-300 hover:scale-105 hover:shadow-[0_0_25px_rgba(79,70,229,0.7)] mr-2">
                                                        Kelola
                                                    </button>
                                                    @if ($dipinjamCount > 0)
                                                        <form action="{{ route('admin.bulkReturn') }}" method="POST"
                                                            class="inline-flex items-center gap-2 align-middle">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="book_id"
                                                                value="{{ $first->book->id }}">
                                                            <input type="hidden" name="nama_peminjam"
                                                                value="{{ $guestName }}">
                                                            <button type="submit"
                                                                class="px-3 py-2 rounded-lg text-white bg-green-600 hover:bg-green-700 text-xs">Kembalikan
                                                                Semua</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr id="{{ $groupId }}" class="hidden">
                                                <td colspan="8" class="px-6 py-4 bg-[#2C3262]/40">
                                                    <div class="space-y-3">
                                                        @foreach ($items as $borrow)
                                                            <div
                                                                class="flex items-center justify-between gap-3 border-b border-white/10 pb-3">
                                                                <div class="text-sm text-white/90">
                                                                    {{ \Carbon\Carbon::parse($borrow->tanggal_pinjam)->format('d-m-Y') }}
                                                                    →
                                                                    {{ \Carbon\Carbon::parse($borrow->tanggal_kembali)->format('d-m-Y') }}
                                                                    <span
                                                                        class="ml-2 px-2 py-0.5 rounded bg-white/10 text-xs">Qty:
                                                                        {{ $borrow->quantity ?? 1 }}</span>
                                                                </div>
                                                                <div class="flex items-center gap-2">
                                                                    @if ($borrow->status === 'dipinjam')
                                                                        <form
                                                                            action="{{ route('admin.extendLoan', $borrow->id) }}"
                                                                            method="POST"
                                                                            class="inline-flex items-center gap-2">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <input type="date"
                                                                                name="tanggal_kembali" required
                                                                                class="block w-32 text-sm text-gray-900 border-gray-300 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500">
                                                                            <button type="submit"
                                                                                class="px-4 py-2 rounded-lg text-white bg-gradient-to-r from-blue-500 to-indigo-600">Perpanjang</button>
                                                                        </form>
                                                                        <button
                                                                            data-modal-target="returnModal-{{ $borrow->id }}"
                                                                            data-modal-toggle="returnModal-{{ $borrow->id }}"
                                                                            class="px-4 py-2 rounded-lg text-white bg-gradient-to-r from-rose-600 to-red-700">Kembalikan</button>
                                                                    @else
                                                                        <span
                                                                            class="text-gray-300 italic">Selesai</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $borrowedBooks->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Return Modals -->
        @foreach ($borrowedBooks as $borrows)
            @foreach ($borrows as $borrow)
                <div id="returnModal-{{ $borrow->id }}" tabindex="-1" aria-hidden="true"
                    class="fixed inset-0 z-50 hidden w-full p-4 overflow-y-auto">
                    <div class="relative w-full max-w-3xl mx-auto">
                        <div
                            class="relative bg-gradient-to-br from-[#2C3262]/95 to-[#434A8B]/95 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden text-white">
                            <div class="flex items-center justify-between p-4 border-b border-white/20">
                                <h3 class="text-lg font-extrabold tracking-wide text-[#F1A004]">
                                    📦 Kembalikan Barang
                                </h3>
                                <button type="button" data-modal-hide="returnModal-{{ $borrow->id }}"
                                    class="text-[#F1A004] bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-[#F1A004] dark:hover:text-white">
                                    ✖
                                </button>
                            </div>
                            <div class="p-6">
                                <form action="{{ route('admin.submit_return_form', $borrow->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="grid gap-4 sm:grid-cols-2">
                                        <div>
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Kondisi
                                                Awal</label>
                                            @if ($borrow->book->kondisi_awal)
                                                <img src="{{ asset('storage/' . $borrow->book->kondisi_awal) }}"
                                                    alt="Kondisi Awal" width="200">
                                            @else
                                                <p class="text-gray-500 dark:text-white">Tidak ada gambar</p>
                                            @endif
                                        </div>
                                        <div>
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Kondisi
                                                Akhir (Foto)</label>
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
                                        <span
                                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent 
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
        @endforeach


    </div>
</x-app-layout>
