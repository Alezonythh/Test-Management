<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $books = Book::query()
            ->when($search, function ($query, $search) {
                return $query->where('judul_buku', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            })
            ->get();

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'judul_buku' => 'required',
        'kategori' => 'required',
        'jumlah_stok' => 'required|integer',
        'status' => 'required|boolean',
        'deskripsi' => 'required',
        'kondisi_awal' => 'nullable|image|max:2048', // optional, max 2MB
    ]);

    // Upload image ke storage/app/public/post-images
    if ($request->hasFile('kondisi_awal')) {
        $validated['kondisi_awal'] = $request->file('kondisi_awal')->store('post-images', 'public');
    }

    Book::create($validated);

    return redirect()->route('books.index')->with('created', 'Barang berhasil dibuat.');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::findOrFail($id);
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul_buku' => 'required',
            'kategori' => 'required',
            'jumlah_stok' => 'required|integer',
            'status' => 'required|boolean',
            'deskripsi' => 'required',
            'kondisi_awal' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $book = Book::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('kondisi_awal')) {
            $image = $request->file('kondisi_awal');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imagePath = $imageName;
        $book->kondisi_awal = $imagePath;
        }

        $book->update($request->except('kondisi_awal'));

        return redirect()->route('books.index')->with('updated', 'Barang Berhasil Diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('books.index')->with('deleted', 'Barang Berhasil Dihapus.');
    }

    public function pinjam(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required',
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
            
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
        ]);

        $bookId = $request->input('book_id');
        $book = Book::findOrFail($bookId);

        // Create a new PinjamBuku record
        $pinjamBuku = new \App\Models\PinjamBuku();
        $pinjamBuku->nama_peminjam = $request->input('nama_peminjam');
        $pinjamBuku->book_id = $bookId;
        $pinjamBuku->tanggal_pinjam = $request->input('tanggal_pinjam');
        $pinjamBuku->tanggal_kembali = $request->input('tanggal_kembali');
        // Set the initial status
        $pinjamBuku->status = auth()->user()->role === 'admin' ? 'dipinjam' : 'menunggu konfirmasi';
        $pinjamBuku->user_id = $request->input('user_id') ?: null;

        
        $pinjamBuku->save();
        \Log::info('PinjamBuku record saved:', $pinjamBuku->toArray());

        $book->decrement('jumlah_stok');

        if ($book->jumlah_stok <= 0) {
            $book->update(['status' => false]);
        }

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.borrowedBooks', ['status' => 'dipinjam'])->with('success', 'Peminjaman Berhasil.');
        } else {
            return redirect()->route('anggota.pending_requests')->with('success', 'Peminjaman Berhasil Diajukan.');
        }
    }

    public function showBorrowForm()
    {
        $books = Book::all();
        return view('admin.borrow_book', compact('books'));
    }

    public function showAdminBorrowForm(string $book_id)
    {
        $book = Book::findOrFail($book_id);
        return view('admin.borrow_form', compact('book'));
    }

    public function showReturnForm(string $id)
    {
        $pinjamBuku = \App\Models\PinjamBuku::findOrFail($id);
        $book = Book::findOrFail($pinjamBuku->book_id);
        return view('admin.return_form', compact('pinjamBuku', 'book'));
    }

    public function submitReturnForm(Request $request, string $id)
    {
        $request->validate([
            'kondisi_akhir' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $pinjamBuku = \App\Models\PinjamBuku::findOrFail($id);

        // Handle image upload
        $image = $request->file('kondisi_akhir');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $imagePath = $imageName;

        $pinjamBuku->kondisi_akhir = $imagePath;
        $pinjamBuku->status = 'dikembalikan';
        $pinjamBuku->save();

        // Increase book stock
        $book = Book::findOrFail($pinjamBuku->book_id);
        $book->increment('jumlah_stok');

        return redirect()->route('admin.borrowedBooks', ['status' => 'dikembalikan'])->with('success', 'Buku Berhasil Dikembalikan.');
    }

    public function showReturnFormAnggota(string $id)
    {
        $pinjamBuku = \App\Models\PinjamBuku::findOrFail($id);
        $book = Book::findOrFail($pinjamBuku->book_id);
        return view('anggota.return_form', compact('pinjamBuku', 'book'));
    }

    public function submitReturnFormAnggota(Request $request, string $id)
    {
        $request->validate([
            'kondisi_akhir' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $pinjamBuku = \App\Models\PinjamBuku::findOrFail($id);

        // Handle image upload
        $image = $request->file('kondisi_akhir');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $imagePath = $imageName;

        $pinjamBuku->kondisi_akhir = $imagePath;
        $pinjamBuku->status = 'menunggu persetujuan';
        $pinjamBuku->save();

        // Increase book stock
        $book = Book::findOrFail($pinjamBuku->book_id);
        $book->increment('jumlah_stok');
        $book->status = true;
        $book->save();

        return redirect()->route('anggota.borrowed', ['status' => 'dipinjam'])->with('success', 'Buku Berhasil Dikembalikan. Menunggu Persetujuan Admin.');
    }
}
