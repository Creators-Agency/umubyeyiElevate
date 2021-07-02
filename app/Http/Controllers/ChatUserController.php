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
        $checkAvailable = ChatUser::where(['chat_id'=>$request->chat_id,'user_id'=>$request->user_id])->first();
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

    public function accepting(REQUEST $request)
    {
        $checkAvailable = ChatUser::where('chat_id',$request->chat_id)->where('user_id',$request->user_id)->first();
        if (!$checkAvailable) {
            return response()->json([
                "message" => "Record not found!"
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($request->decision) {
            $chatuser = ChatUser::where(['chat_id'=>$request->chat_id,'user_id'=>$request->user_id])->update(['status' => 1]);
            if ($chatuser) {
                return response()->json([
                    "message" => "Request approved"
                ],Response::HTTP_OK);
            }

        }else{
           $chatuser = ChatUser::where(['chat_id'=>$request->chat_id,'user_id'=>$request->user_id])->delete();
           if ($chatuser) {
            $this->sendNotification($request->user_id);
            return response()->json([
                "message" => "Request revoked"
            ],Response::HTTP_OK);
           }
        }
        return response()->json([
            "error" => "approving failed"
        ],Response::HTTP_INTERNAL_SERVER_ERROR);

    }

    public function leave(REQUEST $request)
    {
        $checkAvailable = ChatUser::where(['chat_id'=>$request->chat_id,'user_id'=>$request->user_id])->first();
        if (!$checkAvailable) {
            return response()->json([
                "message" => "Record not found!"
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $chatuser = ChatUser::where(['chat_id'=>$request->chat_id,'user_id'=>$request->user_id])->delete();
        if ($chatuser) {
            return response()->json([
                "message" => "Chat Left"
            ],Response::HTTP_OK);
        }
    }

    public function revoke(REQUEST $request)
    {
        $checkAvailable = ChatUser::where('chat_id',$request->chat_id)->where('user_id',$request->user_id)->first();
        if (!$checkAvailable) {
            return response()->json([
                "message" => "Record not found!"
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $chatuser = ChatUser::where(['chat_id'=>$request->chat_id,'user_id'=>$request->user_id])->delete();
        if ($chatuser) {
            return response()->json([
                "message" => "Request Revoked"
            ],Response::HTTP_OK);
        }
    }

    public function all()
    {
        return ChatUser::get();
    }
}