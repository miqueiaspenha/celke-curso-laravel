<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('dashboard');

Route::get('/user/{user}/show', [UserController::class, 'show'])->name('user.show');

Route::get('/index-user', [UserController::class, 'index'])->name('user.index');
Route::get('/create-user', [UserController::class, 'create'])->name('user.create');
Route::post('/store-user', [UserController::class, 'store'])->name('user.store');

Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/update-user/{user}', [UserController::class, 'update'])->name('user.update');

Route::get('/edit-user/{user}/password', [UserController::class, 'editPassword'])->name('user.editPassword');
Route::put('/update-user/{user}/password', [UserController::class, 'updatePassword'])->name('user.updatePassword');

Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

Route::get('/user/{user}/generate-pdf', [UserController::class, 'generatePdf'])->name('user.generatePdf');
Route::get('/user/generate-pdf', [UserController::class, 'generatePdfUsers'])->name('user.generatePdfUsers');

Route::get('/users/generate-csv', [UserController::class, 'generateCsvUsers'])->name('users.generateCsvUsers');