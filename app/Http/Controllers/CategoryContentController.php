<?php

namespace App\Http\Controllers;

use App\Models\CategoryContent;
use Illuminate\Http\Request;


use DB;
use Auth;
use Cache;
use Redirect;
use Validator;
class CategoryContentController extends Controller
{
    
    public function index($category_id)
    {
        $categoryContent = CategoryContent::where('category_id',$category_id)->get();
        if ($categoryContent) {
            return response()->json([
                'message' => 'Successfully fetched all content related to a category with id: '.$category_id,
                'payload' => $categoryContent,
                'status' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Failed to fetch all content related to a category with id: '.$category_id,
                'payload' => $categoryContent,
                'status' => 500,
            ]);
        }
        
    }

    public function fetch($category_id,$id)
    {
        $categoryContent = CategoryContent::where(['category_id'=> $category_id,'id'=>$id])->first();
        if (!Empty($categoryContent)) {
            return response()->json([
                'message' => 'Successfully fetched content related to a category with id: '.$category_id,
                'payload' => $categoryContent,
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

        $categoryContent = new CategoryContent();
        $categoryContent->content = $request->content;
        $categoryContent->status = $request->status;
        $categoryContent->category_id = $request->category_id;
        $categoryContent->user_id = $request->user_id;
        if($categoryContent->save()){
            return response()->json([
                'message' => 'Successfully created content related to a category with id: '.$request->category_id,
                'payload' => $categoryContent,
                'status' => 201,
            ]);
        }else {
            return response()->json([
                'message' => 'Successfully created content related to a category with id: '.$request->category_id,
                'payload' => $categoryContent,
                'status' => 501,
            ]);
        }
    }

    public function update(REQUEST $request,$id)
    {

        $categoryContent = CategoryContent::find($id);
        $categoryContent->content = $request->content;
        $categoryContent->status = $request->status;
        $categoryContent->category_id = $request->category_id;
        $categoryContent->user_id = $request->user_id;
        if($categoryContent->save()){
            return response()->json([
                'message' => 'Successfully updated content related to a category with id: '.$id,
                'payload' => $categoryContent,
                'status' => 201,
            ]);
        }else {
            return response()->json([
                'message' => 'Successfully created content related to a category with id: '.$request->category_id,
                'payload' => $categoryContent,
                'status' => 501,
            ]);
        }
    }

    public function delete($id)
    {

        $categoryContent = CategoryContent::find($id);
        $categoryContent->status = 0;
        if($categoryContent->save()){
            return response()->json([
                'message' => 'Successfully deleted content related to a category with id: '.$id,
                'payload' => $categoryContent,
                'status' => 201,
            ]);
        }else {
            return response()->json([
                'message' => 'Successfully created content related to a category with id: '.$category_id,
                'payload' => $categoryContent,
                'status' => 501,
            ]);
        }
    }

    
}