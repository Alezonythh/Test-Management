<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\pinjamBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class anggotaController extends Controller
{
    /**
     * Menampilkan daftar buku.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        // Tambahkan pencarian jika ada parameter 'search'
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('judul_buku', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%')
                  ->orWhere('kategori','like', '%' . $search . '%');
        }

        // Ambil data dengan pagination
        $books = $query->orderBy('created_at', 'desc')->paginate(6);

        return view('anggota.index', compact('books'));
    }

    public function pendingRequests()
    {
        // Ambil semua permintaan peminjaman dengan status 'menunggu konfirmasi'
        $requests = pinjamBuku::where('user_id', auth()->id())
            ->where('status', 'menunggu konfirmasi')
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->paginate(6);
    
        // Kirim data permintaan ke tampilan
        return view('anggota.pending_requests', compact('requests'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $book = Book::findOrFail($request->book_id);

        if (!$book->status || $book->jumlah_stok <= 0) {
            return back()->with('error', 'Buku tidak tersedia atau stok habis.');
        }
        $user_id = auth()->id();

        if(auth()->user()->role == 'admin' && $request->has('user_id')) {
            $user_id = $request->user_id;
        }

        pinjamBuku::create([
            'user_id' => $user_id,
            'book_id' => $book->id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'menunggu konfirmasi',
        ]);
        return redirect()->back()->with('success', 'Permintaan peminjaman berhasil diajukan. Tunggu konfirmasi dari admin.');
    }


    /**
     * Menampilkan daftar buku yang dipinjam oleh anggota.
     */
    public function borrowedBooks(Request $request)
    {
        $status = $request->input('status', 'dipinjam');

        $borrowedBooks = pinjamBuku::where('user_id', auth()->id())
            ->where('status', $status)
            ->with('book')
            ->orderBy($status == 'dipinjam' ? 'tanggal_pinjam' : 'tanggal_kembali', 'desc')
            ->paginate(6);

        $borrowedBooks->appends(['status' => $status]);

        return view('anggota.borrowed', compact('borrowedBooks', 'status'));
    }

    /**
     * Mengembalikan buku yang sedang dipinjam.
     */
    /*
    public function returnBook($id)
    {
        $peminjaman = pinjamBuku::findOrFail($id);

        // Pastikan buku hanya bisa dikembalikan oleh peminjam yang sama
        if ($peminjaman->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengembalikan buku ini.');
        }

        // Pastikan buku masih berstatus dipinjam
        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Buku sudah dikembalikan.');
        }

        // Update status peminjaman dan stok buku
        $peminjaman->update(['status' => 'dikembalikan']);
        $peminjaman->book->update(['jumlah_stok' => $peminjaman->book->jumlah_stok + 1, 'status' => true]);

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan.');
    }
    */

    /**
     * Menampilkan daftar permintaan peminjaman oleh anggota.
     */
    public function loanRequests()
    {
        $requests = pinjamBuku::where('user_id', auth()->id())
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('anggota.loan_requests', compact('requests'));
    }

    /**
     * Menampilkan permintaan peminjaman yang menunggu konfirmasi oleh admin.
     */
    public function confirmRequests()
    {
        $requests = pinjamBuku::where('status', 'menunggu konfirmasi')
            ->with('book', 'user')
            ->paginate(10);

        return view('admin.confirm_requests', compact('requests'));
    }

    /**
     * Menyetujui permintaan peminjaman buku.
     */
    public function approveRequest($id)
    {
        $peminjaman = pinjamBuku::findOrFail($id);

        if ($peminjaman->status !== 'menunggu konfirmasi') {
            return back()->with('error', 'Permintaan ini sudah diproses.');
        }

        $book = $peminjaman->book;

        if ($book->jumlah_stok <= 0) {
            return back()->with('error', 'Stok buku habis.');
        }

        $peminjaman->update(['status' => 'dipinjam']);
        $book->decrement('jumlah_stok');

        if ($book->jumlah_stok <= 0) {
            $book->update(['status' => false]);
        }

        return back()->with('success', 'Permintaan peminjaman disetujui.');
    }

    /**
     * Menolak permintaan peminjaman buku.
     */
    public function rejectRequest($id)
    {
        $peminjaman = pinjamBuku::findOrFail($id);

        if ($peminjaman->status !== 'menunggu konfirmasi') {
            return back()->with('error', 'Permintaan ini sudah diproses.');
        }

        $peminjaman->delete();

        return back()->with('success', 'Permintaan peminjaman ditolak.');
    }

    /**
     * Menampilkan daftar buku yang dipinjam oleh admin.
     */
    public function borrowedBooksAdmin(Request $request, $status = null)
    {
        $status = $status ?: $request->input('status', 'dipinjam');

        $borrowedBooks = PinjamBuku::with('book','user')
        ->where('status', '=', $status)
        ->orderBy('tanggal_pinjam', 'desc')
        ->paginate(6);

        $borrowedBooks->appends(['status' => $status]);

        return view('admin.borrowed_books', compact('borrowedBooks', 'status'));
    }

    public function getBorrowerName($borrow)
    {
        if ($borrow->user && $borrow->user->name) {
            return $borrow->user->name;
        } 
        return $borrow->nama_peminjam;
    }

    /**
     * Mengembalikan buku oleh admin.
     */
    public function returnBookForAdmin($id) {
        $peminjaman = pinjamBuku::findOrFail($id);
    
        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Buku sudah dikembalikan.');
        }
    
        // Update status peminjaman menjadi 'dikembalikan'
        $peminjaman->update(['status' => 'dikembalikan']);
        
        // Menambahkan stok buku dan mengubah status menjadi tersedia (true)
        $book = $peminjaman->book;
        $book->increment('jumlah_stok');
        
        // Periksa apakah stok buku lebih dari 0, jika iya, ubah status buku menjadi tersedia
        if ($book->jumlah_stok > 0) {
            $book->status = true;
            $book->save();
        }
    
        return redirect()->back()->with('success', 'Buku telah berhasil dikembalikan.');
    }
    /**
     * Menyelesaikan peminjaman buku oleh admin.
     */
    public function completeLoan($id)
    {
        $peminjaman = pinjamBuku::findOrFail($id);

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Peminjaman sudah selesai.');
        }

        $peminjaman->update(['status' => 'dikembalikan']);
        $peminjaman->book->update(['jumlah_stok' => $peminjaman->book->jumlah_stok, 'status' => true]);

        return redirect()->back()->with('success', 'Peminjaman telah diselesaikan.');
    }

    /**
     * Memperpanjang masa peminjaman buku.
     */
    public function extendLoan(Request $request, $id)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date|after_or_equal:today',
        ]);

        $peminjaman = pinjamBuku::findOrFail($id);

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Peminjaman sudah selesai.');
        }

        $peminjaman->update(['tanggal_kembali' => $request->tanggal_kembali]);

        return redirect()->back()->with('success', 'Masa peminjaman berhasil diperpanjang.');
    }

    /**
     * Menampilkan dashboard admin.
     */
    public function dashboard()
    {
        // Jumlah total buku di lemari
        $totalBuku = Book::count();

        // Jumlah buku yang tersedia
        $totalstat = book::where('status', true)->count();

        // Buku yang sudah dikembalikan
        $totalava = book::where('status', false)->count();

        // Mengirimkan data ke view
        return view('dashboard', compact('totalBuku', 'totalstat', 'totalava'));
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
