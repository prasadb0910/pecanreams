<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pn_notice;
use App\Pn_newspaper;
use App\Pn_notice_type;
use App\Pn_property_no_type;
use App\Pn_location_type;
use App\Pn_certificate_no_type;
use App\Pn_notice_legal_owner_name;
use App\Pn_notice_purchased_from;
use App\Pn_notice_company_name;
use App\Pn_notice_guarantor;
use App\Pn_notice_property_no_detail;
use App\Pn_notice_location_detail;
use App\Pn_notice_certificate_no_detail;
use App\User;
use DB;
use Session;
use Mail;
use App\Pn_notice_othername;
use App\Pn_property_file;
use App\Pn_file_property;
use App\Pn_file_property_notice;
use App\Pn_file_notice_criteria;
use Maatwebsite\Excel\Facades\Excel;

class Upload_property_noticeController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index($id='') {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['PropertyNotices'])) {
            if($access['PropertyNotices']['r_view']=='1' || $access['PropertyNotices']['r_insert']=='1' || $access['PropertyNotices']['r_edit']=='1' || $access['PropertyNotices']['r_delete']=='1' || $access['PropertyNotices']['r_approvals']=='1' || $access['PropertyNotices']['r_export']=='1') {
                $all = [];
                $approved = [];
                $pending_for_approval = [];
                $pending_to_send = [];
                $rejected = [];
                return view('upload_property.property_notice', ['access' => $access, 'all' => $all, 'file_id' => $id, 
                                                        'approved' => $approved, 
                                                        'pending_for_approval' => $pending_for_approval, 
                                                        'pending_to_send' => $pending_to_send, 
                                                        'rejected' => $rejected]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function get_data($id='', $file_id='', $status='', $search='', $start='', $length=''){
        $cond = "";

        if($id!=''){
            $cond = " where A.id = '$id'";
        }
        if($file_id!=''){
            if($cond==''){
                $cond = " where B.fk_file_id = '$file_id'";
            } else {
                $cond = $cond . " and B.fk_file_id = '$file_id'";
            }
        }
        if($status!=''){
            if($cond==''){
                $cond = " where A.status = '$status'";
            } else {
                $cond = $cond . " and A.status = '$status'";
            }
        }

        $search_value = '';

       
        if(isset($search) && $search!=""){
        $search_value = "AND (C.notice_title like '%$search%' or B.owner_name like '%$search%' or 
                                B.society_name like '%$search%' or B.address like '%$search%' or 
                                F.name like '%$search%')";
        } else {
            $search_value = '';
        }


        $limit = '';
        if($start!=''&& $length!=''){
            $limit = "LIMIT ".$start.", ".$length;
        }

        if($status=='pending'){
            $sql = "Select A.fk_property_id, A.owner_name, A.society_name, A.address, count(A.id) as notice_count from 
                    (SELECT A.id, F.name as property_by, G.name as notice_by, A.created_at, A.updated_at, A.fk_property_id, 
                        A.fk_notice_id, A.status, B.owner_name, B.society_name, C.date_of_notice, B.address, 
                        D.paper_name, E.notice_type, F.gu_email, C.notice_title, F.gu_mobile, C.notice_file 
                    FROM pn_file_property_notices A 
                    LEFT JOIN pn_file_properties B 
                        ON ( A.fk_property_id = B.id ) 
                    LEFT JOIN pn_notices C 
                        ON ( A.fk_notice_id = C.id ) 
                    LEFT JOIN pn_newspapers D 
                        ON ( C.fk_newspaper_id = D.id ) 
                    LEFT JOIN pn_notice_types E 
                        ON ( C.fk_notice_type_id = E.id )
                    LEFT JOIN group_users F 
                        ON ( B.created_by = F.gu_id ) 
                    LEFT JOIN group_users G 
                        ON ( C.created_by = G.gu_id ) 
                    ". $cond . "
                    ".$search_value.") A 
                    GROUP BY A.fk_property_id, A.owner_name, A.society_name, A.address 
                    Order By A.owner_name ".$limit;
        } else {
            $sql = "Select A.id, A.property_by, A.notice_by, A.created_at, A.updated_at, A.fk_property_id, A.fk_notice_id, 
                        A.status, A.owner_name, A.society_name, A.date_of_notice, A.address, A.paper_name, A.notice_type, A.gu_email, 
                        A.gu_mobile, A.notice_title, A.notice_file, count(C.pn_property_notice_id) as cricount from 
                    (SELECT A.id, F.name as property_by, G.name as notice_by, A.created_at, A.updated_at, A.fk_property_id, 
                        A.fk_notice_id, A.status, B.owner_name, B.society_name, C.date_of_notice, C.address, D.paper_name, E.notice_type, 
                        F.gu_email, C.notice_title, F.gu_mobile, C.notice_file 
                    FROM pn_file_property_notices A 
                    LEFT JOIN pn_file_properties B 
                        ON ( A.fk_property_id = B.id ) 
                    LEFT JOIN pn_notices C 
                        ON ( A.fk_notice_id = C.id ) 
                    LEFT JOIN pn_newspapers D 
                        ON ( C.fk_newspaper_id = D.id ) 
                    LEFT JOIN pn_notice_types E 
                        ON ( C.fk_notice_type_id = E.id )
                    LEFT JOIN group_users F 
                        ON ( B.created_by = F.gu_id ) 
                    LEFT JOIN group_users G 
                        ON ( C.created_by = G.gu_id ) 
                    ". $cond . "
                    ".$search_value.") A 
                    Left JOIN pn_file_notice_criterias C on (C.pn_property_notice_id = A.id) 
                    GROUP BY A.id, A.property_by, A.notice_by, A.created_at, A.updated_at, A.fk_property_id, A.fk_notice_id, 
                            A.status, A.owner_name, A.society_name, A.date_of_notice, A.address, A.paper_name, A.notice_type, 
                            A.gu_email, A.gu_mobile, A.notice_title, A.notice_file 
                    order by A.updated_at desc ".$limit;
        }
        $data = DB::select($sql);
        return $data;
    }
    
    public function get_data_getcount($id='', $file_id='', $status='',$search=''){
        $cond = "";

        if($id!=''){
            $cond = " where A.id = '$id'";
        }
        if($file_id!=''){
            if($cond==''){
                $cond = " where B.fk_file_id = '$file_id'";
            } else {
                $cond = $cond . " and B.fk_file_id = '$file_id'";
            }
        }
        if($status!=''){
            if($cond==''){
                $cond = " where A.status = '$status'";
            } else {
                $cond = $cond . " and A.status = '$status'";
            }
        }

        $search_value = '';

        if(isset($search) && $search!="") {
            $search_value = " AND ( C.notice_title like '%$search%' or B.owner_name like '%$search%' or 
                                B.address like '%$search%' or G.name like '%$search%' )";
        } else {
            $search_value = '';
        }

        if($status=='pending'){
            $sql = "select count(fk_property_id) as countdata from 
                    (Select A.fk_property_id, A.owner_name, A.address, count(A.id) as notice_count from 
                    (SELECT A.id, F.name as property_by, G.name as notice_by, A.created_at, A.updated_at, A.fk_property_id, 
                        A.fk_notice_id, A.status, B.owner_name, B.address, C.date_of_notice, D.paper_name, E.notice_type, 
                        F.gu_email, C.notice_title, F.gu_mobile, C.notice_file 
                    FROM pn_file_property_notices A 
                    LEFT JOIN pn_file_properties B 
                        ON ( A.fk_property_id = B.id ) 
                    LEFT JOIN pn_notices C 
                        ON ( A.fk_notice_id = C.id ) 
                    LEFT JOIN pn_newspapers D 
                        ON ( C.fk_newspaper_id = D.id ) 
                    LEFT JOIN pn_notice_types E 
                        ON ( C.fk_notice_type_id = E.id )
                    LEFT JOIN group_users F 
                        ON ( B.created_by = F.gu_id ) 
                    LEFT JOIN group_users G 
                        ON ( C.created_by = G.gu_id ) 
                    ". $cond . "
                    ".$search_value.") A 
                    GROUP BY A.fk_property_id, A.owner_name, A.address Order By A.owner_name) A";
        } else {
            $sql = "select count(id) as countdata from 
                    (Select A.id, G.name, A.created_at, A.updated_at, A.fk_property_id, A.fk_notice_id, 
                        A.status, B.owner_name, D.paper_name, E.notice_type, 
                        F.gu_email, C.notice_title, F.gu_mobile, C.notice_file 
                    from pn_file_property_notices A 
                    left join pn_file_properties B on (A.fk_property_id=B.id) 
                    left join pn_notices C on (A.fk_notice_id=C.id) 
                    left join pn_newspapers D on (C.fk_newspaper_id=D.id) 
                    left join pn_notice_types E on (C.fk_notice_type_id=E.id) 
                    left join group_users F on (B.created_by = F.gu_id) 
                    left join group_users G on (C.created_by = G.gu_id) 
                    " . $cond . "
                    ".$search_value."
                    order by A.updated_at desc ) A";
        }

        $data = DB::select($sql);
        return $data;
    }

