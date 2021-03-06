<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MoviesController;
use App\Http\Controllers\Api\RentController;

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



Route::prefix('auth')->group(function(){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
});


Route::group(['middleware' => 'auth:api'], function(){
    Route::prefix('admin')->group(function(){
        Route::get('user', [MoviesController::class, 'user_list']);
        Route::post('add', [MoviesController::class, 'add_movie']);
        Route::delete('remove/{id_movie}', [MoviesController::class, 'remove_movie']);
    });

    Route::get('/rent/list', [RentController::class, 'rent_list']);
    Route::post('/rent/{id_movie}', [RentController::class, 'rent']);
    Route::delete('/rent/{id_movie}', [RentController::class, 'unrent']);

    Route::get('available', [MoviesController::class, 'get_available']);
    Route::get('available/{id}', [MoviesController::class, 'get_available']);
});

Route::get('new', [MoviesController::class, 'new']);
Route::get('all', [MoviesController::class, 'get_all']);
Route::get('all/{id}', [MoviesController::class, 'get_all']);