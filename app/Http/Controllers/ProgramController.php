<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Auth;
use Cache;
use Redirect;
use Validator;

use App\Models\Program;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = Program::get();
        return response()->json([
            'message' => 'Successfuly Fetched all programs',
            'payload' => $programs,
            'status' => 200,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(REQUEST $request)
    {
        /**
         * Validate
         */
        // return $request;
        $program = new Program();
        $program->title=$request->title;
        $program->description=$request->description;
        $program->picture_url=$request->picture_url;
        $program->user_id=$request->user_id;
        $program->status=$request->status;

        if($program->save()){
            return response()->json([
                'message' => 'Successfuly Fetched all programs',
                'payload' => $program,
                'status' => 201,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to create a program',
                'payload' => $request,
                'status' => 501,
            ]);
        }
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch($id)
    {
        $program = Program::find($id);
        if($program){
            return response()->json([
                'message' => 'Successfully fetched a program by ID: '.$id,
                'payload' => $program,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to fetch a program by ID: '.$id,
                'payload' => [],
                'status' => 500,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(REQUEST $request,$id)
    {
        // return $request;
        $updatedProgram = Program::find($id);
        $updatedProgram->title = $request->title;
        $updatedProgram->description = $request->description;
        $updatedProgram->picture_url = $request->picture_url;
        $updatedProgram->status = $request->status;
        $updatedProgram->save();
        if($updatedProgram){
            return response()->json([
                'message' => 'Successfully Updated a program by ID: '.$id,
                'payload' => $updatedProgram,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to update a program by ID: '.$id,
                'payload' => $updatedProgram,
                'status' => 500,
            ]);
        }
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $deleteProgram = Program::find($id);
        $deleteProgram->status=0;
        if($deleteProgram){
            return response()->json([
                'message' => 'Successfully delete a program by id: '.$id,
                'payload' => $deleteProgram,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to delete a program',
                'payload' => array(
                    'id' => $id
                ),
                'status' => 500,
            ]);
        }
    }
}