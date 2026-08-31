<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::get('/', [PostController::class, 'home'])->name('home');
Route::get('/blog/{post}', [PostController::class, 'show'])->name('posts.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterPage'])->name('register');
    Route::get('/register-page', [AuthController::class, 'showRegisterPage'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
    Route::get('/login-page', [AuthController::class, 'showLoginPage'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/create', [PostController::class, 'createPage'])->name('create');
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::get('/{post}/edit', [PostController::class, 'editPage'])->name('edit');
        Route::put('/{post}', [PostController::class, 'update'])->name('update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
        Route::delete('/images/{id}', [PostController::class, 'deleteImage'])->name('images.destroy');
    });
});

Route::get('/migrate-db', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $migrateOutput = \Illuminate\Support\Facades\Artisan::output();

        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $seedOutput = \Illuminate\Support\Facades\Artisan::output();

        return response('<div style="font-family:sans-serif;padding:30px;background:#ecfdf5;color:#065f46;border-radius:12px;margin:20px;border:1px solid #a7f3d0;">'
            . '<h2 style="margin-top:0;">✅ Database Migrated & Seeded Successfully on Supabase!</h2>'
            . '<pre style="background:#064e3b;color:#d1fae5;padding:15px;border-radius:8px;font-size:13px;line-height:1.5;">' . htmlspecialchars($migrateOutput . "\n" . $seedOutput) . '</pre>'
            . '<a href="/" style="display:inline-block;margin-top:15px;padding:10px 20px;background:#10b981;color:white;text-decoration:none;border-radius:8px;font-weight:bold;">Go to Homepage &rarr;</a>'
            . '</div>');
    } catch (\Throwable $e) {
        return response('<div style="font-family:sans-serif;padding:30px;background:#fff1f2;color:#9f1239;border-radius:12px;margin:20px;border:1px solid #fecdd3;">'
            . '<h2 style="margin-top:0;">❌ Migration Error</h2>'
            . '<pre style="background:#881337;color:#ffe4e6;padding:15px;border-radius:8px;">' . htmlspecialchars($e->getMessage()) . '</pre>'
            . '</div>', 500);
    }
});
