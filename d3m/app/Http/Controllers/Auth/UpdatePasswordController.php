<?php
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
 
class UpdatePasswordController extends Controller
{
    public function __construct() {
 
        $this->middleware('auth');
 
    }

    public function update(Request $request) {
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

            $this->send_password_changed_email(Auth::id());

            $request->session()->flash('success', 'Your password has been changed.');
 
            return back();
        }
 
        $request->session()->flash('failure', 'Your password has not been changed.');
 
        return back();
    }

    public function send_password_changed_email($user_id){
        $user = User::find($user_id);
        $name = $user->name;
        $email = $user->gu_email;
        $date = date('d/m/Y');
        $time = date('H:i:s');

        $data = array('user_id'=>$user_id, 'name'=>$name, 'email'=>$email, 'date'=>$date, 'time'=>$time);

        Mail::send('payment.mail_password_changed', $data, function($message) use ($data) {
            $message->to($data['email'], $data['name'])
                    ->subject('Assure Password Change')
                    ->from('info@pecanreams.com','Pecan Reams');
        });
    }

}
?>