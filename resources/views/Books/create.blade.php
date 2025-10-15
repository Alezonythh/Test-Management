<x-app-layout>
    <div x-data="{ open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true'), loading: true }" x-init="window.addEventListener('sidebar-toggled', () => { open = JSON.parse(localStorage.getItem('sidebarOpen')) });
    setTimeout(() => loading = false, 1000);" :class="open ? 'ml-64' : 'ml-16'"
        class="transition-all duration-300 relative">

        <!-- Loading Screen -->
        <div x-show="loading"
            class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-white dark:bg-gray-900 transition-opacity duration-500"
            x-transition.opacity>
            <div
                class="w-16 h-16 border-4 border-t-[#F1A004] border-r-transparent border-b-[#F1A004] border-l-transparent rounded-full animate-spin mb-4">
            </div>
            <p class="text-gray-700 dark:text-gray-300 text-lg font-semibold animate-pulse">
                Memuat Halaman Tambah Barang...
            </p>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                Mohon tunggu sebentar, semua data sedang dipersiapkan.
            </p>
        </div>

        <!-- Main Section -->
        <section
            class="bg-gradient-to-br from-[#FFF5E1] to-white dark:from-gray-900 dark:to-gray-800 min-h-screen transition-colors duration-700">
            <div class="py-12 px-4 mx-auto max-w-3xl lg:py-16">

                <!-- Judul -->
                <div class="mb-10 text-center">
                    <h2
                        class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#F1A004] to-[#facc15] dark:from-[#F1A004] dark:to-[#CC8600]">
                        Tambah Barang
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm">
                        Lengkapi data berikut untuk menambahkan barang baru.
                    </p>
                </div>

                <!-- Card Form -->
                <div
                    class="rounded-2xl shadow-2xl border border-[#F1A004]/30 dark:border-white/10 overflow-hidden backdrop-blur-sm 
                           bg-white/90 dark:bg-gradient-to-br dark:from-[#2C3262]/90 dark:to-[#434A8B]/90 p-8 
                           transition-all duration-700">

                    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <!-- Nama Barang -->
                        <div>
                            <label for="judul_buku"
                                class="block mb-2 text-sm font-semibold text-[#F1A004] dark:text-white">Nama
                                Barang</label>
                            <input type="text" name="judul_buku" id="judul_buku" placeholder="Nama Barang"
                                class="w-full p-3 text-sm rounded-xl border border-[#F1A004]/40 bg-white text-gray-900
                                       placeholder-gray-400 focus:ring-2 focus:ring-[#F1A004] focus:border-[#F1A004]
                                       dark:bg-white/20 dark:text-white dark:placeholder-gray-300 dark:border-white/30 
                                       focus:outline-none transition-all duration-300"
                                required>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Kategori -->
                            <div>
                                <label for="kategori"
                                    class="block mb-2 text-sm font-semibold text-[#F1A004] dark:text-white">Kategori</label>
                                <select id="kategori" name="kategori"
                                    class="w-full p-3 rounded-xl text-sm border border-[#F1A004]/40 bg-white text-gray-900
                                           dark:bg-white/20 dark:text-white focus:ring-2 focus:ring-[#F1A004] focus:border-[#F1A004] focus:outline-none">
                                    <option selected>Pilih Kategori</option>
                                    <option value="Camera">Camera</option>
                                    <option value="Headset">Headset</option>
                                    <option value="Proyektor">Proyektor</option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status"
                                    class="block mb-2 text-sm font-semibold text-[#F1A004] dark:text-white">Status</label>
                                <select id="status" name="status"
                                    class="w-full p-3 rounded-xl text-sm border border-[#F1A004]/40 bg-white text-gray-900
                                           dark:bg-white/20 dark:text-white focus:ring-2 focus:ring-[#F1A004] focus:border-[#F1A004] focus:outline-none">
                                    <option selected>Pilih Status</option>
                                    <option value="1">Tersedia</option>
                                    <option value="0">Tidak Tersedia</option>
                                </select>
                            </div>
                        </div>

                        <!-- Jumlah Stok -->
                        <div>
                            <label for="jumlah_stok"
                                class="block mb-2 text-sm font-semibold text-[#F1A004] dark:text-white">Jumlah
                                Stok</label>
                            <input type="number" name="jumlah_stok" id="jumlah_stok" placeholder="Jumlah Stok"
                                class="w-full p-3 text-sm rounded-xl border border-[#F1A004]/40 bg-white text-gray-900
                                       placeholder-gray-400 focus:ring-2 focus:ring-[#F1A004] focus:border-[#F1A004]
                                       dark:bg-white/20 dark:text-white dark:placeholder-gray-300 dark:border-white/30 
                                       focus:outline-none transition-all duration-300"
                                required>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi"
                                class="block mb-2 text-sm font-semibold text-[#F1A004] dark:text-white">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" rows="5" placeholder="Tuliskan deskripsi barang"
                                class="w-full p-3 text-sm rounded-xl border border-[#F1A004]/40 bg-white text-gray-900
                                       placeholder-gray-400 focus:ring-2 focus:ring-[#F1A004] focus:border-[#F1A004]
                                       dark:bg-white/20 dark:text-white dark:placeholder-gray-300 dark:border-white/30 
                                       focus:outline-none transition-all duration-300"></textarea>
                        </div>

                        <!-- Kondisi Awal -->
                        <div>
                            <label for="kondisi_awal"
                                class="block mb-2 text-sm font-semibold text-[#F1A004] dark:text-white">Kondisi Awal
                                (Foto)</label>
                            <input type="file" name="kondisi_awal" id="kondisi_awal"
                                class="block w-full text-sm border border-[#F1A004]/40 rounded-xl cursor-pointer 
                                       bg-white text-gray-900 dark:bg-white/20 dark:text-white focus:ring-2 
                                       focus:ring-[#F1A004] focus:border-[#F1A004] focus:outline-none transition-all duration-300">
                        </div>

                        <!-- Tombol -->
                        <div class="text-center pt-4">
                            <button type="submit"
                                class="relative inline-flex items-center px-8 py-3 text-sm font-semibold text-white rounded-xl
                                       bg-gradient-to-r from-[#F1A004] to-[#facc15] shadow-[0_4px_15px_rgba(241,160,4,0.6)]
                                       hover:from-[#e39b00] hover:to-[#d4a500] hover:shadow-[0_8px_25px_rgba(204,134,0,0.8)]
                                       active:scale-95 active:shadow-inner overflow-hidden group transition-all duration-500">
                                <span
                                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent 
                                           opacity-0 group-hover:opacity-100 translate-x-[-100%] group-hover:translate-x-[100%] 
                                           transition-all duration-700 ease-in-out"></span>
                                ✨ Tambah Barang
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
</x-app-layout>
