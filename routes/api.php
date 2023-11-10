<?php

use App\Http\Controllers\Api\Admin\Notes\NoteController as AdminNoteController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Notes\NoteController;
use App\Http\Controllers\Api\Notes\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('register', [AuthController::class, 'register'])->name('api.v1.register');
        Route::post('login', [AuthController::class, 'login'])->name('api.v1.login');
        Route::post('logout', [AuthController::class, 'logout'])
            ->middleware('auth:api')
            ->name('api.v1.logout');
    });
    Route::group(['middleware' => ['auth:api'], 'namespace' => 'User', 'prefix' => 'user'], function () {
        Route::get('/{user}', [UserController::class, 'show'])->name('api.v1.user.show');
    });
    Route::group(['middleware' => ['auth:api'], 'namespace' => 'Notes', 'prefix' => 'note'], function () {
        Route::get('/', [NoteController::class, 'list'])->name('api.v1.note.list');
        Route::get('/{note}', [NoteController::class, 'show'])->name('api.v1.note.show');
        Route::post('/', [NoteController::class, 'storeOrUpdate'])->name('api.v1.note.store');
        Route::put('/{note}', [NoteController::class, 'storeOrUpdate'])->name('api.v1.note.update');
        Route::delete('/{note}', [NoteController::class, 'destroy'])->name('api.v1.note.destroy');
    });
    Route::group(['middleware' => ['auth:api'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
        Route::group(['middleware' => ['admin'], 'namespace' => 'Admin', 'prefix' => 'note'], function () {
            Route::get('/', [AdminNoteController::class, 'list'])->name('api.v1.admin.note.list');
            Route::get('/{note}', [AdminNoteController::class, 'show'])->name('api.v1.admin.note.show');
            Route::post('/', [AdminNoteController::class, 'storeOrUpdate'])->name('api.v1.admin.note.store');
            Route::put('/{note}', [AdminNoteController::class, 'storeOrUpdate'])->name('api.v1.admin.note.update');
            Route::delete('/{note}', [AdminNoteController::class, 'destroy'])->name('api.v1.admin.note.destroy');
        });
    });
});
