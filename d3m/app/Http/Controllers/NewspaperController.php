<?php

namespace App\Http\Controllers;

use App\User;
use App\Pn_newspaper;
use Illuminate\Http\Request;
use Session;

class NewspaperController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Newspapers'])) {
            if($access['Newspapers']['r_view']=='1' || $access['Newspapers']['r_insert']=='1' || $access['Newspapers']['r_edit']=='1' || $access['Newspapers']['r_delete']=='1' || $access['Newspapers']['r_approvals']=='1' || $access['Newspapers']['r_export']=='1') {
                $newspapers = Pn_newspaper::where('status','approved')->orderBy('updated_at','desc')->get();
                return view('newspapers.index', ['access' => $access, 'newspapers' => $newspapers]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Newspaper', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Newspaper', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function add()
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Newspapers'])) {
            if($access['Newspapers']['r_insert']=='1') {
                return view('newspapers.details', ['access' => $access]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Newspaper', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Newspaper', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function details($id)
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Newspapers'])) {
            if($access['Newspapers']['r_view']=='1') {
                $data = Pn_newspaper::find($id);
                return view('newspapers.details', ['access' => $access, 'data' => $data]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Newspaper', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Newspaper', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function edit($id)
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Newspapers'])) {
            if($access['Newspapers']['r_edit']=='1' || $access['Newspapers']['r_delete']=='1') {
                $data = Pn_newspaper::find($id);
                return view('newspapers.details', ['access' => $access, 'data' => $data]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Newspaper', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Newspaper', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function save(Request $request)
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Newspapers'])) {
            if($access['Newspapers']['r_insert']=='1' || $access['Newspapers']['r_edit']=='1' || $access['Newspapers']['r_delete']=='1' || $access['Newspapers']['r_approvals']=='1') {
                $this->validate($request, [
                    'paper_name' => 'required',
                    'language' => 'required',
                    'e_paper' => 'required',
                    'frequency' => 'required',
                    'area' => 'required',
                    'price' => 'required',
                    'news_type' => 'required',
                ]);

                $data = $request->all();
                $user_id = auth()->user()->gu_id;
                $data['updated_by'] = $user_id;
                $data['status'] = 'approved';
                if(isset($data['id'])){
                    Pn_newspaper::find($data['id'])->update($data);
                    Session::flash('success_msg', 'Newspaper updated successfully!');
                } else {
                    $data['created_by'] = $user_id;
                    Pn_newspaper::create($data);
                    Session::flash('success_msg', 'Newspaper added successfully!');
                }

                return redirect('index.php/newspapers');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Newspaper', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Newspaper', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function delete(Request $request)
    {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Newspapers'])) {
            if($access['Newspapers']['r_delete']=='1') {
                $data['id'] = $request->get('newspaper_id');
                $user_id = auth()->user()->gu_id;
                $data['updated_by'] = $user_id;
                $data['status'] = 'inactive';
                if(isset($data['id'])){
                    Pn_newspaper::find($data['id'])->update($data);
                    Session::flash('success_msg', 'Newspaper deleted successfully!');
                }

                return redirect('index.php/newspapers');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Newspaper', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Newspaper', 'msg' => 'You donot have access to this page.']);
        }
    }
}
