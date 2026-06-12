<?php

use App\Http\Controllers\Guest\HomeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Guest\RecommendationController;
use App\Http\Controllers\Guest\MuaDetailController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MuaRegisterController;
use App\Http\Controllers\Mua\DashboardController as MuaDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Mua\ProfileController as MuaProfileController;
use App\Http\Controllers\Mua\LocationController as MuaLocationController;
use App\Http\Controllers\Mua\PackageController as MuaPackageController;
use App\Http\Controllers\Mua\PortfolioController as MuaPortfolioController;
use App\Http\Controllers\Admin\MuaController as AdminMuaController;
use App\Http\Controllers\Admin\SearchLogController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\NotificationController;

// Guest
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rekomendasi', [RecommendationController::class, 'form'])->name('recommendation.form');
Route::post('/rekomendasi', [RecommendationController::class, 'recommend'])->name('recommendation.process');
Route::get('/rekomendasi/hasil', [RecommendationController::class, 'results'])->name('guest.recommendation.results');

// Authentication
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// MUA Registration
Route::get('/register', [MuaRegisterController::class, 'showRegister'])->name('mua.register');
Route::post('/register', [MuaRegisterController::class, 'register'])->name('mua.register.process');

// Compatibility aliases
Route::get('/admin/login', fn() => redirect()->route('login'))->name('admin.login');
Route::get('/mua/login', fn() => redirect()->route('login'))->name('mua.login');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');
Route::post('/mua/logout', [LoginController::class, 'logout'])->name('mua.logout');

// Authentication-protected routes
Route::middleware(['auth'])->group(function () {

    // Notifications (shared between admin & mua)
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifikasi/{id}/baca', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifikasi/baca-semua', [NotificationController::class, 'readAll'])->name('notifications.read-all');

    // Admin Group
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        // MUA management CRUD
        Route::get('/admin/mua', [AdminMuaController::class, 'index'])->name('admin.mua.index');
        Route::get('/admin/mua/tambah', [AdminMuaController::class, 'create'])->name('admin.mua.create');
        Route::post('/admin/mua/tambah', [AdminMuaController::class, 'store'])->name('admin.mua.store');
        Route::post('/admin/mua/{mua}/approve', [AdminMuaController::class, 'approve'])->name('admin.mua.approve');
        Route::delete('/admin/mua/{mua}/reject', [AdminMuaController::class, 'reject'])->name('admin.mua.reject');
        Route::get('/admin/mua/{mua}', [AdminMuaController::class, 'show'])->name('admin.mua.show');
        Route::get('/admin/mua/{mua}/edit', [AdminMuaController::class, 'edit'])->name('admin.mua.edit');
        Route::put('/admin/mua/{mua}', [AdminMuaController::class, 'update'])->name('admin.mua.update');
        Route::delete('/admin/mua/{mua}', [AdminMuaController::class, 'destroy'])->name('admin.mua.destroy');
        Route::post('/admin/mua/{mua}/toggle', [AdminMuaController::class, 'toggleActive'])->name('admin.mua.toggle');

        // Monitoring
        Route::get('/admin/monitoring', [MonitoringController::class, 'index'])->name('admin.monitoring.index');
        Route::get('/admin/monitoring/searches', [SearchLogController::class, 'index'])->name('admin.monitoring.searches');

        // Master Data
        Route::get('/admin/master', [MasterDataController::class, 'index'])->name('admin.master.index');

        Route::post('/admin/master/districts', [MasterDataController::class, 'districtsStore'])->name('admin.master.districts.store');
        Route::delete('/admin/master/districts/{district}', [MasterDataController::class, 'districtsDestroy'])->name('admin.master.districts.destroy');

        Route::post('/admin/master/event-types', [MasterDataController::class, 'eventTypesStore'])->name('admin.master.event-types.store');
        Route::delete('/admin/master/event-types/{eventType}', [MasterDataController::class, 'eventTypesDestroy'])->name('admin.master.event-types.destroy');

        Route::post('/admin/master/themes', [MasterDataController::class, 'themesStore'])->name('admin.master.themes.store');
        Route::delete('/admin/master/themes/{theme}', [MasterDataController::class, 'themesDestroy'])->name('admin.master.themes.destroy');

        Route::post('/admin/master/theme-types', [MasterDataController::class, 'themeTypesStore'])->name('admin.master.theme-types.store');
        Route::delete('/admin/master/theme-types/{themeType}', [MasterDataController::class, 'themeTypesDestroy'])->name('admin.master.theme-types.destroy');

        Route::post('/admin/master/makeup-looks', [MasterDataController::class, 'makeupLooksStore'])->name('admin.master.makeup-looks.store');
        Route::delete('/admin/master/makeup-looks/{makeupLook}', [MasterDataController::class, 'makeupLooksDestroy'])->name('admin.master.makeup-looks.destroy');

        Route::post('/admin/master/price-ranges', [MasterDataController::class, 'priceRangesStore'])->name('admin.master.price-ranges.store');
        Route::delete('/admin/master/price-ranges/{priceRange}', [MasterDataController::class, 'priceRangesDestroy'])->name('admin.master.price-ranges.destroy');

        Route::post('/admin/master/package-templates', [MasterDataController::class, 'packageTemplatesStore'])->name('admin.master.package-templates.store');
        Route::delete('/admin/master/package-templates/{packageTemplate}', [MasterDataController::class, 'packageTemplatesDestroy'])->name('admin.master.package-templates.destroy');
    });

    // MUA Group
    Route::middleware(['mua'])->group(function () {
        Route::get('/mua/dashboard', [MuaDashboardController::class, 'index'])->name('mua.dashboard');
        Route::get('/mua/profil', [MuaProfileController::class, 'edit'])->name('mua.profile.edit');
        Route::post('/mua/profil', [MuaProfileController::class, 'update'])->name('mua.profile.update');
        Route::get('/mua/lokasi', [MuaLocationController::class, 'edit'])->name('mua.location.edit');
        Route::post('/mua/lokasi', [MuaLocationController::class, 'update'])->name('mua.location.update');

        // Packages CRUD
        Route::get('/mua/paket', [MuaPackageController::class, 'index'])->name('mua.packages.index');
        Route::post('/mua/paket', [MuaPackageController::class, 'store'])->name('mua.packages.store');
        Route::put('/mua/paket/{package}', [MuaPackageController::class, 'update'])->name('mua.packages.update');
        Route::delete('/mua/paket/{package}', [MuaPackageController::class, 'destroy'])->name('mua.packages.destroy');

        // Portfolio CRUD
        Route::get('/mua/portofolio', [MuaPortfolioController::class, 'index'])->name('mua.portfolio.index');
        Route::post('/mua/portofolio', [MuaPortfolioController::class, 'store'])->name('mua.portfolio.store');
        Route::delete('/mua/portofolio/{portfolio}', [MuaPortfolioController::class, 'destroy'])->name('mua.portfolio.destroy');
    });

});


// MUA public detail page
Route::get('/mua/{slug}', [MuaDetailController::class, 'show'])->name('mua.show');
