<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewsController;
use App\Models\Movies;

Route::get('/', function () {
    $movies = Movies::with('genre')
        ->withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->take(8)
        ->get(); // Get first 8 movies
    return view('welcome', compact('movies'));
});

Route::resource('movies', MoviesController::class);
Route::post('movies/{movie}/reviews', [ReviewsController::class, 'store'])->name('movies.reviews.store')->middleware('auth');
Route::resource('bookings', BookingsController::class)->middleware('auth');
Route::post('bookings/{booking}/pay', [BookingsController::class, 'pay'])->name('bookings.pay')->middleware('auth');
Route::post('bookings/{booking}/cancel', [BookingsController::class, 'cancel'])->name('bookings.cancel')->middleware('auth');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
