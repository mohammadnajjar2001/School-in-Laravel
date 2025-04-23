<?php

use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\QuizzeController;
use App\Http\Controllers\Api\StudentController;

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



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/student/events', [EventController::class, 'index']);
    Route::get('/student/quizzes', [QuizzeController::class, 'index']);
    Route::put('/student/password', [StudentController::class, 'updatePassword']);
    Route::get('/student/profile', [StudentController::class, 'showProfile']);
    Route::get('/student/subjects', [StudentController::class, 'index']);

});

// مسار تسجيل خروج الطالب
Route::post('/login/student', [LoginController::class, 'studentLogin'])->name('api.login.student');
Route::post('/student/logout', [LoginController::class, 'studentLogout'])->name('student.logout');

// مسار تسجيل خروج ولي الأمر
Route::post('/login/parent', [LoginController::class, 'parentLogin'])->name('api.login.parent');
Route::middleware('auth:sanctum')->post('/parent/logout', [LoginController::class, 'parentLogout'])->name('parent.logout');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
