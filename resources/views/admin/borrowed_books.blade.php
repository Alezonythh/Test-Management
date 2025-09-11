<x-app-layout>
    <div class="container mx-auto pt-10 lg:pl-64">
        <h1 class="text-3xl font-bold text-white mb-6 text-center">Daftar Peminjaman Buku</h1>

        <!-- Form Filter Status -->
        <div class="mb-4">
            <form method="GET" action="{{ route('admin.borrowedBooks') }}">
                <div class="flex justify-center space-x-6">
                    <button type="submit" name="status" value="dipinjam" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 {{ $status == 'dipinjam' ? 'bg-blue-600' : '' }}">
                        Buku yang Dipinjam
                    </button>
                    <button type="submit" name="status" value="dikembalikan" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 {{ $status == 'dikembalikan' ? 'bg-blue-600' : '' }}">
                        Buku yang Dikembalikan
                    </button>
                    <button type="submit" name="status" value="overdue" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 {{ $status == 'overdue' ? 'bg-blue-600' : '' }}">
                        Buku yang Sudah Waktunya Dikembalikan
                    </button>
                </div>
            </form>
        </div>
        <div>
            <p class="text-gray-700">
                To export the data to Excel, please follow these steps:
                <ol>
                    <li>Select the entire table below.</li>
                    <li>Copy the selected content (Ctrl+C or Cmd+C).</li>
                    <li>Open Microsoft Excel or Google Sheets.</li>
                    <li>Paste the copied content into the spreadsheet (Ctrl+V or Cmd+V).</li>
                    <li>You may need to adjust the column widths to fit the data.</li>
                </ol>
            </p>
        </div>

        @if($borrowedBooks->isEmpty())
            <p class="text-gray-700 text-center">Tidak ada buku dengan status '{{ $status }}'.</p>
        @else
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Judul Buku</th>
                            <th scope="col" class="px-6 py-3">Peminjam</th>
                            <th scope="col" class="px-6 py-3">Tanggal Pinjam</th>
                            <th scope="col" class="px-6 py-3">Tanggal Kembali</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3 text-center">Kondisi Awal</th>
                            <th scope="col" class="px-6 py-3 text-center">Kondisi Akhir</th>
                            
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrowedBooks as $borrow)
                        @php
                            $returnDate = \Carbon\Carbon::parse($borrow->tanggal_kembali);
                            $now = \Carbon\Carbon::now();
                            $diff = $now->diffInDays($returnDate, false);

                            $rowClass = '';
                            if ($diff == 0 && $borrow->status == 'dipinjam') {
                                $rowClass = 'bg-yellow-100';
                            } elseif ($diff < 0 && $borrow->status == 'dipinjam') {
                                $rowClass = 'bg-red-100';
                            }
                        @endphp
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 {{ $rowClass }}">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $borrow->book->judul_buku }}
                                </td>
                                <td class="px-6 py-4">{{  app('App\Http\Controllers\anggotaController')->getBorrowerName($borrow) }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($borrow->tanggal_pinjam)->format('d-m-Y') }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($borrow->tanggal_kembali)->format('d-m-Y') }}
                                    @if ($diff == 0 && $borrow->status == 'dipinjam')
                                        <span class="text-yellow-500 ml-2">(Due Today)</span>
                                    @elseif ($diff < 0 && $borrow->status == 'dipinjam')
                                        <span class="text-red-500 ml-2">(Overdue)</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-medium rounded-lg {{ $borrow->status === 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($borrow->status) }}
                                    </span>
                                </td>
                                 <td class="px-6 py-4 text-center">
                                    @if($borrow->book->kondisi_awal)
                                        <img src="{{ asset('images/' . $borrow->book->kondisi_awal) }}" alt="Kondisi Awal" width="50">
                                    @else
                                        Tidak ada gambar
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($borrow->kondisi_akhir)
                                        <img src="{{ asset('images/' . $borrow->kondisi_akhir) }}" alt="Kondisi Akhir" width="50">
                                    @else
                                        Tidak ada gambar
                                    @endif
                                </td>
                                
                                
                                <td class="px-6 py-4 text-center">
                                    @if($borrow->status === 'dipinjam')
                                        <!-- Form Perpanjangan Peminjaman dan Pengembalian -->
                                        <div class="flex space-x-3 justify-center">
                                            <!-- Form Perpanjangan Peminjaman -->
                                            <form action="{{ route('admin.extendLoan', $borrow->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <div class="flex items-center space-x-2">
                                                    <input type="date" name="tanggal_kembali" required
                                                        class="block w-36 text-sm text-gray-900 border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                                                    <button type="submit" onclick="return confirm('Yakin Ingin Perpanjang?')"
                                                        class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                        Perpanjang
                                                    </button>
                                                </div>
                                            </form>
                                            <button data-modal-target="returnModal-{{ $borrow->id }}" data-modal-toggle="returnModal-{{ $borrow->id }}" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                                               Kembalikan
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-gray-500 italic">Buku Sudah Dikembalikan</span>
                                    @endif
                                </td>
                           </tr>
                       @endforeach
                   </tbody>
                </table>
                     <!-- Pagination -->
                     <div class="mt-4">
                        {{ $borrowedBooks->appends(['status' => $status])->links('pagination::tailwind') }}
                    </div>
            </div>
        @endif
    </div>

    @foreach($borrowedBooks as $borrow)
    <!-- Return Modal -->
    <div id="returnModal-{{ $borrow->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Kembalikan Buku
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="returnModal-{{ $borrow->id }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form action="{{ route('admin.submit_return_form', $borrow->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                            <div class="sm:col-span-2">
                                <label for="kondisi_awal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kondisi Awal</label>
                                @if($borrow->book->kondisi_awal)
                                    <img src="{{ asset('images/' . $borrow->book->kondisi_awal) }}" alt="Kondisi Awal" width="200">
                                @else
                                    <p>Tidak ada gambar</p>
                                @endif
                            </div>
                            <div class="sm:col-span-2">
                                <label for="kondisi_akhir" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kondisi Akhir (Foto)</label>
                                <input type="file" name="kondisi_akhir" id="kondisi_akhir" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                            </div>
                        </div>
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-blue-800">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</x-app-layout>
