<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LecturerController;
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

Route::get('/login', [LoginController::class, 'index']);

Route::post('/login-process', [LoginController::class, 'authenticate']);

Route::middleware('role_check')->group(function () {
    Route::get('/admin', [AdminController::class])->middleware('role_check');
    Route::get('/', [LecturerController::class, 'index'])->middleware('role_check');
});


Route::group(['prefix' => '/', 'middleware' => ['auth', 'role:lecturer']], function () {
    Route::get('/', [LecturerController::class, 'index']);
});

Route::prefix('/lecturer')->group(function () {
    // Trang chủ lecturer
    Route::get('/', [LecturerController::class, 'index'])
        ->name('lecturer/index');

    // Trang tìm kiếm lớp điểm danh
    Route::get('/attendance', [LecturerController::class, 'courseChooser'])
        ->name('lecturer/course');

    // Chọn lớp điểm danh
    Route::post("/course", [LecturerController::class, 'courseDetail'])
        ->name('lecturer/course-detail');
});
