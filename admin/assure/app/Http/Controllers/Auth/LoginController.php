<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use DB;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        attemptLogin as attemptLoginAtAuthenticatesUsers;
        // logout as performLogout;
    }

    // public function logout(Request $request) {
    //     $this->performLogout($request);
    //     return redirect()->route('home.reams');
    // }

    public function performLogout(Request $request) { 
        Auth::logout(); 
        // return redirect('login');
        return redirect('index.php/reams');
    } 

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('adminlte::auth.login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/index.php/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Returns field name to use at login.
     *
     * @return string
     */
    public function username()
    {
        return config('auth.providers.users.field','gu_email');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        if ($this->username() === 'gu_email') return $this->attemptLoginAtAuthenticatesUsers($request);
        if ( ! $this->attemptLoginAtAuthenticatesUsers($request)) {
            return $this->attempLoginUsingUsernameAsAnEmail($request);
        }
        return false;
    }

    /**
     * Attempt to log the user into application using username as an email.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attempLoginUsingUsernameAsAnEmail(Request $request)
    {
        return $this->guard()->attempt(
            ['gu_email' => $request->input('username'), 'gu_password' => $request->input('gu_password')],
            $request->has('remember'));
    }

    protected function get_ci_session($token){
        $sql = "select * from user_login_emails where token = '$token' and isVerified = '0'";
        $data = DB::select($sql);
        if(count($data)>0){
            // $email_id = $data[0]->email;

            // $sql = "select * from group_users where gu_email = '$email_id'";
            // $data2 = DB::select($sql);
            // if(count($data2)>0){
            //     $gu_id = $data2[0]->gu_id;
            //     Auth::loginUsingId($gu_id);
            // }

            $gu_id = $data[0]->user_id;
            Auth::loginUsingId($gu_id);

            DB::update("update user_login_emails set isVerified = '1' where token = '$token'");
        }

        return redirect('index.php/home');
    }
}
