<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BankMiniController;
use App\Http\Controllers\SiswaController;

/*
|--------------------------------------------------------------------------  
| Web Routes  
|--------------------------------------------------------------------------  
|  
| Here is where you can register web routes for your application. These  
| routes are loaded by the RouteServiceProvider and all of them will  
| be assigned to the "web" middleware group. Make something great!  
|  
*/

Route::get('/', function () {  
    return view('welcome');  
});  

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');  
Route::post('/login', [AuthController::class, 'login'])->name('login.post');  
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');  

Route::middleware(['auth'])->group(function () {  
    Route::get('/admin/dashboard', function () {  
        return view('admin.dashboard');  
    })->name('admin.dashboard');  

    Route::get('/siswa/dashboard', function () {  
        return view('siswa.dashboard');  
    })->name('siswa.dashboard');  

    Route::get('/bank_mini/dashboard', function () {  
        return view('bank_mini.dashboard');  
    })->name('bank_mini.dashboard');  
});  

Route::get('admin/transactions', [AdminDashboardController::class, 'transactions'])->name('admin.transactions');
Route::post('admin/transaction/{id}/approve', [AdminDashboardController::class, 'approveTransaction'])->name('admin.transaction.approve');
Route::post('admin/transaction/{id}/reject', [AdminDashboardController::class, 'rejectTransaction'])->name('admin.transaction.reject');
Route::delete('/admin/delete/{id}', [AdminDashboardController::class, 'destroy'])->name('admin.delete');  
Route::post('admin/dashboard/', [AdminDashboardController::class, 'store'])->name('admin.store');  

// Route untuk menampilkan dashboard  
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');  

Route::get('/admin/create', [AdminDashboardController::class, 'create'])->name('admin.create');  
Route::get('/admin/{id}/edit', [AdminDashboardController::class, 'edit'])->name('admin.edit');  
Route::post('/admin/{id}/update', [AdminDashboardController::class, 'update'])->name('admin.update');  

Route::get('/siswa/dashboard', [SiswaController::class, 'index'])->name('siswa.dashboard');

// Define withdraw route for siswa
Route::post('/withdraw/request', [SiswaController::class, 'withdraw'])->name('siswa.withdraw.request');

Route::post('/transfer', [SiswaController::class, 'transfer'])->name('siswa.transfer.request');


Route::get('/bank_siswa/dashboard', [BankMiniController::class, 'index'])->name('bank_mini.dashboard');  
Route::get('/bank_mini/transaction-history', [BankMiniController::class, 'transactionHistory'])->name('bank_mini.history');  
Route::post('/bank_mini/top-up/{id}', [BankMiniController::class, 'topUp'])->name('bank_mini.topup');  
Route::post('/bank_mini/withdraw/{id}', [BankMiniController::class, 'withdraw'])->name('bank_mini.withdraw');  
Route::post('/bank_mini/transfer/{id}', [BankMiniController::class, 'transfer'])->name('bank_mini.transfer');  
Route::post('/bank_mini/create', [BankMiniController::class, 'store'])->name('users.store');
Route::put('/bank_mini/update/{id}', [BankMiniController::class, 'update'])->name('users.update');
Route::delete('/bank_mini/delete/{id}', [BankMiniController::class, 'destroy'])->name('users.destroy');

Route::post('/topup/request', [SiswaController::class, 'requestTopUp'])->name('siswa.topup.request');  
Route::get('/approve-topup/{id}', [BankMiniController::class, 'approveTopUp'])->name('approve.topup');  
Route::get('/approve/withdraw/{id}', [BankMiniController::class, 'approveWithdraw'])->name('approve.withdraw');
Route::get('/reject-topup/{id}', [BankMiniController::class, 'rejectTopUp'])->name('reject.topup');

Route::get('/check-recipient/{id}', [SiswaController::class, 'checkRecipient'])
    ->name('check.recipient');