<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\PinjamBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Exports\BorrowedBooksExport;
use Illuminate\Pagination\LengthAwarePaginator;

class anggotaController extends Controller
{
    /**
     * Menampilkan daftar buku.
     */
    public function index(Request $request)
    {
        $query = Book::query();

     // Search judul / penulis
    if ($request->has('search') && $request->search != '') {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('judul_buku', 'like', '%' . $search . '%')
              ->orWhere('kategori', 'like', '%' . $search . '%');
        });
    }

    // Filter kategori
    if ($request->has('kategori') && $request->kategori != '') {
        $query->where('kategori', $request->kategori);
    }

        $books = $query->orderBy('created_at', 'desc')->paginate(6);

        return view('anggota.index', compact('books'));
    }

    public function pendingRequests()
    {
        $requests = PinjamBuku::where('user_id', auth()->id())
            ->where('status', 'menunggu konfirmasi')
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('anggota.pending_requests', compact('requests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $book = Book::findOrFail($request->book_id);

        if (!$book->status || $book->jumlah_stok <= 0) {
            return back()->with('error', 'Buku tidak tersedia atau stok habis.');
        }

        $user_id = auth()->id();
        if (auth()->user()->role == 'admin' && $request->has('user_id') && $request->user_id != null) {
            $user_id = $request->user_id;
        }

        PinjamBuku::create([
            'user_id' => $user_id,
            'book_id' => $book->id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'menunggu konfirmasi',
            'kondisi_awal' => $request->kondisi_awal,
            'kondisi_akhir' => null,
        ]);

        \Log::info('New borrowing request created:', [
            'user_id' => $user_id,
            'book_id' => $book->id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'menunggu konfirmasi',
            'kondisi_awal' => $request->kondisi_awal,
            'kondisi_akhir' => null,
        ]);

        return redirect()->back()->with('success', 'Permintaan peminjaman berhasil diajukan. Tunggu konfirmasi dari admin.');
    }

public function borrowedBooks(Request $request)
{
    $status = $request->input('status', 'dipinjam');
    $judul = $request->input('judul_buku'); // ambil input search

    $query = PinjamBuku::where('user_id', auth()->id())
        ->where('status', $status)
        ->with('book')
        ->orderBy($status == 'dipinjam' ? 'tanggal_pinjam' : 'tanggal_kembali', 'desc');

    // Filter judul buku jika ada
    if ($judul) {
        $query->whereHas('book', function($q) use ($judul) {
            $q->where('judul_buku', 'like', '%' . $judul . '%');
        });
    }

    $borrowedBooks = $query->paginate(6);
    $borrowedBooks->appends(['status' => $status, 'judul_buku' => $judul]);

    return view('anggota.borrowed', compact('borrowedBooks', 'status'));
}


    public function loanRequests()
    {
        $requests = PinjamBuku::where('user_id', auth()->id())
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('anggota.loan_requests', compact('requests'));
    }


public function confirmRequests(Request $request)
{
    // Ambil semua request menunggu konfirmasi
    $allRequests = PinjamBuku::where('status', 'menunggu konfirmasi')
                    ->with('book', 'user')
                    ->get()
                    ->groupBy('user_id');

    // Ambil user_id unik
    $userIds = $allRequests->keys();

    $perPage = 5;
    $page = $request->get('page', 1);
    $items = $userIds->slice(($page - 1) * $perPage, $perPage);

    $paginatedUsers = new LengthAwarePaginator(
        $items,
        $userIds->count(),
        $perPage,
        $page,
        ['path' => $request->url(), 'query' => $request->query()]
    );

    return view('admin.confirm_requests', [
        'requestsGrouped' => $allRequests,
        'paginatedUsers' => $paginatedUsers,
    ]);
}



  public function approveAllRequestsByUser($userId)
{
    $requests = PinjamBuku::where('user_id', $userId)
                ->where('status', 'menunggu konfirmasi')
                ->with('book')
                ->get();

    DB::transaction(function () use ($requests) {
        foreach ($requests as $peminjaman) {
            $book = $peminjaman->book;
            if ($book->jumlah_stok <= 0) continue;

            $peminjaman->update(['status' => 'dipinjam']);
            $book->decrement('jumlah_stok');

            $book->update(['status' => $book->jumlah_stok > 0]);
        }
    });

    return back()->with('success', 'Semua permintaan user berhasil disetujui.');
}

    public function rejectRequest($id)
    {
        $peminjaman = PinjamBuku::findOrFail($id);

        if ($peminjaman->status !== 'menunggu konfirmasi') {
            return back()->with('error', 'Permintaan ini sudah diproses.');
        }

        $peminjaman->delete();

        return back()->with('success', 'Permintaan peminjaman ditolak.');
    }

    public function rejectAllRequestsByUser($userId)
{
    PinjamBuku::where('user_id', $userId)
        ->where('status', 'menunggu konfirmasi')
        ->delete();

    return back()->with('success', 'Semua permintaan user ditolak.');
}


    public function borrowedBooksAdmin(Request $request, $status = null)
    {
        $status = $status ?: $request->input('status', 'dipinjam');

        $borrowedBooks = PinjamBuku::with('book', 'user')
            ->when($status === 'overdue', function ($query) {
                return $query->where('tanggal_kembali', '<', Carbon::now())
                    ->where('status', 'dipinjam');
            }, function ($query) use ($status) {
                return $query->where('status', '=', $status);
            })
            ->orderBy('tanggal_pinjam', 'desc')
            ->paginate(6);

        $borrowedBooks->appends(['status' => $status]);

        return view('admin.borrowed_books', compact('borrowedBooks', 'status'));
    }

    public function getBorrowerName($borrow)
    {
        return $borrow->user->name ?? $borrow->nama_peminjam ?? '-';
    }

    public function returnBookForAdmin($id)
    {
        $peminjaman = PinjamBuku::findOrFail($id);

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Buku sudah dikembalikan.');
        }

        $peminjaman->update([
            'status' => 'dikembalikan',
            'kondisi_akhir' => request('kondisi_akhir') ?? $peminjaman->kondisi_akhir,
        ]);

        $book = $peminjaman->book;
        $book->increment('jumlah_stok');
        if ($book->jumlah_stok > 0) {
            $book->status = true;
            $book->save();
        }

        return redirect()->back()->with('success', 'Buku telah berhasil dikembalikan.');
    }

    public function completeLoan($id)
    {
        $peminjaman = PinjamBuku::findOrFail($id);

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Peminjaman sudah selesai.');
        }

        $peminjaman->update(['status' => 'dikembalikan']);

        return redirect()->back()->with('success', 'Peminjaman telah diselesaikan.');
    }

    public function extendLoan(Request $request, $id)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date|after_or_equal:today',
        ]);

        $peminjaman = PinjamBuku::findOrFail($id);

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Peminjaman sudah selesai.');
        }

        $peminjaman->update(['tanggal_kembali' => $request->tanggal_kembali]);

        return redirect()->back()->with('success', 'Masa peminjaman berhasil diperpanjang.');
    }

    public function dashboard()
    {
        //total buku
        $totalBuku = Book::count();
        $totalstat = Book::where('status', true)->count();
        $totalava = Book::where('status', false)->count();

        //total barang dipinjam
        $totalPinjam = PinjamBuku::where('status', 'dipinjam')->count();

        $search = request('search'); // ambil dari input search

        $dataPeminjam = DB::table('pinjam_bukus')
            ->join('users', 'pinjam_bukus.user_id', '=', 'users.id')
            ->join('books', 'pinjam_bukus.book_id', '=', 'books.id')
            ->select(
                'books.judul_buku as nama_barang',
                'books.kondisi_awal',
                'pinjam_bukus.id as pinjam_id',
                'users.name as peminjam'
            )
            ->where('pinjam_bukus.status', 'dipinjam')
            ->when($search, function ($query, $search) {
                return $query->where('books.judul_buku', 'like', "%{$search}%");
            })
            ->get();

        $dataKategori = DB::table('books')
            ->leftJoin('pinjam_bukus', function ($join) {
                $join->on('books.id', '=', 'pinjam_bukus.book_id')
                    ->where('pinjam_bukus.status', 'dipinjam');
            })
            ->select(
                'books.kategori',
                DB::raw('SUM(books.jumlah_stok) as jumlah_stok_total'),
                DB::raw('COUNT(pinjam_bukus.id) as dipinjam_total')
            )
            ->groupBy('books.kategori')
            ->get();

        //buku yg dikembalikan
        $dataBukuDikembalikan = DB::table('pinjam_bukus')
            ->where('status', 'dikembalikan')
            ->count();


            
        // Get count of overdue books
        $overdueBooksCount = PinjamBuku::where('tanggal_kembali', '<', Carbon::now())
            ->where('status', 'dipinjam')
            ->count();

        // Get count of pending loan requests
        $pendingRequestsCount = PinjamBuku::where('status', 'menunggu konfirmasi')
            ->count();

        // Get overdue books
        $overdueBooks = PinjamBuku::with('book', 'user')
            ->where('tanggal_kembali', '<', Carbon::now())
            ->where('status', 'dipinjam')
            ->get();
        // Get pending loan requests
        $pendingRequests = PinjamBuku::with('book', 'user')
            ->where('status', 'menunggu konfirmasi')
            ->get();

        return view('dashboard', compact('totalBuku', 'overdueBooksCount', 'pendingRequestsCount', 'overdueBooks', 'pendingRequests', 'dataBukuDikembalikan', 'totalstat', 'totalava', 'totalPinjam', 'dataPeminjam', 'dataKategori'));
    }

    public function exportBorrowedBooks(Request $request, $status = null)
    {
        $status = $status ?: $request->input('status', 'dikembalikan');
        $borrowedBooks = PinjamBuku::with('book', 'user')->where('status', $status)->get();

        $filename = 'borrowed_books_' . $status . '_' . date('YmdHis') . '.xlsx';
        return Excel::download(new BorrowedBooksExport($borrowedBooks), $filename);
    }


    // Tambah ke keranjang
