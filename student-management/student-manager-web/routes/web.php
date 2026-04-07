<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('students.index'));

Route::resource('students', StudentController::class);
