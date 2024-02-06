<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group([
    'middleware' => ['auth']
], function () {

    Route::get('/note', ([HomeController::class, 'index']))
        ->name('note');

    Route::get('/note/create', ([HomeController::class, 'create']))
        ->name('note.create');
    Route::post('/note/create', ([HomeController::class, 'store']))
        ->name('note.store');

    Route::get('/note/edit/{id}', ([HomeController::class, 'edit']))
        ->name('note.edit');
    Route::put('/note/edit/{id}', ([HomeController::class, 'update']))
        ->name('note.update');

    Route::get('/note/show/{id}', ([HomeController::class, 'show']))
        ->name('note.show');

    Route::get('/note/destroy/{id}', ([HomeController::class, 'destroy']))
        ->name('note.destroy');

    Route::get('/user/logout', ([HomeController::class, 'Logout']))
        ->name('user.logout');

    Route::get('/user/setting',([HomeController::class,'setting']))
           ->name('setting.index');

    Route::post('/user/setting/update',([HomeController::class,'settingUpdate']))
    ->name('setting.update');

    Route::get('/user/password',([HomeController::class,'password']))
    ->name('setting.password');

    Route::post('/user/setting/password',([HomeController::class,'passwordUpdate']))
    ->name('password.update');
});
