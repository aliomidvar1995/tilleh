<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
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

Route::apiResource('/news', NewsController::class)->only(['index', 'show', 'store', 'update']);

Route::post('/comments', [CommentController::class, 'store']);

Route::put('/comments/{comment}', [CommentController::class, 'update']);

Route::get('/news/{news}/comments', [CommentController::class, 'index']);