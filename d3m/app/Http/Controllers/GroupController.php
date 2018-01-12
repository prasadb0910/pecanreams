<?php

namespace App\Http\Controllers;

use App\Pn_group;
use App\Pn_group_contact;
use Illuminate\Http\Request;
use App\User;
use DB;
use Session;

class GroupController extends Controller
{
    public function index()
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['UserGroups'])) {
            if($access['UserGroups']['r_view']=='1' || $access['UserGroups']['r_insert']=='1' || $access['UserGroups']['r_edit']=='1' || $access['UserGroups']['r_delete']=='1' || $access['UserGroups']['r_approvals']=='1'  || $access['UserGroups']['r_approvals']=='1') {
                $user_id = auth()->user()->gu_id;
                $sql = "select g.id, g.group_name, g.updated_at, group_concat(p.name) as contact 
                        from pn_groups g left join pn_group_contacts p on g.id=p.fk_group_id 
                        where created_by = '$user_id' 
                        group by g.id, g.group_name, g.updated_at order by g.updated_at desc";
                $groups = DB::select($sql);
                return view('group.index', ['access' => $access, 'groups' => $groups]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Groups', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Groups', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function add()
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['UserGroups'])) {
            if($access['UserGroups']['r_insert']=='1') {
                return view('group.details', ['access' => $access]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Groups', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Groups', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function edit($id)
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['UserGroups'])) {
            if($access['UserGroups']['r_edit']=='1' || $access['UserGroups']['r_delete']=='1') {
                $data = Pn_group::find($id);  
                $group_contacts = Pn_group_contact::where('fk_group_id', $id)->get();

                return view('group.details', ['access' => $access, 'data' => $data, 'group_contacts' => $group_contacts,]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Groups', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Groups', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function save(Request $request)
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['UserGroups'])) {
            if($access['UserGroups']['r_insert']=='1' || $access['UserGroups']['r_edit']=='1' || $access['UserGroups']['r_delete']=='1' || $access['UserGroups']['r_approvals']=='1') {
                $this->validate($request, ['group_name'=>'required']);

                $data['id'] = $request->get('id');
                $data['group_name'] = $request->get('group_name');
                $user_id = auth()->user()->gu_id;
                $data['updated_by'] = $user_id;

                if(isset($data['id'])){
                    $id = $data['id'];
                    Pn_group::find($data['id'])->update($data);
                    Session::flash('success_msg', 'Group updated successfully!');
                } else {
                    $data['created_by'] = $user_id;
                    $id = Pn_group::create($data)->id;
                    Session::flash('success_msg', 'Group added successfully!');
                }

                $name = $request->get('name');
                $email = $request->get('email');
                $mobile = $request->get('mobile');
                Pn_group_contact::where('fk_group_id', $id)->delete();
                $user_data = array();
                for($i=0; $i<count($name); $i++){
                    $user_data[] = array('fk_group_id'=>$id, 'name'=>$name[$i], 'email'=>$email[$i],'mobile'=>$mobile[$i]);
                }
                if(count($user_data)>0){
                    Pn_group_contact::insert($user_data);
                }

                return redirect('index.php/group');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Groups', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Groups', 'msg' => 'You donot have access to this page.']);
        }
    }
}
