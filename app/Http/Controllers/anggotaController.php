<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\PinjamBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\BorrowedBooksExport;
use Maatwebsite\Excel\Facades\Excel;
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
        // Ambil semua request pending milik user lalu kelompokkan
        $all = PinjamBuku::where('user_id', auth()->id())
            ->where('status', 'menunggu konfirmasi')
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->get();

        // Kelompokkan berdasarkan kombinasi item yang sama
        $grouped = $all->groupBy(function ($item) {
            return implode('|', [
                $item->book_id,
                $item->tanggal_pinjam,
                $item->tanggal_kembali,
                $item->status,
            ]);
        })->map(function ($group) {
            // Ambil satu contoh data untuk ditampilkan dan tambahkan jumlahnya
            $first = $group->first();
            $first->setAttribute('group_count', $group->count());
            return $first;
        })->values();

        // Manual pagination untuk hasil yang sudah digroup
        $perPage = 6;
        $page = request()->get('page', 1);
        $items = $grouped->slice(($page - 1) * $perPage, $perPage);

        $requests = new LengthAwarePaginator(
            $items,
            $grouped->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

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
                ->with('book')
                ->get()
                ->groupBy(function($item) {
                    return $item->user_id ?? 'guest_'.$item->nama_peminjam;
                });

// Ambil "user identifier" unik
$userIdsOrGuests = $allRequests->keys();

// Pagination
$perPage = 5;
$page = request()->get('page', 1);
$items = $userIdsOrGuests->slice(($page - 1) * $perPage, $perPage);

$paginatedUsers = new LengthAwarePaginator(
    $items,
    $userIdsOrGuests->count(),
    $perPage,
    $page,
    ['path' => request()->url(), 'query' => request()->query()]
);

return view('admin.confirm_requests', [
    'requestsGrouped' => $allRequests,
    'paginatedUsers' => $paginatedUsers,
]);
}


public function approveAllGuestRequests($guestSlug)
{
    $guestName = str_replace('-', ' ', $guestSlug);

    $requests = PinjamBuku::whereNull('user_id')
        ->where('nama_peminjam', $guestName)
        ->where('status', 'menunggu konfirmasi')
        ->with('book')
        ->get();

    DB::transaction(function () use ($requests) {
        foreach ($requests as $peminjaman) {
            $book = $peminjaman->book;
            if (!$book || $book->jumlah_stok < 1) continue;

            // Ubah status peminjaman
            $peminjaman->update(['status' => 'dipinjam']);

            // Kurangi stok 1 per peminjaman
            $book->decrement('jumlah_stok', 1);
        }
    });

    return back()->with('success', 'Semua permintaan guest berhasil disetujui.');
}



public function rejectAllGuestRequestsByName($guestSlug)
{
    $guestName = str_replace('-', ' ', $guestSlug);

    $requests = PinjamBuku::whereNull('user_id')
        ->where('nama_peminjam', $guestName)
        ->where('status', 'menunggu konfirmasi')
        ->get();

    foreach ($requests as $peminjaman) {
        $peminjaman->delete(); // hapus langsung tanpa menambah stok
    }

    return back()->with('success', 'Semua permintaan guest berhasil ditolak.');
}






