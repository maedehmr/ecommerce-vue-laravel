<?php

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

Route::get('/all-posts',  [App\Http\Controllers\Api\ApiController::class, 'allPost']);
Route::get('/get-letter',  [App\Http\Controllers\Api\ApiController::class, 'getLetter']);
Route::get('/movie/{PostSlug}',  [App\Http\Controllers\Api\ApiController::class, 'single']);
Route::get('/site-header',  [App\Http\Controllers\Api\ApiController::class, 'siteHeader']);
Route::get('/category/{CategorySlug}',  [App\Http\Controllers\Api\ApiController::class, 'archives']);
