<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function resetPassword(REQUEST $request)
    {
        if(!$this->validateEmail($request->email)){
            return $request->email;
            return $this->failedResponse();
        }

        $this->sendEmail($request->email);
        return $this->successResponse();

    }

    

    public function sendEmail($email)
    {
        $token = $this->createToken($email);
        Mail::to($email)->send(new ResetPasswordMail($token));
    }

    public function createToken($email)
    {
        $oldToken = DB::table('password_resets')->where('email',$email)->first();
        if($oldToken){
            return $oldToken;
        }

        $token = time().rand(100,0);
        $this->saveToken($token,$email);
        return $token;
    }

    public function saveToken($token,$email)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }
    public function validateEmail($email)
    {
        return !!User::where('email',$email)->first();
    }

    public function failedResponse()
    {
        return response()->json([
                'error' => "email not found",
        ],Response::HTTP_NOT_FOUND);
    }

    public function successResponse()
    {
        return response()->json([
                'message' => "Reset Link has been sent to your inbox",
        ],Response::HTTP_OK);
    }
}