<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'user',
], function () {
    Route::get('/', [AuthController::class, 'me'])->name('me');
    Route::get('logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
});

Route::resource('groups', GroupController::class)->middleware(['auth:sanctum']);
Route::resource('labs', LabController::class)->middleware(['auth:sanctum']);
Route::resource('notes', NoteController::class)->middleware(['auth:sanctum']);
Route::resource('students', StudentController::class)->middleware(['auth:sanctum']);
Route::post('load/students', [StudentController::class, 'loadStudents'])->middleware(['auth:sanctum']);
Route::resource('grades', GradeController::class)->middleware(['auth:sanctum']);

