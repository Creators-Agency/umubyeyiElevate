<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Auth;
use Cache;
use Redirect;
use Validator;

use App\Models\ProgramContent;

class ProgramContentController extends Controller
{
   public function index($program_id)
    {
        $ProgramContent = ProgramContent::where('program_id',$program_id)->get();
        if ($ProgramContent) {
            return response()->json([
                'message' => 'Successfully fetched all content related to a category with id: '.$program_id,
                'payload' => $ProgramContent,
                'status' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Failed to fetch all content related to a category with id: '.$program_id,
                'payload' => $ProgramContent,
                'status' => 500,
            ]);
        }
        
    }

    public function fetch($program_id,$id)
    {
        $ProgramContent = ProgramContent::where(['program_id'=> $program_id,'id'=>$id])->first();
        if (!Empty($ProgramContent)) {
            return response()->json([
                'message' => 'Successfully fetched content related to a category with id: '.$program_id,
                'payload' => $ProgramContent,
                'status' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Failed to fetch content',
                'payload' => [],
                'status' => 404,
            ]);
        }
    }

    public function store(REQUEST $request)
    {

        $ProgramContent = new ProgramContent();
        $ProgramContent->content = $request->content;
        $ProgramContent->status = $request->status;
        $ProgramContent->program_id = $request->program_id;
        $ProgramContent->user_id = $request->user_id;
        if($ProgramContent->save()){
            return response()->json([
                'message' => 'Successfully created content related to a category with id: '.$request->program_id,
                'payload' => $ProgramContent,
                'status' => 201,
            ]);
        }else {
            return response()->json([
                'message' => 'Successfully created content related to a category with id: '.$request->program_id,
                'payload' => $ProgramContent,
                'status' => 501,
            ]);
        }
    }

    public function update(REQUEST $request,$id)
    {

        $ProgramContent = ProgramContent::find($id);
        $ProgramContent->content = $request->content;
        $ProgramContent->status = $request->status;
        $ProgramContent->program_id = $request->program_id;
        $ProgramContent->user_id = $request->user_id;
        if($ProgramContent->save()){
            return response()->json([
                'message' => 'Successfully updated content related to a category with id: '.$id,
                'payload' => $ProgramContent,
                'status' => 201,
            ]);
        }else {
            return response()->json([
                'message' => 'Successfully created content related to a category with id: '.$request->program_id,
                'payload' => $ProgramContent,
                'status' => 501,
            ]);
        }
    }

    public function delete($id)
    {

        $ProgramContent = ProgramContent::find($id);
        $ProgramContent->status = 0;
        if($ProgramContent->save()){
            return response()->json([
                'message' => 'Successfully deleted content related to a category with id: '.$id,
                'payload' => $ProgramContent,
                'status' => 201,
            ]);
        }else {
            return response()->json([
                'message' => 'Successfully created content related to a category with id: '.$id,
                'payload' => $ProgramContent,
                'status' => 501,
            ]);
        }
    }
}