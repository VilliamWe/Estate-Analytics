<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExposureController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\UserController;


Route::redirect('/', 'login');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/imports', [ImportController::class, 'index'])->name('imports.index');
    Route::post('/imports/properties', [ImportController::class, 'importProperties'])->name('imports.properties');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');


    Route::get('/comparison', [ComparisonController::class, 'index'])->name('comparison.index');
    Route::get('/comparison/print', [ComparisonController::class, 'print'])->name('comparison.print');
    Route::resource('properties', PropertyController::class);
    Route::get('/properties/{property}/print', [PropertyController::class, 'print'])->name('properties.print');
    Route::resource('exposures', ExposureController::class);
    Route::get('/exposures/{exposure}/print', [ExposureController::class, 'print'])->name('exposures.print');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});

Route::middleware('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
});


require __DIR__ . '/auth.php';
