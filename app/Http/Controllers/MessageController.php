<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;

use DB;
use Auth;
use Cache;
use Redirect;
use Validator;
class MessageController extends Controller
{
    public function index($chat_id)
    {
        $message = DB::table('chat_messages')
                    ->join("users","users.id","chat_messages.user_id")
                    ->where('chat_messages.chat_id',$chat_id)
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
            "message" => "all message from chat ID",
            "payload" => $message,
            "status" => 200
        ]);
    }

    public function store()
    {
        # code...
    }
}