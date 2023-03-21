<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\NotifyMail;

class SendEmailController extends Controller
{
    public function index()
    {

    Mail::to('idhamanur@gmail.com')->send(new NotifyMail());

    if (Mail::flushMacros() ) {
        return response()->Fail('Sorry! Please try again latter');
    }else{
        return response()->json('Great! Successfully send in your mail');
        }
    } 
}
