<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return response()->json([
    //     "message" => "Welcome to Elevate API"
    // ]);
    return view('dashboard');
});
Route::get('/category', function () {
    // return response()->json([
    //     "message" => "Welcome to Elevate API"
    // ]);
    return view('category.add');
});