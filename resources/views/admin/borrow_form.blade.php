<x-app-layout>
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Pinjam Buku (Admin)</h2>
            <form action="{{ route('books.pinjam') }}" method="POST">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <input type="hidden" name="borrow_type" value="admin_borrow">

                <!-- Informasi Buku -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Buku</label>
                    <input type="text" value="{{ $book->judul_buku }}" readonly
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penulis</label>
                    <input type="text" value="{{ $book->penulis }}" readonly
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <!-- Nama Peminjam (manual) -->
                <div class="mb-4">
                    <label for="nama_peminjam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Peminjam</label>
                    <input type="text" name="nama_peminjam" id="nama_peminjam" placeholder="Isi nama peminjam" required
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                 <!-- User ID (manual) -->
                <div class="mb-4">
                    <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User ID</label>
                    <input type="number" name="user_id" id="user_id" placeholder="Enter User ID"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                 <!-- Kondisi Awal (Foto) -->
                <div class="mb-4">
                    <label for="kondisi_awal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kondisi Awal (Foto)</label>
                    <input type="file" name="kondisi_awal" id="kondisi_awal"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div>
                        <label for="tanggal_pinjam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                               value="{{ now()->format('Y-m-d') }}" required
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label for="tanggal_kembali" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                               value="{{ now()->addDays(7)->format('Y-m-d') }}" required
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>

                <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 mt-4 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                    Pinjam
                </button>
            </form>
        </div>
    </section>
</x-app-layout>
