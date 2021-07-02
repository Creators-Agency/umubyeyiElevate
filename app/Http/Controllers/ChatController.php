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
use App\Models\ChatUser;
use App\Models\Program;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function list()
    {
        $chats = Chat::get();
        return response()->json([
            'message' => 'Successfuly Fetched all Chats',
            'payload' => $chats,
        ],Response::HTTP_OK);
    }
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
        $Chat->picture_url = "url";
        $Chat->program_id = $request->program_id;
        $Chat->user_id = $request->user_id;
        $Chat->status = 1;
        $Chat->save();
        if($Chat){
            return response()->json([
                'message' => 'Successfully create a Chat ',
                'payload' => $Chat,
            ],Response::HTTP_CREATED);
        }else{
            return response()->json([
                'message' => 'Failed to create a Chat ',
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
        // $focusSub = DB::table("subscriptions")
        //                 ->join("program_packages","program_packages.id","subscriptions.program_package_id")
        //                 ->join("programs","program_packages.program_id","programs.id")
        //                 ->where('subscriptions.user_id',$user)
        //                 ->select(
        //                     "programs.id as p_id"
        //                     )
        //                 ->get();
        return response()->json([
            "subscribed" => $this->getSubscribed($user),
            "unsubscribed" => $this->unSubscribed($user)
        ]);
    }

    public function getSubscribed($user)
    {
        // program_id
        // user_id
        // return ChatUser::get();
        $array = [];
        $data = [];
        // $programs = Program::get();
            $chats = DB::table("chats")
                    ->join("chat_users","chats.id","chat_users.chat_id")
                    ->join("users","chat_users.user_id","users.id")
                    ->where("chat_users.user_id",$user)
                    // ->where("chat_users.status",1)
                    // ->select(
                    //     "chats.id as id"
                    // )
                    ->get();
            array_push($data,$chats);
        if($data)
            return $data[0];
        
    }
    public function unSubscribed($user)
    {
        $test = "SELECT chats.* FROM chats LEFT JOIN chat_users ON (chats.id = chat_users.chat_id) WHERE chat_users.user_id IS NULL";
        return  DB::select(DB::raw($test));
    }
}