<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'role:perusahaan']], function() {
	Route::get('/item', 'ItemController@index')->name('item.index');
	Route::get('/item/load', 'ItemController@load')->name('item.load');
	Route::get('/item/new', 'ItemController@new')->name('item.new');
	Route::post('/item/save','ItemController@save')->name('item.save');
	Route::get('/item/add/{id}', 'ItemController@addForm')->name('item.addForm');
	Route::put('/item/add/{id}', 'ItemController@add')->name('item.add');
	Route::get('/item/changeprice/{id}', 'ItemController@changepriceForm')->name('item.changepriceForm');
	Route::put('/item/changeprice/{id}', 'ItemController@changeprice')->name('item.changeprice');
	Route::get('/item/distribute/{id}', 'ItemController@distributeForm')->name('item.distributeForm');
	Route::get('/getkabupaten/{id}', 'ItemController@getKabupaten')->name('item.getKabupaten');
	Route::get('/gudang/distribute/find', 'GudangController@distributeFind')->name('gudang.distributeFind');
	Route::post('/pengiriman/request', 'PengirimanController@request')->name('pengiriman.request');
	Route::get('/pengiriman/load/perusahaan', 'PengirimanController@loadPerusahaan')->name('pengiriman.loadPerusahaan');
	Route::get('/item/take/{id}', 'ItemController@takeForm')->name('item.takeForm');
	Route::get('/gudang/take/find/{id}', 'GudangController@takeFind')->name('gudang.takeFind');
	Route::post('/pengiriman/take', 'PengirimanController@take')->name('pengiriman.take');
	Route::get('/vessel/schedule', 'PengirimanController@vesselSchedule')->name('vessel.schedule');
});

Route::group(['middleware' => ['auth', 'role:pemilik_gudang']], function() {
	Route::get('/gudang', 'GudangController@index')->name('gudang.index');
	Route::get('/gudang/load', 'GudangController@load')->name('gudang.load');
	Route::get('/pengiriman/load/gudang', 'PengirimanController@loadGudang')->name('pengiriman.loadGudang');
	Route::put('/pengiriman/accept/{id}', 'PengirimanController@accept')->name('pengiriman.accept');
	Route::put('/pengiriman/reject/{id}', 'PengirimanController@reject')->name('pengiriman.reject');
	Route::get('/pengiriman/receive/scanner/{id}', 'PengirimanController@receiveScanner')->name('pengiriman.receiveScanner');
	Route::put('/pengiriman/receive/{id}', 'PengirimanController@receive')->name('pengiriman.receive');
	Route::put('/pengiriman/arrive/{id}', 'PengirimanController@arrive')->name('pengiriman.arrive');
});

Route::group(['middleware' => ['auth', 'role:perusahaan|pemilik_gudang']], function() {
	Route::get('/pengiriman', 'PengirimanController@index')->name('pengiriman.index');
	Route::get('/pengiriman/qrcode/{id}', 'PengirimanController@qrCode')->name('pengiriman.qrCode');
	Route::get('/pengiriman/scanner/{id}', 'PengirimanController@scanner')->name('pengiriman.scanner');
	Route::put('/pengiriman/send/{id}', 'PengirimanController@send')->name('pengiriman.send');
	Route::get('/phone/agreement', 'UserController@verificationAgreement')->name('phone.agreement');
	Route::get('/phone/smsotp', 'UserController@callSMSOTP')->name('phone.smsotp');
	Route::post('/phone/verify', 'UserController@verify')->name('phone.verify');
});