<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Session;
 
class Update_passwordController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'old' => 'required',
            'password' => 'required|min:6|confirmed',
            'confirm' => 'required|min:6|confirmed',
        ]);
 
        $user = User::find(Auth::id());
        $hashedPassword = $user->password;
 
        if (Hash::check($request->old, $hashedPassword)) {
            //Change the password
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
 
            $request->session()->flash('success', 'Your password has been changed.');
 
            return back();
        }
 
        $request->session()->flash('failure', 'Your password has not been changed.');
 
        return back();
    }

    public function check_old_password(Request $request) {
        $user_id = auth()->user()->gu_id;

        $input = $request->all();
        $upass = $input['old_password'];
        $result = 0;

        $sql = "select * from group_users where gu_id = '$user_id'";
        $data = DB::select($sql);
        if (count($data)>0){
            $hashedPassword = $data[0]->gu_password;

            if (password_verify($upass, $hashedPassword)) {
                $result = 1;
            }
        }

        echo $result;
    }

    public function change_password(Request $request) {
        $user_id = auth()->user()->gu_id;
        $now=date('Y-m-d H:i:s');

        // $new_password = $request->new_password;
        $input = $request->all();
        $new_password = $input['new_password'];

        $new_password=password_hash($new_password, PASSWORD_BCRYPT, array('cost' => 10));

        $sql = "update group_users set gu_password = '$new_password', updated_by = '$user_id', updated_at = '$now' where gu_id = '$user_id'";
        $result = DB::update($sql);

        echo 1;
    }

}
?>