<?php

namespace App\Http\Controllers;

use App\User_feedback;
use Illuminate\Http\Request;
use Session;

class User_feedbackController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        // $this->middleware('CheckOtp');
    }

    public function index()
    {
        return view('user_feedback');
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'message' => 'required',
            'type_of_feedback' => 'required',
        ]);

        $data = $request->all();
        $user_id = auth()->user()->id;
        $data['updated_by'] = $user_id;
        $data['status'] = 'approved';
        if(isset($data['id'])){
            User_feedback::find($data['id'])->update($data);
            Session::flash('success_msg', 'User Feedback updated successfully!');
        } else {
            $data['created_by'] = $user_id;
            User_feedback::create($data);
            Session::flash('success_msg', 'User Feedback added successfully!');
        }

        // return redirect()->route('user_feedback.index');
        return redirect('index.php/user_feedback');
    }
}
