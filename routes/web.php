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

Route::get('/dev-1234',function()
    {
        $alldata=[];

        Schema::table('menus', function($table) use ($alldata)
        {
            /**
             * payouts
             * solar_panels
             */

            // $table->longText('description')->after('menu_name');
            // $table->dropUnique(['clientNames'])->unique(false)->change();
            $table->longText('description')->change();
            // $table->integer('moreInfo')->after('status')->default(0);
        });
    }
);