<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PriviledgeController;
use App\Http\Controllers\ProgramCategoryController;
use App\Http\Controllers\ProgramContentController;
use App\Http\Controllers\ProgramContentUploadController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProgramPackageController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return response()->json([
        "message" => "Welcome to Elevate API"
    ]);
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/chats', [ChatController::class, 'index']);
Route::get('/chat-messages', [ChatMessageController::class, 'index']);
Route::get('/packages', [PackageController::class, 'index']);
Route::get('/pages', [PageController::class, 'index']);
Route::get('/payments', [PaymentController::class, 'index']);

Route::prefix('priviledges')->group(function () {
    Route::get('/', [PriviledgeController::class, 'index']);
    Route::get('/{id}', [PriviledgeController::class, 'show']);
    Route::post('/', [PriviledgeController::class, 'store']);
    Route::put('/{id}', [PriviledgeController::class, 'update']);
    Route::delete('/{id}', [PriviledgeController::class, 'destroy']);
});

Route::get('/program-categories', [ProgramCategoryController::class, 'index']);
Route::get('/program-contents', [ProgramContentController::class, 'index']);
Route::get('/program-content-uploads', [ProgramContentUploadController::class, 'index']);
Route::get('/programs', [ProgramController::class, 'index']);
Route::get('/program-packages', [ProgramPackageController::class, 'index']);
Route::get('/subscriptions', [SubscriptionController::class, 'index']);
Route::get('/users', [UserController::class, 'index']);
