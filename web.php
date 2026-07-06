<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AiController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Route Dashboard
Route::get('/dashboard', [NewsController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route Admin
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
});

// Route User
Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Interaksi
    Route::post('/bookmark', [InteractionController::class, 'storeBookmark'])->name('bookmark.store');
    Route::post('/comment', [InteractionController::class, 'storeComment'])->name('comment.store');

    // Bookmark
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmark.index');
    Route::delete('/bookmarks/{id}', [BookmarkController::class, 'destroy'])->name('bookmark.destroy');

    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // ===== AI ROUTES =====
    Route::post('/ai/summarize', [AiController::class, 'summarize'])->name('ai.summarize');
    Route::post('/ai/chat',      [AiController::class, 'chat'])->name('ai.chat');
    Route::post('/ai/recommend', [AiController::class, 'recommend'])->name('ai.recommend');
});

require __DIR__.'/auth.php';