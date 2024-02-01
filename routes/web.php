<?php

use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController AS C;
use App\Http\Controllers\AccountController AS A;

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

Route::prefix('clients')->name('clients-')->group(function () {
    Route::get('/', [C::class, 'index'])->name('index');
    Route::get('/create', [C::class, 'create'])->name('create');
    Route::post('/create', [C::class, 'store'])->name('store');
    Route::get('/{client}/edit', [C::class, 'edit'])->name('edit');
    Route::put('/{client}', [C::class, 'update'])->name('update');
    // Route::get('/{client}/add', [C::class, 'add'])->name('add');
    // Route::get('/{client}/withdraw', [C::class, 'withdraw'])->name('withdraw');
});

Route::prefix('accounts')->name('accounts-')->group(function(){
    Route::get('/create', [A::class, 'create'])->name('create');
    Route::post('/create', [A::class, 'store'])->name('store');
    Route::get('/{account}/processFunds', [A::class, 'processFunds'])->name('processFunds');
    // Route::post('/processFunds', [A::class, 'processFunds'])->name('processFunds');
});

Route::get('/', function () {
    return view('layouts.app');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
