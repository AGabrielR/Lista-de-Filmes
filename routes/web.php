<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/redirect', [App\Http\Controllers\SocialAuthFacebookController::class, 'redirect'])->name('facebook.redirect');

Route::get('/callback', [App\Http\Controllers\SocialAuthFacebookController::class, 'callback'])->name('facebook.callback');

Route::get('/', [App\Http\Controllers\MoviesController::class, 'index'])->name('movies.index');

Route::post('/movies', [App\Http\Controllers\MoviesController::class, 'find'])->name('movies.find');

Auth::routes();

Route::get('/home', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.change')->middleware('auth');

Route::get('/profile/create',[App\Http\Controllers\ProfileController::class, 'create'])->name('profile.create')->middleware('auth');

Route::post('/profile/logout',[App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.exit')->middleware('auth');

Route::post('/profile/access/{id}',[App\Http\Controllers\ProfileController::class, 'accessProfile'])->name('profile.access')->middleware('auth');

Route::post('/profile',[App\Http\Controllers\ProfileController::class, 'store'])->name('profile.store')->middleware('auth');



Route::post('/list/add',[App\Http\Controllers\ListController::class, 'store'])->name('list.store')->middleware('auth');

Route::get('/list/movies',[App\Http\Controllers\ListController::class, 'show'])->name('list.movies')->middleware('auth');

Route::post('/watched/movies/add',[App\Http\Controllers\ListController::class, 'update'])->name('add.watched')->middleware('auth');

Route::get('/watched/movies/',[App\Http\Controllers\ListController::class, 'watched'])->name('list.watched')->middleware('auth');

Route::get('/profile/edit/{id}',[App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');

Route::delete('/profile/destroy/{id}',[App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('auth');
