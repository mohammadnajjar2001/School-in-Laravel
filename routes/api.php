<?php

use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', [LoginController::class, 'test']);



// مسار تسجيل خروج الطالب
Route::post('/login/student', [LoginController::class, 'studentLogin'])->name('api.login.student');
Route::post('/student/logout', [LoginController::class, 'studentLogout'])->name('student.logout');

// مسار تسجيل خروج ولي الأمر
Route::post('/login/parent', [LoginController::class, 'parentLogin'])->name('api.login.parent');
Route::middleware('auth:sanctum')->post('/parent/logout', [LoginController::class, 'parentLogout'])->name('parent.logout');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
