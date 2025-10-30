<x-app-layout>
    <div x-data="{ open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true') }" x-init="window.addEventListener('sidebar-toggled', () => {
        open = JSON.parse(localStorage.getItem('sidebarOpen'));
    });" :class="open ? 'ml-0 sm:ml-64' : 'ml-0 sm:ml-16'"
        class="transition-all duration-300">

        <section
            class="min-h-screen bg-gradient-to-br from-[#FAF7F0] via-[#FFFDF7] to-[#FFF7E0]
                       dark:from-[#1E1B4B] dark:via-[#2C3262] dark:to-[#6a5acd]
                       transition-all duration-500">
            <div class="py-12 px-4 mx-auto max-w-2xl lg:py-16">
                <!-- Header -->
                <div class="mb-10 text-center">
                    <h2 class="text-3xl font-extrabold text-[#E19E02] dark:text-[#F1A004]">
                        Edit Barang
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm">
                        Lengkapi data berikut untuk mengedit data barang.
                    </p>
                </div>

                <!-- Card -->
                <div
                    class="bg-white/90 dark:bg-[#2C3262]/95 
                           backdrop-blur-md rounded-2xl shadow-2xl p-8 
                           border border-[#E19E02]/20 dark:border-white/20 transition-all duration-500">

                    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                            <!-- Nama Barang -->
                            <div class="sm:col-span-2">
                                <label for="judul_buku"
                                    class="block mb-2 text-sm font-semibold text-[#E19E02] dark:text-white">
                                    Nama Barang
                                </label>
                                <input type="text" name="judul_buku" id="judul_buku"
                                    class="w-full p-3 text-sm rounded-xl 
                                           bg-[#FFF9E8] border border-[#E19E02]/40 text-gray-900 
                                           placeholder-gray-500 focus:ring-2 focus:ring-[#E19E02] focus:border-[#E19E02] 
                                           focus:outline-none dark:bg-white/20 dark:text-white dark:placeholder-gray-300"
                                    value="{{ $book->judul_buku }}" required>
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="kategori"
                                    class="block mb-2 text-sm font-semibold text-[#E19E02] dark:text-white">
                                    Kategori
                                </label>
                                <select id="kategori" name="kategori"
                                    class="w-full p-3 rounded-xl text-sm 
                                           bg-[#FFF9E8] border border-[#E19E02]/40 text-gray-900 
                                           focus:ring-2 focus:ring-[#E19E02] focus:border-[#E19E02] focus:outline-none
                                           dark:bg-[#2C3262] dark:text-white dark:border-white/30">
                                    <option value="Camera" {{ $book->kategori == 'Camera' ? 'selected' : '' }}>Camera
                                    </option>
                                    <option value="Headset" {{ $book->kategori == 'Headset' ? 'selected' : '' }}>Headset
                                    </option>
                                    <option value="Proyektor" {{ $book->kategori == 'Proyektor' ? 'selected' : '' }}>
                                        Proyektor</option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status"
                                    class="block mb-2 text-sm font-semibold text-[#E19E02] dark:text-white">
                                    Status
                                </label>
                                <select id="status" name="status"
                                    class="w-full p-3 rounded-xl text-sm 
                                           bg-[#FFF9E8] border border-[#E19E02]/40 text-gray-900 
                                           focus:ring-2 focus:ring-[#E19E02] focus:border-[#E19E02] focus:outline-none
                                           dark:bg-[#2C3262] dark:text-white dark:border-white/30">
                                    <option value="1" {{ $book->status ? 'selected' : '' }}>Tersedia</option>
                                    <option value="0" {{ !$book->status ? 'selected' : '' }}>Tidak Tersedia
                                    </option>
                                </select>
                            </div>

                            <!-- Jumlah Stok -->
                            <div class="sm:col-span-2">
                                <label for="jumlah_stok"
                                    class="block mb-2 text-sm font-semibold text-[#E19E02] dark:text-white">
                                    Jumlah Stok
                                </label>
                                <input type="number" name="jumlah_stok" id="jumlah_stok"
                                    class="w-full p-3 text-sm rounded-xl 
                                           bg-[#FFF9E8] border border-[#E19E02]/40 text-gray-900 
                                           focus:ring-2 focus:ring-[#E19E02] focus:border-[#E19E02] 
                                           focus:outline-none dark:bg-white/20 dark:text-white dark:border-white/30"
                                    value="{{ $book->jumlah_stok }}" required>
                            </div>

                            <!-- Deskripsi -->
                            <div class="sm:col-span-2">
                                <label for="deskripsi"
                                    class="block mb-2 text-sm font-semibold text-[#E19E02] dark:text-white">
                                    Deskripsi
                                </label>
                                <textarea id="deskripsi" name="deskripsi" rows="6"
                                    class="block w-full p-3 text-sm rounded-xl 
                                           bg-[#FFF9E8] border border-[#E19E02]/40 text-gray-900 
                                           placeholder-gray-600 focus:ring-2 focus:ring-[#E19E02] focus:border-[#E19E02] 
                                           focus:outline-none dark:bg-white/20 dark:text-white dark:placeholder-gray-300">{{ $book->deskripsi }}</textarea>
                            </div>

                            <!-- Kondisi Awal -->
                            <div class="sm:col-span-2">
                                <label for="kondisi_awal"
                                    class="block mb-2 text-sm font-semibold text-[#E19E02] dark:text-white">
                                    Kondisi Awal (Foto)
                                </label>
                                <input type="file" name="kondisi_awal" id="kondisi_awal"
                                    class="block w-full text-sm border border-[#E19E02]/40 rounded-xl cursor-pointer 
                                           bg-[#FFF9E8] text-gray-800 placeholder-gray-600 
                                           focus:outline-none focus:ring-2 focus:ring-[#E19E02] focus:border-[#E19E02] 
                                           dark:bg-white/10 dark:text-white dark:border-white/30">
                            </div>
                        </div>

                        <!-- Tombol Update -->
                        <div class="text-center pt-6">
                            <button type="submit"
                                class="px-8 py-3 text-sm font-semibold text-white rounded-xl
               bg-gradient-to-r from-amber-400 to-yellow-500
               hover:from-amber-500 hover:to-yellow-600
               dark:from-yellow-400 dark:to-amber-500
               shadow-md hover:shadow-lg transition-all duration-300">
                                Update Barang
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
