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

Route::get('/attendance', [AtteController::class, 'index'])->middleware('auth');
Route::get('/users', [AtteController::class, 'users'])->middleware('auth');
// Route::post('/users', [AtteController::class, 'users'])->middleware('auth');

Route::get('/parsonal', [AtteController::class, 'parsonal'])->middleware('auth');
Route::post('/parsonal', [AtteController::class, 'parsonal'])->middleware('auth');

Route::get('/date', [AtteController::class, 'showdate'])->middleware('auth');
Route::post('/date', [AtteController::class, 'showdate'])->middleware('auth');

Route::post('/startwork', [AtteController::class, 'startwork'])->middleware('auth');;
Route::post('/finishwork', [AtteController::class, 'finishwork'])->middleware('auth');;
Route::post('/startrest', [AtteController::class, 'startrest'])->middleware('auth');;
Route::post('/finishrest', [AtteController::class, 'finishrest'])->middleware('auth');;

Route::get('/search', [AtteController::class, 'search']);

Route::get('/mail', [MailSendController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
