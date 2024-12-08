<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CommentController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth:api');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update')->middleware('auth:api');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth:api');

Route::get('/dashboard-data', [DashboardController::class, 'getDashboardData'])->middleware(['auth:api']);
