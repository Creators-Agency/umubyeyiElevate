<?php

namespace App\Http\Controllers;

use App\Models\ProgramCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Auth;
use Cache;
use Redirect;
use Validator;

class ProgramCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($program_id)
    {
        $ProgramCategory = DB::table('program_categories')
                            ->join('categories','program_categories.category_id','categories.id')
                            ->join('programs','program_categories.program_id','programs.id')
                            ->where('programs.id',$program_id)
                            ->select(
                                'categories.title as categoryTitle',
                                'categories.description as categoryDescription',
                                'categories.status as categoryStatus',
                                'categories.user_id as categoryCreatedBy',
                                'categories.created_at as categoryCreated_at',
                                'categories.updated_at as categoryUpdated_at',
                                'programs.title as programsTitle',
                                'programs.description as programDescription',
                                'programs.picture_url as programPicture_url',
                                'programs.status as programStatus',
                                'programs.user_id as programCreatedBy',
                                'programs.created_at as categoryCreated_at',
                                'programs.updated_at as categoryUpdated_at',
                            )
                            ->get();
        return response()->json([
            'message' => 'Successfuly Fetched all ProgramCategorys',
            'payload' => $ProgramCategory,
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
        $ProgramCategory = new ProgramCategory();
        $ProgramCategory->program_id=$request->program_id;
        $ProgramCategory->category_id=$request->category_id;
        if($ProgramCategory->save()){
            return response()->json([
                'message' => 'Successfuly created Category related to this program',
                'payload' => $ProgramCategory,
                'status' => 201,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to create a Program Category',
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
    public function fetch($program_id,$id)
    {
        $ProgramCategory = DB::table('program_categories')
                            ->join('categories','program_categories.category_id','categories.id')
                            ->join('programs','program_categories.program_id','programs.id')
                            ->where('program_categories.id',$id)
                            ->where('programs.id',$program_id)
                            ->select(
                                'categories.title as categoryTitle',
                                'categories.description as categoryDescription',
                                'categories.status as categoryStatus',
                                'categories.user_id as categoryCreatedBy',
                                'categories.created_at as categoryCreated_at',
                                'categories.updated_at as categoryUpdated_at',
                                'programs.title as programsTitle',
                                'programs.description as programDescription',
                                'programs.picture_url as programPicture_url',
                                'programs.status as programStatus',
                                'programs.user_id as programCreatedBy',
                                'programs.created_at as categoryCreated_at',
                                'programs.updated_at as categoryUpdated_at',
                            )
                            ->first();
        if($ProgramCategory){
            return response()->json([
                'message' => 'Successfully fetched a ProgramCategory by ID: '.$id,
                'payload' => $ProgramCategory,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to fetch a ProgramCategory by ID: '.$id,
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
        $ProgramCategory = ProgramCategory::find($id);
        $ProgramCategory->program_id=$request->program_id;
        $ProgramCategory->category_id=$request->category_id;
        $ProgramCategory->save();
        if($ProgramCategory){
            return response()->json([
                'message' => 'Successfully Updated a ProgramCategory by ID: '.$id,
                'payload' => $ProgramCategory,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to update a ProgramCategory by ID: '.$id,
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
    // public function destroy($id)
    // {
    //     $ProgramCategory =ProgramCategory::find($id);
    //     $ProgramCategory->program_id=$request->program_id;
    //     $ProgramCategory->category_id=$request->category_id;
    //     if($ProgramCategory){
    //         return response()->json([
    //             'message' => 'Successfully delete a ProgramCategory by id: '.$id,
    //             'payload' => $ProgramCategory,
    //             'status' => 200,
    //         ]);
    //     }else{
    //         return response()->json([
    //             'message' => 'Failed to delete a ProgramCategory',
    //             'payload' => array(
    //                 'id' => $id
    //             ),
    //             'status' => 500,
    //         ]);
    //     }
    // }
}