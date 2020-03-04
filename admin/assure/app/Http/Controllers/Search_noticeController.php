<?php

namespace App\Http\Controllers;

use App\TesseractOCR;
use App\User;
use App\Pn_notice;
use App\Pn_newspaper;
use App\Pn_notice_type;
use App\Pn_property_no_type;
use App\Pn_property_notice;
use App\Pn_location_type;
use App\Pn_certificate_no_type;
use App\Pn_notice_legal_owner_name;
use App\Pn_notice_purchased_from;
use App\Pn_notice_company_name;
use App\Pn_notice_guarantor;
use App\Pn_notice_property_no_detail;
use App\Pn_notice_location_detail;
use App\Pn_notice_certificate_no_detail;
use App\Pn_no_notice;
use App\Pn_property;
use App\Pn_notice_criteria;
use App\Pn_notice_othername;
use App\Pn_notice_scan;
use App\Pn_notice_count;
use Illuminate\Http\Request;
use Session;
use DB;
use Carbon\Carbon;
use DateTime;

class Search_noticeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Notices'])) {
            if($access['Notices']['r_view']=='1' || $access['Notices']['r_insert']=='1' || $access['Notices']['r_edit']=='1' || $access['Notices']['r_delete']=='1' || $access['Notices']['r_approvals']=='1' || $access['Notices']['r_export']=='1') {
                $newspaper_list = DB::select("select * from pn_newspapers where status = 'approved'");
                return view('search_notice.index', ['access' => $access, 'newspaper_list' => $newspaper_list]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Search_notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Search_notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    function FormatDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        $returnDate = null;
        if ($d && $d->format($format) == $date) {
            // $returnDate = DateTime::createFromFormat($format, $date)->format('Y-m-d');
            $dateInput = explode('/',$date);
            $returnDate = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
        }

        return $returnDate;
    }

    public function get_data(Request $request){
    // public function get_data(){
        // echo 'get_data1';
        // exit;

        // $params = $columns = $totalRecords = $data = array();
        // $data = $request->all();

        // if(isset($data['notice_type_id'])) {
        //     $notice_type_id = $data['notice_type_id'];
        // } else {
        //     $notice_type_id = '0';
        // }
        // if(isset($data['newspaper'])) {
        //     $newspaper = $data['newspaper'];
        // } else {
        //     $newspaper = '';
        // }
        // if(isset($data['from_date'])) {
        //     $from_date = $data['from_date'];
        // } else {
        //     $from_date = '';
        // }
        // if(isset($data['to_date'])) {
        //     $to_date = $data['to_date'];
        // } else {
        //     $to_date = '';
        // }
        // if(isset($data['keyword'])) {
        //     $keyword = $data['keyword'];
        // } else {
        //     $keyword = '';
        // }
        // if(isset($data['match_word'])) {
        //     $match_word = $data['match_word'];
        // } else {
        //     $match_word = '';
        // }
        // if(isset($data['search']['value'])) {
        //     $search_value = $data['search']['value'];
        // } else {
        //     $search_value = '';
        // }

        // $notice_type_id = '0';
        // $newspaper = '';
        // $from_date = '';
        // $to_date = '';
        // $keyword = '';
        // $match_word = '';
        // $search_value = '';

        $params = $columns = $totalRecords = $data = array();
        // $params = $_REQUEST;
        $params = $request->all();
        // $ip_address =  $_SERVER['REMOTE_ADDR'];
        $date = date("Y-m-d H:i:s");

        // $params['draw'] = 1;
        // $params['start'] = 0;
        // $params['length'] = 10;
        // $params['notice_type_id'] = 0;
        // $params['newspaper'] = 'All';
        // $params['keyword'] = 'ABC';
        // $params['match_word'] = "any";
        
        if(isset($params['notice_type_id'])) {
            $notice_type_id = $params['notice_type_id'];
        } else {
            $notice_type_id = '';
        }
        if(isset($params['newspaper'])) {
            $newspaper = $params['newspaper'];
        } else {
            $newspaper = '';
        }
        if(isset($params['from_date'])) {
            $from_date = $params['from_date'];
        } else {
            $from_date = '';
        }
        if(isset($params['to_date'])) {
            $to_date = $params['to_date'];
        } else {
            $to_date = '';
        }
        if(isset($params['keyword'])) {
            $keyword = $params['keyword'];
        } else {
            $keyword =  "" ;
        }
        if(isset($params['match_word'])) {
            $match_word = $params['match_word'];
        } else {
            $match_word = "";
        }
        if(isset($params['search']['value'])) {
            $search_value = $params['search']['value'];
        } else {
            $search_value = '';
        }

        $cond = "";

        if(isset($notice_type_id)){
            if($notice_type_id>0){
                $cond = $cond . " and A.fk_notice_type_id = '$notice_type_id'";
            }
        }

        if($newspaper!="All" && $newspaper!=""){
            $cond = $cond . " and A.fk_newspaper_id = '$newspaper'";
        }
        if($from_date!=""){
            // $returnDate = null;
            // $dateInput = explode('/',$from_date);
            // $returnDate = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
            // $from_date = $returnDate;
            $from_date = $this->FormatDate($from_date);
            if($from_date!=null){
                $cond = $cond . " and A.date_of_notice >= '$from_date'";
            }
        }
        if($to_date!=""){
            // $returnDate = null;
            // $dateInput = explode('/',$to_date);
            // $returnDate = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
            // $to_date = $returnDate;
            $to_date = $this->FormatDate($to_date);
            if($to_date!=null){
                $cond = $cond . " and A.date_of_notice <= '$to_date'";
            }
        }

        $criteria = "";
        $match = "";

        if($match_word=='exact'){
            if($keyword!=''){
                $criteria = " ='".$keyword."' ";
            }
        } else {
            if($keyword!=''){
                $criteria = " like '%".$keyword."%' ";
            }
        }

        if(isset($_POST['noticetypetext']))
            $noticetypetext =  $_POST['noticetypetext'];
        else
            $noticetypetext =  '';

        
        if(isset($_POST['newspapertext']))
            $newspapertext =  $_POST['newspapertext'];
        else
            $newspapertext =  '';

        // $sql2 = "INSERT INTO 
        //         user_tracking_assure (ip_address,searched_from,search_type,type_id,type_text,module_name,searched_on,action,start_date,end_date,match_keyword,newspaper)
        //         VALUES ('$ip_address', 'Web Page','Notice Type','$noticetypetext','$keyword','Search Notice','$date','Clicked On Search Data','$from_date','$to_date','$match_word','$newspapertext')";
        // $conn->query($sql2);

        $notice_id = array();
        $i=0;
        if($criteria==''){
            $posts = [];
            $sql = "select A.id from pn_notices A where A.status = 'approved' " . $cond;
            $result=DB::select($sql);
            foreach($result as $row){
                $posts[] = $row->id;
            }

            if(count($posts)>0) {
                $ids =  implode(",", $posts);
            } else {
                $ids =  0;
            }

            $sql = "select distinct A.id from pn_notices A 
                    where A.id in ($ids) and A.status = 'approved' and 
                        (A.city like '%".$search_value."%' or A.pincode like '%".$search_value."%' or A.property_type like '%".$search_value."%' or 
                        A.floor like '%".$search_value."%' or A.wing like '%".$search_value."%' or A.building_name like '%".$search_value."%' or 
                        A.society_name like '%".$search_value."%' or A.address like '%".$search_value."%'  or A.property_description like '%".$search_value."%'  or A.notice_title like '%".$search_value."%' or A.state like '%".$search_value."%')";
            $result2=DB::select($sql);
            if(count($result2)>0){
                foreach($result2 as $row2){
                    $notice_id[$i++] = $row2->id;
                }
            }

            $sql = "select distinct A.id from pn_notices A 
                    left join pn_notice_location_details B on (A.id = B.fk_notice_id) 
                    where A.id in ($ids) and A.status = 'approved' and B.location like '%".$search_value."%'";
            $result2=DB::select($sql);
            if(count($result2)>0){
                foreach($result2 as $row2){
                    $notice_id[$i++] = $row2->id;
                }
            }

            $sql = "select distinct A.id from pn_notices A 
                    left join pn_notice_property_no_details C on (A.id = C.fk_notice_id) 
                    where A.id in ($ids) and A.status = 'approved' and C.property_no like '%".$search_value."%'";
            $result2=DB::select($sql);
            if(count($result2)>0){
                foreach($result2 as $row2){
                    $notice_id[$i++] = $row2->id;
                }
            }

            $sql = "select distinct A.id from pn_notices A 
                    left join pn_notice_certificate_no_details D on (A.id = D.fk_notice_id) 
                    where A.id in ($ids) and A.status = 'approved' and D.certificate_no like '%".$search_value."%'";
            $result2=DB::select($sql);
            if(count($result2)>0){
                foreach($result2 as $row2){
                    $notice_id[$i++] = $row2->id;
                }
            }

            $sql = "select distinct A.id from pn_notices A 
                    left join pn_notice_legal_owner_names E on (A.id = E.fk_notice_id) 
                    where A.id in ($ids) and A.status = 'approved' and E.legal_owner_name like '%".$search_value."%'";
            $result2=DB::select($sql);
            if(count($result2)>0){
                foreach($result2 as $row2){
                    $notice_id[$i++] = $row2->id;
                }
            }

            $sql = "select distinct A.id from pn_notices A 
                    left join pn_notice_purchased_froms F on (A.id = F.fk_notice_id) 
                    where A.id in ($ids) and A.status = 'approved' and F.purchased_from like '%".$search_value."%'";
            $result2=DB::select($sql);
            if(count($result2)>0){
                foreach($result2 as $row2){
                    $notice_id[$i++] = $row2->id;
                }
            }

            $sql = "select distinct A.id from pn_notices A 
                    left join pn_notice_company_names G on (A.id = G.fk_notice_id) 
                    where A.id in ($ids) and A.status = 'approved' and G.company_name like '%".$search_value."%'";
            $result2=DB::select($sql);
            if(count($result2)>0){
                foreach($result2 as $row2){
                    $notice_id[$i++] = $row2->id;
                }
            }
        } else {

            $sql = "select A.id from pn_notices A where A.status = 'approved' " . $cond;
            $result=DB::select($sql);
            $posts = [];
            foreach($result as $row){
                $posts[] = $row->id;
            }

            if(count($posts)>0) {
                $ids =  implode(",", $posts);
            } else {
                $ids =  0;
            }
            
            $sql = "select distinct A.id from pn_notices A 
                    where A.id  in ($ids) and A.status = 'approved' and 
                        (A.city ".$criteria." or A.pincode ".$criteria." or A.property_type ".$criteria." or A.floor ".$criteria." or 
                        A.wing ".$criteria." or A.building_name ".$criteria." or A.society_name ".$criteria." or A.address ".$criteria." or 
                        A.property_description ".$criteria." or A.notice_title ".$criteria."
                          or A.state ".$criteria." ) and 
                        (A.city like '%".$search_value."%' or A.pincode like '%".$search_value."%' or A.property_type like '%".$search_value."%' or 
                        A.floor like '%".$search_value."%' or A.wing like '%".$search_value."%' or A.building_name like '%".$search_value."%' or 
                        A.society_name like '%".$search_value."%' or A.address like '%".$search_value."%' or A.property_description like '%".$search_value."%' or A.notice_title like '%".$search_value."%' or A.state like '%".$search_value."%')";

            $result2=DB::select($sql);
            if(count($result2)>0)
            {
                foreach($result2 as $row2){
                    $notice_id[$i++] = $row2->id;
                }
                /*if(count($notice_id)>0)
                {
                    goto Next2;
                }*/
            }

            $sql = "select distinct A.id from pn_notices A 
                    left join pn_notice_location_details B on (A.id = B.fk_notice_id) 
                    where A.id in ($ids) and A.status = 'approved' and 
                        B.location ".$criteria." and B.location like '%".$search_value."%'";
            $result2=DB::select($sql);
            if(count($result2)>0){
                foreach($result2 as $row2){
                    $notice_id[$i++] = $row2->id;
                }
                /*if(count($notice_id)>0)
                {
                    goto Next2;
                }*/
            }

            $sql = "select distinct A.id from pn_notices A 
                    left join pn_notice_property_no_details C on (A.id = C.fk_notice_id) 
                    where A.id in ($ids) and A.status = 'approved' and 
                        C.property_no ".$criteria." and C.property_no like '%".$search_value."%'";
            $result2=DB::select($sql);
            if(count($result2)>0){
                foreach($result2 as $row2){
                    $notice_id[$i++] = $row2->id;
                }
                /*if(count($notice_id)>0)
                {
                    goto Next2;
                }*/
            }

            $sql = "select distinct A.id from pn_notices A 
                    left join pn_notice_certificate_no_details D on (A.id = D.fk_notice_id) 
                    where A.id in ($ids) and A.status = 'approved' and 
                        D.certificate_no ".$criteria." and D.certificate_no like '%".$search_value."%'";
            $result2=DB::select($sql);
            if(count($result2)>0){
                foreach($result2 as $row2){
                    $notice_id[$i++] = $row2->id;
                }
                /*if(count($notice_id)>0)
                {
                    goto Next2;
                }*/
            }

            $sql = "select distinct A.id from pn_notices A 
                    left join pn_notice_legal_owner_names E on (A.id = E.fk_notice_id) 
                    where A.id in ($ids) and A.status = 'approved' and 
                        E.legal_owner_name ".$criteria." and E.legal_owner_name like '%".$search_value."%'";
            $result2=DB::select($sql);
            if(count($result2)>0){
                foreach($result2 as $row2){
                    $notice_id[$i++] = $row2->id;
                }
                /*if(count($notice_id)>0)
                {
                    goto Next2;
                }*/
            }

            $sql = "select distinct A.id from pn_notices A 
                    left join pn_notice_purchased_froms F on (A.id = F.fk_notice_id) 
                    where A.id in ($ids) and A.status = 'approved' and 
                        F.purchased_from ".$criteria." and F.purchased_from like '%".$search_value."%'";
            $result2=DB::select($sql);
            if(count($result2)>0){
                foreach($result2 as $row2){
                    $notice_id[$i++] = $row2->id;
                }
                /*if(count($notice_id)>0)
                {
                    goto Next2;
                }*/
            }

            $sql = "select distinct A.id from pn_notices A 
                    left join pn_notice_company_names G on (A.id = G.fk_notice_id) 
                    where A.id in ($ids) and A.status = 'approved' and 
                        G.company_name ".$criteria." and G.company_name like '%".$search_value."%'";
            $result2=DB::select($sql);
            if(count($result2)>0){
                foreach($result2 as $row2){
                    $notice_id[$i++] = $row2->id;
                }
                /*if(count($notice_id)>0)
                {
                    goto Next2;
                }*/
            }
        }
        
        $totalRecords = 0;
        if(count($notice_id)>0){
            $sql = "select count(id) as tot_cnt from pn_notices where status='approved' and id in (".implode(',', $notice_id).")";
            $queryTot=DB::select($sql);
            if(count($queryTot)>0){
                $totalRecords = $queryTot[0]->tot_cnt;
            }
        }

        $notice = array();
        if(count($notice_id)>0){
            $sql = "select id, date_of_notice, address, notice_file, notice_title from pn_notices where status='approved' and id in (".implode(',', $notice_id).") order by date_of_notice desc 
                    LIMIT ".$params['start'].", ".$params['length'];
            $notice=DB::select($sql);
        }

        $notice_data = array();
        if(count($notice)>0){
            foreach($notice as $data){
                $row = array(
                            '<a href="'.url('uploads/notices/'.$data->notice_file).'" target="_new">
                            <img src="'.url('uploads/notices/'.$data->notice_file).'" style="width: 120px; height: 135px;">
                            </a>',
                            '<div style="font-weight: bold; font-size: 15px;">'.$data->notice_title.'</div>
                            <div>'.date('d/m/Y',strtotime($data->date_of_notice)).'</div>
                            <div style="line-height: 15px;">'.$data->address.'</div>
                            <div><a href="'.url('uploads/notices/'.$data->notice_file).'" target="_new">Read More</a></div>'
                        );
                // $row = array(
                //             $data->notice_file,
                //             $data->notice_title
                //         );
                $notice_data[] = $row;
            }
        }

        $json_data = array(
                    "draw"            => intval($params['draw']),   
                    "recordsTotal"    => intval($totalRecords),  
                    "recordsFiltered" => intval($totalRecords),
                    "data"            => $notice_data
                    );

        echo json_encode($json_data);
    }
}
