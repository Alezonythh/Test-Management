<x-app-layout>
    @section('content')
        <div class="container">
            <h1>Pinjam Buku</h1>
            <form action="{{ route('books.pinjam') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_peminjam">Nama Peminjam</label>
                    <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" required>
                </div>
                <div class="form-group">
                    <label for="book_id">Judul Buku</label>
                    <select class="form-control" id="book_id" name="book_id" required>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}">{{ $book->judul_buku }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Pinjam</button>
            </form>
        </div>
    @endsection
</x-app-layout>