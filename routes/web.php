<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\KasirMiddleware;
use App\Livewire\Admin\Kasir\Form as FormKasir;
use App\Livewire\Admin\Kasir\Index as Kasir;
use App\Livewire\Admin\Kategori\Index as Kategori;
use App\Livewire\Admin\Kategori\Form as FormKategori;
use App\Livewire\Admin\Produk\Form as FormProduk;
use App\Livewire\Admin\Produk\Index as Produk;
use App\Livewire\Auth\Login;
use App\Livewire\Transaksi\RiwayatTransaksi;
use App\Livewire\Transaksi\Transaksi;
use Illuminate\Support\Facades\Route;

Route::get('/', Login::class)->name('login');

// Untuk Admin
Route::middleware([AdminMiddleware::class])->group(function () {
    //Produk
    Route::get('produk', Produk::class)->name('produk.index');
    Route::get('produk/form/{produkId?}', FormProduk::class)->name('produk.form');
    //Kategori
    Route::get('kategori', Kategori::class)->name('kategori.index');
    Route::get('kategori/form/{kategoriId?}', FormKategori::class)->name('kategori.form');
    //Kasir
    Route::get('kasir', Kasir::class)->name('kasir.index');
    Route::get('kasir/form/{kasirId?}', FormKasir::class)->name('kasir.form');
});

// Untuk Kasir
Route::middleware([KasirMiddleware::class])->group(function () {
    //Transaksi
    Route::get('transaksi', Transaksi::class)->name('transaksi');
});

// Tidak dimasukkan middleware admin dan kasir karena keduanya bisa masuk
// Hanya orang yang sudah login bisa masuk
Route::middleware(['auth'])->group(function () {
    Route::get('riwayat-transaksi', RiwayatTransaksi::class)->name('riwayat.transaksi');
});