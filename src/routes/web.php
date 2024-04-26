<?php

use App\Http\Controllers\FortifyController;
use App\Http\Controllers\AtteController;
use App\Http\Controllers\MailSendController;
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

Route::get('/', function () {return redirect('/login');});

Route::get('/attendance', [AtteController::class, 'index'])->middleware('verified');
Route::get('/users', [AtteController::class, 'users'])->middleware('verified');

Route::get('/parsonal', [AtteController::class, 'parsonal'])->middleware('verified');
Route::post('/parsonal', [AtteController::class, 'parsonal'])->middleware('verified');

Route::get('/date', [AtteController::class, 'showdate'])->middleware('verified');
Route::post('/date', [AtteController::class, 'showdate'])->middleware('verified');

Route::post('/startwork', [AtteController::class, 'startwork'])->middleware('verified');
Route::post('/finishwork', [AtteController::class, 'finishwork'])->middleware('verified');
Route::post('/startrest', [AtteController::class, 'startrest'])->middleware('verified');
Route::post('/finishrest', [AtteController::class, 'finishrest'])->middleware('verified');

Route::get('/search', [AtteController::class, 'search'])->middleware('verified');;

Route::get('/mail', [MailSendController::class, 'index'])->middleware('verified');;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
});
