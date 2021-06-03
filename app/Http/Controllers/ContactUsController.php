<?php

namespace App\Http\Controllers;

use Mail;
use App\Http\Requests\ContactUs;
use App\Mail\ContactUs as MailContactUs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactUsController extends Controller
{
    public function sendMessage(ContactUs $request)
    {
        // return $request;
        $this->sendMail($request);
    }
    public function sendMail($request)
    {
        if(Mail::to($request->email)->send(new MailContactUs($request))){
            return $this->successResponse();
        }
        return $this->failedResponse();
    }

     public function failedResponse()
    {
        return response()->json([
            "error" => "Unable to send email, Retry again!!",
        ],Response::HTTP_SERVICE_UNAVAILABLE);
    }

    public function successResponse()
    {
        return response()->json([
            "message" => "Thank for contacting us!",
        ],Response::HTTP_OK);
    }


}