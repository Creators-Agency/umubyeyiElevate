<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatUserRequest;
use App\Models\ChatUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatUserController extends Controller
{
    public function requestToJoin(ChatUserRequest $request)
    {
        $checkAvailable = ChatUser::where('chat_id',$request->chat_id)->where('user_id',$request->user_id)->first();
        if ($checkAvailable) {
            return response()->json([
                "message" => "Already joined"
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $chatuser = new ChatUser();
        $chatuser->chat_id = $request->chat_id;
        $chatuser->user_id = $request->user_id;
        $chatuser->save();
        if ($chatuser) {
            return response()->json([
                "message" => "Your Request has been Sent"
            ],Response::HTTP_CREATED);
        } else{
            return response()->json([
                "message" => "Failed "
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function accepting($id)
    {
        $chatuser = ChatUser::find($id);
        $chatuser->status = 1;
        $chatuser->save();
        if ($chatuser) {
            return response()->json([
                "message" => "Request approved"
            ],Response::HTTP_OK);
        }
    }

    public function leave($id)
    {
        $chatuser = ChatUser::find($id);
        $chatuser->status = 0;
        $chatuser->save();
        if ($chatuser) {
            return response()->json([
                "message" => "Chat Left"
            ],Response::HTTP_OK);
        }
    }

    public function revoke($id)
    {
        $chatuser = ChatUser::find($id);
        $chatuser->status = 0;
        $chatuser->save();
        if ($chatuser) {
            return response()->json([
                "message" => "Request Revoked"
            ],Response::HTTP_OK);
        }
    }
}