<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BarangController;

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

Route::get('/',[StudentController::class,'index']); 
Route::get('/logout',[StudentController::class,'logout']); 
Route::post('/masuk', [StudentController::class, 'masuk']);
// Route::get('/daftar',[StudentController::class, 'daftar']);
// Route::post('/simpanDaftar',[StudentController::class, 'simpanPendaftaran']);
Route::get('/cetakNota/{id}',[StudentController::class, 'cetakNota']);


Route::group(['middleware'=>'IsAdmin'], function(){
    Route::get('/dashboard',[StudentController::class, 'dashboard']);
    Route::get('/showAllNota',[StudentController::class, 'showAllNota']);
    Route::get('/buatNota',[StudentController::class,'tampilhalaman']);
    Route::post('/simpanNota',[StudentController::class, 'simpanNota']);
    Route::get('/showData/{id}',[StudentController::class, 'showData']);
    Route::get('/hapusNota/{id}',[StudentController::class, 'hapusNota']);
    Route::get('/loadmore/{skip}',[StudentController::class, 'loadmore']);
    Route::post('/queryCari',[StudentController::class, 'queryCari']);
    Route::post('/loadmoreQuery',[StudentController::class, 'loadmoreQuery']);
    Route::post('/queryFilterDashboard',[StudentController::class, 'queryFilterDashboard']);

    Route::get('/barang',[BarangController::class, 'barang']);
    Route::post('/simpanBarang',[BarangController::class, 'simpanBarang']);
    Route::get('/loadmoreBarang/{skip}',[BarangController::class, 'loadmoreBarang']);
    Route::get('/hapusBarang/{id}',[BarangController::class, 'hapusBarang']);
    Route::post('/queryCariBarang',[BarangController::class, 'queryCariBarang']);
    Route::post('/loadmoreQueryBarang',[BarangController::class, 'loadmoreQueryBarang']);
    Route::get('/detailBarang/{id}',[BarangController::class, 'detailBarang']);

    Route::post('/getBarang',[BarangController::class, 'getBarang']);
    Route::get('/pilihBarang/{id}',[BarangController::class, 'pilihBarang']);
    
    

});











