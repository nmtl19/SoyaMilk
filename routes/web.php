<?php

use App\Http\Controllers\MasterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MasterController::class, 'Landing'])->name('Landing');
Route::get('/Registrasi', [MasterController::class, 'Registrasi'])->name('Registrasi');
Route::post('/AuthRegistrasi', [MasterController::class, 'AuthRegistrasi'])->name('AuthRegistrasi');
Route::get('/Login', [MasterController::class, 'Login'])->name('Login');
Route::post('/AuthLogin', [MasterController::class, 'AuthLogin'])->name('AuthLogin');
Route::get('/Logout', [MasterController::class, 'Logout'])->name('Logout');

Route::get('/Beranda', [MasterController::class, 'Beranda'])->name('Beranda');
Route::get('/BiodataDiri', [MasterController::class, 'BiodataDiri'])->name('BiodataDiri');
Route::post('/AuthBiodataDiri', [MasterController::class, 'AuthBiodataDiri'])->name('AuthBiodataDiri');
Route::get('/BiodataMitra', [MasterController::class, 'BiodataMitra'])->name('BiodataMitra');
Route::get('/AkunCustomer', [MasterController::class, 'AkunCustomer'])->name('AkunCustomer');
Route::get('/BiodataCustomer/{id}', [MasterController::class, 'BiodataCustomer'])->name('BiodataCustomer');
Route::get('/LihatArtikel/{id}', [MasterController::class, 'LihatArtikel'])->name('LihatArtikel');
Route::get('/TambahArtikel', [MasterController::class, 'TambahArtikel'])->name('TambahArtikel');
Route::post('/AuthTambahArtikel', [MasterController::class, 'AuthTambahArtikel'])->name('AuthTambahArtikel');
Route::get('/EditArtikel/{id}', [MasterController::class, 'EditArtikel'])->name('EditArtikel');
Route::post('/AuthEditArtikel', [MasterController::class, 'AuthEditArtikel'])->name('AuthEditArtikel');
Route::get('/HapusArtikel/{id}', [MasterController::class, 'HapusArtikel'])->name('HapusArtikel');

Route::get('/Produk', [MasterController::class, 'Produk'])->name('Produk');
Route::get('/TambahProduk', [MasterController::class, 'TambahProduk'])->name('TambahProduk');
Route::post('/AuthTambahProduk', [MasterController::class, 'AuthTambahProduk'])->name('AuthTambahProduk');
Route::get('/LihatProduk/{id}', [MasterController::class, 'LihatProduk'])->name('LihatProduk');
Route::get('/EditProduk/{id}', [MasterController::class, 'EditProduk'])->name('EditProduk');
Route::post('/AuthEditProduk', [MasterController::class, 'AuthEditProduk'])->name('AuthEditProduk');
Route::get('/HapusProduk/{id}', [MasterController::class, 'HapusProduk'])->name('HapusProduk');
Route::post('/AuthPemesananProduk/{id}', [MasterController::class, 'AuthPemesananProduk'])->name('HapusProduk');

Route::get('/Pemesanan', [MasterController::class, 'Pemesanan'])->name('Pemesanan');
Route::get('/DetailPemesanan/{id}', [MasterController::class, 'DetailPemesanan'])->name('DetailPemesanan');

Route::get('/UlasanProduk/{id}', [MasterController::class, 'UlasanProduk'])->name('UlasanProduk');
Route::post('/AuthUlasanProduk/{id}', [MasterController::class, 'AuthUlasanProduk'])->name('AuthUlasanProduk');
Route::get('/HapusUlasan/{id}', [MasterController::class, 'HapusUlasan'])->name('HapusUlasan');

Route::get('/Keuangan', [MasterController::class, 'Keuangan'])->name('Keuangan');
Route::get('/TambahKeuangan', [MasterController::class, 'TambahKeuangan'])->name('TambahKeuangan');
Route::post('/AuthTambahKeuangan', [MasterController::class, 'AuthTambahKeuangan'])->name('AuthTambahKeuangan');