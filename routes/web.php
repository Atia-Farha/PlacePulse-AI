<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ReportController::class, 'index'])->name('home');
Route::post('/api/generate-report', [ReportController::class, 'generate'])->name('report.generate');
Route::post('/api/reverse-geocode', [ReportController::class, 'reverseGeocode'])->name('report.geocode');
Route::get('/api/export-pdf', [ReportController::class, 'exportPdf'])->name('report.pdf');

// Custom Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// History Routes
Route::middleware('auth')->group(function () {
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/api/history/{id}', [HistoryController::class, 'show'])->name('history.show');
    Route::delete('/api/history/{id}', [HistoryController::class, 'destroy'])->name('history.destroy');
});