public function borrowedBooksAdmin(Request $request, $status = null)
{
    $status = $status ?: $request->input('status', 'dipinjam');

    // Ambil semua dulu
    $all = PinjamBuku::with('book')
        ->when($status === 'overdue', function ($query) {
            return $query->where('tanggal_kembali', '<', Carbon::now())
                         ->where('status', 'dipinjam');
        }, function ($query) use ($status) {
            return $query->where('status', '=', $status);
        })
        ->orderBy('tanggal_pinjam', 'desc')
        ->get()
        ->groupBy('nama_peminjam')
        // Sort groups so the borrower with the most recent created record appears first
        ->sortByDesc(function ($items) {
            return $items->max('created_at');
        });

    // Manual pagination
    $page = request()->get('page', 1);
    $perPage = 5;
    $paginated = new LengthAwarePaginator(
        $all->slice(($page - 1) * $perPage, $perPage, true),
        $all->count(),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    return view('admin.borrowed_books', [
        'borrowedBooks' => $paginated,
        'status' => $status
    ]);
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

    // Bulk return multiple items of the same book for a borrower
    public function bulkReturn(Request $request)
    {
        $validated = $request->validate([
            'nama_peminjam' => 'required|string',
            'book_id' => 'required|exists:books,id',
        ]);

        $nama = $validated['nama_peminjam'];
        $bookId = (int) $validated['book_id'];
        DB::transaction(function () use ($nama, $bookId) {
            $book = Book::lockForUpdate()->findOrFail($bookId);

            // Ambil semua record yang statusnya masih dipinjam untuk peminjam dan buku ini
            $records = PinjamBuku::where('nama_peminjam', $nama)
                ->where('book_id', $bookId)
                ->where('status', 'dipinjam')
                ->orderBy('tanggal_pinjam', 'asc')
                ->get();

            if ($records->count() < 1) {
                throw new \Exception('Tidak ada item yang sedang dipinjam untuk dikembalikan.');
            }

            foreach ($records as $r) {
                $r->update(['status' => 'dikembalikan']);
            }

            // Tambah stok sesuai jumlah yang dikembalikan
            $book->increment('jumlah_stok', $records->count());
            if ($book->jumlah_stok > 0) {
                $book->status = true;
                $book->save();
            }
        });

        return back()->with('success', 'Pengembalian massal berhasil diproses.');
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
    ->join('books', 'pinjam_bukus.book_id', '=', 'books.id')
    ->select(
        'pinjam_bukus.nama_peminjam as peminjam',
        DB::raw('COUNT(pinjam_bukus.id) as total_pinjam'),
        DB::raw('MIN(books.kondisi_awal) as kondisi_awal') 
    )
    ->where('pinjam_bukus.status', 'dipinjam')
    ->when($search, function ($query, $search) {
        return $query->where('pinjam_bukus.nama_peminjam', 'like', "%{$search}%");
    })
    ->groupBy('pinjam_bukus.nama_peminjam')
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

    if(isset($cart[$id])){
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
    return back()->with('success', 'Barang ditambahkan ke keranjang!');
}


// Hapus item dari keranjang
public function removeFromCart($id)
{
    $cart = session()->get('cart', []);
    if(isset($cart[$id])){
        unset($cart[$id]);
        session()->put('cart', $cart);
    }
    return response()->json(['success' => true]);
}


// Checkout (Pinjam Semua)
public function checkoutCart(Request $request)
{
    $sessionCart = session()->get('cart', []); // ambil data dari session
    $inputCart = $request->cart; // ambil data dari form

    if (!$inputCart || count($inputCart) == 0) {
        return back()->with('error', 'Keranjang masih kosong.');
    }
    $isAdmin = auth()->check() && in_array(auth()->user()->role, ['admin','supervisor']);

    foreach ($inputCart as $book_id => $item) {
        if (!isset($sessionCart[$book_id])) continue;

        $quantity = (int) $item['quantity'];
        $book = Book::find($book_id);

        // Validasi stok
        if ($book && $book->jumlah_stok < $quantity) {
            return back()->with('error', "Stok buku '{$book->judul_buku}' tidak mencukupi.");
        }

        // 🔥 Buat beberapa record tergantung quantity
        for ($i = 0; $i < $quantity; $i++) {
            PinjamBuku::create([
                'user_id' => auth()->check() ? auth()->id() : null,
                'nama_peminjam' => $item['nama_peminjam'] ?? (auth()->check() ? (auth()->user()->name ?? 'User') : 'Guest'),
                'book_id' => $book_id,
                'tanggal_pinjam' => $item['tanggal_pinjam'],
                'tanggal_kembali' => $item['tanggal_kembali'],
                'status' => 'dipinjam',
                'kondisi_awal' => 'Bagus',
                'kondisi_akhir' => null,
                'quantity' => 1,
            ]);
        }
        $book->decrement('jumlah_stok', $quantity);
        if ($book->jumlah_stok <= 0) { $book->status = false; $book->save(); }
    }

    session()->forget('cart');
    if ($isAdmin) {
        return redirect()->route('admin.borrowedBooks', ['status' => 'dipinjam'])
            ->with('success', 'Peminjaman berhasil dan langsung dikonfirmasi.');
    }
    return redirect()->route('anggota.borrowedBooks', ['status' => 'dipinjam'])
        ->with('success', 'Peminjaman berhasil dan langsung diproses.');
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
