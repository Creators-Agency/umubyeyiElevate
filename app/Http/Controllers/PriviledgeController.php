<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Auth;
use Cache;
use Redirect;
use Validator;

use App\Models\Priviledge;

class PriviledgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $priviledges = Priviledge::all();
        return response()->json([
            "message" => "Data Found - Priviledge",
            "payload" => $priviledges
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            "message" => "Welcome to Elevate API - Priviledge"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $priviledge = new Priviledge();
        $priviledge->title = request()->title;
        $priviledge->status = request()->status;
        $priviledge->save();

        return response()->json([
            "message" => "Data Created - Priviledge",
            "payload" => $priviledge
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
        $priviledge = Priviledge::find($id);

        return response()->json([
            "message" => "Data Found - Priviledge",
            "payload" => $priviledge
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
            "message" => "Welcome to Elevate API - Priviledge"
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
        $priviledge = Priviledge::find($id);
        $priviledge->title = request()->title;
        $priviledge->status = request()->status;
        $priviledge->save();

        return response()->json([
            "message" => "Data Updated - Priviledge",
            "payload" => $priviledge
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
        $priviledge = Priviledge::find($id);
        $priviledge->delete();

        return response()->json([
            "message" => "Data Deleted - Priviledge"
        ]);
    }
}