    public function noticecriteria(Request $request) {
        $id = $request->input('id');
        $tbody = '';
        $sql = "Select * from pn_file_notice_criterias Where pn_property_notice_id=".$id;
        $dataget = DB::select($sql);

        if(count($dataget)>0) {
            for($i=0;$i<count($dataget);$i++) {
                $tbody.='<tr>
                            <td>'.$dataget[$i]->parameter.'</td>
                            <td>'.$dataget[$i]->notice.'</td>
                            <td>'.$dataget[$i]->property.'</td>
                        </tr>';
            }
        } 

        echo $tab = '<table id="matchingdata">
                        <tr>
                            <th>Parameter</th>
                            <th>Notice</th>
                            <th>Property</th>
                        </tr>
                        '.$tbody.'
                    </table>';
    }

    public function matching_notice(Request $request) {
        $id = $request->input('id');
        // $id = 23;
        $result_data = '';

        $sql = "select A.id, F.name as property_by, G.name as notice_by, A.created_at, A.updated_at, A.fk_property_id, 
                    A.fk_notice_id, A.status, B.owner_name, C.date_of_notice, C.address, D.paper_name, E.notice_type, 
                    F.gu_email, C.notice_title, F.gu_mobile, C.notice_file, 
                    H.parameter, H.property, H.notice, H.matching_criteria 
                from pn_file_property_notices A 
                left join pn_file_properties B 
                    on ( A.fk_property_id = B.id ) 
                left join pn_notices C 
                    on ( A.fk_notice_id = C.id ) 
                left join pn_newspapers D 
                    on ( C.fk_newspaper_id = D.id ) 
                left join pn_notice_types E 
                    on ( C.fk_notice_type_id = E.id )
                left join group_users F 
                    on ( B.created_by = F.gu_id ) 
                left join group_users G 
                    on ( C.created_by = G.gu_id ) 
                left join pn_file_notice_criterias H 
                    on (H.pn_property_notice_id = A.id) 
                where A.fk_property_id='$id' and A.status = 'pending' 
                order by A.id, A.fk_property_id, A.fk_notice_id";
        $dataget = DB::select($sql);

        if(count($dataget)>0) {
            $tbody = '';
            $prv_notice_id = '';
            $notice_id = '';
            $prv_property_id = '';
            $property_id = '';
            $notice_count = 0;
            $tab = '';

            for($i=0; $i<count($dataget); $i++) {
                $tbody.='<tr>
                            <td style="word-break: break-all;">'.$dataget[$i]->parameter.'</td>
                            <td style="word-break: break-all;">'.$dataget[$i]->notice.'</td>
                            <td style="word-break: break-all;">'.$dataget[$i]->property.'</td>
                            <td style="word-break: break-all;">'.$dataget[$i]->matching_criteria.'</td>
                        </tr>';

                $prv_notice_id = $dataget[$i]->fk_notice_id;
                $prv_property_id = $dataget[$i]->fk_property_id;

                $bl_notice_flag = false;
                $bl_property_flag = false;

                if($i==(count($dataget)-1)) {
                    $bl_notice_flag = true;
                    $bl_property_flag = true;
                    $notice_count = $notice_count + 1;
                } else {
                    $notice_id = $dataget[$i+1]->fk_notice_id;
                    $property_id = $dataget[$i+1]->fk_property_id;

                    if($notice_id!=$prv_notice_id) {
                        $bl_notice_flag = true;
                        $notice_count = $notice_count + 1;
                    }
                    if($property_id!=$prv_property_id) {
                        $bl_property_flag = true;
                    }
                }

                if($bl_notice_flag==true) {
                    $tab.= '        <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-2 text-right">'.$notice_count.'</label>
                                        <label class="col-md-2 col-sm-2 col-xs-2">Notice Id</label>
                                        <label class="col-md-8 col-sm-8 col-xs-8">'.$dataget[$i]->fk_notice_id.'</label>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-2 text-right">&nbsp;</label>
                                        <label class="col-md-2 col-sm-2 col-xs-2">Notice Name</label>
                                        <label class="col-md-8 col-sm-8 col-xs-8">'.$dataget[$i]->notice_title.'</label>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-2 text-right">&nbsp;</label>                                        
                                        <span class="col-md-2 col-sm-2 col-xs-2"><a href="'.url("index.php/upload_property_notice/details/". $dataget[$i]->id).'" target="_blank">View Details</a></span>
                                        <label class="col-md-8 col-sm-8 col-xs-8">&nbsp;</label>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-2 text-right">&nbsp;</label> 
                                        <div class="col-md-8 col-sm-8 col-xs-8">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th>Parameter</th>
                                                    <th>Notice</th>
                                                    <th>Property</th>
                                                    <th>Matching Criteria</th>
                                                </tr>
                                                '.$tbody.'
                                            </table>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-2 text-right">&nbsp;</label>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-md-2 col-sm-2 col-xs-2">&nbsp;</div>
                                        <div class="col-md-8 col-sm-8 col-xs-8">
                                            <a href="javascript:void(0)" class="btn_reject btn btn-default btn-sm pull-right" data-attrid="'.$dataget[$i]->id.'">Reject</a>
                                            <a href="javascript:void(0)" class="btn_approve btn btn-default btn-sm pull-right" data-attrid="'.$dataget[$i]->id.'" style="margin-right: 10px;">Approve</a>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-2">&nbsp;</div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>';

                    $tbody = '';
                }
                
                if($bl_property_flag==true) {
                    $result_data.= '<!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Matching Notices</h4>
                                        </div>
                                        <div class="modal-body" style="display: inline-block;">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label class="col-md-2 col-sm-2 col-xs-2">Property Name</label>
                                                    <label class="col-md-8 col-sm-8 col-xs-8">'.$dataget[$i]->owner_name.'</label>
                                                    <input type="hidden" id="property_id" name="property_id" value="'.$dataget[$i]->fk_property_id.'" />
                                            </div>
                                            <div class="col-md-2 col-sm-2 col-xs-2">&nbsp;</div>
                                            ' . $tab . '
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>';

                    $tab = '';
                }
            }
        } 

        echo $result_data;
    }

