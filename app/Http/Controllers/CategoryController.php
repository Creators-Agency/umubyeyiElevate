<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Auth;
use Cache;
use Redirect;
use Validator;

use App\Models\Category;

class CategoryController extends Controller
{
    ublic function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','fetch']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = category::get();
        return response()->json([
            'message' => 'Successfuly Fetched all categorys',
            'payload' => $categories,
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
        $category = new Category();
        $category->title=$request->title;
        $category->description=$request->description;
        $category->status=$request->status;
        $category->user_id=$request->user_id;
        if($category->save()){
            $category = Category::orderBy('id','DESC')->first();
            return response()->json([
                'message' => 'Successfuly Fetched all categorys',
                'payload' => $category,
                'status' => 201,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to create a category',
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
        $category = Category::find($id);
        if($category){
            return response()->json([
                'message' => 'Successfully fetched a category by ID: '.$id,
                'payload' => $category,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to fetch a category by ID: '.$id,
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
        $category = Category::find($id);
        $category->title = $request->title;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->save();
        if($category){
            return response()->json([
                'message' => 'Successfully Updated a category by ID: '.$id,
                'payload' => $category,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to update a category by ID: '.$id,
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
    public function delete($id)
    {
        $category = Category::find($id);
        $category->status = 0;
        $category->save();
        if($category){
            return response()->json([
                'message' => 'Successfully delete a category by id: '.$id,
                'payload' => $category,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to delete a category',
                'payload' => array(
                    'id' => $id
                ),
                'status' => 500,
            ]);
        }
    }
}