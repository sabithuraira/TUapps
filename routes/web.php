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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('testa', function () {
    $value = Cache::get('CommunityBPS');
    print_r($value);

    $value2 = Cookie::get('CommunityBPS');
    print_r($value2);

    $cookie = '';
    if(isset($_COOKIE["CommunityBPS"])){
        $cookie = $_COOKIE["CommunityBPS"];
    }
    print_r($cookie);

    $service_url    = 'http://pbd.bps.go.id/simpeg_api/bps16';
	$curl           = curl_init($service_url);
	$curl_post_data = array(
        "apiKey" => '4vl8i/WeNeRlRxM4KDk93VqdT0/LZ9g+GBITo+OiHVs=',
        "kategori"=> 'view_pegawai',
        "kdkab" => '01'
	);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
	$curl_response = curl_exec($curl);
	print_r($curl_response);
	curl_close($curl);
});


Route::resource('uker','UkerController');
Route::resource('type_kredit','TypeKreditController');
Route::resource('rincian_kredit','RincianKreditController');
Route::resource('angka_kredit','AngkaKreditController');
Route::resource('user','UserController');
Route::resource('log_book','LogBookController');
Route::post('log_book/data_log_book', 'LogBookController@dataLogBook');
Route::get('log_book/{id}/print', 'LogBookController@print');

Route::resource('ckp','CkpController')->except(['show']);

// Route::resource('attribute_pos','AttributePosController')->except(['show']);
Route::post('ckp/data_ckp', 'CkpController@dataCkp');
// Route::get('ckp/print', 'CkpController@print');
Route::get('ckp/print',array('as'=>'print','uses'=>'CkpController@print'));

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('guest', 'HomeController@guest')->name('guest');
