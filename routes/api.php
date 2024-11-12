<?php

use App\Http\Controllers\CoinGeckoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\CategoryController;

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

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

Route::get('/get', [UserController::class, 'get']);

Route::post('/login', [AuthController::class, 'login']);

Route::put('/update', [UserController::class, 'update']);

Route::get('/filter', [UserController::class, 'filter']);

Route::post('/create', [UserController::class, 'create']);

Route::delete('/delete', [UserController::class, 'delete'])
    ->middleware('auth:api');

Route::get('/users/data', [UserController::class, 'getData']);

Route::get('/get_all_users', [UserController::class, 'getAllUsers'])
    ->middleware(['checkType', 'auth:api']);

Route::get('/get_profile', [ProfileController::class, 'getProfile'])
    ->middleware('auth:api');

Route::get('/weather/city', [WeatherController::class, 'getWeather']);

Route::get('/users/{userId}/posts', [PostsController::class, 'getPost']);

Route::put('/enableUser/{user}', [UserController::class, 'enableUser']);

Route::post('/create_profile', [ProfileController::class, 'createProfile'])
    ->middleware('auth:api');

Route::post('/users/{userId}/posts', [PostsController::class, 'createPost']);

Route::get('/users/{userId}/category', [CategoryController::class, 'getCategory']);

Route::get('/get_profile_by_id/{id}', [ProfileController::class, 'getProfileById']);

Route::post('/users/{user}/category', [CategoryController::class, 'createCategory']);

Route::get('/bitcoin_price', [CoinGeckoController::class, 'getBitcoinPrice']);
