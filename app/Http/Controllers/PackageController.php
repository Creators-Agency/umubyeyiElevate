<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Auth;
use Cache;
use Redirect;
use Validator;

use App\Models\Package;

class PackageController extends Controller
{
   /**
    * 
    */
    public function index()
    {
        $Package = Package::get();
        if ($Package) {
            return response()->json([
                'message' => 'Successfully fetched all package',
                'payload' => $Package,
                'status' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Failed to fetch all package',
                'payload' => $Package,
                'status' => 500,
            ]);
        }
    }
    public function store(REQUEST $request)
    {
        /**
         * Validate
         */
        $Package = new Package();
        $Package->title = $request->title;
        $Package->description = $request->description;
        $Package->price = $request->price;
        $Package->duration = $request->duration;
        $Package->status = $request->status;
        $Package->user_id = $request->user_id;

        if($Package->save()){
            return response()->json([
                'message' => 'Package was successfuly created',
                'payload' => $Package,
                'status' => 201,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to create a Package',
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
        $Package = Package::find($id);
        if($Package){
            return response()->json([
                'message' => 'Successfully fetched a Package by ID: '.$id,
                'payload' => $Package,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to fetch a Package by ID: '.$id,
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
        $Package = Package::find($id);
        $Package->title = $request->title;
        $Package->description = $request->description;
        $Package->price = $request->price;
        $Package->duration = $request->duration;
        $Package->status = $request->status;
        $Package->user_id = $request->user_id;
        $Package->save();
        if($Package){
            return response()->json([
                'message' => 'Successfully Updated a Package by ID: '.$id,
                'payload' => $Package,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to update a Package by ID: '.$id,
                'payload' => $Package,
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
        $deletePackage = Package::find($id);
        $deletePackage->status=0;
        if($deletePackage){
            return response()->json([
                'message' => 'Successfully delete a Package by id: '.$id,
                'payload' => $deletePackage,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to delete a Package',
                'payload' => array(
                    'id' => $id
                ),
                'status' => 500,
            ]);
        }
    }


}