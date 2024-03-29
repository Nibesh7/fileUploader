<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/user-data', 'App\Http\Controllers\UploadController@exportData');



Route::post('/upload-json', 'App\Http\Controllers\UploadController@uploadJson')->name('upload.json');


Route::get('/github', [App\Http\Controllers\Auth\LoginController::class, 'githHub'])->name('github');

Route::get('/callback/github', [App\Http\Controllers\Auth\LoginController::class, 'githHubUser']);

