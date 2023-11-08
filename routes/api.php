<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Notes\NoteController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    });
    Route::group(['middleware' => ['auth:api'], 'namespace' => 'Notes', 'prefix' => 'note'], function () {
        Route::get('/', [NoteController::class, 'list'])->name('api.v1.note.list');
        Route::get('/{note}', [NoteController::class, 'show'])->name('api.v1.note.show');
        Route::post('/', [NoteController::class, 'storeOrUpdate'])->name('api.v1.note.store');
        Route::delete('/{note}', [NoteController::class, 'destroy'])->name('api.v1.note.destroy');
    });
});
