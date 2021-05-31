<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Verification extends Controller
{
    public function verify($verificationKey)
    {
        $verify = User::where(['verify_token'=>$verificationKey,'verified'=>0])->update(['verified'=>1]);
        if($verify){
            return response()->json([
                'status' => 200,
                'message' => "Verified"
            ]);
        } else{
            return response()->json([
                'status' => 500,
                'message' => "Failed"
            ]);
        }
    }
}