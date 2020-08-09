<?php

Route::get('/', 'HomeController@index')->name('home');
Route::get('/posting-donasi/{id}','HomeController@posting')->name('home.posting');
Route::get('/berita/{id}', 'HomeController@berita');
Route::post('/donasi-masuk','MasukanDonasiController@masukan_donasi');
Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/login','AdminController@show')->name('admin.getlogin');
Route::post('/admin/login','AdminController@login')->name('admin.login');

Route::get('/penggalang-dana/login','PenggalangDanaController@show')->name('penggalang.getlogin');
Route::post('/penggalang-dana/login','PenggalangDanaController@login')->name('penggalang.login');

Route::group(['middleware' => ['web', 'ceklogin']], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/','AdminController@index')->name('admin.index');
        Route::post('logout','AdminController@logout')->name('admin.logout');
        Route::get('donatur','AdminController@donatur')->name('admin.donatur');
        
        //Melihat Posting Routes
        Route::get('melihat-posting','AdminController@melihat_posting')->name('admin.melihat-posting');
        Route::get('melihat-posting/{id}/edit','AdminController@show_melihat_posting');
        Route::post('melihat-posting/update','AdminController@update_melihat_posting')->name('admin.melihat-posting-update');
        Route::get('postingid','AdminController@postingid')->name('admin.postingid');
        
        //PDF
        Route::get('pdf-donatur','AdminController@pdf_donatur')->name('admin.pdf-donatur');
        Route::get('pdf-penggalang','AdminController@pdf_penggalang')->name('admin.pdf-penggalang');

        //Profil Routes
        Route::get('profil','AdminController@profil')->name('admin.profil');
        Route::post('profil','AdminController@store_profil')->name('admin.profil-store');
        
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
});

Route::group(['middleware' => ['web', 'cekloginpenggalangdana']], function () {
    Route::prefix('penggalang-dana')->group(function () {
        Route::get('/','PenggalangDanaController@beranda')->name('penggalang-dana.beranda');
        Route::get('pengaturan-akun','PenggalangDanaController@pengaturan_akun')->name('penggalang-dana.pengaturan-akun');
        Route::post('pengaturan-akun','PenggalangDanaController@store_pengaturan_akun')->name('penggalang-dana.pengaturan-akun-store');
        Route::post('logout','PenggalangDanaController@logout')->name('penggalang-dana.logout');
    
        //Biodata Routes
        Route::get('biodata','BiodataDonaturController@index')->name('penggalang-dana.biodata');
        Route::post('biodata','BiodataDonaturController@store')->name('penggalang-dana.biodata-post');
        
        //posting-donasi routes
        Route::resource('posting-donasi','PostingDonasiController')->only(['index','store']);
        Route::get('posting-donasi/{id}/edit','PostingDonasiController@show');
        Route::post('posting-donasi/update','PostingDonasiController@update');
        Route::post('posting-donasi/destroy/{id}','PostingDonasiController@destroy');
        Route::get('postingdonasiid','PostingDonasiController@postingid')->name('posting.postingid');
        Route::get('getposting/{id}','PostingDonasiController@getposting');
        Route::get('posting-donasi/{id}', 'PostingDonasiController@lihat_donasi');

        //Bank Routes
        Route::resource('bank','BankController')->only(['index','store']);
        Route::get('bank/{id}/edit','BankController@show');
        Route::post('bank/update','BankController@update');
        Route::post('bank/destroy/{id}','BankController@destroy');
        Route::get('getbank/{id}','BankController@getbank');

        //Pdf Routes
        Route::get('pdf-posting/{id}','PostingDonasiController@pdf_posting');
    });
});
