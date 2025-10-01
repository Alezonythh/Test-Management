<x-app-layout>
    <div x-data="{ open: JSON.parse(localStorage.getItem('sidebarOpen') || 'true'), loading: true }" x-init="window.addEventListener('sidebar-toggled', () => { open = JSON.parse(localStorage.getItem('sidebarOpen')) });
    setTimeout(() => loading = false, 1500);" :class="open ? 'ml-64' : 'ml-16'"
        class="transition-all duration-300 relative">

        <!-- Loading Overlay -->
        <div x-show="loading" x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-700" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-white dark:bg-gray-900">

            <!-- Spinner -->
            <div
                class="w-16 h-16 border-4 border-t-indigo-500 border-r-transparent border-b-indigo-500 border-l-transparent rounded-full animate-spin mb-4">
            </div>

            <!-- Loading Text -->
            <p class="text-gray-700 dark:text-gray-300 text-lg font-semibold animate-pulse">
                Memuat Konfirmasi Permintaan...
            </p>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                Mohon tunggu sebentar, semua data sedang dipersiapkan.
            </p>
        </div>
        <div class="container mx-auto p-6 lg:pl-64">
            <div class="p-6" x-show="!loading" x-transition.opacity>
                <h1 class="text-3xl font-bold text-gray-200 mb-6">Permintaan Peminjaman</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($requests as $request)
                        <div
                            class="max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $request->book->judul_buku }}
                            </h5>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                <span class="font-semibold">Nama Anggota:</span> {{ $request->user->name }}
                            </p>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                <span class="font-semibold">Tanggal Pinjam:</span> {{ $request->tanggal_pinjam }}
                            </p>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                <span class="font-semibold">Tanggal Kembali:</span> {{ $request->tanggal_kembali }}
                            </p>
                            <div class="flex justify-between mt-4">
                                <form action="{{ route('admin.approveRequest', $request->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600">
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('admin.rejectRequest', $request->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
</x-app-layout>
