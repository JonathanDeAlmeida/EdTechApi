<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::post('save-student', [StudentController::class, 'save']);
Route::delete('remove-student', [StudentController::class, 'remove']);
Route::get('get-students', [StudentController::class, 'get']);
Route::get('filter-students', [StudentController::class, 'filter']);