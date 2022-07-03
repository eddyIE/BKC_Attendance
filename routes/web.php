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

Route::get('login', 'LoginController@index')->name('login');

Route::post('login-process', 'LoginController@authenticate');

Route::get('logout', 'LoginController@logout');

Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'role:admin']], function (){
    Route::get('/', 'AdminController@index');
});

Route::group(['prefix' => '/', 'middleware' => ['auth', 'role:lecturer']], function (){
    Route::get('/', 'LecturerController@index');
});

Route::get('/majors', [App\Http\Controllers\AttendanceCtrl::class, 'index']);
