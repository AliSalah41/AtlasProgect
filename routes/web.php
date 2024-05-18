<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/form', function () {
    return view('form');
})->name('form');
Route::get('/index', function () {
    return view('pages.model.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
//     Route::resource('area', \App\Http\Controllers\AreaController::class);
//     Route::resource('category', \App\Http\Controllers\CategoryController::class);
//     Route::resource('section', \App\Http\Controllers\SectionController::class);
// Route::resource('company', \App\Http\Controllers\CompanyController::class);
// Route::resource('product', \App\Http\Controllers\ProductController::class);

Route::resource('album', AlbumController::class);
Route::post('/upload-image', [AlbumController::class,'uploadImage'])->name('upload-image');
Route::delete('/albums/{id}', [AlbumController::class, 'deleteWithImages'])->name('albums.deleteWithImages');
Route::post('/albums/{album}/move-images', [AlbumController::class, 'moveImages'])->name('albums.move-images');

Route::get('/api/albums', [AlbumController::class, 'getAllAlbums']);
});
require __DIR__.'/auth.php';
