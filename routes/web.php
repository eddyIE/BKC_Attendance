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

    Route::resource('major', 'MajorController')->except('edit');
    Route::patch('major/{major}/restore', 'MajorController@restore')->name('major.restore');
    Route::post('major/import', 'MajorController@import');

    Route::resource('program', 'ProgramController')->except('edit');
    Route::patch('program/{program}/restore', 'ProgramController@restore')->name('program.restore');

    Route::resource('subject', 'SubjectController')->except('edit');
    Route::patch('subject/{subject}/restore', 'SubjectController@restore')->name('subject.restore');

    Route::resource('student', 'StudentController')->except('edit');
    Route::patch('student/{student}/restore', 'StudentController@restore')->name('student.restore');

    Route::resource('class', 'ClassController')->except('edit');
    Route::patch('class/{class}/restore', 'ClassController@restore')->name('class.restore');

    Route::resource('course', 'CourseController')->except('edit');
    Route::patch('course/{course}/restore', 'CourseController@restore')->name('course.restore');

    // Điểm danh
    Route::get("attendance", 'LecturerController@courseChooser');

    Route::post('course-data', 'LecturerController@getCourseData');

    Route::post('attendance', 'AttendanceController@createAttendance');
});

Route::group(['prefix' => '/', 'middleware' => ['auth', 'role:lecturer']], function (){
    // Trang chủ lecturer
    Route::get('/', 'LecturerController@index');

    // Trang tìm kiếm lớp điểm danh
    Route::get('/course', 'LecturerController@courseChooser');

    // Chọn lớp điểm danh
    Route::post('/course-data', 'LecturerController@getCourseData');

    // Tạo điểm danh
    Route::post('/attendance', 'AttendanceController@createAttendance');

    // Chi tiết buổi học trong lịch sử
    Route::get('/lesson/{id}', 'LecturerController@prevLessonDetail');

    // Quản lí các lớp được phân công
    Route::get('/my-course', 'LecturerController@courseManagement');

    // Update ẩn/hiện phân công
    Route::get('/my-course/visibility/{id}', 'LecturerController@courseUpdateVisibility');

    // Chấm công
    Route::get('/time-keeping/{month?}', 'LecturerController@timeKeeping');

    // Excel
    Route::get('/course/export/{courseId}', 'LecturerController@exportStudentData');
});
