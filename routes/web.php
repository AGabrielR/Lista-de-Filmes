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

Route::get('/', [App\Http\Controllers\MoviesController::class, 'index'])->name('movies.index');

Route::post('/movies', [App\Http\Controllers\MoviesController::class, 'find'])->name('movies.find');

Auth::routes();

Route::get('/profile/change', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.change')->middleware('auth');;

Route::get('/profile/create',[App\Http\Controllers\ProfileController::class, 'create'])->name('profile.create')->middleware('auth');;

Route::post('/profile/{id}',[App\Http\Controllers\ProfileController::class, 'accessProfile'])->name('profile.access')->middleware('auth');;

Route::post('/profile',[App\Http\Controllers\ProfileController::class, 'store'])->name('profile.store')->middleware('auth');;

Route::get('/profile/edit/{id}',[App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');;

Route::put('/profile/update/{id}','ProfileController@update')->name('profile.update')->middleware('auth');;

Route::delete('/profile/destroy/{id}',[App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('auth');;