    public function notices_data(Request $request) {
        $param = $request->input('param');
        $start = $star_len = $request->input('start');
        $length = $request->input('length'); 
        /*$param = 'pending';
        $start = '0';
        $length = '10';*/
        $search_value1 =  $request->input('search');
        $search_value = $search_value1['value'];
        $file_id = $request->input('file_id'); 

        $getdata = $this->get_data('', $file_id, $param, $search_value, $start,$length);
        $getdatacount = $this->get_data_getcount('', $file_id, $param, $search_value);
        //$start = 0;    
        $notices_array = [];

       if(!empty($getdata)) {
            $tbody = '';

            for($i=0; $i<count($getdata); $i++) { 
                if($param=='pending') {
                    $row = array(
                                $start+1,
                                '<div>'.$getdata[$i]->owner_name.'</div>',
                                ''.$getdata[$i]->address.'',
                                ''.$getdata[$i]->notice_count.'',
                                '<a href="javascript:void(0)" class="matching_notice" data-attrid="'.$getdata[$i]->fk_property_id.'">Read More.....</a>'
                            );        
                } else {
                    $row = array(
                                $start+1,
                                '<div><a href="'.url("index.php/upload_property_notice/details/". $getdata[$i]->id).'" >'. $getdata[$i]->fk_notice_id.'</a></div>',
                                '<div>'.$getdata[$i]->notice_title.'</div>',
                                '<div>'.$getdata[$i]->owner_name.'</div>',
                                ''.$getdata[$i]->address.'',
                                ''.($getdata[$i]->cricount>0?'<a href="javascript:void(0)" class="mcriteria" data-attrid="'.$getdata[$i]->id.'">Read More.....</a>':'NA').'',
                                ''.$getdata[$i]->notice_by.'',
                                ''.$getdata[$i]->created_at.'',
                            );

                    //<button type="button" id="property_notice_'.$getdata[$i]->id.'" class="label label-danger" onClick="show_modal(this)">Reject</button>
                    if($param=='pending to send') {
                        $row[]='<div><input type="checkbox" name="id[]" value="'.$getdata[$i]->id.'" /></div>';     
                    }
                    if($param=='rejected') {
                        $row[]=''.$getdata[$i]->status.'';     
                    }
                }

                $notices_array[] = $row;
                $start = $start+1;
            }

            $tbody = '';
        }
        //$notices_array1 = array_slice($notices_array,$star_len,$length);

        $json_data = array(
            "draw"            => $request->input('draw'),   
            "recordsTotal"    => intval($getdatacount[0]->countdata),  
            "recordsFiltered" => intval($getdatacount[0]->countdata),
            "data"            => $notices_array
        );

        echo json_encode($json_data);
    }

