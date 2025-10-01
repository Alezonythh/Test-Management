<x-app-layout>
    <div x-data="{
        open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true'),
    }" x-init="window.addEventListener('sidebar-toggled', () => {
        open = JSON.parse(localStorage.getItem('sidebarOpen'));
    });" :class="open ? 'ml-64' : 'ml-16'"
        class="transition-all duration-300">
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5"> 
        <div class="mx-auto max-w-screen-xl px-4">
                            <!-- Flash Message -->
                            @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                
                 <!-- Form Pencarian -->
                 <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-6 border-b dark:border-gray-700">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Daftar Anggota</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data anggota dengan mudah.</p>
    </div>
    <div class="flex mt-4 sm:mt-0 gap-2">
        <form action="{{ route('users.index') }}" method="GET" class="flex">
            <input type="text" name="search" id="search"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-[#F1A004] focus:border-[#F1A004] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                placeholder="Cari nama/email..." value="{{ request('search') }}">
            <button type="submit"
                class="text-white bg-[#2C3262] hover:bg-[#1e244a] px-4 rounded-r-lg transition-all">
                Cari
            </button>
        </form>
        <button id="defaultModalButton" data-modal-target="defaultModal" data-modal-toggle="defaultModal"
    class="relative group block px-6 py-2.5 text-white font-semibold rounded-2xl
           bg-gradient-to-r from-[#F1A004] to-[#CC8600]
           shadow-[0_4px_15px_rgba(241,160,4,0.6)]
           transition-all duration-500 ease-in-out
           hover:scale-110 hover:shadow-[0_8px_25px_rgba(204,134,0,0.8)]
           active:scale-95 active:shadow-inner overflow-hidden">
    
    <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent 
                 opacity-0 group-hover:opacity-100 -translate-x-full group-hover:translate-x-full 
                 transition-all duration-700 ease-in-out"></span>
    
    Tambah Anggota
</button>
    </div>
</div>



                <!-- Tabel Daftar Pengguna -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">No</th>
                                <th scope="col" class="px-4 py-3">Nama Anggota</th>
                                <th scope="col" class="px-4 py-3">Email</th>
                                <th scope="col" class="px-4 py-3">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3">{{ $loop->iteration}}</td>
                                    <td class="px-4 py-3">{{ $user->name }}</td>
                                    <td class="px-4 py-3">{{ $user->email }}</td>
                                    <td class="px-4 py-3 flex text-right space-x-2 items-center">
                                        <a href="{{ route('users.edit', $user->id) }}" 
   class="relative group block px-6 py-2.5 text-white font-semibold rounded-2xl
          bg-gradient-to-r from-blue-600 to-indigo-600
          shadow-[0_4px_15px_rgba(37,99,235,0.6)]
          transition-all duration-500 ease-in-out
          hover:scale-110 hover:shadow-[0_8px_25px_rgba(37,99,235,0.8)]
          active:scale-95 active:shadow-inner overflow-hidden">
    
    <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent 
                 opacity-0 group-hover:opacity-100 -translate-x-full group-hover:translate-x-full 
                 transition-all duration-700 ease-in-out"></span>
    
    Edit
</a>

<!-- Button Delete -->
<button type="submit" 
        class="relative group block px-6 py-2.5 text-white font-semibold rounded-2xl
               bg-gradient-to-r from-red-600 to-red-800
               shadow-[0_4px_15px_rgba(220,38,38,0.6)]
               transition-all duration-500 ease-in-out
               hover:scale-110 hover:shadow-[0_8px_25px_rgba(220,38,38,0.8)]
               active:scale-95 active:shadow-inner overflow-hidden">
        
        <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent 
                     opacity-0 group-hover:opacity-100 -translate-x-full group-hover:translate-x-full 
                     transition-all duration-700 ease-in-out"></span>
        
        Delete
    </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <div class="p-4">
                        {{ $users->links() }}
                    </div>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="defaultModal" tabindex="-1" aria-hidden="true"
    class="fixed inset-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto bg-black/60 backdrop-blur-sm">
    <div class="relative w-full max-w-lg mx-auto animate-[fadeInScale_0.4s_ease-out]">
        <div
            class="relative bg-gradient-to-br from-[#2C3262]/95 to-[#434A8B]/95 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden text-white">

            <!-- Modal Header -->
            <div class="flex items-start justify-between p-4 border-b border-white/20">
                <h3 class="text-lg font-extrabold tracking-wide">👤 Tambah Anggota</h3>
                <button type="button"
                    class="text-white/70 hover:text-white hover:bg-white/20 rounded-lg text-xs p-2 transition"
                    data-modal-toggle="defaultModal">
                    ✖
                </button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('users.store') }}" method="POST" class="p-4 space-y-3 text-sm">
                @csrf

                <div>
                    <label for="name" class="block mb-1 text-xs font-medium">Nama Lengkap</label>
                    <input type="text" name="name" id="name"
                        class="w-full p-2 rounded-lg bg-white/20 border border-white/30 text-white placeholder-gray-200 focus:ring-2 focus:ring-indigo-300 focus:outline-none"
                        placeholder="Nama Lengkap" required>
                </div>

                <div>
                    <label for="email" class="block mb-1 text-xs font-medium">Email</label>
                    <input type="email" name="email" id="email"
                        class="w-full p-2 rounded-lg bg-white/20 border border-white/30 text-white placeholder-gray-200 focus:ring-2 focus:ring-indigo-300 focus:outline-none"
                        placeholder="Masukan email siswa" required>
                </div>

                <div>
                    <label for="password" class="block mb-1 text-xs font-medium">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full p-2 rounded-lg bg-white/20 border border-white/30 text-white placeholder-gray-200 focus:ring-2 focus:ring-indigo-300 focus:outline-none"
                        placeholder="Masukan Password" required>
                </div>

                <!-- Tombol Submit -->
                <button type="submit"
                    class="relative w-full px-3 py-2 rounded-lg font-bold text-white text-sm bg-gradient-to-r from-[#2C3262] via-[#434A8B] to-[#2C3262] shadow-lg overflow-hidden hover:scale-[1.02] transition-all duration-500">
                    <span class="relative z-10">✨ Tambah Anggota</span>
                    <span
                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full animate-[shine_2s_infinite]"></span>
                </button>
            </form>
        </div>
    </div>
</div>

    </section></div>
</x-app-layout>
