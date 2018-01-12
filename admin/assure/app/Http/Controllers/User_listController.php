<?php

namespace App\Http\Controllers;

use App\User;
use App\Pn_property;
use Illuminate\Http\Request;
use Session;
use DB;

class User_listController extends Controller
{
    public function index()
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Users'])) {
            if($access['Users']['r_view']=='1' || $access['Users']['r_insert']=='1' || $access['Users']['r_edit']=='1' || $access['Users']['r_delete']=='1' || $access['Users']['r_approvals']=='1' || $access['Users']['r_export']=='1') {
                $user_id = auth()->user()->gu_id;
                $sql = "select A.*, B.prop_cnt from 
                        (select * from group_users) A 
                        left join 
                        (select created_by, count(id) as prop_cnt from pn_properties group by created_by) B 
                        on (A.gu_id = B.created_by)";
                $sql1 = "select A.*, B.prop_cnt from 
                        (select * from group_users where status='block') A 
                        left join 
                        (select created_by, count(id) as prop_cnt from pn_properties group by created_by) B 
                        on (A.gu_id = B.created_by)";
                $sql2 = "select A.*, B.prop_cnt from 
                        (select * from group_users where status='active') A 
                        left join 
                        (select created_by, count(id) as prop_cnt from pn_properties group by created_by) B 
                        on (A.gu_id = B.created_by)";
                $sql3 = "select A.*, B.prop_cnt from 
                        (select * from group_users where status='inactive') A 
                        left join 
                        (select created_by, count(id) as prop_cnt from pn_properties group by created_by) B 
                        on (A.gu_id = B.created_by)";

                $users = DB::select($sql);
                $block = DB::select($sql1);
                $active = DB::select($sql2);
                $inactive = DB::select($sql3);

                return view('user.front_user_list', ['access' => $access, 'Users' => $users,'block' => $block,'active' => $active,'inactive' => $inactive]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Users', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Users', 'msg' => 'You donot have access to this page.']);
        }
    }


public function add_user()
{
    $user = new User();
    $access = $user->get_access();
    if(isset($access['Users'])) {
        if($access['Users']['r_insert']=='1') {
            return view('user.add_user', ['access' => $access]);
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'Users' => 'Users', 'msg' => 'You donot have access to this page.']);
        }
    } else {
        return view('message', ['access' => $access, 'title'  => 'Access Denied', 'Users' => 'Users', 'msg' => 'You donot have access to this page.']);
    }
}


public function edit($gu_id)
{
    $user = new User();
    $access = $user->get_access();
    if(isset($access['Users'])) {
        if($access['Users']['r_edit']=='1' || $access['Users']['r_delete']=='1') {
            $data = User::find($gu_id);

            return view('user.add_user', ['access' => $access, 'data' => $data]);
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User', 'msg' => 'You donot have access to this page.']);
        }
    } else {
        return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User', 'msg' => 'You donot have access to this page.']);
    }
}



public function save(Request $request)
{
    $user = new User();
    $access = $user->get_access();
    if(isset($access['Users'])) {
        if($access['Users']['r_insert']=='1' || $access['Users']['r_edit']=='1' || $access['Users']['r_delete']=='1' || $access['Users']['r_approvals']=='1') {
            $this->validate($request, [
                                        'name'=>'required',
                                        'gu_email' => 'required',
                                        'gu_password' => 'required|min:8',
                                        'gu_mobile' => 'required|min:10'	
                                    ]);

            $data = $request->all();
            $user_id = auth()->user()->gu_id;
            $data['updated_by'] = $user_id;

            $data['assigned_role'] = 2;

            $data["gu_password"]=bcrypt($data["gu_password"]);
               //	$data["gu_password"]= Crypt::encrypt($data["gu_password"]);

            if(isset($data['gu_id'])){
			   	//$data["gu_password"]= Crypt::decrypt($data["gu_password"]);      
                User::find($data['gu_id'])->update($data);
                Session::flash('success_msg', 'User updated successfully!');
            } else {
                $data['created_by'] = $user_id;
                User::create($data);
                Session::flash('success_msg', 'User added successfully!');
            }

            return redirect('index.php/user');
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User', 'msg' => 'You donot have access to this page.']);
        }
    } else {
        return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'User', 'msg' => 'You donot have access to this page.']);
    }
}


}
