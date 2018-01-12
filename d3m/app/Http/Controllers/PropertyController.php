<?php

namespace App\Http\Controllers;

use App\User;
use App\Pn_property;
use App\Pn_property_no_type;
use App\Pn_location_type;
use App\Pn_certificate_no_type;
use App\Pn_property_legal_owner_name;
use App\Pn_property_purchased_from;
use App\Pn_property_company_name;
use App\Pn_property_guarantor;
use App\Pn_property_prop_no_detail;
use App\Pn_property_location_detail;
use App\Pn_property_certificate_no_detail;
use App\Pn_group;
use Illuminate\Http\Request;
use Session;
use DateTime;
use DB;

class PropertyController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_view']=='1' || $access['Properties']['r_insert']=='1' || $access['Properties']['r_edit']=='1' || $access['Properties']['r_delete']=='1' || $access['Properties']['r_approvals']=='1' || $access['Properties']['r_export']=='1') {
                $user_id = auth()->user()->gu_id;
                $property = Pn_property::where('created_by',$user_id)->orderBy('updated_at','desc')->get();

                // $sql = "select A.*, B.fk_notice_id, C.notice_file 
                //         from pn_properties A 
                //         left join pn_property_notices B on (A.id = B.fk_property_id) 
                //         left join pn_notices C on (B.fk_notice_id = C.id) 
                //         where A.status = 'approved' and A.created_by = '$user_id'";
                // $property = DB::select($sql);


                return view('property.index', ['access' => $access, 'property' => $property]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
            }
        } else if(isset($access['AdminProperties'])) {
            if($access['AdminProperties']['r_view']=='1') {
                $sql = "select A.*, B.name as user_name from pn_properties A left join group_users B on (A.created_by = B.gu_id) 
                        where A.status = 'approved' order by updated_at desc";
                $property = DB::select($sql);
                // $property = Pn_property::orderBy('updated_at','desc')->get();
                
                return view('property.index', ['access' => $access, 'property' => $property]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function add(){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_insert']=='1') {
                $user_id = auth()->user()->gu_id;
                $group_details = Pn_group::where('created_by',$user_id)->orderBy('group_name','asc')->get();
                $property_no_type_list = Pn_property_no_type::orderBy('property_no_type','asc')->get();
                $location_type_list = Pn_location_type::orderBy('location_type','asc')->get();
                $certificate_no_type_list = Pn_certificate_no_type::orderBy('certificate_no_type','asc')->get();

                // $user_id = auth()->user()->gu_id;
                // $sql = "select * from user_plan_details where user_id = '$user_id'";
                // $data2 = DB::select($sql);
                // if(count($data2)>0){
                //     $plan_name = $data2[0]->plan_name;
                //     $no_of_properties = floatval($data2[0]->no_of_properties);
                //     $plan_expires_on = new DateTime($data2[0]->plan_expires_on);
                // } else {
                //     $plan_name = '';
                //     $no_of_properties = 0;
                //     $plan_expires_on = '';
                // }

                // $end_date = date('Y-m-d');
                // $end_date = new DateTime($end_date);
                // $balance_days = 0;

                // if($plan_expires_on != ''){
                //     if($plan_expires_on>$end_date){
                //         $diff = date_diff($plan_expires_on, $end_date);
                //         $balance_days = floatval($diff->format("%a"));
                //     } else {
                //         $balance_days = 0;
                //     }
                // }

                // $sql = "select count(id) as no_of_prop from pn_properties where status = 'approved' and created_by = '$user_id'";
                // $data2 = DB::select($sql);
                // if(count($data2)>0){
                //     $no_of_prop = intval($data2[0]->no_of_prop);
                // } else {
                //     $no_of_prop = 0;
                // }

                // if($no_of_properties<$no_of_prop || $balance_days == 0){
                //     Session::flash('warning_msg', 'This will be charged Rs 200/- per month!');
                // }

                return view('property.details', ['access' => $access, 'property_no_type_list' => $property_no_type_list, 
                                                'location_type_list' => $location_type_list, 'certificate_no_type_list' => $certificate_no_type_list, 
                                                'group_details' => $group_details]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function details($id){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_view']=='1') {
                $group_details = Pn_group::orderBy('group_name','asc')->get();
                $property_no_type_list = Pn_property_no_type::orderBy('property_no_type','asc')->get();
                $location_type_list = Pn_location_type::orderBy('location_type','asc')->get();
                $certificate_no_type_list = Pn_certificate_no_type::orderBy('certificate_no_type','asc')->get();
                $data = Pn_property::find($id);
                $legal_owner_name = Pn_property_legal_owner_name::where('fk_property_id', $id)->get();
                $purchased_from = Pn_property_purchased_from::where('fk_property_id', $id)->get();
                $company_name = Pn_property_company_name::where('fk_property_id', $id)->get();
                $guarantor = Pn_property_guarantor::where('fk_property_id', $id)->get();
                $property_no_detail = Pn_property_prop_no_detail::where('fk_property_id', $id)->get();
                $location_detail = Pn_property_location_detail::where('fk_property_id', $id)->get();
                $certificate_no_detail = Pn_property_certificate_no_detail::where('fk_property_id', $id)->get();

                return view('property.details', ['access' => $access, 'data' => $data, 'legal_owner_name' => $legal_owner_name, 
                                                'purchased_from' => $purchased_from, 'company_name' => $company_name, 
                                                'guarantor' => $guarantor, 'property_no_detail' => $property_no_detail, 
                                                'location_detail' => $location_detail, 'certificate_no_detail' => $certificate_no_detail, 
                                                'property_no_type_list' => $property_no_type_list, 'location_type_list' => $location_type_list, 
                                                'certificate_no_type_list' => $certificate_no_type_list, 'group_details' => $group_details]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
            }
        } else if(isset($access['AdminProperties'])) {
            if($access['AdminProperties']['r_view']=='1') {
                $group_details = Pn_group::orderBy('group_name','asc')->get();
                $property_no_type_list = Pn_property_no_type::orderBy('property_no_type','asc')->get();
                $location_type_list = Pn_location_type::orderBy('location_type','asc')->get();
                $certificate_no_type_list = Pn_certificate_no_type::orderBy('certificate_no_type','asc')->get();
                $data = Pn_property::find($id);
                $legal_owner_name = Pn_property_legal_owner_name::where('fk_property_id', $id)->get();
                $purchased_from = Pn_property_purchased_from::where('fk_property_id', $id)->get();
                $company_name = Pn_property_company_name::where('fk_property_id', $id)->get();
                $guarantor = Pn_property_guarantor::where('fk_property_id', $id)->get();
                $property_no_detail = Pn_property_prop_no_detail::where('fk_property_id', $id)->get();
                $location_detail = Pn_property_location_detail::where('fk_property_id', $id)->get();
                $certificate_no_detail = Pn_property_certificate_no_detail::where('fk_property_id', $id)->get();

                return view('property.details', ['access' => $access, 'data' => $data, 'legal_owner_name' => $legal_owner_name, 
                                                'purchased_from' => $purchased_from, 'company_name' => $company_name, 
                                                'guarantor' => $guarantor, 'property_no_detail' => $property_no_detail, 
                                                'location_detail' => $location_detail, 'certificate_no_detail' => $certificate_no_detail, 
                                                'property_no_type_list' => $property_no_type_list, 'location_type_list' => $location_type_list, 
                                                'certificate_no_type_list' => $certificate_no_type_list, 'group_details' => $group_details]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function edit($id){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_edit']=='1' || $access['Properties']['r_delete']=='1') {
                $group_details = Pn_group::orderBy('group_name','asc')->get();
                $property_no_type_list = Pn_property_no_type::orderBy('property_no_type','asc')->get();
                $location_type_list = Pn_location_type::orderBy('location_type','asc')->get();
                $certificate_no_type_list = Pn_certificate_no_type::orderBy('certificate_no_type','asc')->get();
                $data = Pn_property::find($id);
                $legal_owner_name = Pn_property_legal_owner_name::where('fk_property_id', $id)->get();
                $purchased_from = Pn_property_purchased_from::where('fk_property_id', $id)->get();
                $company_name = Pn_property_company_name::where('fk_property_id', $id)->get();
                $guarantor = Pn_property_guarantor::where('fk_property_id', $id)->get();
                $property_no_detail = Pn_property_prop_no_detail::where('fk_property_id', $id)->get();
                $location_detail = Pn_property_location_detail::where('fk_property_id', $id)->get();
                $certificate_no_detail = Pn_property_certificate_no_detail::where('fk_property_id', $id)->get();

                return view('property.details', ['access' => $access, 'data' => $data, 'legal_owner_name' => $legal_owner_name, 
                                                'purchased_from' => $purchased_from, 'company_name' => $company_name, 
                                                'guarantor' => $guarantor, 'property_no_detail' => $property_no_detail, 
                                                'location_detail' => $location_detail, 'certificate_no_detail' => $certificate_no_detail, 
                                                'property_no_type_list' => $property_no_type_list, 'location_type_list' => $location_type_list, 
                                                'certificate_no_type_list' => $certificate_no_type_list,'group_details' => $group_details]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function save(Request $request){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_insert']=='1' || $access['Properties']['r_edit']=='1' || $access['Properties']['r_delete']=='1' || $access['Properties']['r_approvals']=='1') {
                // $this->validate($request, [
                //     'owner_1' => 'required',
                //     'property_name' => 'required',
                //     'address' => 'required',
                // ]);

                // $data = $request->all();
                // $user_id = auth()->user()->gu_id;
                // $data['updated_by'] = $user_id;
                // $data['status'] = 'approved';
                // if(isset($data['id'])){
                //     Pn_property::find($data['id'])->update($data);
                //     Session::flash('success_msg', 'Property updated successfully!');
                // } else {
                //     $data['created_by'] = $user_id;
                //     Pn_property::create($data);
                //     Session::flash('success_msg', 'Property added successfully!');
                // }

                $data['id'] = $request->get('id');
                // $data['date_of_notice'] = $request->get('date_of_notice');
                $data['fk_group_id'] = $request->get('fk_group_id');
                $data['property_name'] = $request->get('property_name');
                $data['property_type'] = $request->get('property_type');
                $data['building_name'] = $request->get('building_name');
                $data['society_name'] = $request->get('society_name');
                $data['floor'] = $request->get('floor');
                $data['wing'] = $request->get('wing');
                $data['apartment_no'] = $request->get('apartment_no');
                $data['address'] = $request->get('address');
                $data['city'] = $request->get('city');
                $data['pincode'] = $request->get('pincode');
                $data['state'] = $request->get('state');
                $data['country'] = $request->get('country');
                $data['parking'] = $request->get('parking');
                $data['description'] = $request->get('description');
                $data['issued_by'] = $request->get('issued_by');
                $data['google_map_address'] = $request->get('google_map_address');
                $data['description'] = $request->get('description');
                $data['parking_no'] = $request->get('parking_no');
                $data['no_of_parking'] = $request->get('no_of_parking');
                // $data['company_name'] = $request->get('company_name');

                $user_id = auth()->user()->gu_id;
                $data['updated_by'] = $user_id;
                $data['status'] = 'approved';
                if(isset($data['id'])){
                    $id = $data['id'];
                    Pn_property::find($id)->update($data);
                    Session::flash('success_msg', 'Property updated successfully!');
                } else {
                    $data['created_by'] = $user_id;
                    $id = Pn_property::create($data)->id;
                    Session::flash('success_msg', 'Property added successfully!');
                }

                $fk_property_no_type_id = $request->get('fk_property_no_type_id');
                $property_no = $request->get('property_no');
                Pn_property_prop_no_detail::where('fk_property_id', $id)->delete();
                $property_no_data = array();
                for($i=0; $i<count($fk_property_no_type_id); $i++){
                    $property_no_data[] = array('fk_property_id'=>$id, 'fk_property_no_type_id'=>$fk_property_no_type_id[$i], 'property_no'=>$property_no[$i]);
                }
                if(count($property_no_data)>0){
                    Pn_property_prop_no_detail::insert($property_no_data);
                }

                $fk_location_type_id = $request->get('fk_location_type_id');
                $location = $request->get('location');
                Pn_property_location_detail::where('fk_property_id', $id)->delete();
                $location_data = array();
                for($i=0; $i<count($fk_location_type_id); $i++){
                    $location_data[] = array('fk_property_id'=>$id, 'fk_location_type_id'=>$fk_location_type_id[$i], 'location'=>$location[$i]);
                }
                if(count($location_data)>0){
                    Pn_property_location_detail::insert($location_data);
                }

                $fk_certificate_no_type_id = $request->get('fk_certificate_no_type_id');
                $certificate_no = $request->get('certificate_no');
                Pn_property_certificate_no_detail::where('fk_property_id', $id)->delete();
                $certificate_no_data = array();
                for($i=0; $i<count($fk_certificate_no_type_id); $i++){
                    $certificate_no_data[] = array('fk_property_id'=>$id, 'fk_certificate_no_type_id'=>$fk_certificate_no_type_id[$i], 'certificate_no'=>$certificate_no[$i]);
                }
                if(count($certificate_no_data)>0){
                    Pn_property_certificate_no_detail::insert($certificate_no_data);
                }

                $legal_owner_name = $request->get('legal_owner_name');
                Pn_property_legal_owner_name::where('fk_property_id', $id)->delete();
                $legal_owner_name_data = array();
                for($i=0; $i<count($legal_owner_name); $i++){
                    $legal_owner_name_data[] = array('fk_property_id'=>$id, 'legal_owner_name'=>$legal_owner_name[$i]);
                }
                if(count($legal_owner_name_data)>0){
                    Pn_property_legal_owner_name::insert($legal_owner_name_data);
                }

                $purchased_from = $request->get('purchased_from');
                Pn_property_purchased_from::where('fk_property_id', $id)->delete();
                $purchased_from_data = array();
                for($i=0; $i<count($purchased_from); $i++){
                    $purchased_from_data[] = array('fk_property_id'=>$id, 'purchased_from'=>$purchased_from[$i]);
                }
                if(count($purchased_from_data)>0){
                    Pn_property_purchased_from::insert($purchased_from_data);
                }

                $guarantor = $request->get('guarantor');
                Pn_property_guarantor::where('fk_property_id', $id)->delete();
                $guarantor_data = array();
                for($i=0; $i<count($guarantor); $i++){
                    $guarantor_data[] = array('fk_property_id'=>$id, 'guarantor'=>$guarantor[$i]);
                }
                if(count($guarantor_data)>0){
                    Pn_property_guarantor::insert($guarantor_data);
                }

                $company_name = $request->get('company_name');
                Pn_property_company_name::where('fk_property_id', $id)->delete();
                $company_name_data = array();
                for($i=0; $i<count($company_name); $i++){
                    $company_name_data[] = array('fk_property_id'=>$id, 'company_name'=>$company_name[$i]);
                }
                if(count($company_name_data)>0){
                    Pn_property_company_name::insert($company_name_data);
                }

                return redirect('index.php/property');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function list1(){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['AdminProperties'])) {
            if($access['AdminProperties']['r_view']=='1') {
                // $sql = "select A.*, B.fk_notice_id  
                //         from pn_properties A left join pn_property_notices B on (A.id = B.fk_property_id) 
                //         where A.status = 'approved'";
                // $property = DB::select($sql);

                // return view('property.list', ['access' => $access, 'property' => $property]);

                $property = Pn_property::orderBy('updated_at','desc')->get();

                // $group_details = Pn_group::orderBy('group_name','asc')->get();
                // $property_no_type_list = Pn_property_no_type::orderBy('property_no_type','asc')->get();
                // $location_type_list = Pn_location_type::orderBy('location_type','asc')->get();
                // $certificate_no_type_list = Pn_certificate_no_type::orderBy('certificate_no_type','asc')->get();
                // $data = Pn_property::find($id);
                // $legal_owner_name = Pn_property_legal_owner_name::where('fk_property_id', $id)->get();
                // $purchased_from = Pn_property_purchased_from::where('fk_property_id', $id)->get();
                // $company_name = Pn_property_company_name::where('fk_property_id', $id)->get();
                // $guarantor = Pn_property_guarantor::where('fk_property_id', $id)->get();
                // $property_no_detail = Pn_property_prop_no_detail::where('fk_property_id', $id)->get();
                // $location_detail = Pn_property_location_detail::where('fk_property_id', $id)->get();
                // $certificate_no_detail = Pn_property_certificate_no_detail::where('fk_property_id', $id)->get();

                return view('property.list', ['access' => $access, 'property' => $property]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Property', 'msg' => 'You donot have access to this page.']);
        }
    }
}
