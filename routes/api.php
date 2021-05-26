<?php

use App\Http\Controllers\CategoryContentController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MessageController;
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

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('register', 'AuthController@register');
    Route::post('profile', 'AuthController@me');

});

Route::prefix('pages')->group(function () {
    Route::get('/', [PageController::class, 'index']);
    Route::get('/view/{id}', [PageController::class, 'fetch']);
    Route::post('/', [PageController::class, 'store']);
    Route::put('/{id}', [PageController::class, 'update']);
    Route::delete('/{id}', [PageController::class, 'delete']);
});

Route::prefix('priviledges')->group(function () {
    Route::get('/', [PriviledgeController::class, 'index']);
    Route::get('/{id}', [PriviledgeController::class, 'show']);
    Route::post('/', [PriviledgeController::class, 'store']);
    Route::put('/{id}', [PriviledgeController::class, 'update']);
    Route::delete('/{id}', [PriviledgeController::class, 'destroy']);
});

Route::prefix('menus')->group(function () {
    Route::get('/{program_id}/view/', [MenuController::class, 'index']);
    Route::get('/{program_id}/view/{id}', [MenuController::class, 'show']);
    Route::post('/', [MenuController::class, 'store']);
    Route::put('/{id}', [MenuController::class, 'update']);
    Route::delete('/{id}', [MenuController::class, 'destroy']);
});


Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController ::class, 'index']);
    Route::get('/{id}', [CategoryController::class, 'fetch']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'delete']);
});
Route::prefix('programs')->group(function () {
    Route::get('/', [ProgramController::class, 'index']);
    Route::get('/{id}', [ProgramController::class, 'fetch']);
    Route::post('/', [ProgramController::class, 'store']);
    Route::put('/{id}', [ProgramController::class, 'update']);
    Route::delete('/{id}', [ProgramController::class, 'delete']);
});
Route::prefix('categories')->group(function () {
    Route::get('/{program_id}/view/', [ProgramCategoryController::class, 'index']);
    Route::get('/{program_id}/view/{id}', [ProgramCategoryController::class, 'fetch']);
    Route::post('/', [ProgramCategoryController::class, 'store']);
    Route::put('/{id}', [ProgramCategoryController::class, 'update']);
    Route::delete('/{id}', [ProgramCategoryController::class, 'delete']);
});

Route::prefix('contents')->group(function () {
    Route::get('/category/{category_id}/view/', [CategoryContentController::class, 'index']);
    Route::get('/category/{category_id}/view/{id}', [CategoryContentController::class, 'fetch']);
    Route::post('/category', [CategoryContentController::class, 'store']);
    Route::put('/{id}/category', [CategoryContentController::class, 'update']);
    Route::delete('/{id}/category', [CategoryContentController::class, 'delete']);

    Route::get('/program/{program_id}/view/', [ProgramContentController::class, 'index']);
    Route::get('/program/{program_id}/view/{id}', [ProgramContentController::class, 'fetch']);
    Route::post('/program', [ProgramContentController::class, 'store']);
    Route::put('/{id}/program', [ProgramContentController::class, 'update']);
    Route::delete('/{id}/program', [ProgramContentController::class, 'delete']);
});

Route::prefix('packages')->group(function () {
    Route::get('/', [PackageController::class, 'index']);
    Route::get('/view/{id}', [PackageController::class, 'fetch']);
    Route::post('/', [PackageController::class, 'store']);
    Route::put('/{id}', [PackageController::class, 'update']);
    Route::delete('/{id}', [PackageController::class, 'delete']);
});

Route::prefix('package')->group(function () {
    Route::get('/{program_id}/view/', [ProgramPackageController::class, 'index']);
    Route::get('/{program_id}/view/{id}', [ProgramPackageController::class, 'fetch']);
    Route::post('/', [ProgramPackageController::class, 'store']);
    Route::put('/{id}', [ProgramPackageController::class, 'update']);
    Route::delete('/{id}', [ProgramPackageController::class, 'delete']);
});

Route::prefix('subscriptions')->group(function () {
    Route::get('/{package_id}/view/', [SubscriptionController::class, 'index']);
    Route::get('/{package_id}/view/{id}', [SubscriptionController::class, 'fetch']);
    Route::post('/', [SubscriptionController::class, 'store']);
    Route::put('/{id}', [SubscriptionController::class, 'update']);
    Route::delete('/{id}', [SubscriptionController::class, 'delete']);
});

Route::prefix('chats')->group(function () {
    Route::get('/{program_id}/view/', [ChatController::class, 'index']);
    Route::get('/{program_id}/view/{id}', [ChatController::class, 'fetch']);
    Route::post('/', [ChatController::class, 'store']);
    Route::put('/{id}', [ChatController::class, 'update']);
    Route::delete('/{id}', [ChatController::class, 'delete']);
});

Route::prefix('messages')->group(function () {
    Route::get('/{chat_id}/view', [MessageController::class, 'index']);
    Route::get('/{chat_id}/view/{id}', [MessageController::class, 'fetch']);
    Route::post('/', [MessageController::class, 'store']);
    Route::put('/{id}', [MessageController::class, 'update']);
    Route::delete('/{id}', [MessageController::class, 'delete']);
});

Route::prefix('uploads')->group(function () {
    Route::get('/{program_id}/view/{content_id}/view', [ProgramContentUploadController::class, 'index']);
    Route::get('/{program_id}/view/{content_id}/view/{id}', [ProgramContentUploadController::class, 'fetch']);
    Route::post('/', [ProgramContentUploadController::class, 'store']);
    Route::put('/{id}', [ProgramContentUploadController::class, 'update']);
    Route::delete('/{id}', [ProgramContentUploadController::class, 'delete']);
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'analyticsData']);
    Route::get('/transactions', [DashboardController::class, 'transactions']);
    Route::get('/categories', [DashboardController::class, 'categories']);
    Route::get('/analytics', [DashboardController::class, 'analytics']);
});


// Route::get('/program-categories', [ProgramCategoryController::class, 'index']);
// Route::get('/program-contents', [ProgramContentController::class, 'index']);
// Route::get('/program-content-uploads', [ProgramContentUploadController::class, 'index']);
// Route::get('/programs', [ProgramController::class, 'index']);
// Route::get('/program-packages', [ProgramPackageController::class, 'index']);
// Route::get('/subscriptions', [SubscriptionController::class, 'index']);
Route::post('/callback', [SubscriptionController::class, 'paymentCallBack']);
Route::get('/users', [UserController::class, 'index']);
// Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/chats', [ChatController::class, 'index']);
Route::get('/chat-messages', [ChatMessageController::class, 'index']);
// Route::get('/packages', [PackageController::class, 'index']);
Route::get('/pages', [PageController::class, 'index']);
Route::get('/payments', [PaymentController::class, 'index']);