<x-app-layout>
<section class="bg-white dark:bg-gray-900">
  <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
      <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Edit Buku</h2>
      <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
              <div class="sm:col-span-2">
                  <label for="judul_buku" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul buku</label>
                  <input type="text" name="judul_buku" id="judul_buku" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $book->judul_buku }}" required>
              </div>
              
              <div class="sm:col-span-1">
                  <label for="kategori" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                  <select id="kategori" name="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                      <option value="Fiksi" {{ $book->kategori == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                      <option value="Non-Fiksi" {{ $book->kategori == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                      <option value="Sains" {{ $book->kategori == 'Sains' ? 'selected' : '' }}>Sains</option>
                      <option value="Teknologi" {{ $book->kategori == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                  </select>
              </div>
              <div class="sm:col-span-1">
                  <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                  <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                      <option value="1" {{ $book->status ? 'selected' : '' }}>Tersedia</option>
                      <option value="0" {{ !$book->status ? 'selected' : '' }}>Tidak Tersedia</option>
                  </select>
              </div>
              <div class="sm:col-span-2">
                  <label for="jumlah_stok" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Stok</label>
                  <input type="number" name="jumlah_stok" id="jumlah_stok" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $book->jumlah_stok }}" required>
              </div> 
              <div class="sm:col-span-2">
                  <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                  <textarea id="deskripsi" name="deskripsi" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">{{ $book->deskripsi }}</textarea>
              </div>
              <div class="sm:col-span-2">
                  <label for="kondisi_awal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kondisi Awal (Foto)</label>
                  <input type="file" name="kondisi_awal" id="kondisi_awal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
              </div>
          </div>
          <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
              Update Buku
          </button>
      </form>
  </div>
</section>
</x-app-layout>
