<?php

namespace App\Http\Controllers;

use App\User;
use App\Pn_notice_type;
use Illuminate\Http\Request;
use Session;

class Notice_typeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['NoticeTypes'])) {
            if($access['NoticeTypes']['r_view']=='1' || $access['NoticeTypes']['r_insert']=='1' || $access['NoticeTypes']['r_edit']=='1' || $access['NoticeTypes']['r_delete']=='1' || $access['NoticeTypes']['r_approvals']=='1' || $access['NoticeTypes']['r_export']=='1') {
                $notice_type = Pn_notice_type::where('status','approved')->orderBy('updated_at','desc')->get();
                return view('notice_type.index', ['access' => $access, 'notice_type' => $notice_type]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Type', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Type', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function add()
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['NoticeTypes'])) {
            if($access['NoticeTypes']['r_insert']=='1') {
                return view('notice_type.details', ['access' => $access]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Type', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Type', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function details($id)
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['NoticeTypes'])) {
            if($access['NoticeTypes']['r_view']=='1') {
                $data = Pn_notice_type::find($id);
                return view('notice_type.details', ['access' => $access, 'data' => $data]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Type', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Type', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function edit($id)
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['NoticeTypes'])) {
            if($access['NoticeTypes']['r_edit']=='1' || $access['NoticeTypes']['r_delete']=='1') {
                $data = Pn_notice_type::find($id);
                return view('notice_type.details', ['access' => $access, 'data' => $data]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Type', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Type', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function save(Request $request)
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['NoticeTypes'])) {
            if($access['NoticeTypes']['r_insert']=='1' || $access['NoticeTypes']['r_edit']=='1' || $access['NoticeTypes']['r_delete']=='1' || $access['NoticeTypes']['r_approvals']=='1') {
                $this->validate($request, [
                    'notice_type' => 'required',
                ]);

                $data = $request->all();
                $user_id = auth()->user()->gu_id;
                $data['updated_by'] = $user_id;
                $data['status'] = 'approved';
                if(isset($data['id'])){
                    Pn_notice_type::find($data['id'])->update($data);
                    Session::flash('success_msg', 'Notice Type updated successfully!');
                } else {
                    $data['created_by'] = $user_id;
                    Pn_notice_type::create($data);
                    Session::flash('success_msg', 'Notice Type added successfully!');
                }

                return redirect('index.php/notice_type');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Type', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Type', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function delete(Request $request)
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['NoticeTypes'])) {
            if($access['NoticeTypes']['r_delete']=='1') {
                $data['id'] = $request->get('notice_type_id');
                $user_id = auth()->user()->gu_id;
                $data['updated_by'] = $user_id;
                $data['status'] = 'inactive';
                if(isset($data['id'])){
                    Pn_notice_type::find($data['id'])->update($data);
                    Session::flash('success_msg', 'Notice Type deleted successfully!');
                }

                return redirect('index.php/notice_type');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Type', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Type', 'msg' => 'You donot have access to this page.']);
        }
    }
}
