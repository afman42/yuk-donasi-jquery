<?php

Route::get('/', function () {
    return view('home');
});

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/tes', function () {
    return view('admin.index');
});

Route::get('/login', function () {
    return view('layouts.login');
});

Route::get('/admin/login','AdminController@show');
Route::post('/admin/login','AdminController@login')->name('admin.login');


Route::prefix('admin')->group(function () {
    Route::get('/','AdminController@index')->name('admin.index');
    Route::post('/logout','AdminController@logout')->name('admin.logout');
    Route::get('donatur','AdminController@donatur')->name('admin.donatur');
    
    //Penggalang Dana Routes
    Route::get('penggalang-dana','AdminController@penggalang_dana')->name('admin.penggalang');
    Route::post('penggalang-dana','AdminController@store_penggalang_dana')->name('admin.penggalang-post');
    Route::get('penggalang-dana/{id}/edit','AdminController@show_penggalang_dana');
    Route::post('penggalang-dana/update','AdminController@update_penggalang_dana');
    Route::post('penggalang-dana/destroy/{id}','AdminController@destroy_penggalang_dana');
    Route::get('getpenggalang-dana/{id}','AdminController@getpenggalang_dana');
    
    //Donatur Routes
    Route::get('donatur','AdminController@donatur')->name('admin.donatur');
    Route::post('donatur','AdminController@store_donatur')->name('admin.donatur-post');
    Route::get('donatur/{id}/edit','AdminController@show_donatur');
    Route::post('donatur/update','AdminController@update_donatur');
    Route::post('donatur/destroy/{id}','AdminController@destroy_donatur');
    Route::get('getdonatur/{id}','AdminController@getdonatur');

    //Berita Routes
    Route::resource('berita','BeritaController')->only(['index','store']);
    Route::get('beritaid','BeritaController@beritaid')->name('berita.beritaid');
    Route::get('berita/{id}/edit','BeritaController@show');
    Route::post('berita/update','BeritaController@update');
    Route::post('berita/destroy/{id}','BeritaController@destroy');
    Route::get('getberita/{id}','BeritaController@getbank');
});

Route::prefix('penggalang-dana')->group(function () {
    Route::get('/','PenggalangDanaController@beranda')->name('penggalang-dana.beranda');
    Route::get('pengaturan-akun','PenggalangDanaController@pengaturan_akun')->name('penggalang-dana.pengaturan-akun');
    Route::get('posting-donasi','PenggalangDanaController@posting_donasi')->name('penggalang-dana.posting-donasi');
    
    
    Route::get('profil','BiodataDonaturController@index')->name('penggalang-dana.profil');
    Route::post('profil','BiodataDonaturController@store')->name('penggalang-dana.profil-post');
    //Bank Routes
    Route::resource('bank','BankController')->only(['index','store']);
    Route::get('bank/{id}/edit','BankController@show');
    Route::post('bank/update','BankController@update');
    Route::post('bank/destroy/{id}','BankController@destroy');
    Route::get('getbank/{id}','BankController@getbank');
});