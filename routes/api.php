<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [UserController::class, 'login']);
Route::post('create/user', [UserController::class, 'createUser']);
Route::get('show/user/{id}', [UserController::class, 'showUserId']);
Route::post('create/product', [ProductController::class, 'createProduct']);
Route::get('show/produk', [ProductController::class, 'showProduct']);
