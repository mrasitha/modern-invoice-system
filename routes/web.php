<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [DashboardController::class, 'index']);

// සියලුම Documents (Invoices/Quotes) එක තැනක බැලීමට
Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Projects
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');

// Documents (Invoices/Quotes) - මේ ටික හරියටම තියෙන්න ඕනේ
Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
Route::post('/documents/store', [DocumentController::class, 'store'])->name('documents.store');
Route::get('/documents/{id}/status/{status}', [DocumentController::class, 'updateStatus'])->name('documents.updateStatus');
Route::get('/documents/{id}/convert', [DocumentController::class, 'convertToInvoice'])->name('documents.convert');
Route::get('/documents/{id}/view-pdf', [DocumentController::class, 'viewPDF'])->name('documents.viewPdf');
Route::get('/documents/{id}/pdf', [DocumentController::class, 'downloadPDF'])->name('documents.pdf');