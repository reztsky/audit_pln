<?php

use App\Http\Controllers\Admin\DaftarHadirController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KertasKerjaController;
use App\Http\Controllers\Admin\LhaController;
use App\Http\Controllers\Admin\LhaReviewController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\PkaController;
use App\Http\Controllers\Admin\SuratTugasController;
use App\Http\Controllers\Admin\TimAuditController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TindakLanjutLhaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'controller' => LoginController::class,
], function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/auth', 'auth')->name('auth');
});

Route::group([
    'middleware' => 'auth',
    'prefix' => '/admin'
], function () {
    Route::group([
        'controller' => DashboardController::class,
        'prefix' => '/dashboard',
        'as' => 'dashboard.'
    ], function () {
        Route::get('/', 'index')->name('index');
    });

    Route::group([
        'controller' => PegawaiController::class,
        'prefix' => '/pegawai',
        'as' => 'pegawai.'
    ], function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });

    Route::group([
        'controller' => SuratTugasController::class,
        'prefix' => '/surat-tugas',
        'as' => 'suratTugas.'
    ], function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });

    Route::group([
        'controller' => PkaController::class,
        'prefix' => '/pka',
        'as' => 'pka.'
    ], function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/detail/{id}', 'detail')->name('detail');
    });

    Route::group([
        'controller' => TimAuditController::class,
        'prefix' => '/tim-audit',
        'as' => 'timAudit.'
    ], function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/tim-by-pka/{id_pka}', 'timByPka')->name('timByPka');
    });

    Route::group([
        'controller' => DaftarHadirController::class,
        'prefix' => '/daftar-hadir',
        'as' => 'daftarHadir.'
    ], function () {
        Route::post('/store', 'store')->name('store');
        Route::get('/daftar-hadir-pka/{idpka}', 'daftarHadirPka')->name('daftarHadirPka');
    });

    Route::group([
        'controller' => KertasKerjaController::class,
        'prefix' => '/kertas-kerja',
        'as' => 'kertasKerja.'
    ], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create/{idpka}', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/show/{idpka}', 'show')->name('show');
        Route::get('/detail/{id}', 'detail')->name('detail');
        Route::get('/edit/{id}','edit')->name('edit');
        Route::post('/update/{id}','update')->name('update');
    });

    Route::group([
        'controller' => LhaController::class,
        'prefix' => '/lha',
        'as' => 'lha.'
    ], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create/{idpka}', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/detail/{id}', 'detail')->name('detail');
        Route::get('/show{id}', 'show')->name('show');
        Route::post('/submit-keatasan/{id}', 'submitKeAtasan')->name('submitKeAtasan');
        Route::get('/edit/{id}','edit')->name('edit');
        Route::post('/update/{id}','update')->name('update');
        Route::get('/review/{idpka}','review')->name('review');
        Route::post('/review/acc-atasan','accAtasan')->name('accAtasan');
    });

    Route::group([
        'controller' => LhaReviewController::class,
        'prefix' => '/lha-review',
        'as' => 'lhaReview.'
    ], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', [LhaReviewController::class, 'show'])->name('show');
        Route::post('/{id}/submit', [LhaReviewController::class, 'submitReview'])->name('submit');
    });

    Route::group([
        'controller'=>TindakLanjutLhaController::class,
        'prefix'=>'/tindak-lanjut-lha',
        'as'=>'tindakLanjut.'
    ],function(){
        Route::get('/','index')->name('index');
        Route::get('/create/{id_lha}','create')->name('create');
        Route::post('/store','store')->name('store');
        Route::post('/update/{id}','update')->name('update');
        Route::get('/submit-keatasan/{id}','submitKeatasan')->name('submitKeatasan');
        Route::get('/review-tindaklanjut/{id}','reviewTindakLanjut')->name('reviewTindakLanjut');
        Route::post('/submit-review','submitReview')->name('submitReview');
    });
});
