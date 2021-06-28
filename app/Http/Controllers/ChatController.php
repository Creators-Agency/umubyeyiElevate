<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Auth;
use Cache;
use Redirect;
use Validator;

use App\Models\Chat;
use App\Models\Program;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($program_id)
    {
       $program = DB::table('programs')
                ->join('chats','chats.program_id','programs.id')
                ->where('programs.id',$program_id)
                ->get();
        if ($program) {
            return response()->json([
                "message" => "Welcome to Elevate API - Chat",
                "payload" => $program,
                'status' => 200
            ]);
        }else{
            return response()->json([
                "message" => "Welcome to Elevate API - Chat",
                "payload" => $program,
                'status' => 500
            ]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ChatRequest $request)
    {
        $Chat = new Chat();
        $Chat->title = $request->title;
        $Chat->description = $request->description;
        $Chat->picture_url = $request->picture_url;
        $Chat->program_id = $request->program_id;
        $Chat->user_id = 1;
        $Chat->status = 1;
        $Chat->save();
        if($Chat){
            return response()->json([
                'message' => 'Successfully create a Chat ',
                'payload' => $Chat,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to create a Chat ',
                'payload' => $request,
                'status' => 500,
            ]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch($program_id, $id)
    {
        $program = DB::table('programs')
                ->join('chats','chats.program_id','programs.id')
                ->where('programs.id',$program_id)
                ->where('chats.id',$id)
                ->get();
        if ($program) {
            return response()->json([
                "message" => "Welcome to Elevate API - Chat",
                "payload" => $program,
                'status' => 200
            ]);
        }else{
            return response()->json([
                "message" => "Welcome to Elevate API - Chat",
                "payload" => $program,
                'status' => 500
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json([
            "message" => "Welcome to Elevate API - Chat"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Chat = Chat::find($id);
        $Chat->title = $request->title;
        $Chat->description = $request->description;
        $Chat->picture_url = $request->picture_url;
        $Chat->program_id = $request->program_id;
        $Chat->status = 1;
        $Chat->save();
        if($Chat){
            return response()->json([
                'message' => 'Successfully updated a Chat ',
                'payload' => $Chat,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to update a Chat ',
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
        $Chat = Chat::find($id);
        $Chat->status = 0;
        $Chat->save();
        if($Chat){
            return response()->json([
                'message' => 'Successfully deleted a Chat ',
                'payload' => $Chat,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to delete a Chat ',
                'payload' => $Chat,
                'status' => 500,
            ]);
        }
    }

    public function displayChat($user)
    {
        $focusSub = DB::table("subscriptions")
                        ->join("program_packages","program_packages.id","subscriptions.program_package_id")
                        ->join("programs","program_packages.program_id","programs.id")
                        ->where('subscriptions.user_id',$user)
                        ->select(
                            "programs.id as p_id"
                            )
                        ->get();
        return response()->json([
            "subscribed" => $this->getSubscribed($user,$focusSub),
            "unsubscribed" => $this->unSubscribed($user,$focusSub)
        ]);
    }

    public function getSubscribed($user,$subscriptions)
    {
        // program_id
        // user_id
        $array = [];
        $data = [];
        $programs = Program::get();
        foreach($$programs as $program){
            $chats = DB::table("chats")
                    ->join("users","chats.user_id","users.id")
                    ->where("chats.user_id",$user)
                    ->where("chats.program_id",$$program->id)
                    ->get();
            array_push($data,$chats);
        }
        return $data[0];
        
    }
    public function unSubscribed($user,$subscriptions)
    {
        $data = [];
        foreach($subscriptions as $sub){
            $chats = DB::table("chats")
                    ->join("users","chats.user_id","users.id")
                    ->where("chats.user_id",'!=',$user)
                    ->where("chats.program_id",$sub->p_id)
                    ->get();
            array_push($data,$chats);
        }
        return $data[0];
    }
}