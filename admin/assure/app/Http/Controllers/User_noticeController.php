<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\User;
use Mail;

class User_noticeController extends Controller
{
    public function __construct(){
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
                B.no_of_parking, B.guarantors, B.company_name, B.company_reg_no, B.certificate_no, B.distinctive_no, B.folio_no, 
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
                left join group_users F on (B.created_by = F.gu_id)" . $cond;
        $data = DB::select($sql);
        return $data;
    }
    
    public function index(){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['UserNotices'])) {
            if($access['UserNotices']['r_view']=='1' || $access['UserNotices']['r_insert']=='1' || $access['UserNotices']['r_edit']=='1' || $access['UserNotices']['r_delete']=='1' || $access['UserNotices']['r_approvals']=='1' || $access['UserNotices']['r_export']=='1') {
                $user_id = auth()->user()->gu_id;
                $sql = "select A.id, A.fk_property_id, A.fk_notice_id, A.status, B.property_name, B.address, 
                        C.notice_title, C.notice_file, C.date_of_notice, C.issued_by, D.paper_name, E.notice_type 
                        from pn_property_notices A 
                        left join pn_properties B on (A.fk_property_id=B.id) 
                        left join pn_notices C on (A.fk_notice_id=C.id) 
                        left join pn_newspapers D on (C.fk_newspaper_id=D.id) 
                        left join pn_notice_types E on (C.fk_notice_type_id=E.id) 
                        where A.status = 'approved' and B.created_by = '$user_id' and B.id is not null";
                $notice = DB::select($sql);
                return view('user_notice.index', ['access' => $access, 'notice' => $notice]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function send($id){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['UserNotices'])) {
            if($access['UserNotices']['r_insert']=='1' || $access['UserNotices']['r_edit']=='1' || $access['UserNotices']['r_delete']=='1' || $access['UserNotices']['r_approvals']=='1') {
                $sql = "select A.id, A.fk_property_id, A.fk_notice_id, A.status, B.property_name, B.address, 
                        C.notice_title, C.notice_file, C.date_of_notice, C.issued_by, D.paper_name, E.notice_type, 
                        F.name, F.gu_email, F.gu_mobile, G.name as group_user_name, G.email as group_user_email, G.mobile as group_user_mobile 
                        from pn_property_notices A 
                        left join pn_properties B on (A.fk_property_id=B.id) 
                        left join pn_notices C on (A.fk_notice_id=C.id) 
                        left join pn_newspapers D on (C.fk_newspaper_id=D.id) 
                        left join pn_notice_types E on (C.fk_notice_type_id=E.id) 
                        left join group_users F on (B.created_by = F.gu_id) 
                        left join pn_group_contacts G on (B.fk_group_id = G.fk_group_id) 
                        where A.status = 'approved' and A.id = '$id' and B.id is not null";
                $property = DB::select($sql);

                if(count($property)>0){
                    foreach($property as $data){
                        $name = $data->name;
                        $email = $data->gu_email;
                        $mobile = $data->gu_mobile;
                        $property_name = $data->property_name;
                        $date_of_notice = $data->date_of_notice;
                        $address = $data->address;
                        $paper_name = $data->paper_name;
                        $link = url('index.php/user_notice');
                        $group_user_name = $data->group_user_name;
                        $group_user_email = $data->group_user_email;
                        $group_user_mobile = $data->group_user_mobile;
                        $notice_file = $data->notice_file;

                        // $group_user_email = 'prasadb0910@gmail.com';
                        // $group_user_mobile = '9773560529';

                        $data3 = array('name'=>$name, 'email'=>$email, 'mobile'=>$mobile, 'property_name'=>$property_name, 
                                        'date_of_notice'=>$date_of_notice, 'address'=>$address, 'paper_name'=>$paper_name, 'link'=>$link, 
                                        'group_user_name'=>$group_user_name, 'group_user_email'=>$group_user_email, 
                                        'group_user_mobile'=>$group_user_mobile, 'notice_file'=>$notice_file);

                        // echo $data3['email'];

                        Mail::send('property_notice.group_mail', $data3, function($message) use ($data3) {
                            $message->to($data3['group_user_email'], $data3['group_user_name'])
                                    ->subject('Notice Alert On Property - '.$data3['property_name'])
                                    ->from('info@pecanreams.com','Pecan Reams')
                                    ->attach(url('/') . '/uploads/notices/' . $data3['notice_file']);
                        });

                        $sms = "Hi%20".$name."%2C%20public%20notice%20has%20been%20published%20on%20your%20asset%3a%20".$property_name."%2E%20To%20view%20details%20please%20click%20on%20the%20link%2E%20".$link;
                        $sms = str_replace(' ', '%20', $sms);
                        $sms = str_replace(':', '%3A', $sms);
                        $sms = str_replace(',', '%2C', $sms);
                        $surl = "http://smshorizon.co.in/api/sendsms.php?user=Ashish_Chandak&apikey=QizzeB4YLplingobMXX2&mobile=" . $group_user_mobile . "&message=" . $sms . "&senderid=PECANR&type=txt";
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_URL, $surl);
                        curl_exec($ch);
                        curl_close($ch);

                        // $user_id = auth()->user()->gu_id;
                        // $data4['sent_by'] = $user_id;
                        // $data4['sent_at'] = date('Y-m-d H:i:s');
                        // $data4['status'] = 'approved';
                        
                        // Pn_property_notice::find($id)->update($data4);
                    }

                    $msg = 'Property Notice sent successfully!';
                    Session::flash('success_msg', $msg);
                }

                return redirect('index.php/user_notice');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property Notice', 'msg' => 'You donot have access to this page.']);
        }
    }
}
