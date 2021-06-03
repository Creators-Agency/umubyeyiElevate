<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Auth;
use Cache;
use Redirect;
use Validator;

use App\Models\ProgramPackage;

class ProgramPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($program_id)
    {
        $programPackage = DB::table('program_packages')
                                ->join('programs','program_packages.program_id','programs.id')
                                ->join('packages','program_packages.package_id','packages.id')
                                ->where('programs.id',$program_id)
                                ->select(
                                    'packages.id as Id',
                                    'packages.title as packageTitle',
                                    'packages.description as packageDescription',
                                    'packages.price as packagePrice',
                                    'packages.duration as packageDuration',
                                    // 'packages.status as packageStatus',
                                    // 'packages.user_id as packageCreatedBy',
                                    // 'packages.created_at as packageCreated_at',
                                    // 'packages.updated_at as packageUpdated_at',
                                    // 'programs.title as programsTitle',
                                    // 'programs.description as programDescription',
                                    // 'programs.picture_url as programPicture_url',
                                    // 'programs.status as programStatus',
                                    // 'programs.user_id as programCreatedBy',
                                    // 'programs.created_at as categoryCreated_at',
                                    // 'programs.updated_at as categoryUpdated_at',
                                )
                                ->get();
                                
        return response()->json([
            'message' => 'Successfuly Fetched all Program packages',
            'payload' => $programPackage,
            'status' => 200,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(REQUEST $request)
    {
        $programPackage = new programPackage();
        $programPackage->program_id = $request->program_id;
        $programPackage->package_id = $request->package_id;
        if($programPackage->save()){
            return response()->json([
                'message' => 'Successfuly created Category related to this program',
                'payload' => $programPackage,
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
        $programPackage = DB::table('program_packages')
                                ->join('programs','program_packages.program_id','programs.id')
                                ->join('packages','program_packages.package_id','packages.id')
                                ->where('programs.id',$program_id)
                                ->where('program_packages.id',$id)
                                ->select(
                                    'packages.id as id',
                                    'packages.title as packageTitle',
                                    'packages.description as packageDescription',
                                    'packages.price as packagePrice',
                                    'packages.duration as packageDuration',
                                    // 'packages.status as packageStatus',
                                    // 'packages.user_id as packageCreatedBy',
                                    // 'packages.created_at as packageCreated_at',
                                    // 'packages.updated_at as packageUpdated_at',
                                    // 'programs.title as programsTitle',
                                    // 'programs.description as programDescription',
                                    // 'programs.picture_url as programPicture_url',
                                    // 'programs.status as programStatus',
                                    // 'programs.user_id as programCreatedBy',
                                    // 'programs.created_at as categoryCreated_at',
                                    // 'programs.updated_at as categoryUpdated_at',
                                )
                                ->get();
                                
        return response()->json([
            'message' => 'Successfuly Fetched all Program packages',
            'payload' => $programPackage,
            'status' => 200,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(REQUEST $request,$id)
    {
        $programPackage = programPackage::find($id);
        $programPackage->program_id = $request->program_id;
        $programPackage->package_id = $request->package_id;
        if($programPackage->save()){
            return response()->json([
                'message' => 'Successfuly updated program package table',
                'payload' => $programPackage,
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json([
            "message" => "Welcome to Elevate API - Program Package"
        ]);
    }
}