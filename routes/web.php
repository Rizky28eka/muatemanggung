<?php

use App\Http\Controllers\Guest\HomeController;
use Illuminate\Support\Facades\Route;

// Guest
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rekomendasi', fn() => 'Form rekomendasi — coming soon')->name('recommendation.form');
Route::get('/mua/{slug}', fn($slug) => 'Detail MUA — coming soon')->name('mua.show');

// Admin placeholder routes (for layout links)
Route::get('/admin/dashboard', fn() => 'Admin dashboard — coming soon')->name('admin.dashboard');
Route::post('/admin/logout', fn() => 'Logout')->name('admin.logout');
Route::get('/admin/mua', fn() => '')->name('admin.mua.index');
Route::get('/admin/master/districts', fn() => '')->name('admin.master.districts.index');
Route::get('/admin/master/event-types', fn() => '')->name('admin.master.event-types.index');
Route::get('/admin/master/themes', fn() => '')->name('admin.master.themes.index');
Route::get('/admin/master/makeup-looks', fn() => '')->name('admin.master.makeup-looks.index');
Route::get('/admin/monitoring/searches', fn() => '')->name('admin.monitoring.searches');

// MUA placeholder routes (for layout links)
Route::get('/mua/dashboard', fn() => '')->name('mua.dashboard');
Route::post('/mua/logout', fn() => '')->name('mua.logout');
Route::get('/mua/profil', fn() => '')->name('mua.profile.edit');
Route::get('/mua/paket', fn() => '')->name('mua.packages.index');
Route::get('/mua/portofolio', fn() => '')->name('mua.portfolio.index');
Route::get('/mua/lokasi', fn() => '')->name('mua.location.edit');
