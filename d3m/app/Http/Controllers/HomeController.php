<?php

namespace App\Http\Controllers;

use App\Project_detail;
use Illuminate\Http\Request;
use DB;
use Session;
use Mail;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('CheckOtp');
    }

    public function index()
    {
        // if(auth()->user()->mail_sent==0){
        //     $this->send_email(auth()->user()->name, auth()->user()->gu_email);

        //     $sql = "update group_users set mail_sent = '1' where gu_id = '".auth()->user()->gu_id."'";
        //     DB::update($sql);
        // }

        return view('dashboard.dashboard');
    }

    public function send_email($name, $email){
        $data = array('name'=>$name, 'email'=>$email);

        Mail::send('dashboard.mail_welcome', $data, function($message) use ($data) {
            $message->to($data['email'], $data['name'])
                    ->subject('Welcome to Pecan Reams')
                    ->from('info@pecanreams.com','Pecan Reams');
        });
    }
}