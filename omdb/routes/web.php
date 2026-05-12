<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\controlpanel\dashboardController;
use Illuminate\Support\Facades\Route;

// Routing untuk Auth
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'register_process'])->name('signup');
Route::post('/login', [AuthController::class, 'login'])->name('signin');
Route::post('/logout', [AuthController::class, 'logout'])->name('signout');



// Route::get('/panel_control', function () {
//     return view('panel_control.dashboard');
// });

// Route::get('/My', function () {
//     return view('panel_control.My');
// });

//route group for admin
Route::prefix('panel_control')->group(function () {
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard'); 
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('setlocale');