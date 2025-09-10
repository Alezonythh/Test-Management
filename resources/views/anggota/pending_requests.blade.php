<x-app-layout>
    <div class="container mx-auto p-6 lg:pl-64">
        <h1 class="text-3xl font-bold text-gray-200 mb-6">Status Pengajuan Peminjaman</h1>

        @if($requests->isEmpty())
            <div class="text-center text-gray-200">
                <p>Tidak ada pengajuan peminjaman.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($requests as $request)
                    <div class="max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $request->book->judul_buku }}
                        </h5>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                            <span class="font-semibold">Tanggal Pinjam:</span> {{ $request->tanggal_pinjam }}
                        </p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                            <span class="font-semibold">Tanggal Kembali:</span> {{ $request->tanggal_kembali }}
                        </p>
                        <p class="mb-3 font-normal">
                            @if ($request->status === 'menunggu konfirmasi')
                                <span class="px-2 py-1 text-sm font-medium bg-yellow-100 text-yellow-600 rounded-lg">
                                    Menunggu Konfirmasi
                                </span>
                            @elseif ($request->status === 'disetujui')
                                <span class="px-2 py-1 text-sm font-medium bg-green-100 text-green-600 rounded-lg">
                                    Disetujui
                                </span>
                            @elseif ($request->status === 'ditolak')
                                <span class="px-2 py-1 text-sm font-medium bg-red-100 text-red-600 rounded-lg">
                                    Ditolak
                                </span>
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
