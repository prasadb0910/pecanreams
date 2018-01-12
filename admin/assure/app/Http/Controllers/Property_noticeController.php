<?php

namespace App\Http\Controllers;

use App\Pn_property_notice;
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
use App\Pn_property_legal_owner_name;
use App\Pn_property_purchased_from;
use App\Pn_property_company_name;
use App\Pn_property_guarantor;
use App\Pn_property_prop_no_detail;
use App\Pn_property_location_detail;
use App\Pn_property_certificate_no_detail;
use App\Pn_no_notice;
use App\Pn_property;
use App\Pn_group;
use App\User;
use DB;
use Session;
use Mail;

class Property_noticeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_data($id='', $status=''){
        $cond = "";

        if($id!=''){
            $cond = " where A.id = '$id'";
        }
        if($status!=''){
            if($cond==''){
                $cond = " where A.status = '$status'";
            } else {
                $cond = $cond . " and A.status = '$status'";
            }
        }
        $sql = "select A.id, A.fk_property_id, A.fk_notice_id, A.status, B.owner_1, B.owner_2, B.property_name, B.purchased_from, B.property_type, 
                B.description, B.building_name, B.society_name, B.address, B.apartment_no, B.floor, B.wing, B.district, B.city, B.pincode, 
                B.village, B.taluka, B.post, B.division, B.state, B.country, B.google_map_address, B.sheet_no, B.room_no, B.block_no, 
                B.ward_no, B.khata_no, B.sr_no, B.plot_no, B.scheme_no, B.cts_no, B.survey_no, B.gut_no, B.hissa_no, B.area, 
                B.no_of_parking, B.guarantors, B.company_name, B.company_reg_no, B.certificate_no, B.distinctive_no, B.folio_no, B.fk_group_id, 
                C.notice_title, C.date_of_notice, C.notice_file, C.details, C.fk_newspaper_id, C.days_for_respond, C.issued_by, 
                C.reason_for_notice, C.issued_for, C.subject_matter, C.name_of_property, C.date_of_purchase, C.property_status, 
                C.property_type, C.property_description, C.building_name, C.unit_no, C.floor, C.wing, C.address, C.landmark, 
                C.village, C.city, C.pincode, C.state, C.country, C.google_map_address, C.cts_no, C.survey_number, C.area, C.parking, 
                C.legal_owner_name, C.legal_owner_pan, C.legal_owner_address, C.company_name, C.company_registration_no, 
                C.fk_notice_type_id, C.society_name, C.page_number, D.paper_name, E.notice_type, F.name, F.gu_email, F.gu_mobile 
                from pn_property_notices A 
                left join pn_properties B on (A.fk_property_id=B.id) 
                left join pn_notices C on (A.fk_notice_id=C.id) 
                left join pn_newspapers D on (C.fk_newspaper_id=D.id) 
                left join pn_notice_types E on (C.fk_notice_type_id=E.id) 
                left join group_users F on (B.created_by = F.gu_id)" . $cond . " order by A.updated_at desc";
        $data = DB::select($sql);
        return $data;
    }
    
    public function index(){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['PropertyNotices'])) {
            if($access['PropertyNotices']['r_view']=='1' || $access['PropertyNotices']['r_insert']=='1' || $access['PropertyNotices']['r_edit']=='1' || $access['PropertyNotices']['r_delete']=='1' || $access['PropertyNotices']['r_approvals']=='1' || $access['PropertyNotices']['r_export']=='1') {
                // $this->match_notice();
                // $this->match_property();
                $all = $this->get_data();
                $approved = $this->get_data('', 'approved');
                $pending_for_approval = $this->get_data('', 'pending');
                $pending_to_send = $this->get_data('', 'pending to send');
                $rejected = $this->get_data('', 'rejected');
                return view('property_notice.index', ['access' => $access, 'all' => $all, 'approved' => $approved, 
                                                        'pending_for_approval' => $pending_for_approval, 'pending_to_send' => $pending_to_send, 
                                                        'rejected' => $rejected]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function match_notice(){
        $property = Pn_property::orderBy('updated_at','desc')->get();
        
        foreach($property as $data){
            $cond = "";

            $cond2 = "";
            if(isset($data->district) && $data->district!=''){
                $cond2 = $cond2 . "(B.fk_location_type_id = '4' and B.location like '%" . $data->district . "%')";
            }
            if(isset($data->city) && $data->city!=''){
                if($cond2==""){
                    $cond2 = "A.city like '%" . $data->city . "%'";
                } else {
                    $cond2 = $cond2 . " or A.city like '%" . $data->city . "%'";
                }
            }
            if(isset($data->pincode) && $data->pincode!=''){
                if($cond2==""){
                    $cond2 = "A.pincode like '%" . $data->pincode . "%'";
                } else {
                    $cond2 = $cond2 . " or A.pincode like '%" . $data->pincode . "%'";
                }
            }
            if($cond2!=""){
                $cond = $cond . "and (((B.fk_location_type_id is null or B.fk_location_type_id = '' or B.location is null or B.location = '') and 
                                (A.city is null or A.city  = '') and (A.pincode is null or A.pincode  = '')) or (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->village) && $data->village!=''){
                $cond2 = $cond2 . "(H.fk_location_type_id = '5' and H.location like '%" . $data->village . "%')";
            }
            if(isset($data->taluka) && $data->taluka!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "(H.fk_location_type_id = '2' and H.location like '%" . $data->taluka . "%')";
                } else {
                    $cond2 = $cond2 . " or (H.fk_location_type_id = '2' and H.location like '%" . $data->taluka . "%')";
                }
            }
            if(isset($data->post) && $data->post!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "(H.fk_location_type_id = '3' and H.location like '%" . $data->post . "%')";
                } else {
                    $cond2 = $cond2 . " or (H.fk_location_type_id = '3' and H.location like '%" . $data->post . "%')";
                }
            }
            if(isset($data->division) && $data->division!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "(H.fk_location_type_id = '1' and H.location like '%" . $data->division . "%')";
                } else {
                    $cond2 = $cond2 . " or (H.fk_location_type_id = '1' and H.location like '%" . $data->division . "%')";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and ((H.fk_location_type_id is null or H.fk_location_type_id = '' or H.location is null or H.location = '') or 
                                    (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->property_type) && $data->property_type!=''){
                $cond2 = $cond2 . "A.property_type is null or A.property_type  = '' or A.property_type like '%" . $data->property_type . "%'";
            }
            if($cond2!=""){
                $cond = $cond . " and (" . $cond2 . ")";
            }

            $cond2 = "";
            if(isset($data->apartment_no) && $data->apartment_no!=''){
                $cond2 = $cond2 . "(C.fk_property_no_type_id is null or C.fk_property_no_type_id = '' or C.property_no is null or C.property_no = '') or 
                                    (C.fk_property_no_type_id = '9' and C.property_no like '%" . $data->apartment_no . "%')";
            }
            if($cond2!=""){
                $cond = $cond . " and (" . $cond2 . ")";
            }

            $cond2 = "";
            if(isset($data->floor) && $data->floor!=''){
                $cond2 = "A.floor like '%" . $data->floor . "%'";
            }
            if(isset($data->wing) && $data->wing!=''){
                if($cond2==""){
                    $cond2 = "A.wing like '%" . $data->wing . "%'";
                } else {
                    $cond2 = $cond2 . " or A.wing like '%" . $data->wing . "%'";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.floor is null or A.floor  = '') and (A.wing is null or A.wing  = '')) or (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->sheet_no) && $data->sheet_no!=''){
                $cond2 = $cond2 . "(I.fk_property_no_type_id = '1' and I.property_no like '%" . $data->sheet_no . "%')";
            }
            if(isset($data->room_no) && $data->room_no!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "(I.fk_property_no_type_id = '2' and I.property_no like '%" . $data->room_no . "%')";
                } else {
                    $cond2 = $cond2 . " or (I.fk_property_no_type_id = '2' and I.property_no like '%" . $data->room_no . "%')";
                }
            }
            if(isset($data->block_no) && $data->block_no!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "(I.fk_property_no_type_id = '3' and I.property_no like '%" . $data->block_no . "%')";
                } else {
                    $cond2 = $cond2 . " or (I.fk_property_no_type_id = '3' and I.property_no like '%" . $data->block_no . "%')";
                }
            }
            if(isset($data->ward_no) && $data->ward_no!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "(I.fk_property_no_type_id = '4' and I.property_no like '%" . $data->ward_no . "%')";
                } else {
                    $cond2 = $cond2 . " or (I.fk_property_no_type_id = '4' and I.property_no like '%" . $data->ward_no . "%')";
                }
            }
            if(isset($data->khata_no) && $data->khata_no!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "(I.fk_property_no_type_id = '5' and I.property_no like '%" . $data->khata_no . "%')";
                } else {
                    $cond2 = $cond2 . " or (I.fk_property_no_type_id = '5' and I.property_no like '%" . $data->khata_no . "%')";
                }
            }
            if(isset($data->sr_no) && $data->sr_no!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "(I.fk_property_no_type_id = '6' and I.property_no like '%" . $data->sr_no . "%')";
                } else {
                    $cond2 = $cond2 . " or (I.fk_property_no_type_id = '6' and I.property_no like '%" . $data->sr_no . "%')";
                }
            }
            if(isset($data->plot_no) && $data->plot_no!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "(I.fk_property_no_type_id = '7' and I.property_no like '%" . $data->plot_no . "%')";
                } else {
                    $cond2 = $cond2 . " or (I.fk_property_no_type_id = '7' and I.property_no like '%" . $data->plot_no . "%')";
                }
            }
            if(isset($data->scheme_no) && $data->scheme_no!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "(I.fk_property_no_type_id = '8' and I.property_no like '%" . $data->scheme_no . "%')";
                } else {
                    $cond2 = $cond2 . " or (I.fk_property_no_type_id = '8' and I.property_no like '%" . $data->scheme_no . "%')";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and ((I.fk_property_no_type_id is null or I.fk_property_no_type_id = '' or I.property_no is null or I.property_no = '') or 
                                    (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->cts_no) && $data->cts_no!=''){
                $cond2 = $cond2 . "(J.fk_property_no_type_id = '10' and J.property_no like '%" . $data->cts_no . "%')";
            }
            if(isset($data->survey_no) && $data->survey_no!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "(J.fk_property_no_type_id = '11' and J.property_no like '%" . $data->survey_no . "%')";
                } else {
                    $cond2 = $cond2 . " or (J.fk_property_no_type_id = '11' and J.property_no like '%" . $data->survey_no . "%')";
                }
            }
            if(isset($data->gut_no) && $data->gut_no!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "(J.fk_property_no_type_id = '12' and J.property_no like '%" . $data->gut_no . "%')";
                } else {
                    $cond2 = $cond2 . " or (J.fk_property_no_type_id = '12' and J.property_no like '%" . $data->gut_no . "%')";
                }
            }
            if(isset($data->hissa_no) && $data->hissa_no!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "(J.fk_property_no_type_id = '13' and J.property_no like '%" . $data->hissa_no . "%')";
                } else {
                    $cond2 = $cond2 . " or (J.fk_property_no_type_id = '13' and J.property_no like '%" . $data->hissa_no . "%')";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and ((J.fk_property_no_type_id is null or J.fk_property_no_type_id = '' or J.property_no is null or J.property_no = '') or 
                                    (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->certificate_no) && $data->certificate_no!=''){
                $cond2 = $cond2 . "(D.fk_certificate_no_type_id = '1' and D.certificate_no like '%" . $data->certificate_no . "%')";
            }
            if(isset($data->distinctive_no) && $data->distinctive_no!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "(D.fk_certificate_no_type_id = '2' and D.certificate_no like '%" . $data->distinctive_no . "%')";
                } else {
                    $cond2 = $cond2 . " or (D.fk_certificate_no_type_id = '2' and D.certificate_no like '%" . $data->distinctive_no . "%')";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and ((D.fk_certificate_no_type_id is null or D.fk_certificate_no_type_id = '' or D.certificate_no is null or D.certificate_no = '') or 
                                    (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->property_name) && $data->property_name!=''){
                $cond2 = $cond2 . "A.name_of_property like '%" . $data->property_name . "%'";
            }
            if(isset($data->building_name) && $data->building_name!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "A.building_name like '%" . $data->building_name . "%'";
                } else {
                    $cond2 = $cond2 . " or A.building_name like '%" . $data->building_name . "%'";
                }
            }
            if(isset($data->society_name) && $data->society_name!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "A.society_name like '%" . $data->society_name . "%'";
                } else {
                    $cond2 = $cond2 . " or A.society_name like '%" . $data->society_name . "%'";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.name_of_property is null or A.name_of_property  = '') and 
                                (A.building_name is null or A.building_name  = '') and (A.society_name is null or A.society_name  = '')) 
                                or (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->address) && $data->address!=''){
                $cond2 = $cond2 . "A.address like '%" . $data->address . "%'";
            }
            if(isset($data->description) && $data->description!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "A.property_description like '%" . $data->description . "%'";
                } else {
                    $cond2 = $cond2 . " or A.property_description like '%" . $data->description . "%'";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.address is null or A.address  = '') and (A.property_description is null or A.property_description  = '')) 
                                or (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->owner_1) && $data->owner_1!=''){
                $cond2 = $cond2 . "E.legal_owner_name like '%" . $data->owner_1 . "%'";
            }
            if(isset($data->owner_2) && $data->owner_2!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "E.legal_owner_name is null or E.legal_owner_name  = '' or E.legal_owner_name like '%" . $data->owner_2 . "%'";
                } else {
                    $cond2 = $cond2 . " or E.legal_owner_name like '%" . $data->owner_2 . "%'";
                }
            }
            if(isset($data->purchased_from) && $data->purchased_from!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "F.purchased_from like '%" . $data->purchased_from . "%'";
                } else {
                    $cond2 = $cond2 . " or F.purchased_from like '%" . $data->purchased_from . "%'";
                }
            }
            if(isset($data->company_name) && $data->company_name!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "G.company_name like '%" . $data->company_name . "%'";
                } else {
                    $cond2 = $cond2 . " or G.company_name like '%" . $data->company_name . "%'";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((E.legal_owner_name is null or E.legal_owner_name  = '') and (F.purchased_from is null or F.purchased_from  = '')
                                and (G.company_name is null or G.company_name  = '')) or (" . $cond2 . "))";
            }

            $sql = "select distinct A.id from pn_notices A 
                    left join pn_notice_location_details B on (A.id = B.fk_notice_id) 
                    left join pn_notice_property_no_details C on (A.id = C.fk_notice_id) 
                    left join pn_notice_certificate_no_details D on (A.id = D.fk_notice_id) 
                    left join pn_notice_legal_owner_names E on (A.id = E.fk_notice_id) 
                    left join pn_notice_purchased_froms F on (A.id = F.fk_notice_id) 
                    left join pn_notice_company_names G on (A.id = G.fk_notice_id) 
                    left join pn_notice_location_details H on (A.id = H.fk_notice_id) 
                    left join pn_notice_property_no_details I on (A.id = I.fk_notice_id) 
                    left join pn_notice_property_no_details J on (A.id = J.fk_notice_id) 
                    where A.status = 'approved' and 
                    A.id not in (select distinct fk_notice_id from pn_property_notices where fk_property_id='".$data->id."') and 
                    (B.fk_location_type_id is not null or B.fk_location_type_id <> '' or B.location is not null or B.location <> '' or 
                        A.city is not null or A.city <> '' or A.pincode is not null or A.pincode <> '' or 
                        A.property_type is not null or A.property_type <> '' or C.fk_property_no_type_id is not null or C.fk_property_no_type_id <> '' or 
                        C.property_no is not null or C.property_no <> '' or A.floor is not null or A.floor <> '' or A.wing is not null or A.wing <> '' or 
                        A.name_of_property is not null or A.name_of_property <> '' or 
                        D.fk_certificate_no_type_id is not null or D.fk_certificate_no_type_id <> '' or 
                        D.certificate_no is not null or D.certificate_no <> '' or A.building_name is not null or A.building_name <> '' or 
                        A.society_name is not null or A.society_name <> '' or A.address is not null or A.address <> '' or 
                        A.property_description is not null or A.property_description <> '' or 
                        E.legal_owner_name is not null or E.legal_owner_name <> '' or 
                        F.purchased_from is not null or F.purchased_from <> '' or 
                        G.company_name is not null or G.company_name <> '') " . $cond;
            $notice = DB::select($sql);
            // echo $sql;
            // echo '<br/>';
            // echo json_encode($notice);
            // echo '<br/>';

            foreach($notice as $data2){
                $data3 = array();
                $data3['fk_property_id'] = $data->id;
                $data3['fk_notice_id'] = $data2->id;
                $user_id = '1';
                $data3['updated_by'] = $user_id;
                $data3['status'] = 'pending';
                $data3['created_by'] = $user_id;
                Pn_property_notice::create($data3);
            }
        }
    }

    public function match_property(){
        $notice = Pn_notice::orderBy('updated_at','desc')->get();
        
        foreach($notice as $data){
            $cond = "";

            $sql = "select fk_location_type_id, location from pn_notice_location_details where fk_notice_id = '".$data->id."'";
            $location = DB::select($sql);
            $cond2 = "";
            foreach($location as $data2){
                if($data2->fk_location_type_id=='4' && isset($data2->location) && $data2->location!=''){
                    if($cond2==""){
                        $cond2 = "A.district like '%" . trim(str_replace("'", "", $data2->location)) . "%'";
                    } else {
                        $cond2 = $cond2 . " or A.district like '%" . trim(str_replace("'", "", $data2->location)) . "%'";
                    }
                }
            }
            if(isset($data->city) && $data->city!=''){
                if($cond2==""){
                    $cond2 = "A.city like '%" . trim(str_replace("'", "", $data->city)) . "%'";
                } else {
                    $cond2 = $cond2 . " or A.city like '%" . trim(str_replace("'", "", $data->city)) . "%'";
                }
            }
            if(isset($data->pincode) && $data->pincode!=''){
                if($cond2==""){
                    $cond2 = "A.pincode like '%" . trim(str_replace("'", "", $data->pincode)) . "%'";
                } else {
                    $cond2 = $cond2 . " or A.pincode like '%" . trim(str_replace("'", "", $data->pincode)) . "%'";
                }
            }

            if($cond2!=""){
                $cond = $cond . "and (((A.district is null or A.district  = '') and (A.city is null or A.city  = '') and 
                                    (A.pincode is null or A.pincode  = '')) or (" . $cond2 . "))";
            }

            $cond2 = "";
            foreach($location as $data2){
                if(isset($data2->fk_location_type_id) && $data2->fk_location_type_id!='' && isset($data2->location) && $data2->location!=''){
                    if($data2->fk_location_type_id=='5'){
                        if($cond2==""){
                            $cond2 = "A.village like '%" . trim(str_replace("'", "", $data2->location)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.village like '%" . trim(str_replace("'", "", $data2->location)) . "%'";
                        }
                    }
                    if($data2->fk_location_type_id=='2'){
                        if($cond2==""){
                            $cond2 = "A.taluka like '%" . trim(str_replace("'", "", $data2->location)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.taluka like '%" . trim(str_replace("'", "", $data2->location)) . "%'";
                        }
                    }
                    if($data2->fk_location_type_id=='3'){
                        if($cond2==""){
                            $cond2 = "A.post like '%" . trim(str_replace("'", "", $data2->location)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.post like '%" . trim(str_replace("'", "", $data2->location)) . "%'";
                        }
                    }
                    if($data2->fk_location_type_id=='1'){
                        if($cond2==""){
                            $cond2 = "A.division like '%" . trim(str_replace("'", "", $data2->location)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.division like '%" . trim(str_replace("'", "", $data2->location)) . "%'";
                        }
                    }
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.village is null or A.village  = '') and (A.taluka is null or A.taluka  = '') and 
                                    (A.post is null or A.post  = '') and (A.division is null or A.division  = '')) or 
                                    (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->property_type) && $data->property_type!=''){
                $cond2 = $cond2 . "A.property_type is null or A.property_type  = '' or A.property_type like '%" . trim(str_replace("'", "", $data->property_type)) . "%'";
            }
            if($cond2!=""){
                $cond = $cond . " and (" . $cond2 . ")";
            }

            $sql = "select fk_property_no_type_id, property_no from pn_notice_property_no_details where fk_notice_id = '".$data->id."'";
            $property_no = DB::select($sql);
            $cond2 = "";
            foreach($property_no as $data2){
                if(isset($data2->fk_property_no_type_id) && $data2->fk_property_no_type_id!='' && isset($data2->property_no) && $data2->property_no!=''){
                    if($data2->fk_property_no_type_id=='9'){
                        if($cond2==""){
                            $cond2 = "A.apartment_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.apartment_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        }
                    }
                }
            }
            if($cond2!=""){
                $cond = $cond . " and ((A.apartment_no is null or A.apartment_no  = '') or (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->floor) && $data->floor!=''){
                $cond2 = "A.floor like '%" . trim(str_replace("'", "", $data->floor)) . "%'";
            }
            if(isset($data->wing) && $data->wing!=''){
                if($cond2==""){
                    $cond2 = "A.wing like '%" . trim(str_replace("'", "", $data->wing)) . "%'";
                } else {
                    $cond2 = $cond2 . " or A.wing like '%" . trim(str_replace("'", "", $data->wing)) . "%'";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.floor is null or A.floor  = '') and (A.wing is null or A.wing  = '')) or (" . $cond2 . "))";
            }

            $cond2 = "";
            foreach($property_no as $data2){
                if(isset($data2->fk_property_no_type_id) && $data2->fk_property_no_type_id!='' && isset($data2->property_no) && $data2->property_no!=''){
                    if($data2->fk_property_no_type_id=='1'){
                        if($cond2==""){
                            $cond2 = "A.sheet_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.sheet_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='2'){
                        if($cond2==""){
                            $cond2 = "A.room_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.room_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='3'){
                        if($cond2==""){
                            $cond2 = "A.block_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.block_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='4'){
                        if($cond2==""){
                            $cond2 = "A.ward_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.ward_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='5'){
                        if($cond2==""){
                            $cond2 = "A.khata_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.khata_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='6'){
                        if($cond2==""){
                            $cond2 = "A.sr_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.sr_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='7'){
                        if($cond2==""){
                            $cond2 = "A.plot_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.plot_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='8'){
                        if($cond2==""){
                            $cond2 = "A.scheme_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.scheme_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        }
                    }
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.sheet_no is null or A.sheet_no  = '') and (A.room_no is null or A.room_no  = '') and 
                                        (A.block_no is null or A.block_no  = '') and (A.ward_no is null or A.ward_no  = '') and 
                                        (A.khata_no is null or A.khata_no  = '') and (A.sr_no is null or A.sr_no  = '') and 
                                        (A.plot_no is null or A.plot_no  = '') and (A.scheme_no is null or A.scheme_no  = '')) or (" . $cond2 . "))";
            }

            $cond2 = "";
            foreach($property_no as $data2){
                if(isset($data2->fk_property_no_type_id) && $data2->fk_property_no_type_id!='' && isset($data2->property_no) && $data2->property_no!=''){
                    if($data2->fk_property_no_type_id=='10'){
                        if($cond2==""){
                            $cond2 = "A.cts_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.cts_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='11'){
                        if($cond2==""){
                            $cond2 = "A.survey_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.survey_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='12'){
                        if($cond2==""){
                            $cond2 = "A.gut_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.gut_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='13'){
                        if($cond2==""){
                            $cond2 = "A.hissa_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.hissa_no like '%" . trim(str_replace("'", "", $data2->property_no)) . "%'";
                        }
                    }
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.cts_no is null or A.cts_no  = '') and (A.survey_no is null or A.survey_no  = '') and 
                                        (A.gut_no is null or A.gut_no  = '') and (A.hissa_no is null or A.hissa_no  = '')) or (" . $cond2 . "))";
            }

            $sql = "select fk_certificate_no_type_id, certificate_no from pn_notice_certificate_no_details where fk_notice_id = '".$data->id."'";
            $certificate_no = DB::select($sql);
            $cond2 = "";
            foreach($certificate_no as $data2){
                if(isset($data2->fk_certificate_no_type_id) && $data2->fk_certificate_no_type_id!='' && isset($data2->certificate_no) && $data2->certificate_no!=''){
                    if($data2->fk_certificate_no_type_id=='1'){
                        if($cond2==""){
                            $cond2 = "A.certificate_no like '%" . trim(str_replace("'", "", $data2->certificate_no)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.certificate_no like '%" . trim(str_replace("'", "", $data2->certificate_no)) . "%'";
                        }
                    }
                    if($data2->fk_certificate_no_type_id=='2'){
                        if($cond2==""){
                            $cond2 = "A.distinctive_no like '%" . trim(str_replace("'", "", $data2->certificate_no)) . "%'";
                        } else {
                            $cond2 = $cond2 . " or A.distinctive_no like '%" . trim(str_replace("'", "", $data2->certificate_no)) . "%'";
                        }
                    }
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.certificate_no is null or A.certificate_no  = '') and 
                                        (A.distinctive_no is null or A.distinctive_no  = '')) or (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->name_of_property) && $data->name_of_property!=''){
                $cond2 = $cond2 . "A.property_name like '%" . trim(str_replace("'", "", $data->name_of_property)) . "%'";
            }
            if(isset($data->building_name) && $data->building_name!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "A.building_name like '%" . trim(str_replace("'", "", $data->building_name)) . "%'";
                } else {
                    $cond2 = $cond2 . " or A.building_name like '%" . trim(str_replace("'", "", $data->building_name)) . "%'";
                }
            }
            if(isset($data->society_name) && $data->society_name!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "A.society_name like '%" . trim(str_replace("'", "", $data->society_name)) . "%'";
                } else {
                    $cond2 = $cond2 . " or A.society_name like '%" . trim(str_replace("'", "", $data->society_name)) . "%'";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.property_name is null or A.property_name  = '') and 
                                (A.building_name is null or A.building_name  = '') and (A.society_name is null or A.society_name  = '')) 
                                or (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->address) && $data->address!=''){
                $cond2 = $cond2 . "A.address like '%" . trim(str_replace("'", "", $data->address)) . "%'";
            }
            if(isset($data->property_description) && $data->property_description!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "A.description like '%" . trim(str_replace("'", "", $data->property_description)) . "%'";
                } else {
                    $cond2 = $cond2 . " or A.description like '%" . trim(str_replace("'", "", $data->property_description)) . "%'";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.address is null or A.address  = '') and (A.description is null or A.description  = '')) 
                                or (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->legal_owner_name) && $data->legal_owner_name!=''){
                $cond2 = $cond2 . "A.owner_1 like '%" . trim(str_replace("'", "", $data->legal_owner_name)) . "%'";
            }
            if(isset($data->legal_owner_name) && $data->legal_owner_name!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "A.owner_2 like '%" . trim(str_replace("'", "", $data->legal_owner_name)) . "%'";
                } else {
                    $cond2 = $cond2 . " or A.owner_2 like '%" . trim(str_replace("'", "", $data->legal_owner_name)) . "%'";
                }
            }
            if(isset($data->purchased_from) && $data->purchased_from!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "A.purchased_from like '%" . trim(str_replace("'", "", $data->purchased_from)) . "%'";
                } else {
                    $cond2 = $cond2 . " or A.purchased_from like '%" . trim(str_replace("'", "", $data->purchased_from)) . "%'";
                }
            }
            if(isset($data->company_name) && $data->company_name!=''){
                if($cond2==""){
                    $cond2 = $cond2 . "A.company_name like '%" . trim(str_replace("'", "", $data->company_name)) . "%'";
                } else {
                    $cond2 = $cond2 . " or A.company_name like '%" . trim(str_replace("'", "", $data->company_name)) . "%'";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.owner_1 is null or A.owner_1  = '') and (A.owner_2 is null or A.owner_2  = '') and 
                                (A.purchased_from is null or A.purchased_from  = '') and 
                                (A.company_name is null or A.company_name  = '')) or (" . $cond2 . "))";
            }


            $sql = "select distinct A.id from pn_properties A where A.status = 'approved' and 
                    A.id not in (select distinct fk_property_id from pn_property_notices where fk_notice_id='".$data->id."') and 
                    (A.district is not null or A.district <> '' or A.city is not null or A.city <> '' or 
                    A.pincode is not null or A.pincode <> '' or A.village is not null or A.village <> '' or 
                    A.taluka is not null or A.taluka <> '' or A.post is not null or A.post <> '' or 
                    A.division is not null or A.division <> '' or A.property_type is not null or A.property_type <> '' or 
                    A.apartment_no is not null or A.apartment_no <> '' or A.floor is not null or A.floor <> '' or 
                    A.wing is not null or A.wing <> '' or A.sheet_no is not null or A.sheet_no <> '' or A.room_no is not null or A.room_no <> '' or 
                    A.block_no is not null or A.block_no <> '' or A.ward_no is not null or A.ward_no <> '' or 
                    A.khata_no is not null or A.khata_no <> '' or A.sr_no is not null or A.sr_no <> '' or 
                    A.plot_no is not null or A.plot_no <> '' or A.scheme_no is not null or A.scheme_no <> '' or 
                    A.cts_no is not null or A.cts_no <> '' or A.survey_no is not null or A.survey_no <> '' or 
                    A.gut_no is not null or A.gut_no <> '' or A.hissa_no is not null or A.hissa_no <> '' or 
                    A.certificate_no is not null or A.certificate_no <> '' or A.distinctive_no is not null or A.distinctive_no <> '' or 
                    A.property_name is not null or A.property_name <> '' or A.building_name is not null or A.building_name <> '' or 
                    A.society_name is not null or A.society_name <> '' or A.address is not null or A.address <> '' or 
                    A.description is not null or A.description <> '' or A.owner_1 is not null or A.owner_1 <> '' or 
                    A.owner_2 is not null or A.owner_2 <> '' or A.purchased_from is not null or A.purchased_from <> '' or 
                    A.company_name is not null or A.company_name <> '') " . $cond;
            $notice = DB::select($sql);
            // echo $sql;
            // echo '<br/>';
            // echo json_encode($notice);
            // echo '<br/>';

            foreach($notice as $data2){
                $data3 = array();
                $data3['fk_notice_id'] = $data->id;
                $data3['fk_property_id'] = $data2->id;
                $user_id = '1';
                $data3['updated_by'] = $user_id;
                $data3['status'] = 'pending';
                $data3['created_by'] = $user_id;
                Pn_property_notice::create($data3);
            }
        }
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

                $property = Pn_property::find($property_id);
                $legal_owner_name1 = Pn_property_legal_owner_name::where('fk_property_id', $property_id)->get();
                $purchased_from1 = Pn_property_purchased_from::where('fk_property_id', $property_id)->get();
                $company_name1 = Pn_property_company_name::where('fk_property_id', $property_id)->get();
                $guarantor1 = Pn_property_guarantor::where('fk_property_id', $property_id)->get();
                $property_no_detail1 = Pn_property_prop_no_detail::where('fk_property_id', $property_id)->get();
                $location_detail1 = Pn_property_location_detail::where('fk_property_id', $property_id)->get();
                $certificate_no_detail1 = Pn_property_certificate_no_detail::where('fk_property_id', $property_id)->get();

                return view('property_notice.details', ['access' => $access, 'data' => $data, 'notice' => $notice, 'legal_owner_name' => $legal_owner_name, 
                                                        'purchased_from' => $purchased_from, 'company_name' => $company_name, 
                                                        'guarantor' => $guarantor, 'property_no_detail' => $property_no_detail, 
                                                        'location_detail' => $location_detail, 'certificate_no_detail' => $certificate_no_detail, 
                                                        'newspaper_list' => $newspaper_list, 'notice_type_list' => $notice_type_list, 
                                                        'property_no_type_list' => $property_no_type_list, 'location_type_list' => $location_type_list, 
                                                        'certificate_no_type_list' => $certificate_no_type_list, 'property' => $property, 
                                                        'legal_owner_name1' => $legal_owner_name1, 
                                                        'purchased_from1' => $purchased_from1, 'company_name1' => $company_name1, 
                                                        'guarantor1' => $guarantor1, 'property_no_detail1' => $property_no_detail1, 
                                                        'location_detail1' => $location_detail1, 'certificate_no_detail1' => $certificate_no_detail1]);
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
                    $data2['status'] = 'pending to send';
                    $msg = 'Property Notice approved successfully!';
                } else {
                    $data2['status'] = 'rejected';
                    $msg = 'Property Notice rejected successfully!';
                }
                
                Pn_property_notice::find($data['id'])->update($data2);
                Session::flash('success_msg', $msg);

                return redirect('index.php/property_notice');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
        }
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

        Mail::send('property_notice.mail', $data, function($message) use ($data) {
            $message->to($data['email'], $data['name'])
                    ->subject('Notice Alert On Property - '.$data['property_name'])
                    ->from('info@pecanreams.com','Pecan Reams')
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
                            $name = $data2[0]->name;
                            $email = $data2[0]->gu_email;
                            $mobile = $data2[0]->gu_mobile;
                            $property_name = $data2[0]->property_name;
                            $date_of_notice = $data2[0]->date_of_notice;
                            $address = $data2[0]->address;
                            $paper_name = $data2[0]->paper_name;
                            $link = url('index.php/user_notice');
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
                            
                            Pn_property_notice::find($id)->update($data4);
                        }
                    }

                    $msg = 'Property Notice sent successfully!';
                    Session::flash('success_msg', $msg);
                }

                return redirect('index.php/property_notice');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
        }
    }
}