<?php

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
Route::get('/index', 'Controller@index');

Route::get('/', 'Controller@signin');
Route::get('/signin' , 'Controller@signin');
Route::get('/signup' , 'Controller@signup');
Route::get('/signout' , 'Controller@signout');

Route::post('/signupProcess' , 'Controller@signupProcess');
Route::post('/signinProcess' , 'Controller@signinProcess');

Route::group(['prefix' => 'user' , 'middleware' => ['auth']], function(){
    Route::get('/home' , 'UserController@index');
    Route::get('/itemmasuk' , 'UserController@itemmasuk');
    Route::post('/itemmasukprocess' , 'UserController@itemmasukProcess');
    Route::get('/itemkeluar' , 'UserController@itemkeluar');
    Route::post('/itemkeluarprocess' , 'UserController@itemkeluarProcess');

    Route::get('/stock' , 'UserController@stock');
    Route::get('/tambahitem' , 'UserController@tambahitem');
    Route::post('/tambahitemprocess' , 'UserController@tambahitemProcess');
    Route::get('/transaksi' , 'UserController@transaksi');
    Route::post('/transaksi/filter' , 'UserController@transaksiFilter');
    Route::post('/tutupbuku' , 'UserController@tutupbuku');
    Route::get('/reportprofit' ,'UserController@reportprofit');
    Route::post('/reportprofit/filter' ,'UserController@reportprofitfilter');
    Route::get('/reportincome' ,'UserController@reportincome');
    Route::post('/reportincome/filter' ,'UserController@reportincomefilter');
    Route::get('/reportoutcome' ,'UserController@reportoutcome');
    Route::post('/reportoutcome/filter' ,'UserController@reportoutcomefilter');
    Route::get('/tambahitembaru' , 'UserController@tambahitembaru');
    Route::post('/tambahitembaruprocess' ,'UserController@tambahitembaruprocess');


});

Route::post('/test' , 'UserController@test');
