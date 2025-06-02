<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'controller'=>LoginController::class,
],function(){
    Route::get('/login','index')->name('login');
});
