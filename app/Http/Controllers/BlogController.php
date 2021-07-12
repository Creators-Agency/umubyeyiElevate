<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlogController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['fetch','index','list']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $Blogs = Blog::get();
        return response()->json([
            'message' => 'Successfuly Fetched all Blogs',
            'payload' => $Blogs,
            'status' => 200,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        $Blog = new Blog();
        $Blog->title=$request->title;
        $Blog->description=$request->description;
        $Blog->picture_url=$request->picture_url;
        $Blog->user_id=$request->user_id;
        $Blog->status=$request->status;

        if($Blog->save()){
            return response()->json([
                'message' => 'Successfuly Fetched all Blogs',
                'payload' => $Blog,
            ],Response::HTTP_CREATED);
        }else{
            return response()->json([
                'message' => 'Failed to create a Blog',
                'payload' => $request,
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
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
        $Blog = Blog::find($id);
        if($Blog){
            return response()->json([
                'message' => 'Successfully fetched a Blog by ID: '.$id,
                'payload' => $Blog,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to fetch a Blog by ID: '.$id,
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
    public function update(BlogRequest $request,$id)
    {
        // return $request;
        $updatedBlog = Blog::find($id);
        $updatedBlog->title = $request->title;
        $updatedBlog->description = $request->description;
        $updatedBlog->picture_url = $request->picture_url;
        $updatedBlog->status = $request->status;
        $updatedBlog->save();
        if($updatedBlog){
            return response()->json([
                'message' => 'Successfully Updated a Blog by ID: '.$id,
                'payload' => $updatedBlog,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to update a Blog by ID: '.$id,
                'payload' => $updatedBlog,
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
        $deleteBlog = Blog::find($id);
        $deleteBlog->status=0;
        if($deleteBlog){
            return response()->json([
                'message' => 'Successfully delete a Blog by id: '.$id,
                'payload' => $deleteBlog,
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'Failed to delete a Blog',
                'payload' => array(
                    'id' => $id
                ),
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}