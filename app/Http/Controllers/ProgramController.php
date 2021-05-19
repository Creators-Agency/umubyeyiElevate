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
    public function create(REQUEST $request)
    {
        /**
         * Validate
         */
        $program = new Program();
        $program->title=$request->title;
        $program->description=$request->description;
        $program->picture_url=$request->picture_url;
        $program->status=$request->status;
        $program->user_id=$request->user_id;
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
        $program = Program::where(['id' => $id])->update($request);
        if($program){
            return response()->json([
                'message' => 'Successfully Updated a program by ID: '.$id,
                'payload' => $program,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to update a program by ID: '.$id,
                'payload' => $request,
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
    public function destroy($id)
    {
        $program = Program::where(['id' => $id])->update('status',0);
        if($program){
            return response()->json([
                'message' => 'Successfully delete a program by id: '.$id,
                'payload' => $program,
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