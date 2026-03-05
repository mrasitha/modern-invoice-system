<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [DashboardController::class, 'index']);

Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
Route::post('/documents/store', [DocumentController::class, 'store'])->name('documents.store');
