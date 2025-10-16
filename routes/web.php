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
route::group(['middleware' => ['auth', 'role:admin|supervisor']], function(){
    Route::get('/anggota/loan-requests', [AnggotaController::class, 'loanRequests'])->name('anggota.loan_requests');
    Route::get('/admin/confirm-requests', [anggotaController::class, 'confirmRequests'])->name('admin.confirmRequests');
    Route::delete('/admin/reject-all/{userId}', [AnggotaController::class, 'rejectAllRequestsByUser'])->name('admin.rejectAllRequests');
    Route::patch('/admin/approve-all/{userId}', [AnggotaController::class, 'approveAllRequestsByUser'])->name('admin.approveAllRequests');
    Route::delete('/admin/reject-request/{id}', [AnggotaController::class, 'rejectRequest'])->name('admin.rejectRequest');
    Route::get('/admin/borrowed-books/{status?}', [AnggotaController::class, 'borrowedBooksAdmin'])->name('admin.borrowedBooks');
    Route::patch('/admin/return-book/{id}', [AnggotaController::class, 'returnBookForAdmin'])->name('admin.returnBookForAdmin');
    Route::patch('/admin/complete-loan/{id}', [AnggotaController::class, 'completeLoan'])->name('admin.completeLoan');
    Route::patch('/admin/extend-loan/{id}', [AnggotaController::class, 'extendLoan'])->name('admin.extendLoan');
    route::resource('users',userController::class);
    Route::get('/admin/borrow-book', [BookController::class, 'showBorrowForm'])->name('admin.borrowBook');
    Route::get('/admin/borrow-form/{book_id}', [BookController::class, 'showAdminBorrowForm'])->name('admin.borrowForm');
    Route::get('/admin/return-form/{id}', [BookController::class, 'showReturnForm'])->name('admin.show_return_form');
    Route::post('/admin/return-form/{id}', [BookController::class, 'submitReturnForm'])->name('admin.submit_return_form');
   Route::get('/admin/borrowed-books/export/{status?}', [AnggotaController::class, 'exportBorrowedBooks'])->name('admin.borrowedBooks.export');
});
route::group(['middleware' => ['auth', 'role:admin']], function(){
    
});
route::group(['middleware' => ['auth', 'role:admin|supervisor']], function(){
    
});
route::group(['middleware' => ['auth', 'role:admin']], function(){
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
});
route::group(['middleware' => ['auth', 'role:admin|supervisor']], function(){
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
   Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::get('/admin/borrow-book', [BookController::class, 'showBorrowForm'])->name('admin.borrowBook');
    Route::get('/admin/borrow-form/{book_id}', [BookController::class, 'showAdminBorrowForm'])->name('admin.borrowForm');
    Route::post('/books/pinjam', [BookController::class, 'pinjam'])->name('books.pinjam');
});
route::group(['middleware' => ['auth', 'role:admin|supervisor']], function(){
    Route::get('/admin/borrow-book', [BookController::class, 'showBorrowForm'])->name('admin.borrowBook');
    Route::get('/admin/borrow-form/{book_id}', [BookController::class, 'showAdminBorrowForm'])->name('admin.borrowForm');
    Route::post('/books/pinjam', [BookController::class, 'pinjam'])->name('books.pinjam');
});
Route::get('/anggota', [anggotaController::class, 'index'])->name('anggota.index');
route::group(['middleware' => ['auth', 'role:anggota']], function(){
    Route::get('/anggota/pending-requests', [anggotaController::class, 'pendingRequests'])->name('anggota.pending_requests');
    Route::get('/anggota/borrowed', [anggotaController::class, 'borrowedBooks'])->name('anggota.borrowed');
    Route::get('/borrowed-books', [anggotaController::class, 'borrowedBooks'])->name('anggota.borrowedBooks');
    Route::post('/anggota', [anggotaController::class, 'store'])->name('anggota.store');
    Route::post('/anggota/return-form/{id}', [BookController::class, 'submitReturnFormAnggota'])->name('anggota.submit_return_form');
    Route::post('/keranjang/add/{id}', [AnggotaController::class, 'addToCart'])->name('keranjang.add');
Route::delete('/keranjang/remove/{id}', [AnggotaController::class, 'removeFromCart'])->name('keranjang.remove');
Route::post('/keranjang/checkout', [AnggotaController::class, 'checkoutCart'])->name('keranjang.checkout');
Route::patch('/keranjang/update/{id}', [AnggotaController::class, 'updateCart'])->name('keranjang.update');
});

Route::get('/dashboard', [anggotaController::class, 'dashboard'])->name('dashboard');
Route::get('/admin/borrowed-books/export/{status?}', [anggotaController::class, 'exportBorrowedBooks'])->name('admin.borrowedBooks.exportWithStatus');
Route::get('/export-borrowed-books/{status?}', [App\Http\Controllers\anggotaController::class, 'exportBorrowedBooks'])
    ->name('export.borrowed.books');
require __DIR__.'/auth.php';
