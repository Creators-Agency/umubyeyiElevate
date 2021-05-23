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
        $message = ChatMessage::where('chat_id',$chat_id)->get();
        return response()->json([
            "message" => "all message from chat ID",
            "payload" => $message,
            "status" => 200
        ]);
    }
}