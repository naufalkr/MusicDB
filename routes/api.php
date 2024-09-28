<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



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

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);  
    Route::resource('/songs', \App\Http\Controllers\Api\SongController::class);
    Route::resource('/albums', \App\Http\Controllers\Api\AlbumController::class);
    Route::resource('/recordlabels', \App\Http\Controllers\Api\RecordlabelController::class);
    Route::resource('/singers', \App\Http\Controllers\Api\SingerController::class);
    Route::resource('/playlists', \App\Http\Controllers\Api\PlaylistController::class);
    Route::resource('/shows', \App\Http\Controllers\Api\ShowController::class);
    Route::resource('/episodes', \App\Http\Controllers\Api\EpisodeController::class);

});

