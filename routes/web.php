<?php

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/tes', function () {
    return view('admin.index');
});

Route::get('/login', function () {
    return view('layouts.login');
});

Route::prefix('admin')->group(function () {
    Route::get('penggalang-dana','AdminController@penggalang_dana')->name('admin.penggalang');
    Route::get('donatur','AdminController@donatur')->name('admin.donatur');
});

Route::prefix('penggalang-dana')->group(function () {
    Route::get('/','PenggalangDanaController@beranda')->name('penggalang-dana.beranda');
    Route::get('pengaturan-akun','PenggalangDanaController@pengaturan_akun')->name('penggalang-dana.pengaturan-akun');
    Route::get('posting-donasi','PenggalangDanaController@posting_donasi')->name('penggalang-dana.posting-donasi');
    
    //Bank Routes
    Route::resource('bank','BankController')->only(['index','store']);
    Route::get('bank/{id}/edit','BankController@show');
    Route::post('bank/update','BankController@update');
    Route::post('bank/destroy/{id}','BankController@destroy');
    Route::get('getbank/{id}','BankController@getbank');
});