    public function approve_record(Request $request) {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['PropertyNotices'])) {
            if($access['PropertyNotices']['r_approvals']=='1') {
                $id = $request->get('id');
                $user_id = auth()->user()->gu_id;

                $data2['approved_by'] = $user_id;
                $data2['approved_at'] = date('Y-m-d H:i:s');
                $data2['status'] = 'approved';
                if(isset($id)) {
                    Pn_file_property_notice::find($id)->update($data2);
                }

                $msg = 'Property Notice Approved!';
            } else {
                $msg = 'You donot have access to this page.';
            }
        } else {
            $msg = 'You donot have access to this page.';
        }

        echo $msg;
    }
    
    public function reject_record(Request $request) {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['PropertyNotices'])) {
            if($access['PropertyNotices']['r_approvals']=='1') {
                $id = $request->get('id');
                $user_id = auth()->user()->gu_id;

                $data2['approved_by'] = $user_id;
                $data2['approved_at'] = date('Y-m-d H:i:s');
                $data2['status'] = 'rejected';
                if(isset($id)) {
                    Pn_file_property_notice::find($id)->update($data2);
                }

                $msg = 'Property Notice Rejected!';
            } else {
                $msg = 'You donot have access to this page.';
            }
        } else {
            $msg = 'You donot have access to this page.';
        }

        echo $msg;
    }
    
    public function details($id){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['PropertyNotices'])) {
            if($access['PropertyNotices']['r_view']=='1') {
                $data = $this->get_data($id);
                $notice_id = $data[0]->fk_notice_id;
                $property_id = $data[0]->fk_property_id;

                $newspaper_list = Pn_newspaper::orderBy('paper_name','asc')->get();
                $notice_type_list = Pn_notice_type::orderBy('notice_type','asc')->get();
                $property_no_type_list = Pn_property_no_type::orderBy('property_no_type','asc')->get();
                $location_type_list = Pn_location_type::orderBy('location_type','asc')->get();
                $certificate_no_type_list = Pn_certificate_no_type::orderBy('certificate_no_type','asc')->get();
                
                $notice = Pn_notice::find($notice_id);
                $legal_owner_name = Pn_notice_legal_owner_name::where('fk_notice_id', $notice_id)->get();
                $purchased_from = Pn_notice_purchased_from::where('fk_notice_id', $notice_id)->get();
                $company_name = Pn_notice_company_name::where('fk_notice_id', $notice_id)->get();
                $guarantor = Pn_notice_guarantor::where('fk_notice_id', $notice_id)->get();
                $property_no_detail = Pn_notice_property_no_detail::where('fk_notice_id', $notice_id)->get();
                $location_detail = Pn_notice_location_detail::where('fk_notice_id', $notice_id)->get();
                $certificate_no_detail = Pn_notice_certificate_no_detail::where('fk_notice_id', $notice_id)->get();

                $property = Pn_file_property::find($property_id);
                $owner_name1 = explode(',', $property->owner_name);
                $legal_owner_name1 = array();
                $i = 0;
                if(isset($owner_name1)){
                    if(count($owner_name1)>0){
                        for($i=0; $i<count($owner_name1); $i++){
                            $legal_owner_name1[$i]['legal_owner_name'] = $owner_name1[$i];
                        }
                    }
                }

                $location1 = array();
                $i = 0;
                if(isset($property->division)){
                    if($property->division!=''){
                        $location1[$i]['fk_location_type_id'] = 1;
                        $location1[$i]['location'] = $property->division;
                        $i = $i + 1;
                    }
                }
                if(isset($property->taluka)){
                    if($property->taluka!=''){
                        $location1[$i]['fk_location_type_id'] = 2;
                        $location1[$i]['location'] = $property->taluka;
                        $i = $i + 1;
                    }
                }
                if(isset($property->post)){
                    if($property->post!=''){
                        $location1[$i]['fk_location_type_id'] = 3;
                        $location1[$i]['location'] = $property->post;
                        $i = $i + 1;
                    }
                }
                if(isset($property->area)){
                    if($property->area!=''){
                        $location1[$i]['fk_location_type_id'] = 4;
                        $location1[$i]['location'] = $property->area;
                        $i = $i + 1;
                    }
                }
                if(isset($property->village)){
                    if($property->village!=''){
                        $location1[$i]['fk_location_type_id'] = 5;
                        $location1[$i]['location'] = $property->village;
                        $i = $i + 1;
                    }
                }

                $property_no1 = array();
                $i = 0;
                if(isset($property->unit_no)){
                    if($property->unit_no!=''){
                        $property_no1[$i]['fk_property_no_type_id'] = 9;
                        $property_no1[$i]['property_no'] = $property->unit_no;
                        $i = $i + 1;
                    }
                }
                if(isset($property->cs_no)){
                    if($property->cs_no!=''){
                        $property_no1[$i]['fk_property_no_type_id'] = 14;
                        $property_no1[$i]['property_no'] = $property->cs_no;
                        $i = $i + 1;
                    }
                }
                if(isset($property->cts_no)){
                    if($property->cts_no!=''){
                        $property_no1[$i]['fk_property_no_type_id'] = 10;
                        $property_no1[$i]['property_no'] = $property->cts_no;
                        $i = $i + 1;
                    }
                }
                if(isset($property->gut_no)){
                    if($property->gut_no!=''){
                        $property_no1[$i]['fk_property_no_type_id'] = 12;
                        $property_no1[$i]['property_no'] = $property->gut_no;
                        $i = $i + 1;
                    }
                }
                if(isset($property->hissa_no)){
                    if($property->hissa_no!=''){
                        $property_no1[$i]['fk_property_no_type_id'] = 13;
                        $property_no1[$i]['property_no'] = $property->hissa_no;
                        $i = $i + 1;
                    }
                }
                if(isset($property->plot_no)){
                    if($property->plot_no!=''){
                        $property_no1[$i]['fk_property_no_type_id'] = 7;
                        $property_no1[$i]['property_no'] = $property->plot_no;
                        $i = $i + 1;
                    }
                }

                return view('upload_property.details', ['access' => $access, 'data' => $data, 'notice' => $notice, 'legal_owner_name' => $legal_owner_name, 
                                                        'purchased_from' => $purchased_from, 'company_name' => $company_name, 
                                                        'guarantor' => $guarantor, 'property_no_detail' => $property_no_detail, 
                                                        'location_detail' => $location_detail, 'certificate_no_detail' => $certificate_no_detail, 
                                                        'newspaper_list' => $newspaper_list, 'notice_type_list' => $notice_type_list, 
                                                        'property_no_type_list' => $property_no_type_list, 'location_type_list' => $location_type_list, 
                                                        'certificate_no_type_list' => $certificate_no_type_list, 'property' => $property, 
                                                        'legal_owner_name1' => $legal_owner_name1, 
                                                        'property_no_detail1' => $property_no1, 
                                                        'location_detail1' => $location1]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function save(Request $request){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['PropertyNotices'])) {
            if($access['PropertyNotices']['r_insert']=='1' || $access['PropertyNotices']['r_edit']=='1' || $access['PropertyNotices']['r_delete']=='1' || $access['PropertyNotices']['r_approvals']=='1') {
                // $this->validate($request, [
                //     'owner_1' => 'required',
                //     'property_name' => 'required',
                //     'address' => 'required',
                // ]);

                $data = $request->all();

                $user_id = auth()->user()->gu_id;
                $data2['approved_by'] = $user_id;
                $data2['approved_at'] = date('Y-m-d H:i:s');

                if(isset($data['approve'])){
                    $data2['status'] = 'approved';
                    $msg = 'Property Notice approved successfully!';
                } else {
                    $data2['status'] = 'rejected';
                    $msg = 'Property Notice rejected successfully!';
                }
                
                Pn_file_property_notice::find($data['id'])->update($data2);
                Session::flash('success_msg', $msg);

                return redirect('index.php/upload_property_notice');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function reject(Request $request){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['PropertyNotices'])) {
            if($access['PropertyNotices']['r_approvals']=='1') {
                $id = $request->get('property_notice_id');
                
                $user_id = auth()->user()->gu_id;

                for($i=0;$i<count($id);$i++)
                {
                   
                    $data2['approved_by'] = $user_id;
                    $data2['approved_at'] = date('Y-m-d H:i:s');
                    $data2['status'] = 'rejected';
                    if(isset($id[$i])){
                        Pn_file_property_notice::find($id[$i])->update($data2);
                       
                    } 
                }
                $msg = 'Property Notice Rejected!';    
                Session::flash('success_msg', $msg);

                return redirect('index.php/upload_property_notice');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function export(){
        $items = Pn_property_file::all();
        echo json_encode($items);

        // Excel::create('items', function($excel) use($items) {
        //     $excel->sheet('ExportFile', function($sheet) use($items) {
        //         $sheet->fromArray($items);
        //     });
        // })->export('xls');
    }

    public function download_report($id='', $action=''){
        $sql = "select A.id, A.created_at, count(B.id) as no_of_property 
                from pn_property_files A 
                left join pn_file_properties B on (A.id=B.fk_file_id) 
                where A.id = '$id' 
                group by A.id, A.created_at";
        $file_details = DB::select($sql);
        if(count($file_details)>0){
            $data_received_at = date('d/m/Y',strtotime($file_details[0]->created_at));
            $no_of_property = $file_details[0]->no_of_property;
        } else {
            $data_received_at = '';
            $no_of_property = '';
        }

        $sql = "select AA.fk_property_id, AA.owner_name, AA.address, BB.no_of_notices, AA.date_of_notice, 
                    AA.paper_name, AA.page_number, AA.notice_type, AA.remark, AA.notice_file from 
                (select B.id as fk_property_id, B.owner_name, B.address, D.date_of_notice, D.fk_newspaper_id, 
                    C.fk_notice_id, D.fk_notice_type_id, D.page_number, E.paper_name, F.notice_type, 
                    group_concat(concat(G.parameter, ' ', G.matching_criteria)) as remark, 
                    concat('".url('/')."/uploads/notices/', D.notice_file) as notice_file 
                from pn_property_files A 
                left join pn_file_properties B on (A.id=B.fk_file_id) 
                left join pn_file_property_notices C on (B.id=C.fk_property_id and C.status='approved') 
                left join pn_notices D on (C.fk_notice_id=D.id) 
                left join pn_newspapers E on (D.fk_newspaper_id=E.id) 
                left join pn_notice_types F on (D.fk_notice_type_id=F.id) 
                left join pn_file_notice_criterias G on (C.id=G.pn_property_notice_id) 
                where A.id = '$id' 
                group by B.id, B.owner_name, B.address, D.date_of_notice, D.fk_newspaper_id, 
                    C.fk_notice_id, D.fk_notice_type_id, D.page_number, E.paper_name, F.notice_type, 
                    D.notice_file) AA 
                left join 
                (select fk_property_id, count(id) as no_of_notices from pn_file_property_notices 
                where status='Approved' group by fk_property_id) BB 
                on (AA.fk_property_id=BB.fk_property_id) 
                order by AA.fk_property_id";
        $result = DB::select($sql);

        // $template_path=url('/')."/templates/PN_Report.xlsx";
        $template_path=public_path()."/templates/PN_Report.xlsx";
        // $template_path=public_path()."\\templates\\PN_Report.xlsx";

        // $excel = new \PHPExcel();
        $excel = \PHPExcel_IOFactory::load($template_path);
        $excel->setActiveSheetIndex(0);
        $objWorksheet = $excel->getActiveSheet();

        $col_name[]=array();
        for($i=0; $i<=100; $i++) {
            $col_name[$i] = \PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $row = 2;
        $col = 0;
        $objWorksheet->setCellValue($col_name[$col+4].strval($row), $data_received_at);
        $row = $row + 1;
        $objWorksheet->setCellValue($col_name[$col+0].strval($row), 'No. Of Properties: '.$no_of_property);
        $objWorksheet->setCellValue($col_name[$col+4].strval($row), date('d/m/Y'));
        $row = $row + 4;
        $fk_property_id = '';
        $old_fk_property_id = '';
        $sr_no = 1;
        
        for($i=0; $i<count($result); $i++){
            $fk_property_id = $result[$i]->fk_property_id;
            if($fk_property_id!=$old_fk_property_id){
                $old_fk_property_id = $fk_property_id;
                $objWorksheet->setCellValue($col_name[$col+0].strval($row), $sr_no);
                $objWorksheet->setCellValue($col_name[$col+1].strval($row), $result[$i]->owner_name);
                $objWorksheet->setCellValue($col_name[$col+2].strval($row), $result[$i]->address);
                $sr_no = $sr_no + 1;
            }
            
            $no_of_notices = '';
            if(isset($result[$i]->no_of_notices)){
                if($result[$i]->no_of_notices!=''){
                    $no_of_notices = $result[$i]->no_of_notices;
                }
            }

            if($no_of_notices!=''){
                $objWorksheet->setCellValue($col_name[$col+3].strval($row), $result[$i]->no_of_notices);
                $objWorksheet->setCellValue($col_name[$col+4].strval($row), date('d/m/Y',strtotime($result[$i]->date_of_notice)));
                $objWorksheet->setCellValue($col_name[$col+5].strval($row), $result[$i]->paper_name);
                $objWorksheet->setCellValue($col_name[$col+6].strval($row), $result[$i]->page_number);
                $objWorksheet->setCellValue($col_name[$col+7].strval($row), $result[$i]->notice_type);
                $objWorksheet->setCellValue($col_name[$col+8].strval($row), $result[$i]->remark);
                $objWorksheet->setCellValue($col_name[$col+9].strval($row), $result[$i]->notice_file);
            } else {
                $objWorksheet->setCellValue($col_name[$col+3].strval($row), 'NA');
                $objWorksheet->setCellValue($col_name[$col+4].strval($row), 'NA');
                $objWorksheet->setCellValue($col_name[$col+5].strval($row), 'NA');
                $objWorksheet->setCellValue($col_name[$col+6].strval($row), 'NA');
                $objWorksheet->setCellValue($col_name[$col+7].strval($row), 'NA');
                $objWorksheet->setCellValue($col_name[$col+8].strval($row), 'NA');
                $objWorksheet->setCellValue($col_name[$col+9].strval($row), 'NA');
            }
            
            $row = $row + 1;
        }

        $objWorksheet->getStyle('A6:'.$col_name[$col+9].strval($row-1))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        $filename='PN_Report_'.$id.'_'.date('dmyHis').'.xlsx';

        if($action=="save") {
            $path  = "/var/www/html/admin/assure/public/reports/";
            $upload_path  = "/var/www/html/admin/assure/public/reports";

            // $path  = 'C:/wamp64/www/pecanreams/admin/assure/public/reports/';
            // $upload_path = 'C:/wamp64/www/pecanreams/admin/assure/public/reports';
            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }
            $reportpath = $path.$filename;

            $writer = \PHPExcel_IOFactory::createWriter($excel, 'Excel2007'); 
            $writer->save($reportpath);

            return $reportpath;
        } else {
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $writer = new \PHPExcel_Writer_Excel2007($excel);
            $writer->save('php://output');

            exit;
        }
    }

    public function send_report($id=''){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['PropertyNotices'])) {
            if($access['PropertyNotices']['r_insert']=='1' || $access['PropertyNotices']['r_edit']=='1' || $access['PropertyNotices']['r_delete']=='1' || $access['PropertyNotices']['r_approvals']=='1') {
                if(isset($id)){
                    $report_file = $this->download_report($id, 'save');
                    $name = 'Prasad';
                    $email = 'prasad.bhisale@pecanreams.com';
                    $this->send_report_email($name, $email, $report_file);

                    $msg = 'Report sent successfully!';
                    Session::flash('success_msg', $msg);
                }

                return redirect('index.php/upload_property');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function send_report_email($name, $email, $report_file){
        $data = array('name'=>$name, 'email'=>$email, 'report_file'=>$report_file);

        Mail::send('upload_property.mail', $data, function($message) use ($data) {
            $message->to($data['email'], $data['name'])
                    ->subject('Public Notice Matching Report')
                    ->from('info@pecanreams.com','Pecan Reams')
                    ->bcc('prasad.bhisale@pecanreams.com', 'Prasad')
                    ->attach($data['report_file']);
        });
    }

    public function send_sms($name, $property_name, $link, $mobile){
        $sms = "Hi%20".$name."%2C%20we%20have%20identified%20public%20notice%20on%20your%20asset%3a%20".$property_name."%2E%20To%20view%20details%20please%20click%20on%20the%20link%2E%20".$link;
        $sms = str_replace(' ', '%20', $sms);
        $sms = str_replace(':', '%3A', $sms);
        $sms = str_replace(',', '%2C', $sms);
        $surl = "http://smshorizon.co.in/api/sendsms.php?user=Ashish_Chandak&apikey=QizzeB4YLplingobMXX2&mobile=" . $mobile . "&message=" . $sms . "&senderid=PECANR&type=txt";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $surl);
        curl_exec($ch);
        curl_close($ch);
    }

    public function send_email($name, $email, $mobile, $property_name, $date_of_notice, $address, $paper_name, $link, $notice_file){
        $data = array('name'=>$name, 'email'=>$email, 'mobile'=>$mobile, 'property_name'=>$property_name, 
                        'date_of_notice'=>$date_of_notice, 'address'=>$address, 'paper_name'=>$paper_name, 
                        'link'=>$link, 'notice_file'=>$notice_file);

        Mail::send('upload_property.mail', $data, function($message) use ($data) {
            $message->to($data['email'], $data['name'])
                    ->subject('Notice Alert On Property - '.$data['property_name'])
                    ->from('info@pecanreams.com','Pecan Reams')
                    ->bcc('pranav@pecanreams.com', 'Pranav')
                    ->attach(url('/') . '/uploads/notices/' . $data['notice_file']);
        });
    }

    public function send(Request $request){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['PropertyNotices'])) {
            if($access['PropertyNotices']['r_insert']=='1' || $access['PropertyNotices']['r_edit']=='1' || $access['PropertyNotices']['r_delete']=='1' || $access['PropertyNotices']['r_approvals']=='1') {
                $data = $request->all();

                if(isset($data['id'])){
                    foreach($data['id'] as $id){
                        $data2 = $this->get_data($id);

                        if(count($data2)>0){
                            $name = $data2[0]->property_by;
                            $email = $data2[0]->gu_email;
                            $mobile = $data2[0]->gu_mobile;
                            $property_name = $data2[0]->property_name;
                            $date_of_notice = $data2[0]->date_of_notice;
                            $address = $data2[0]->address;
                            $paper_name = $data2[0]->paper_name;

                            // $link = url('index.php/user_notice');
                            $link = url('uploads/notices', $data2[0]->notice_file);

                            $notice_file = $data2[0]->notice_file;

                            // $email = 'prasad.bhisale@pecanreams.com';
                            // $mobile = '9773560529';

                            $this->send_sms($name, $property_name, $link, $mobile);
                            $this->send_email($name, $email, $mobile, $property_name, $date_of_notice, $address, $paper_name, $link, $notice_file);

                            $fk_group_id = $data2[0]->fk_group_id;
                            $sql = "select * from pn_group_contacts where fk_group_id = '$fk_group_id'";
                            $data4 = DB::select($sql);
                            if(count($data4)>0){
                                for($j=0; $j<count($data4); $j++){
                                    $this->send_sms($data4[$j]->name, $property_name, $link, $data4[$j]->mobile);
                                    $this->send_email($data4[$j]->name, $data4[$j]->email, $data4[$j]->mobile, $property_name, $date_of_notice, $address, $paper_name, $link, $notice_file);
                                }
                            }
                            
                            $user_id = auth()->user()->gu_id;
                            $data4['sent_by'] = $user_id;
                            $data4['sent_at'] = date('Y-m-d H:i:s');
                            $data4['status'] = 'approved';
                            
                            Pn_file_property_notice::find($id)->update($data4);
                        }
                    }

                    $msg = 'Property Notice sent successfully!';
                    Session::flash('success_msg', $msg);
                }

                return redirect('index.php/upload_property_notice');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
        }
    }
}