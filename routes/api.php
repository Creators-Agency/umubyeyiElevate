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

Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

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

Route::prefix('programs')->group(function () {
    Route::get('/', [CompanyController::class, 'list']);
    Route::get('/{id}', [CompanyController::class, 'fetch']);
    Route::post('/', [CompanyController::class, 'store']);
    Route::put('/{id}', [CompanyController::class, 'update']);
    Route::delete('/{id}', [CompanyController::class, 'delete']);
});
Route::prefix('categories')->group(function () {
    Route::get('/{programs_id}/view/', [ProgramCategoryController::class, 'list']);
    Route::get('/{programs_id}/view/{id}', [ProgramCategoryController::class, 'fetch']);
    Route::post('/', [ProgramCategoryController::class, 'store']);
    Route::put('/{id}', [ProgramCategoryController::class, 'update']);
    Route::delete('/{id}', [ProgramCategoryController::class, 'delete']);
});

Route::prefix('contents')->group(function () {
    Route::get('/{programs_id}/view/', [ProgramContentController::class, 'list']);
    Route::get('/{programs_id}/view/{id}', [ProgramContentController::class, 'fetch']);
    Route::post('/', [ProgramContentController::class, 'store']);
    Route::put('/{id}', [ProgramContentController::class, 'update']);
    Route::delete('/{id}', [ProgramContentController::class, 'delete']);
});

Route::prefix('packages')->group(function () {
    Route::get('/{programs_id}/view/', [ProgramPackageController::class, 'list']);
    Route::get('/{programs_id}/view/{id}', [ProgramPackageController::class, 'fetch']);
    Route::post('/', [ProgramPackageController::class, 'store']);
    Route::put('/{id}', [ProgramPackageController::class, 'update']);
    Route::delete('/{id}', [ProgramPackageController::class, 'delete']);
});

// Route::prefix('packages')->group(function () {
//     Route::get('/{programs_id}/view/', [PackageController::class, 'list']);
//     Route::get('/{programs_id}/view/{id}', [PackageController::class, 'fetch']);
//     Route::post('/', [PackageController::class, 'store']);
//     Route::put('/{id}', [PackageController::class, 'update']);
//     Route::delete('/{id}', [PackageController::class, 'delete']);
// });

Route::prefix('uploads')->group(function () {
    Route::get('/{programs_id}/view/{content_id}/view', [ProgramContentUploadController::class, 'list']);
    Route::get('/{programs_id}/view/{content_id}/view/{id}', [ProgramContentUploadController::class, 'fetch']);
    Route::post('/', [ProgramContentUploadController::class, 'store']);
    Route::put('/{id}', [ProgramContentUploadController::class, 'update']);
    Route::delete('/{id}', [ProgramContentUploadController::class, 'delete']);
});

Route::get('/program-categories', [ProgramCategoryController::class, 'index']);
Route::get('/program-contents', [ProgramContentController::class, 'index']);
Route::get('/program-content-uploads', [ProgramContentUploadController::class, 'index']);
Route::get('/programs', [ProgramController::class, 'index']);
Route::get('/program-packages', [ProgramPackageController::class, 'index']);
Route::get('/subscriptions', [SubscriptionController::class, 'index']);
Route::get('/users', [UserController::class, 'index']);