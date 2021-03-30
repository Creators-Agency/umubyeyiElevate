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

Route::get('/', [CategoryController::class, 'index']);
Route::get('/', [ChatController::class, 'index']);
Route::get('/', [ChatMessageController::class, 'index']);
Route::get('/', [PackageController::class, 'index']);
Route::get('/', [PageController::class, 'index']);
Route::get('/', [PaymentController::class, 'index']);
Route::get('/', [PriviledgeController::class, 'index']);
Route::get('/', [ProgramCategoryController::class, 'index']);
Route::get('/', [ProgramContentController::class, 'index']);
Route::get('/', [ProgramContentUploadController::class, 'index']);
Route::get('/', [ProgramController::class, 'index']);
Route::get('/', [ProgramPackageController::class, 'index']);
Route::get('/', [SubscriptionController::class, 'index']);
Route::get('/', [UserController::class, 'index']);
