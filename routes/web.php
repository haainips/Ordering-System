<?php

use App\Http\Controllers\MejaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/menu', [MenuController::class, 'show'])->name('daftarmenu');
Route::get('/menu/filter/{id_kategori}', [MenuController::class, 'filterKategori']);


// Menampilkan Cart
Route::get('/keranjang', [OrderController::class, 'cart'])->name('order.cart');

//Menampilkan Form Cek pesanan
Route::get('/pesanan/cek-pesanan', [PaymentController::class, 'checkOrder'])->name('order.view');
Route::post('/pesanan/cek-pesanan', [PaymentController::class, 'viewOrder'])->name('order.check');

// Memasukkan Menu Ke Keranjang
Route::post('/order/add', [OrderController::class, 'addToCart'])->name('order.add');

// Update Quantity
Route::get('/cart/decrease/{id_menu}', [OrderController::class, 'decreaseQuantity'])->name('order.decreaseQuantity');
Route::get('/cart/increase/{id_menu}', [OrderController::class, 'increaseQuantity'])->name('order.increaseQuantity');

// Delete Cart
Route::delete('/cart/delete/{id_menu}', [OrderController::class, 'deleteItem'])->name('order.deleteItem');

// Konfirmasi Pesanan
Route::get('/pesanan/confirm', [OrderController::class, 'confirmOrder'])->name('order.confirm');
// 
Route::post('/pesanan/confirm', [OrderController::class, 'storeOrder'])->name('order.store');

Route::get('/payment/success', [OrderController::class, 'paymentSuccess'])->name('payment.success');

Route::delete('/payment/cancel/{id}', [OrderController::class, 'paymentCancel'])->name('order.cancel');