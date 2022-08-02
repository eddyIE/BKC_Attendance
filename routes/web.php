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

    Route::resource('major', 'MajorController');
});

Route::group(['prefix' => '/', 'middleware' => ['auth', 'role:lecturer']], function (){
    // Trang chủ lecturer
    Route::get('/', 'LecturerController@index');

    // Trang tìm kiếm lớp điểm danh
    Route::get('/course', 'LecturerController@courseChooser');

    // Chọn lớp điểm danh
    Route::post("/course-detail", 'LecturerController@courseDetail');

    // Tạo điểm danh
    Route::post("/attendance", 'AttendanceController@createAttendance');

    // Chi tiết buổi học trong lịch sử
    Route::get('/lesson/{id}', 'LecturerController@prevLessonDetail');

});
