<x-app-layout>
    <div x-data="{
        open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true'),
    }" x-init="window.addEventListener('sidebar-toggled', () => {
        open = JSON.parse(localStorage.getItem('sidebarOpen'));
    });" :class="open ? 'ml-64' : 'ml-16'"
        class="transition-all duration-300">

        <section class="bg-gray-50 dark:bg-gray-900 p-5 sm:p-7 sm:rounded-lg">
            <div class="mx-auto max-w-screen-xl px-4">

                <!-- Alert sukses -->
                @if (session('success'))
                    <div
                        class="mb-5 rounded-xl border border-[#F1A004]/30 bg-[#FFF8E5] 
                                dark:bg-green-900/30 dark:border-green-500/30
                                text-[#5C4B00] dark:text-green-200 p-4 text-sm 
                                shadow-md flex items-center justify-between">
                        <span class="font-semibold">{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()"
                            class="text-[#F1A004] dark:text-green-300 hover:scale-110 transition">✕</button>
                    </div>
                @endif

                <!-- Kontainer utama -->
                <div class="relative overflow-hidden rounded-2xl shadow-2xl text-white sm:rounded-lg">
                    <!-- Background -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-[#fff8e1] via-[#fffef8] to-[#fff8e1]
               dark:from-[#2C3262] dark:via-[#434A8B] dark:to-[#2C3262]">
                    </div>

                    <!-- Efek glow lembut -->
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-[#F1A004]/20 via-white/10 to-transparent 
               dark:from-[#2C3262]/30 dark:via-[#434A8B]/30 dark:to-[#2C3262]/30 blur-xl animate-pulse">
                    </div>

                    <!-- Konten -->
                    <div class="relative z-10">

                        <!-- Header -->
                        <div
                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-6 border-b border-white/20 dark:border-white/20">
                            <div>
                                <h2 class="text-2xl font-extrabold text-[#F1A004] dark:text-white">👥 Daftar Anggota
                                </h2>
                                <p class="text-sm text-gray-700 dark:text-gray-300">Kelola data anggota dengan mudah.
                                </p>
                            </div>

                            <!-- Search & Button -->
                            <div class="flex mt-4 sm:mt-0 gap-2">
                                <form action="{{ route('users.index') }}" method="GET" class="flex">
                                    <input type="text" name="search" id="search"
                                        class="bg-white/90 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-[#F1A004] focus:border-[#F1A004] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="Cari nama/email..." value="{{ request('search') }}">
                                    <button type="submit"
                                        class="text-white bg-[#F1A004] hover:bg-[#d89403] px-4 rounded-r-lg transition-all">
                                        Cari
                                    </button>
                                </form>

                                <!-- Tombol Tambah Anggota -->
                                <button id="defaultModalButton" data-modal-target="defaultModal"
                                    data-modal-toggle="defaultModal"
                                    class="relative group block px-6 py-2.5 text-white font-semibold rounded-xl
                           bg-gradient-to-r from-[#F1A004] to-[#d89403]
                           shadow-[0_4px_15px_rgba(241,160,4,0.5)]
                           transition-all duration-500 ease-in-out
                           hover:scale-105 hover:shadow-[0_8px_25px_rgba(204,134,0,0.7)]
                           active:scale-95 overflow-hidden">
                                    <span
                                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent 
                               opacity-0 group-hover:opacity-100 -translate-x-full group-hover:translate-x-full 
                               transition-all duration-700 ease-in-out"></span>
                                    Tambah Anggota
                                </button>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-900 dark:text-gray-200">
                                <thead class="text-xs uppercase bg-[#F1A004]/10 dark:bg-white/10">
                                    <tr>
                                        <th class="px-4 py-3">No</th>
                                        <th class="px-4 py-3">Nama Anggota</th>
                                        <th class="px-4 py-3">Email</th>
                                        <th class="px-4 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr
                                            class="border-b border-gray-200 dark:border-white/20 hover:bg-[#F1A004]/5 dark:hover:bg-white/10 transition">
                                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-3">{{ $user->name }}</td>
                                            <td class="px-4 py-3">{{ $user->email }}</td>
                                            <td class="px-4 py-3 flex space-x-2">
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="px-5 py-2 rounded-xl text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:scale-105 transition-all">
                                                    Edit
                                                </a>

                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    class="delete-form inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-5 py-2 rounded-xl text-white bg-gradient-to-r from-red-600 to-red-800 hover:scale-105 transition-all">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                class="px-4 py-3 text-center text-gray-600 dark:text-gray-300">
                                                Tidak ada anggota ditemukan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="p-4">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal Tambah Anggota -->
                <div id="defaultModal" tabindex="-1" aria-hidden="true"
                    class="fixed inset-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto bg-black/60 backdrop-blur-sm">
                    <div class="relative w-full max-w-lg mx-auto animate-[fadeInScale_0.4s_ease-out]">
                        <div
                            class="relative rounded-2xl shadow-2xl overflow-hidden 
                   bg-gradient-to-br from-white to-[#FFF8E1] dark:from-[#2C3262]/95 dark:to-[#434A8B]/95
                   border border-gray-200/40 dark:border-white/10 
                   backdrop-blur-md transition-all duration-500">

                            <!-- Header -->
                            <div
                                class="flex items-start justify-between p-4 
                       border-b border-gray-200/40 dark:border-white/10">
                                <h3
                                    class="text-lg font-extrabold tracking-wide 
                           text-gray-900 dark:text-white flex items-center gap-2">
                                    👤 Tambah Anggota
                                </h3>
                                <button type="button"
                                    class="text-gray-600 hover:text-gray-900 dark:text-white/70 dark:hover:text-white 
                           hover:bg-gray-200/40 dark:hover:bg-white/20 rounded-lg text-xs p-2 transition"
                                    data-modal-toggle="defaultModal">✖</button>
                            </div>

                            <!-- Body -->
                            <form action="{{ route('users.store') }}" method="POST" class="p-5 space-y-4 text-sm">
                                @csrf

                                <div>
                                    <label for="name"
                                        class="block mb-1 text-xs font-semibold text-gray-700 dark:text-gray-200">Nama
                                        Lengkap</label>
                                    <input type="text" name="name" id="name"
                                        class="w-full p-2.5 rounded-lg border text-gray-800 dark:text-white
                               placeholder-gray-400 dark:placeholder-gray-300
                               bg-white/80 dark:bg-white/10 border-gray-300 dark:border-white/20
                               focus:ring-2 focus:ring-[#F1A004] dark:focus:ring-indigo-400 focus:outline-none"
                                        placeholder="Nama Lengkap" required>
                                </div>

                                <div>
                                    <label for="email"
                                        class="block mb-1 text-xs font-semibold text-gray-700 dark:text-gray-200">Email</label>
                                    <input type="email" name="email" id="email"
                                        class="w-full p-2.5 rounded-lg border text-gray-800 dark:text-white
                               placeholder-gray-400 dark:placeholder-gray-300
                               bg-white/80 dark:bg-white/10 border-gray-300 dark:border-white/20
                               focus:ring-2 focus:ring-[#F1A004] dark:focus:ring-indigo-400 focus:outline-none"
                                        placeholder="Masukan email siswa" required>
                                </div>

                                <div>
                                    <label for="password"
                                        class="block mb-1 text-xs font-semibold text-gray-700 dark:text-gray-200">Password</label>
                                    <input type="password" name="password" id="password"
                                        class="w-full p-2.5 rounded-lg border text-gray-800 dark:text-white
                               placeholder-gray-400 dark:placeholder-gray-300
                               bg-white/80 dark:bg-white/10 border-gray-300 dark:border-white/20
                               focus:ring-2 focus:ring-[#F1A004] dark:focus:ring-indigo-400 focus:outline-none"
                                        placeholder="Masukan Password" required>
                                </div>

                                <!-- Tombol Submit -->
                                <button type="submit"
                                    class="relative w-full px-4 py-2.5 rounded-lg font-bold text-sm text-white 
                           bg-gradient-to-r from-[#F1A004] via-[#FFD54F] to-[#F1A004]
                           dark:from-[#2C3262] dark:via-[#434A8B] dark:to-[#2C3262]
                           shadow-lg hover:shadow-xl hover:scale-[1.02] 
                           transition-all duration-500 overflow-hidden group">
                                    <span class="relative z-10">✨ Tambah Anggota</span>
                                    <span
                                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent 
                               -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
</x-app-layout>

<!-- SWEETALERT2 SCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin?',
                    text: "User ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
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
    @if (session('created'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('created') }}",
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
</script>
