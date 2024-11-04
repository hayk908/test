<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PivoteController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

Route::put('/create', [UserController::class, 'create']);

Route::put('/update', [UserController::class, 'update']);

Route::delete('/delete', [UserController::class, 'delete'])
    ->middleware('auth:api');

Route::get('/search', [UserController::class, 'search']);

Route::get('/get', [UserController::class, 'get']);

Route::put('/update_enable/{id}', [UserController::class, 'updateEnable']);

Route::get('/get_all_users', [UserController::class, 'getAllUsers'])
    ->middleware(['checkType', 'auth:api']);

Route::get('/filter', [UserController::class, 'filter']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/create_profile', [ProfileController::class, 'createProfile'])
    ->middleware('auth:api');

Route::get('/get_profile', [ProfileController::class, 'getProfile'])
    ->middleware('auth:api');

Route::get('/get_profile_by_id/{id}', [ProfileController::class, 'getProfileById']);

Route::post('/users/{userId}/posts', [PostsController::class, 'createPost']);

Route::get('/users/{userId}/posts', [PostsController::class, 'getPost']);

Route::post('/users/{user}/category', [CategoryController::class, 'createCategory']);

Route::get('/users/{userId}/category', [CategoryController::class, 'getCategory']);
