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

Route::get('/login', [\App\Http\Controllers\LoginController::class, 'index']);

Route::post('/login-process', [\App\Http\Controllers\LoginController::class, 'authenticate']);

Route::middleware('role_check')->group(function (){
    Route::get('/admin', [\App\Http\Controllers\AdminController::class])->middleware('role_check');
    Route::get('/', 'LecturerController@index')->middleware('role_check');
});


Route::group(['prefix' => '/', 'middleware' => ['auth', 'role:lecturer']], function (){
    Route::get('/', 'LecturerController@index');
});

Route::get('/majors', [App\Http\Controllers\AttendanceCtrl::class, 'index']);
