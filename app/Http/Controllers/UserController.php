<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Auth;
use Cache;
use Redirect;
use Validator;

use App\Models\User;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function h()
    {
        return response()->json([
            "message" => "Welcome to Elevate API - User"
        ]);
    }

    public function index()
    {
        $users = DB::table('users')
                    ->join('priviledges','users.priviledge','priviledges.id')
                    ->where('priviledges.')
                    ->get();
        if ($users) {
            return response()->json([
                "message" => "expert",
                "payload" => $users
            ],Response::HTTP_OK);
        }
        return response()->json([
            "error" => "Oops! contact system admin",
        ],Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json([
            "message" => "Welcome to Elevate API - User"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            "message" => "Welcome to Elevate API - User"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json([
            "message" => "Welcome to Elevate API - User"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return response()->json([
            "message" => "Welcome to Elevate API - User"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json([
            "message" => "Welcome to Elevate API - User"
        ]);
    }
}