public function addToCart($id)
{
    $book = Book::findOrFail($id);
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            'judul_buku' => $book->judul_buku,
            'kategori' => $book->kategori,
            'jumlah_stok' => $book->jumlah_stok,
            'status' => $book->status,
            'deskripsi' => $book->deskripsi,
            'quantity' => 1,
        ];
    }

    session()->put('cart', $cart);
    return back()->with('success', 'Buku ditambahkan ke keranjang!');
}

// Hapus item dari keranjang
public function removeFromCart($id)
{
    $cart = session()->get('cart', []);
    unset($cart[$id]);
    session()->put('cart', $cart);

    return back()->with('success', 'Item dihapus dari keranjang.');
}

// Checkout (Pinjam Semua)
public function checkoutCart()
{
    $cart = session('cart', []);

    foreach ($cart as $id => $item) {
        $jumlah = $item['quantity'] ?? 1;

        for ($i = 0; $i < $jumlah; $i++) {
            PinjamBuku::create([
                'user_id' => auth()->id(),
                'book_id' => $id,
                'tanggal_pinjam' => now(),
                'tanggal_kembali' => now()->addDays(7),
                'status' => 'menunggu konfirmasi',
                'kondisi_akhir' => null,
            ]);
        }
    }

    session()->forget('cart');
    return back()->with('success', 'Permintaan peminjaman dikirim ke admin!');
}

public function updateCart(Request $request, $id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $newQty = max(1, (int)$request->input('quantity'));
        $maxQty = $cart[$id]['jumlah_stok'];

        if ($newQty > $maxQty) {
            return back()->with('error', 'Jumlah melebihi stok!');
        }

        $cart[$id]['quantity'] = $newQty;
        session()->put('cart', $cart);
        return back()->with('success', 'Jumlah buku diperbarui!');
    }

    return back()->with('error', 'Buku tidak ditemukan di keranjang.');
}

    
}
