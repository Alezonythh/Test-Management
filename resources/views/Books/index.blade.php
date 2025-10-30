<x-app-layout>
    <div x-data="{ open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true') }" x-init="window.addEventListener('sidebar-toggled', () => { open = JSON.parse(localStorage.getItem('sidebarOpen')); });" :class="open ? 'ml-0 sm:ml-64' : 'ml-0 sm:ml-16'"
        class="transition-all duration-300">
        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-7xl">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold" style="color: #F1A004;">Daftar Barang</h2>
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <a href="{{ route('books.create') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white 
                   bg-[#F1A004] hover:bg-[#d89200] 
                   rounded-xl shadow-md hover:shadow-lg 
                   transition-all duration-300 ease-out">
                            Tambah Barang
                        </a>
                    @endif
                </div>

                <div class="flex items-center justify-between mb-6">
                    <form action="{{ route('books.index') }}" method="GET" class="w-full max-w-md">
                        <div class="relative group">
                            <!-- Icon -->
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-white opacity-80 group-focus-within:opacity-100 transition"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 5a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>

                            <!-- Input -->
                            <input type="search" name="search" id="table-search" placeholder="Cari barang..."
                                class="block w-full p-2.5 pl-10 text-sm text-white 
                       rounded-xl border border-transparent 
                       bg-[#F1A004] focus:bg-[#d89200]
                       placeholder-white/70
                       shadow-md focus:shadow-lg 
                       transition-all duration-300 ease-out
                       dark:bg-[#2C3262] dark:focus:bg-[#434A8B]">
                        </div>
                    </form>
                </div>


                @if (session('success'))
                    <div
                        class="my-4 p-4 text-green-800 bg-green-50 border border-green-200 rounded-lg dark:bg-green-900/30 dark:text-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Table -->
                <div
                    class="relative overflow-x-auto rounded-2xl shadow-xl border border-[#F1A004]/20 dark:border-white/10">
                    <table class="w-full text-sm text-left">
                        <thead
                            class="uppercase text-xs bg-[#F1A004]/90 text-white dark:bg-[#2C3262]/90 dark:text-gray-100">
                            <tr>
                                <th class="px-6 py-3">Nama Barang</th>
                                <th class="px-6 py-3">Kategori</th>
                                <th class="px-6 py-3">Jumlah Stok</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Deskripsi</th>
                                <th class="px-6 py-3 text-center">Kondisi Awal</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                                <th class="px-6 py-3 text-center">Pinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                                <tr
                                    class="bg-white hover:bg-[#fff3cd] border-b border-[#F1A004]/20 
                                           dark:bg-[#1c1c2e] dark:hover:bg-[#2a2a46] dark:border-gray-700 transition">
                                    <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">
                                        {{ $book->judul_buku }}</td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $book->kategori }}</td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $book->jumlah_stok }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold 
                                                   {{ $book->status ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                                            {{ $book->status ? 'Tersedia' : 'Tidak Tersedia' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        {{ Str::limit($book->deskripsi, 50) }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($book->kondisi_awal)
                                            <img src="{{ asset('storage/' . $book->kondisi_awal) }}" alt="Foto"
                                                class="w-12 h-12 object-cover rounded-lg mx-auto border border-[#F1A004]/40 shadow">
                                        @else
                                            <span class="text-gray-400 italic">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        @if (Auth::check() && Auth::user()->role == 'admin')
                                            <div class="inline-flex items-center gap-2 whitespace-nowrap">
                                                <a href="{{ route('books.edit', $book->id) }}"
                                                    class="inline-flex px-5 py-2 rounded-lg font-semibold text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:scale-105 transition">
                                                    Edit
                                                </a>
                                                <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                                    class="inline delete-form">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex px-5 py-2 rounded-lg font-semibold text-white bg-gradient-to-r from-red-500 to-red-700 hover:scale-105 transition">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if (Auth::check() && in_array(Auth::user()->role, ['admin','supervisor']))
                                            <form id="addToCartForm-{{ $book->id }}"
                                                action="{{ route('keranjang.add', $book->id) }}" method="POST"
                                                class="inline-block mr-2">
                                                @csrf
                                                <button type="submit"
                                                    class="px-4 py-2 rounded-lg font-semibold text-white bg-gradient-to-r from-[#F1A004] to-[#d89200] hover:opacity-90 transition disabled:opacity-50"
                                                    {{ $book->jumlah_stok <= 0 ? 'disabled' : '' }}>
                                                    Tambah ke Keranjang
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modal -->
                @foreach ($books as $book)
                    <div id="modal-{{ $book->id }}" tabindex="-1"
                        class="fixed inset-0 z-50 hidden w-full p-4 overflow-y-auto bg-black/50 backdrop-blur-sm">
                        <div
                            class="relative mx-auto w-full max-w-md bg-white dark:bg-[#2C3262] text-gray-800 dark:text-gray-100 rounded-2xl shadow-xl p-6">
                            <div class="flex justify-between items-center border-b pb-3 dark:border-gray-600">
                                <h3 class="font-bold text-lg text-[#F1A004] dark:text-white">Form Peminjaman</h3>
                                <button type="button" data-modal-hide="modal-{{ $book->id }}"
                                    class="text-[#F1A004] dark:text-white hover:opacity-70">
                                    ✕
                                </button>
                            </div>
                            <form action="{{ route('books.pinjam') }}" method="POST" class="mt-6 space-y-4">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <div>
                                    <label for="nama_peminjam"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama
                                        Peminjam</label>
                                    <input type="text" id="nama_peminjam" name="nama_peminjam"
                                        class="w-full p-3 rounded-lg text-sm bg-gray-50 border border-[#F1A004]/40 focus:ring-2 focus:ring-[#F1A004] dark:bg-white/10 dark:text-white dark:border-white/30"
                                        placeholder="Nama peminjam..." required>
                                </div>
                                <div>
                                    <label for="tanggal_pinjam"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal
                                        Pinjam</label>
                                    <input type="date" id="tanggal_pinjam" name="tanggal_pinjam"
                                        class="w-full p-3 rounded-lg text-sm bg-gray-50 border border-[#F1A004]/40 focus:ring-2 focus:ring-[#F1A004] dark:bg-white/10 dark:text-white dark:border-white/30"
                                        value="{{ now()->format('Y-m-d') }}" required>
                                </div>
                                <div>
                                    <label for="tanggal_kembali"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal
                                        Kembali</label>
                                    <input type="date" id="tanggal_kembali" name="tanggal_kembali"
                                        class="w-full p-3 rounded-lg text-sm bg-gray-50 border border-[#F1A004]/40 focus:ring-2 focus:ring-[#F1A004] dark:bg-white/10 dark:text-white dark:border-white/30"
                                        value="{{ now()->addDays(7)->format('Y-m-d') }}" required>
                                </div>
                                <button type="submit"
                                    class="w-full mt-6 px-8 py-3 text-sm font-semibold text-white rounded-xl bg-gradient-to-r from-[#F1A004] to-[#d89200] hover:scale-105 transition">
                                    Pinjam
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <!-- Floating Cart Button for Admin/Supervisor -->
        @if (Auth::check() && in_array(Auth::user()->role, ['admin','supervisor']))
            <button onclick="toggleCart()"
                class="fixed bottom-5 right-5 flex items-center justify-center w-14 h-14 rounded-full shadow-lg transition-all duration-300 z-50 bg-[#F1A004] hover:bg-[#d68c00] dark:bg-[#2C3262] dark:hover:bg-[#3b4180]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="white" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.3 5.2a1 1 0 001 1.3h12.6a1 1 0 001-1.3L17 13M7 13l1.5-5h7L17 13M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                </svg>
            </button>

            <!-- Cart Modal -->
            <div id="cartModal"
                class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                <div
                    class="bg-white dark:bg-[#2C3262] text-gray-800 dark:text-gray-100 rounded-2xl w-[95%] sm:w-[460px] max-h-[85vh] shadow-2xl flex flex-col overflow-hidden">
                    <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-white/20">
                        <h2 class="text-lg font-bold text-gray-800 dark:text-white">Keranjang Peminjaman</h2>
                        <button onclick="toggleCart()"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition">×</button>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4 space-y-3">
                        @php $cart = session('cart', []); @endphp
                        @if (count($cart) > 0)
                            <form action="{{ route('keranjang.checkout') }}" method="POST" id="cartForm">
                                @csrf
                                <div
                                    class="mb-3 p-3 rounded-lg bg-yellow-50 border border-yellow-200 dark:bg-white/10 dark:border-white/20">
                                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">Nama
                                        Peminjam</label>
                                    <input type="text" id="global-borrower-name" placeholder="Nama Peminjam"
                                        required value="{{ Auth::user()->name ?? '' }}"
                                        class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 dark:bg-transparent dark:text-white">
                                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-300">Akan diterapkan ke semua
                                        item.</p>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                                    <div
                                        class="p-3 rounded-lg bg-blue-50 border border-blue-200 dark:bg-white/10 dark:border-white/20">
                                        <label
                                            class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">Tanggal
                                            Pinjam</label>
                                        <input type="date" id="global-borrow-date"
                                            class="w-full p-2 border rounded-md dark:bg-transparent dark:text-white"
                                            value="{{ now()->format('Y-m-d') }}">
                                    </div>
                                    <div
                                        class="p-3 rounded-lg bg-blue-50 border border-blue-200 dark:bg-white/10 dark:border-white/20">
                                        <label
                                            class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-200">Tanggal
                                            Kembali</label>
                                        <input type="date" id="global-return-date"
                                            class="w-full p-2 border rounded-md dark:bg-transparent dark:text-white"
                                            value="{{ now()->addDays(7)->format('Y-m-d') }}">
                                    </div>
                                </div>

                                @foreach ($cart as $id => $item)
                                    <div
                                        class="p-3 rounded-lg border border-gray-200 dark:border-white/20 flex items-start justify-between gap-3">
                                        <div class="flex-1">
                                            <div class="font-semibold">{{ $item['judul_buku'] }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-300">Kategori:
                                                {{ $item['kategori'] }}</div>
                                            <input type="hidden" name="cart[{{ $id }}][nama_peminjam]"
                                                class="cart-item-borrower-name">
                                            <input type="hidden" name="cart[{{ $id }}][tanggal_pinjam]"
                                                class="cart-item-tanggal-pinjam">
                                            <input type="hidden" name="cart[{{ $id }}][tanggal_kembali]"
                                                class="cart-item-tanggal-kembali">
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button type="button" onclick="updateQty(this, -1, {{ $id }})"
                                                class="px-2 py-1 rounded bg-gray-200 dark:bg-white/10">-</button>
                                            <input type="number" min="1" value="{{ $item['quantity'] }}"
                                                data-max="{{ $item['jumlah_stok'] }}"
                                                class="w-14 text-center p-1 rounded border dark:bg-transparent dark:text-white"
                                                name="cart[{{ $id }}][quantity]">
                                            <button type="button" onclick="updateQty(this, 1, {{ $id }})"
                                                class="px-2 py-1 rounded bg-gray-200 dark:bg-white/10">+</button>
                                        </div>
                                        <button type="button" onclick="removeFromCart({{ $id }})"
                                            class="flex items-center gap-1 px-3 py-1.5 text-sm font-medium 
           text-red-600 bg-red-100 hover:bg-red-200 
           dark:text-red-400 dark:bg-red-500/10 dark:hover:bg-red-500/20 
           rounded-lg transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
                                                class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Hapus
                                        </button>

                                    </div>
                                @endforeach

                                <div class="flex justify-end gap-3 mt-4">
                                    <button type="button" onclick="toggleCart()"
                                        class="px-4 py-2 rounded-lg border">Tutup</button>
                                    <button type="submit"
                                        class="px-4 py-2 rounded-lg text-white bg-green-600 hover:bg-green-700">Pinjam
                                        Semua</button>
                                </div>
                            </form>
                        @else
                            <div class="text-center text-gray-500">Keranjang kosong.</div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>

<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin?',
                text: "Data buku akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    @if (session('deleted'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('deleted') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif
    @if (session('updated'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('updated') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif
    @if (session('created'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('created') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif
</script>

@if (Auth::check() && in_array(Auth::user()->role, ['admin','supervisor']))
<script>
        function toggleCart() {
            const el = document.getElementById('cartModal');
            if (el) el.classList.toggle('hidden');
        }

        function syncBorrowerName() {
            const v = document.getElementById('global-borrower-name')?.value || '';
            document.querySelectorAll('#cartForm input[name$="[nama_peminjam]"]').forEach(el => el.value = v);
        }

        function syncBorrowDates() {
            const v1 = document.getElementById('global-borrow-date')?.value || '';
            const v2 = document.getElementById('global-return-date')?.value || '';
            document.querySelectorAll('#cartForm input[name$="[tanggal_pinjam]"]').forEach(el => el.value = v1);
            document.querySelectorAll('#cartForm input[name$="[tanggal_kembali]"]').forEach(el => el.value = v2);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const gName = document.getElementById('global-borrower-name');
            const gBorrow = document.getElementById('global-borrow-date');
            const gReturn = document.getElementById('global-return-date');
            if (gName) gName.addEventListener('input', syncBorrowerName);
            if (gBorrow) gBorrow.addEventListener('change', syncBorrowDates);
            if (gReturn) gReturn.addEventListener('change', syncBorrowDates);
            const cartForm = document.getElementById('cartForm');
            if (cartForm) {
                cartForm.addEventListener('submit', () => {
                    syncBorrowerName();
                    syncBorrowDates();
                });
            }
        });

        function updateQty(btn, diff, id) {
            const input = btn.parentElement.querySelector('input[type=number]');
            let val = parseInt(input.value || '1') + diff;
            const max = parseInt(input.dataset.max || '1');
            if (val < 1) val = 1;
            if (val > max) val = max;
            input.value = val;
            updateQuantity(id, val);
        }

        function updateQuantity(id, quantity) {
            fetch(`/keranjang/update/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    quantity
                })
            }).catch(() => {});
        }

        function removeFromCart(id) {
            fetch(`/keranjang/remove/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(res => res.json()).then(data => {
                if (data.success) location.reload();
            });
        }
</script>
@endif
