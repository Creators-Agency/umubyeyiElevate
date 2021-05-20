<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Auth;
use Cache;
use Redirect;
use Validator;

use App\Models\Subscription;
use App\Models\User;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Subscriptions = Subscription::get();
        return response()->json([
            'message' => 'Successfuly Fetched all Subscriptions',
            'payload' => $Subscriptions,
            'status' => 200,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(REQUEST $request)
    {
        /**
         * Validate
         */
        //get GMT time
        $pack = Package::find($request->package_id);
        $transactionID = sha1(md5(time())).rand(102,0);
        $offset=2*60*60; //converting 2 hours to seconds.
        $dateFormat="Y-m-d";
        $start = $timeNdate=gmdate($dateFormat, time()+$offset);
        $end = date('Y-m-d', strtotime('+1 month', strtotime($timeNdate)));
        $Subscription = new Subscription();
        $Subscription->start_on = $start;
        $Subscription->end_on = $end;
        $Subscription->transactionID = $transactionID;
        $Subscription->package_id = $request->package_id;
        $Subscription->user_id = $request->user_id;

        if($Subscription->save()){
            // call payment api
            // invoke BulkSms to notify user that he/she has invoked payment
            return response()->json([
                'message' => 'Successfuly Fetched all Subscriptions',
                'payload' => $Subscription,
                'status' => 201,
            ]);
        }else{
            //message 
            return response()->json([
                'message' => 'Failed to create a Subscription',
                'payload' => $request,
                'status' => 501,
            ]);
        }
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch($id)
    {
        $Subscription = Subscription::find($id);
        if($Subscription){
            return response()->json([
                'message' => 'Successfully fetched a Subscription by ID: '.$id,
                'payload' => $Subscription,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to fetch a Subscription by ID: '.$id,
                'payload' => [],
                'status' => 500,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(REQUEST $request,$id)
    {
        // return $request;
        $updatedSubscription = Subscription::find($id);
        $updatedSubscription->title = $request->title;
        $updatedSubscription->description = $request->description;
        $updatedSubscription->picture_url = $request->picture_url;
        $updatedSubscription->status = $request->status;
        $updatedSubscription->save();
        if($updatedSubscription){
            return response()->json([
                'message' => 'Successfully Updated a Subscription by ID: '.$id,
                'payload' => $updatedSubscription,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to update a Subscription by ID: '.$id,
                'payload' => $updatedSubscription,
                'status' => 500,
            ]);
        }
        
    }


    public function payment_api($phone, $amount, $transactionID) {
            $url = "https://opay-api.oltranz.com/opay/paymentrequest";
            $content = '{
                "telephoneNumber" : "'.$phone.'",
                "amount" : "'.$amount.'",
                "organizationId" : "fa99567c-a2ab-4fbe-84c5-1d20093a3c8e",
                "description" : "Payment of Solar Panel",
                "callbackUrl" : "http://umubyeyi/api/callback",
                "transactionId" : "'.$transactionID.'"
            }';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $content,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            )
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    /** CallBack API Payment */
public function paymentCallBack(Request $request) {
        /* if transaction is successfuly */
        // if( $_POST["status"]=="SUCCESS" )
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
        if($request->status == "SUCCESS") {
            $get = Subscription::where('transactionID', $request->transactionId)->first();
            if(isset($get)) {
                Subscription::where('transactionID', $request->transactionId)->update(['status' => 1]);
                $myObj = new \stdClass();
                $myObj->message = 'Transaction succeeded!';
                $myObj->success = 'true';
                $myObj->request_id = $request->transactionId;
                $myJSON = json_encode($myObj);
                $com = User::where('id', $get->user_id)->first();
                $phone = '0'.$com->telephone;
                $message = $com->firstname." Your payment has been processed successfully and you Subscription is validated.\n Your transaction id'.$request->transactionId.\n Thank you!";
                $this->BulkSms($phone, $message);
            }
        } else {
            /**
             * message 
             */
            $get = Subscription::where('transactionID', $request->transactionId)->first();
            if(isset($get)) {
                $com = User::where('id', $get->user_id)->first();
                $phone = '0'.$com->telephone;
                $message = 'Transaction could not be processed!';
                $this->BulkSms($phone,$message);
            }
        }

        return true;
    }
    /**
     * burlk SMS
     */
    public function BulkSms($number,$message) {
        // GuzzleHttp\Client
        $client = new Client([
            'base_uri'=>'https://www.intouchsms.co.rw',
            'timeout'=>'900.0'
        ]);

		$result = $client->request('POST','api/sendsms/.json', [
		    'form_params' => [
		        'username' => 'muhirwa',
		        'password' => '123Muhirwa',
		        'sender' => 'Belecom ltd',
		        'recipients' => $number,
		        'message' => $message,
		    ]
		]);
    }





}