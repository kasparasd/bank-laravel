<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController as C;
use App\Http\Controllers\AccountController as A;
use App\Http\Controllers\HomeController as H;


Route::get('/', [H::class, 'index']);

Route::group(['middleware' => 'auth'], function () {

    Route::prefix('clients')->name('clients-')->group(function () {
        Route::get('/', [C::class, 'index'])->name('index');
        Route::get('/create', [C::class, 'create'])->name('create');
        Route::post('/create', [C::class, 'store'])->name('store');
        Route::get('/{client}/edit', [C::class, 'edit'])->name('edit');
        Route::put('/{client}', [C::class, 'update'])->name('update');
        Route::get('/{client}/delete', [C::class, 'delete'])->name('delete');
        Route::delete('/{client}/destroy', [C::class, 'destroy'])->name('destroy');
    });

    Route::prefix('accounts')->name('accounts-')->group(function () {
        Route::get('/create', [A::class, 'create'])->name('create');
        Route::post('/create', [A::class, 'store'])->name('store');
        Route::post('/action', [A::class, 'action'])->name('action');
        Route::get('/{client}/{account}/addFunds', [A::class, 'addFunds'])->name('addFunds');
        Route::post('/{client}/{accountNum}/addFunds', [A::class, 'addFundsPost'])->name('addFundsPost');
        Route::get('/{client}/{account}/withdraw', [A::class, 'withdraw'])->name('withdraw');
        Route::post('/{client}/{accountNum}/withdraw', [A::class, 'withdrawPost'])->name('withdrawPost');
        Route::post('/{client}/{accountNum}/transfer', [A::class, 'transferPost'])->name('transferPost');
        Route::delete('/destroy', [A::class, 'destroy'])->name('destroy');
    });
});
Auth::routes(['register' => false]);
