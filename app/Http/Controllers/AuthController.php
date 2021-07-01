<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Priviledge;
use App\Models\Subscription;
use App\Models\User;
use JWTAuth;
use DB;
use Illuminate\Http\Response;
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
        $priv = Priviledge::where('position',1)->first();
        if (!$priv) {
            return response()->json([
                'error' => "Permission not found"
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        // return $priv->position;
        /**
         * to do
         * -----
         * message for verification
         */
        $token = time().rand(100,0);
        $created= User::create([
            'name'=>$request->name,
            'password'=>$request->password,
            'email'=>$request->email,
            'telephone'=>$request->telephone,
            'verify_token'=>$token,
            'priviledge'=>$priv->position
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

    public function admin(REQUEST $request)
    {
        $priv = Priviledge::where('position',$request->priviledge)->first();
        if (!$priv) {
            return response()->json([
                'error' => "Permission not found"
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        /**
         * to do
         * -----
         * message for verification
         */
        $token = time().rand(100,0);
        $password = rand(0,10);
        $created= User::create([
            'name'=>$request->name,
            'password'=>$password,
            'email'=>$request->email,
            'telephone'=>$request->telephone,
            'verify_token'=>$token,
            'verified'=>$request->verified,
            'priviledge'=>$priv->position
            ]);
        if ($created) {
            $this->sendLogin($password);
            return response()->json([
                "message" => "created successfuly"
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            "error" => "failed"
        ],Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function sendLogin($password)
    {
        return $password;
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
        // return $user->original->id;
        $activeSub=[];
        $data=[];
        $offset=2*60*60; //converting 2 hours to seconds.
        $dateFormat="Y-m-d";
        $now = gmdate($dateFormat, time()+$offset);
        $subscription = Subscription::where('user_id',$user->original->id)->orderBy('id','DESC')->get();
        foreach($subscription as $sub){
            if($sub->end_date <= $now){
                $activeSub['id'] = $sub->id;
                $activeSub['start_on'] = $sub->start_on;
                $activeSub['end_on'] = $sub->end_on;
                $activeSub['amount'] = $sub->amount;
                $activeSub['status'] = $sub->status;
                $activeSub['transactionID'] = $sub->transactionID;
                 $joint = DB::table('program_packages')
                    ->join('packages','packages.id','program_packages.package_id')
                    ->join('programs','programs.id','program_packages.program_id')
                    ->select(
                        'programs.title as programTitle',
                        'programs.id as programId',
                        'packages.title as packagesTitle',
                        'packages.id as packagesId',

                    )
                    ->where('program_packages.id',$sub->program_package_id)
                    ->get();
                $activeSub['packages_id'] = $joint[0]->packagesId;
                $activeSub['packages_title'] = $joint[0]->packagesTitle;
                $activeSub['program_id'] = $joint[0]->programId;
                $activeSub['program_title'] = $joint[0]->programTitle;
                $activeSub['program_package_id'] = $sub->program_package_id;
                $activeSub['program_package_id'] = $sub->program_package_id;
                $activeSub['user_id'] = $sub->user_id;
                $activeSub['status'] = $sub->status;
                array_push($data, $activeSub);
            }
        }
        // return $activeSub;
        /**
         * ------------- 
         * | condition |
         * -------------
         * if duration of he/she subcribed has not been expired
         *      example subscription was 2020-01-01 and duration was one year on 2021-01-01 shouldn't be returned
         * 
         */
        if($user->original->verified !== 1){
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'payload' => $user->original,
                'subscription' => $data,
                'status' =>422,
                'expires_in' => $this->guard()->factory()->getTTL() * 1
            ]);
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'payload' => $user->original,
            'subscription' => $data,
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