<x-app-layout>
    <div x-data="{ open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true') }" x-init="window.addEventListener('sidebar-toggled', () => {
        open = JSON.parse(localStorage.getItem('sidebarOpen'));
    });" :class="open ? 'ml-64' : 'ml-16'"
        class="transition-all duration-300 relative">
        <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
            <div class="mx-auto max-w-screen-md px-4 lg:px-0">
                <div
                    class="relative bg-gradient-to-br from-[#2C3262]/95 to-[#434A8B]/95 
                        backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden text-white p-6">

                    <!-- Header -->
                    <div class="flex items-center justify-between border-b border-white/20 pb-3 mb-4">
                        <h2 class="text-lg font-extrabold tracking-wide">✏️ Edit Anggota</h2>
                        <a href="{{ route('users.index') }}"
                            class="text-[#F1A004] bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-[#F1A004] dark:hover:text-white">
                            ✖
                        </a>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4 text-sm">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block mb-1 text-xs font-medium">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}"
                                class="w-full p-2 rounded-lg bg-white/20 border border-white/30 text-white 
                                   placeholder-gray-200 focus:ring-2 focus:ring-indigo-300 focus:outline-none"
                                placeholder="Nama Lengkap" required>
                        </div>

                        <div>
                            <label for="email" class="block mb-1 text-xs font-medium">Email</label>
                            <input type="email" name="email" id="email" value="{{ $user->email }}"
                                class="w-full p-2 rounded-lg bg-white/20 border border-white/30 text-white 
                                   placeholder-gray-200 focus:ring-2 focus:ring-indigo-300 focus:outline-none"
                                placeholder="Masukkan Email" required>
                        </div>

                        <div>
                            <label for="password" class="block mb-1 text-xs font-medium">Password</label>
                            <input type="password" name="password" id="password"
                                class="w-full p-2 rounded-lg bg-white/20 border border-white/30 text-white 
                                   placeholder-gray-200 focus:ring-2 focus:ring-indigo-300 focus:outline-none"
                                placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit"
                            class="relative w-full px-3 py-2 rounded-lg font-bold text-white text-sm 
                               bg-gradient-to-r from-[#2C3262] via-[#434A8B] to-[#2C3262] 
                               shadow-lg overflow-hidden hover:scale-[1.02] transition-all duration-500">
                            <span class="relative z-10">💾 Simpan Perubahan</span>
                            <span
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent 
                                     -translate-x-full animate-[shine_2s_infinite]"></span>
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
