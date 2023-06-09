<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


//autenticado
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::post('links', [LinkController::class, 'store'])->name('links.store');
    Route::get('/links', [LinkController::class, 'list'])->name('links.list');

    Route::delete('/links/{id}', [LinkController::class, 'destroy'])->name('links.destroy');
    Route::put('/links/{id}', [LinkController::class, 'update'])->name('links.update');
    Route::get('/links/{id}', [LinkController::class, 'show'])->name('links.show');
});
