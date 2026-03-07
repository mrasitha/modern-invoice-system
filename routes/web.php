<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Landing Page (Welcome)
// මේක Guest සහ Auth දෙන්නාටම ඕන නම් මෙතන තියන්න. 
// නැත්නම් කෙලින්ම Login එකට Redirect කරන්නත් පුළුවන්.
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
});

// 2. Guest Routes (Login වෙන්න කලින්)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 3. Authenticated Routes (Login වුණු අයට විතරයි)
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Projects Management
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::post('/store', [ProjectController::class, 'store'])->name('store');
        Route::get('/{id}', [ProjectController::class, 'show'])->name('show');
    });

    // Documents (Invoices/Quotes) Management
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/', [DocumentController::class, 'index'])->name('index');
        Route::get('/create', [DocumentController::class, 'create'])->name('create');
        Route::post('/store', [DocumentController::class, 'store'])->name('store');
        
        // Actions
        Route::get('/{id}/status/{status}', [DocumentController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/{id}/convert', [DocumentController::class, 'convertToInvoice'])->name('convert');
        
        // PDF Handling
        Route::get('/{id}/view-pdf', [DocumentController::class, 'viewPDF'])->name('viewPdf');
        Route::get('/{id}/pdf', [DocumentController::class, 'downloadPDF'])->name('pdf');
    });

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

});