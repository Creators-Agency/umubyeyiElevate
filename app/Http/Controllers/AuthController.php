<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        // return $credentials;
        $customClaims = ['foo' => 'bar', 'baz' => 'bob'];
        // $this->guard()->attempt($credentials);
        // $user = User::first();
        // return $token = JWTAuth::fromUser($user);


        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401); 
        
    }

    public function register(REQUEST $request)
    {
        $token = time().rand(100,0);
        $created= User::create([
            'name'=>$request->name,
            'password'=>$request->password,
            'email'=>$request->email,
            'telephone'=>$request->telephone,
            'verify_token'=>$token
            ]);
        if ($created) {
            if ($request->verificationWay === 0) {
                $this->sendBulk($created->telephone,$token);
            }else{
                $this->sendEmail($request->email,$token);
            }
        }
        return $this->login($request);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = $this->me();
        $subscription = Subscription::where('user_id',$user->original->id)->orderBy('id','DESC')->first();
        if($user->original->verified !== 1){
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'payload' => $user->original,
                'subscription' => $subscription,
                'status' =>422,
                'expires_in' => $this->guard()->factory()->getTTL() * 1
            ]);
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'payload' => $user->original,
            'subscription' => $subscription,
            'status' =>200,
            'expires_in' => $this->guard()->factory()->getTTL() * 1
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

    public function sendEmail($email,$token)
    {
        return $email;
    }

    public function sendBulk($phone,$token)
    {
        return $phone;
    }
}