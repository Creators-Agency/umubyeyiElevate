<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return response()->json([
    //     "message" => "Welcome to Elevate API"
    // ]);
    return view('undermaintenance');
});
// Route::get('admin/category', function () {
//     // return response()->json([
//     //     "message" => "Welcome to Elevate API"
//     // ]);
//     return view('category.add');
// });
Route::prefix('admin/category')->group(function () {
    Route::post('/', [CategoryController::class, 'store'])->name('CreateCategory');
    Route::get('/list', [CategoryController::class, 'index']);
    Route::put('/{id}', [PriviledgeController::class, 'update']);
    Route::delete('/{id}', [PriviledgeController::class, 'destroy']);
});