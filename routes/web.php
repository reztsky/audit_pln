<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'controller'=>LoginController::class,
],function(){
    Route::get('/login','index')->name('login');
    Route::post('/auth','auth')->name('auth');
});

Route::group([
    // 'middleware'=>'auth',
    'prefix'=>'/admin'
],function(){
    Route::group([
        'controller'=>DashboardController::class,
        'prefix'=>'/dashboard',
        'as'=>'dashboard.'
    ],function(){
        Route::get('/','index')->name('index');
    });

    Route::group([
        'controller'=>PegawaiController::class,
        'prefix'=>'/pegawai',
        'as'=>'pegawai.'
    ],function(){
        Route::get('/','index')->name('index');
        Route::post('/store','store')->name('store');
        Route::delete('/delete/{id}','delete')->name('delete');
    });
});
