<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, Notifiable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'group_users';

	protected $primaryKey = 'gu_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'gu_email', 'gu_password', 'gu_mobile', 'assigned_role', 'status'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['gu_password', 'remember_token'];

	public $timestamps = false;

    public function get_access($section="") {
        $cond = "";
        if($section!=""){
            $cond = " and section = '$section'";
        }
        $assure = auth()->user()->assure;

        if($assure=='1'){
        	$role_id = '2';
        } else {
        	$role_id = auth()->user()->assigned_role;
        }

        $result = DB::select("select * from user_role_options where role_id = '$role_id'" . $cond);
        $access = array();
        foreach($result as $data){
            $access[$data->section]['r_view']=$data->r_view;
            $access[$data->section]['r_insert']=$data->r_insert;
            $access[$data->section]['r_edit']=$data->r_edit;
            $access[$data->section]['r_delete']=$data->r_delete;
            $access[$data->section]['r_approvals']=$data->r_approvals;
            $access[$data->section]['r_export']=$data->r_export;
        }
        return $access;
    }
}
