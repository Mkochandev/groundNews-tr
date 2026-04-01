<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

Route::get('/', [NewsController::class, 'index'])->name('home');

// Auth pages
Route::view('/giris', 'pages.login')->name('login');
Route::view('/kayit', 'pages.register')->name('register');

// Footer pages
Route::view('/hakkimizda', 'pages.about')->name('about');
Route::view('/metodoloji', 'pages.methodology')->name('methodology');
Route::view('/gizlilik-politikasi', 'pages.privacy')->name('privacy');
Route::view('/iletisim', 'pages.contact')->name('contact');

// News detail route
Route::get('/haber/{id}', [NewsController::class, 'show'])->name('news.show');

// Category routes
Route::get('/gundem',      fn() => app(NewsController::class)->index(request()->merge(['category' => 'gundem'])))->name('category.gundem');
Route::get('/ekonomi',     fn() => app(NewsController::class)->index(request()->merge(['category' => 'ekonomi'])))->name('category.ekonomi');
Route::get('/siyaset',     fn() => app(NewsController::class)->index(request()->merge(['category' => 'siyaset'])))->name('category.siyaset');
Route::get('/dis-politika',fn() => app(NewsController::class)->index(request()->merge(['category' => 'dis-politika'])))->name('category.dis-politika');
Route::get('/yerel',       fn() => app(NewsController::class)->index(request()->merge(['category' => 'yerel'])))->name('category.yerel');
Route::get('/senin-icin',  fn() => app(NewsController::class)->index(request()->merge(['category' => 'senin-icin'])))->name('category.senin-icin');
Route::get('/golge-gundem',fn() => app(NewsController::class)->index(request()->merge(['category' => 'golge-gundem'])))->name('category.golge-gundem');
Route::get('/teknoloji',   fn() => app(NewsController::class)->index(request()->merge(['category' => 'teknoloji'])))->name('category.teknoloji');
Route::get('/spor',        fn() => app(NewsController::class)->index(request()->merge(['category' => 'spor'])))->name('category.spor');
Route::get('/blindspot',   fn() => app(NewsController::class)->index(request()->merge(['category' => 'blindspot'])))->name('category.blindspot');