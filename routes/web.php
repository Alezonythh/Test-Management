<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\userController;
use App\Http\Controllers\anggotaController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
route::group(['middleware' => ['auth', 'role:admin']], function(){
    Route::get('/anggota/loan-requests', [AnggotaController::class, 'loanRequests'])->name('anggota.loan_requests');
    Route::get('/admin/confirm-requests', [anggotaController::class, 'confirmRequests'])->name('admin.confirmRequests');
    Route::patch('/admin/approve-request/{id}', [anggotaController::class, 'approveRequest'])->name('admin.approveRequest');
    Route::delete('/admin/reject-request/{id}', [anggotaController::class, 'rejectRequest'])->name('admin.rejectRequest');
    Route::get('/admin/borrowed-books/{status?}', [anggotaController::class, 'borrowedBooksAdmin'])->name('admin.borrowedBooks');
    Route::patch('/admin/return-book/{id}', [anggotaController::class, 'returnBookForAdmin'])->name('admin.returnBookForAdmin');
    Route::patch('/admin/complete-loan/{id}', [anggotaController::class, 'completeLoan'])->name('admin.completeLoan');
    Route::patch('/admin/extend-loan/{id}', [anggotaController::class, 'extendLoan'])->name('admin.extendLoan');
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::post('/books/pinjam', [BookController::class, 'pinjam'])->name('books.pinjam');
    route::resource('users',userController::class);
    Route::get('/admin/borrow-book', [BookController::class, 'showBorrowForm'])->name('admin.borrowBook');
    Route::get('/admin/borrow-form/{book_id}', [BookController::class, 'showAdminBorrowForm'])->name('admin.borrowForm');
    Route::get('/admin/return-form/{id}', [BookController::class, 'showReturnForm'])->name('admin.show_return_form');
    Route::post('/admin/return-form/{id}', [BookController::class, 'submitReturnForm'])->name('admin.submit_return_form');
});
Route::get('/anggota', [anggotaController::class, 'index'])->name('anggota.index');
route::group(['middleware' => ['auth', 'role:anggota']], function(){
    Route::get('/anggota/pending-requests', [anggotaController::class, 'pendingRequests'])->name('anggota.pending_requests');
    Route::get('/anggota/borrowed', [anggotaController::class, 'borrowedBooks'])->name('anggota.borrowed');
    Route::get('/borrowed-books', [anggotaController::class, 'borrowedBooks'])->name('anggota.borrowedBooks');
    Route::post('/anggota', [anggotaController::class, 'store'])->name('anggota.store');
    Route::post('/anggota/return-form/{id}', [BookController::class, 'submitReturnFormAnggota'])->name('anggota.submit_return_form');
});

Route::get('/dashboard', [anggotaController::class, 'dashboard'])->name('dashboard');
require __DIR__.'/auth.php';
