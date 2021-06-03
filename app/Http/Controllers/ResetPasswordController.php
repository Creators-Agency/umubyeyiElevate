<?php

namespace App\Http\Controllers;
use DB;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Requests\ChangePassword;
use App\Http\Requests\ChangePasswordProfile;

class ResetPasswordController extends Controller
{
    public function resetPassword(REQUEST $request)
    {
        if(!$this->validateEmail($request->email)){
            // return $request->email;
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
            return $oldToken->token;
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


    /**
     * resetting part
     */

    public function reset(ChangePassword $request)
    {
       return $this->checkResetPassword($request)->count() > 0 ? $this->changePassword($request):$this->tokenNotFound();
    }

    public function checkResetPassword($request)
    {
        return DB::table('password_resets')->where(['email'=>$request->email,'token'=>$request->resetToken]);
    }

    public function changePassword($request)
    {
        $user = User::whereEmail($request->email)->first();
        $user->update(['password' => $request->password]);
        $this->checkResetPassword($request)->delete();
        return response()->json([
            "message" => "Password changed"
        ],Response::HTTP_CREATED);
    }
    public function tokenNotFound()
    {
        return response()->json([
            'error' => "Token not found or has expired!"
        ],Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * 
     */
    public function resetProfile(ChangePasswordProfile $request)
    {
        $user = User::whereEmail($request->email)->first();
        $user->update(['password' => $request->password]);
        if ($user) {
            return response()->json([
                "message" => "Password changed"
            ],Response::HTTP_CREATED);
        }else{
            return response()->json([
                'error' => "Unable to change password!"
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}