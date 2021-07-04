<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Auth;
use Cache;
use Redirect;
use Validator;

use App\Models\ChatMessage;
use Illuminate\Http\Response;

class ChatMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function chatMessage($chatID)
    {
        
        $message = DB::table('chat_messages')
                ->join("users","users.id","chat_messages.user_id")
                ->where('chat_messages.chat_id',$chatID)
                ->select(
                    "chat_messages.id as id",
                    "chat_messages.content as content",
                    "chat_messages.chat_id as chat_id",
                    "chat_messages.user_id as user_id",
                    "chat_messages.created_at as created_at",
                    "chat_messages.updated_at as updated_at",
                    "users.name as name",
                )
                ->get();
        return response()->json([
            "message" => "Welcome to Elevate API - Chat Message",
            "payload" => $message
        ],Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            "message" => "Welcome to Elevate API - Chat Message"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = new ChatMessage();
        $message->content = $request->content;
        $message->chat_id = $request->chat_id;
        $message->user_id = $request->user_id;
        $message->save();
        if ($message) {
            return response()->json([
                "message" => "message sent",
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "message" => "Welcome to Elevate API - Chat Message"
        ],Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            "message" => "Welcome to Elevate API - Chat Message"
        ]);
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
            "message" => "Welcome to Elevate API - Chat Message"
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
        return response()->json([
            "message" => "Welcome to Elevate API - Chat Message"
        ]);
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
            "message" => "Welcome to Elevate API - Chat Message"
        ]);
    }
}