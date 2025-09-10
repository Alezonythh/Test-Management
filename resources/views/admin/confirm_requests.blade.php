<x-app-layout>
    <div class="container mx-auto p-6 lg:pl-64">
        <h1 class="text-3xl font-bold text-gray-200 mb-6">Permintaan Peminjaman</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($requests as $request)
                <div class="max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
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
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600">
                                Setujui
                            </button>
                        </form>
                        <form action="{{ route('admin.rejectRequest', $request->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600">
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
</x-app-layout>
