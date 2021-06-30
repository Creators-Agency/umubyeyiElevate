<?php

namespace App\Http\Controllers;

use App\Http\Requests\Testimonial as RequestsTestimonial;
use App\Models\testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonial = testimonial::get();
        if ($testimonial)
        return response()->json([
            "message" => "All testimonial",
            "payload" => $testimonial
        ],Response::HTTP_OK);

        return response()->json([
            "error" => "Failed to fetch all testimonial",
        ],Response::HTTP_INTERNAL_SERVER_ERROR);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestsTestimonial $request)
    {
        $testimonial = new testimonial();
        $testimonial->names=$request->names;
        $testimonial->profession=$request->profession;
        $testimonial->message=$request->message;
        $testimonial->status=$request->status;
        if($testimonial->save()){
            return response()->json([
                "message" => "Testimonial created successfuly",
                "payload" => $request
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "error" => "Failed to create",
            "payload" => $request
        ],Response::HTTP_INTERNAL_SERVER_ERROR);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function show(testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function edit(testimonial $testimonial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, testimonial $testimonial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy(testimonial $testimonial)
    {
        //
    }
}