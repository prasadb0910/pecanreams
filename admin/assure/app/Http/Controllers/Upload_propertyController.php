<?php

namespace App\Http\Controllers;

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
use App\Pn_property_file;
use App\Pn_file_property;
use App\Pn_file_property_notice;
use App\Pn_file_notice_criteria;
use Illuminate\Http\Request;
use Session;
use DB;
use Carbon\Carbon;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;

class Upload_propertyController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_view']=='1' || $access['Properties']['r_insert']=='1' || $access['Properties']['r_edit']=='1' || $access['Properties']['r_delete']=='1' || $access['Properties']['r_approvals']=='1' || $access['Properties']['r_export']=='1') {
                // $file = Pn_property_file::where('status','approved')->orderBy('updated_at','desc')->get();
                return view('upload_property.index', ['access' => $access]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function get_data(Request $request){
        $data = $request->all();

        $files = DB::select("select A.id, A.file_name, A.file_path, A.output_file_name, A.output_file_path, 
                                    A.status, A.created_at, A.updated_at, count(C.id) as total_cnt, 
                                    sum(case when C.status = 'pending' then 1 else 0 end) as pending_cnt, 
                                    sum(case when C.status = 'approved' then 1 else 0 end) approved_cnt, 
                                    sum(case when C.status = 'rejected' then 1 else 0 end) rejected_cnt 
                                from pn_property_files A 
                                left join pn_file_properties B on (A.id = B.fk_file_id) 
                                left join pn_file_property_notices C on (B.id = C.fk_property_id) 
                                where A.status = 'approved' or A.status = 'pending' 
                                group by A.id, A.file_name, A.file_path, A.output_file_name, A.output_file_path, 
                                    A.status, A.created_at, A.updated_at
                                order by A.updated_at desc");
        $rows = '';
        $i=1;
        foreach($files as $data){
            $rows = $rows . '<tr>
                                <td class="table-text">
                                    <div>'.$i++.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.date('d/m/Y',strtotime($data->created_at)).'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->file_name.'</div>
                                </td>
                                <td class="table-text">
                                    <div><a href="'.$data->file_path.'"><i class="fa export fa-download"></i></a></div>
                                </td>
                                <td class="table-text">
                                    <div>'.(($data->status=='approved')?'uploaded':$data->status).'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->total_cnt.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->pending_cnt.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->approved_cnt.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->rejected_cnt.'</div>
                                </td>
                                <td class="table-text">
                                    <div><a href="'.$data->output_file_path.'"><i class="fa export fa-download"></i></a></div>
                                </td>
                                <td class="table-text">
                                    <div><button type="button" id="send_output_'.$data->id.'" class="label label-info" onClick="send_output(this)">Send</button></div>
                                </td>
                                <td
                                    <a href="'.url('index.php/upload_property/property_notice/'.$data->id).'" class="label label-primary">View</a>
                                    <button type="button" id="notice_'.$data->id.'" class="label label-danger" onClick="show_modal(this)">Delete</button>
                                </td>
                            </tr>';
        }

        $result['rows'] = $rows;
        echo json_encode($result);
    }

    public function property_notice($id){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_view']=='1') {
                $newspaper_list = Pn_newspaper::orderBy('paper_name','asc')->get();
                $notice_type_list = Pn_notice_type::orderBy('notice_type','asc')->get();
                $property_no_type_list = Pn_property_no_type::orderBy('property_no_type','asc')->get();
                $location_type_list = Pn_location_type::orderBy('location_type','asc')->get();
                $certificate_no_type_list = Pn_certificate_no_type::orderBy('certificate_no_type','asc')->get();
                $data = Pn_notice::find($id);
                $legal_owner_name = Pn_notice_legal_owner_name::where('fk_notice_id', $id)->get();
                $purchased_from = Pn_notice_purchased_from::where('fk_notice_id', $id)->get();
                $company_name = Pn_notice_company_name::where('fk_notice_id', $id)->get();
                $guarantor = Pn_notice_guarantor::where('fk_notice_id', $id)->get();
                $property_no_detail = Pn_notice_property_no_detail::where('fk_notice_id', $id)->get();
                $location_detail = Pn_notice_location_detail::where('fk_notice_id', $id)->get();
                $certificate_no_detail = Pn_notice_certificate_no_detail::where('fk_notice_id', $id)->get();
                $othername = Pn_notice_othername::where('fk_notice_id', $id)->get();
                return view('notice.details', ['access' => $access, 'data' => $data, 'legal_owner_name' => $legal_owner_name, 
                                                'purchased_from' => $purchased_from, 'company_name' => $company_name, 
                                                'guarantor' => $guarantor, 'property_no_detail' => $property_no_detail, 
                                                'location_detail' => $location_detail, 'certificate_no_detail' => $certificate_no_detail, 
                                                'newspaper_list' => $newspaper_list, 'notice_type_list' => $notice_type_list, 
                                                'property_no_type_list' => $property_no_type_list, 'location_type_list' => $location_type_list, 
                                                'othername' => $othername, 
                                                'certificate_no_type_list' => $certificate_no_type_list]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function upload_file(Request $request){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_insert']=='1' || $access['Properties']['r_edit']=='1' || $access['Properties']['r_delete']=='1' || $access['Properties']['r_approvals']=='1') {
                $property_file = $request->get('property_file');

                $user_id = auth()->user()->gu_id;
                $property_file = $request->file('property_file');
                if(isset($property_file)){
                    $imageName = $property_file->getClientOriginalName();
                    $imagePath = base_path() . '\public\uploads\property_file\\';
                    // $imagePath = base_path() . '/public/uploads/property_file/';

                    // echo $imagePath;
                    // echo '<br/>';

                    $property_file->move($imagePath, $imageName);
                    $data['file_name'] = $imageName;
                    $data['file_path'] = $imagePath;
                    $data['status'] = 'pending';
                    $data['created_by'] = $user_id;
                    $data['updated_by'] = $user_id;

                    // $id = Pn_property_file::create($data)->id;
                    $id = 1;
                    Session::flash('success_msg', 'File uploaded successfully!');

                    if($request->hasFile('property_file')){
                        // $path = $request->file('property_file')->getRealPath();
                        $path = $imagePath.$imageName;

                        // echo $path;
                        // echo '<br/>';

                        $data = Excel::load($path, function($reader) {})->get();

                        // echo json_encode($data);
                        // echo '<br/>';

                        // echo json_encode($data[0]['property_owner_name']);
                        // echo '<br/>';
                        // echo json_encode($data[0]['unit_no']);
                        // echo '<br/>';

                        $data2 = array();

                        if(!empty($data) && $data->count()){

                            // $data2 = $data->toArray();
                            // echo json_encode($data2[0]);
                            // echo '<br/>';

                            // echo $data2[0]['property_owner_name'];
                            // echo '<br/>';
                            // echo $data2[0]['unit_no'];
                            // echo '<br/>';

                            foreach ($data->toArray() as $key => $value) {
                                if(!empty($value)){
                                    // echo json_encode($key);
                                    // echo '<br/>';
                                    // echo json_encode($value);
                                    // echo '<br/>';

                                    // echo json_encode($value->property_owner_name);
                                    // echo '<br/>';

                                    // echo json_encode($value->unit_no);
                                    // echo '<br/>';

                                    echo $value['property_owner_name'];
                                    echo '<br/>';
                                    echo $value['unit_no.'];
                                    echo '<br/>';

                                    $insert[] = ['fk_file_id' => $id,
                                                'owner_name' => $value['property_owner_name'], 
                                                'unit_no' => $value['unit_no.'], 
                                                'cs_no' => $value['cs_no.'], 
                                                'cts_no' => $value['cts_no.'], 
                                                'gut_no' => $value['gut_no.'], 
                                                'hissa_no' => $value['hissa_no.'], 
                                                'plot_no' => $value['plot_no.'], 
                                                'wing' => $value['wing'], 
                                                'floor' => $value['floor'], 
                                                'society_name' => $value['buildingsociety_name'], 
                                                'area' => $value['area'], 
                                                'village' => $value['village'], 
                                                'address' => $value['address'], 
                                                'road' => $value['road'], 
                                                'division' => $value['division'], 
                                                'post' => $value['post'], 
                                                'taluka' => $value['taluka'], 
                                                'city' => $value['citydistrict'], 
                                                'pincode' => $value['pincode'], 
                                                'state' => $value['state'],
                                                'status' => 'approved',
                                                'created_by' => $user_id,
                                                'updated_by' => $user_id];
                                }
                            }

                            if(!empty($insert)){
                                Pn_file_property::insert($insert);
                            }
                        }


                        // echo json_encode($data2);
                        // echo '<br/>';

                        // for ($i=0; $i<count($data2); $i++) {
                        //     $insert[] = ['fk_file_id' => $id,
                        //                 'owner_name' => $data2[$i]['property_owner_name'], 
                        //                 'unit_no' => $data2[$i]['unit_no'], 
                        //                 'cs_no' => $data2[$i]['cs_no'], 
                        //                 'cts_no' => $data2[$i]['cts_no'], 
                        //                 'gut_no' => $data2[$i]['gut_no'], 
                        //                 'hissa_no' => $data2[$i]['hissa_no'], 
                        //                 'plot_no' => $data2[$i]['plot_no'], 
                        //                 'wing' => $data2[$i]['wing'], 
                        //                 'floor' => $data2[$i]['floor'], 
                        //                 'society_name' => $data2[$i]['buildingsociety_name'], 
                        //                 'area' => $data2[$i]['area'], 
                        //                 'village' => $data2[$i]['village'], 
                        //                 'address' => $data2[$i]['address'], 
                        //                 'road' => $data2[$i]['road'], 
                        //                 'division' => $data2[$i]['division'], 
                        //                 'post' => $data2[$i]['post'], 
                        //                 'taluka' => $data2[$i]['taluka'], 
                        //                 'city' => $data2[$i]['citydistrict'], 
                        //                 'pincode' => $data2[$i]['pincode'], 
                        //                 'state' => $data2[$i]['state'],
                        //                 'status' => 'approved',
                        //                 'created_by' => $user_id,
                        //                 'updated_by' => $user_id];
                        // }

                        // if(!empty($insert)){
                        //     Pn_file_property::insert($insert);
                        // }
                    }
                }

                echo 1;

                // $this->match_property($id);
                // $this->match_notice($id);

                // $this->match_property_notice($id);
                
                // return redirect('index.php/notice');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function get_scan(Request $request){
        $data = $request->all();
        $date_of_notice = $this->FormatDate($data['date_of_notice']);
        $fk_newspaper_id = $data['fk_newspaper_id'];
        $page_number = $data['page_number'];

        $cond = '';

        if($date_of_notice!=''){
            $cond = $cond . " and A.date_of_notice = '$date_of_notice'";
        }
        if($fk_newspaper_id!=''){
            $cond = $cond . " and A.fk_newspaper_id = '$fk_newspaper_id'";
        }
        if($page_number!=''){
            $cond = $cond . " and A.page_number = '$page_number'";
        }

        $scan_data = DB::select("select A.*, B.paper_name from pn_notice_scans A left join pn_newspapers B on (A.fk_newspaper_id=B.id) 
                                where A.status = 'approved'" . $cond);

        $rows = '';
        $i = 0;
        foreach($scan_data as $data){
            $rows = $rows . '<tr>
                                <td class="table-text">
                                    <div>'.++$i.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->date_of_notice.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->paper_name.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->page_number.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->section.'</div>
                                </td>
                                <td>
                                    <input type="hidden" id="scan_image_'.$i.'_file" name="scan_image" value="'.$data->notice_file.'" />
                                    <button type="button" id="scan_image_'.$i.'" class="label label-success" onClick="cropScanImage(this);">Select</button>
                                </td>
                            </tr>';
        }

        $result['rows'] = $rows;
        echo json_encode($result);
    }

    public function set_scan(Request $request){
        $data = $request->all();
        $imagedata = $data['imagedata'];
        if(isset($imagedata)){
            // $imageName = 'Scan_' . date('dmYHis') . '.' . $imagedata->getClientOriginalExtension();
            // $imagePath = base_path() . '/public/uploads/scans/temp/';
            // $imagedata->move($imagePath, $imageName);

            // define('UPLOAD_DIR', base_path() . '/public/uploads/scans/temp/');
            define('UPLOAD_DIR', base_path() . '/public/uploads/scans/temp/');
            $image_parts = explode(";base64,", $imagedata);
            $image_base64 = base64_decode($image_parts[1]);

            // $file = UPLOAD_DIR . uniqid() . '.png';
            $imageName = 'Scan_' . date('dmYHis') . '.png';
            $file = UPLOAD_DIR . $imageName;

            // $imageName = 'Scan_' . date('dmYHis') . '.png';
            // $imagePath = base_path() . '/public/uploads/scans/temp/';
            // $image_base64->move($imagePath, $imageName);

            file_put_contents($file, $image_base64);
        }
        $result['imageName'] = $imageName;
        echo json_encode($result);
    }

    public function add_notice(Request $request){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_insert']=='1') {
                $newspaper_id = $request->get('newspaper_id');
                $date_of_notice = $request->get('date_of_notice');
                $form_action = $request->get('form_action');

                if($form_action=='set_notice'){
                    $date_of_notice = $this->FormatDate($request->get('date_of_notice'));

                    $user_id = auth()->user()->gu_id;
                    $affected = DB::update("update pn_no_notices set status = 'approved', updated_by = ".$user_id.", updated_at = now() 
                                            where date(date_of_notice) = date('".$date_of_notice."') and 
                                            fk_newspaper_id = '".$newspaper_id."'");
                    
                    if($affected==0){
                        $data['date_of_notice'] = $date_of_notice;
                        $data['fk_newspaper_id'] = $newspaper_id;
                        $data['updated_by'] = $user_id;
                        $data['status'] = 'approved';
                        $data['created_by'] = $user_id;
                        $id = Pn_no_notice::create($data)->id;
                        Session::flash('success_msg', 'Newspaper marked as no notice!');
                    } else {
                        Session::flash('success_msg', 'Newspaper updated as no notice!');
                    }
                    
                    return redirect('index.php/notice');
                } else {
                    $newspaper_list = Pn_newspaper::orderBy('paper_name','asc')->get();
                    $notice_type_list = Pn_notice_type::orderBy('notice_type','asc')->get();
                    $property_no_type_list = Pn_property_no_type::orderBy('property_no_type','asc')->get();
                    $location_type_list = Pn_location_type::orderBy('location_type','asc')->get();
                    $certificate_no_type_list = Pn_certificate_no_type::orderBy('certificate_no_type','asc')->get();
                    $data2['fk_newspaper_id'] = $newspaper_id;
                    $data2['date_of_notice'] = $date_of_notice;
                    return view('notice.details', ['access' => $access, 'newspaper_list' => $newspaper_list, 'notice_type_list' => $notice_type_list, 
                                                    'property_no_type_list' => $property_no_type_list, 'location_type_list' => $location_type_list, 
                                                    'certificate_no_type_list' => $certificate_no_type_list, 'data2' => $data2]);
                }
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function add(){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_insert']=='1') {
                $newspaper_list = Pn_newspaper::orderBy('paper_name','asc')->get();
                $notice_type_list = Pn_notice_type::orderBy('notice_type','asc')->get();
                $property_no_type_list = Pn_property_no_type::orderBy('property_no_type','asc')->get();
                $location_type_list = Pn_location_type::orderBy('location_type','asc')->get();
                $certificate_no_type_list = Pn_certificate_no_type::orderBy('certificate_no_type','asc')->get();
                return view('notice.details', ['access' => $access, 'newspaper_list' => $newspaper_list, 'notice_type_list' => $notice_type_list, 
                                                'property_no_type_list' => $property_no_type_list, 'location_type_list' => $location_type_list, 
                                                'certificate_no_type_list' => $certificate_no_type_list]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function details($id){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_view']=='1') {
                $newspaper_list = Pn_newspaper::orderBy('paper_name','asc')->get();
                $notice_type_list = Pn_notice_type::orderBy('notice_type','asc')->get();
                $property_no_type_list = Pn_property_no_type::orderBy('property_no_type','asc')->get();
                $location_type_list = Pn_location_type::orderBy('location_type','asc')->get();
                $certificate_no_type_list = Pn_certificate_no_type::orderBy('certificate_no_type','asc')->get();
                $data = Pn_notice::find($id);
                $legal_owner_name = Pn_notice_legal_owner_name::where('fk_notice_id', $id)->get();
                $purchased_from = Pn_notice_purchased_from::where('fk_notice_id', $id)->get();
                $company_name = Pn_notice_company_name::where('fk_notice_id', $id)->get();
                $guarantor = Pn_notice_guarantor::where('fk_notice_id', $id)->get();
                $property_no_detail = Pn_notice_property_no_detail::where('fk_notice_id', $id)->get();
                $location_detail = Pn_notice_location_detail::where('fk_notice_id', $id)->get();
                $certificate_no_detail = Pn_notice_certificate_no_detail::where('fk_notice_id', $id)->get();
                $othername = Pn_notice_othername::where('fk_notice_id', $id)->get();
                return view('notice.details', ['access' => $access, 'data' => $data, 'legal_owner_name' => $legal_owner_name, 
                                                'purchased_from' => $purchased_from, 'company_name' => $company_name, 
                                                'guarantor' => $guarantor, 'property_no_detail' => $property_no_detail, 
                                                'location_detail' => $location_detail, 'certificate_no_detail' => $certificate_no_detail, 
                                                'newspaper_list' => $newspaper_list, 'notice_type_list' => $notice_type_list, 
                                                'property_no_type_list' => $property_no_type_list, 'location_type_list' => $location_type_list, 
                                                'othername' => $othername, 
                                                'certificate_no_type_list' => $certificate_no_type_list]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function edit($id){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_edit']=='1') {
                $newspaper_list = Pn_newspaper::orderBy('paper_name','asc')->get();
                $notice_type_list = Pn_notice_type::orderBy('notice_type','asc')->get();
                $property_no_type_list = Pn_property_no_type::orderBy('property_no_type','asc')->get();
                $location_type_list = Pn_location_type::orderBy('location_type','asc')->get();
                $certificate_no_type_list = Pn_certificate_no_type::orderBy('certificate_no_type','asc')->get();
                $data = Pn_notice::find($id);
                $legal_owner_name = Pn_notice_legal_owner_name::where('fk_notice_id', $id)->get();
                $purchased_from = Pn_notice_purchased_from::where('fk_notice_id', $id)->get();
                $company_name = Pn_notice_company_name::where('fk_notice_id', $id)->get();
                $guarantor = Pn_notice_guarantor::where('fk_notice_id', $id)->get();
                $property_no_detail = Pn_notice_property_no_detail::where('fk_notice_id', $id)->get();
                $location_detail = Pn_notice_location_detail::where('fk_notice_id', $id)->get();
                $certificate_no_detail = Pn_notice_certificate_no_detail::where('fk_notice_id', $id)->get();
                $othername = Pn_notice_othername::where('fk_notice_id', $id)->get();
                return view('notice.details', ['access' => $access, 'data' => $data, 'legal_owner_name' => $legal_owner_name, 
                                                'purchased_from' => $purchased_from, 'company_name' => $company_name, 
                                                'guarantor' => $guarantor, 'property_no_detail' => $property_no_detail, 
                                                'location_detail' => $location_detail, 'certificate_no_detail' => $certificate_no_detail, 
                                                'newspaper_list' => $newspaper_list, 'notice_type_list' => $notice_type_list, 
                                                'property_no_type_list' => $property_no_type_list, 'location_type_list' => $location_type_list, 
                                                'othername' => $othername,
                                                'certificate_no_type_list' => $certificate_no_type_list]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function map($id){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_edit']=='1') {
                $newspaper_list = Pn_newspaper::orderBy('paper_name','asc')->get();
                $notice_type_list = Pn_notice_type::orderBy('notice_type','asc')->get();
                $property_no_type_list = Pn_property_no_type::orderBy('property_no_type','asc')->get();
                $location_type_list = Pn_location_type::orderBy('location_type','asc')->get();
                $certificate_no_type_list = Pn_certificate_no_type::orderBy('certificate_no_type','asc')->get();
                $data = Pn_notice::find($id);
                $legal_owner_name = Pn_notice_legal_owner_name::where('fk_notice_id', $id)->get();
                $purchased_from = Pn_notice_purchased_from::where('fk_notice_id', $id)->get();
                $company_name = Pn_notice_company_name::where('fk_notice_id', $id)->get();
                $guarantor = Pn_notice_guarantor::where('fk_notice_id', $id)->get();
                $property_no_detail = Pn_notice_property_no_detail::where('fk_notice_id', $id)->get();
                $location_detail = Pn_notice_location_detail::where('fk_notice_id', $id)->get();
                $certificate_no_detail = Pn_notice_certificate_no_detail::where('fk_notice_id', $id)->get();
                $othername = Pn_notice_othername::where('fk_notice_id', $id)->get();
                return view('notice.details', ['access' => $access, 'data' => $data, 'legal_owner_name' => $legal_owner_name, 
                                                'purchased_from' => $purchased_from, 'company_name' => $company_name, 
                                                'guarantor' => $guarantor, 'property_no_detail' => $property_no_detail, 
                                                'location_detail' => $location_detail, 'certificate_no_detail' => $certificate_no_detail, 
                                                'newspaper_list' => $newspaper_list, 'notice_type_list' => $notice_type_list, 
                                                'property_no_type_list' => $property_no_type_list, 'location_type_list' => $location_type_list, 
                                                'othername' => $othername, 
                                                'certificate_no_type_list' => $certificate_no_type_list]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
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

    public function match_property($notice_id){
        // $notice_id = '1';
        $notice = Pn_notice::where('id',$notice_id)->orderBy('updated_at','desc')->get();
        // $property = Pn_property::orderBy('updated_at','desc')->get();
        
        // echo count($notice);
        // echo '<br/>';

        foreach($notice as $data){
            $cond = "";

            $sql = "select fk_location_type_id, location from pn_notice_location_details where fk_notice_id = '".$data->id."'";
            $location = DB::select($sql);
            $cond2 = "";
            foreach($location as $data2){
                if($data2->fk_location_type_id=='4' && isset($data2->location) && $data2->location!=''){
                    if(!is_numeric($data2->location)){
                        $cond4 = " or soundex(B.location) like concat('%', soundex('" . trim(str_replace("'", "", $data2->location)) . "'), '%')";
                    } else {
                        $cond4 = "";
                    }
                    if($cond2==""){
                        $cond2 = $cond2 . "(B.fk_location_type_id = '4' and (B.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                    } else {
                        $cond2 = $cond2 . " or (B.fk_location_type_id = '4' and (B.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                    }
                }
            }
            if(isset($data->city) && $data->city!=''){
                if(!is_numeric($data->city)){
                    $cond4 = " or soundex(A.city) like concat('%', soundex('" . trim(str_replace("'", "", $data->city)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                if($cond2==""){
                    $cond2 = "(A.city like '%" . trim(str_replace("'", "", trim(str_replace("'", "", $data->city)))) . "%'".$cond4.")";
                } else {
                    $cond2 = $cond2 . " or (A.city like '%" . trim(str_replace("'", "", $data->city)) . "%'".$cond4.")";
                }
            }
            if(isset($data->pincode) && $data->pincode!=''){
                if(!is_numeric($data->pincode)){
                    $cond4 = " or soundex(A.pincode) like concat('%', soundex('" . trim(str_replace("'", "", $data->pincode)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                if($cond2==""){
                    $cond2 = "(A.pincode like '%" . trim(str_replace("'", "", $data->pincode)) . "%'".$cond4.")";
                } else {
                    $cond2 = $cond2 . " or (A.pincode like '%" . trim(str_replace("'", "", $data->pincode)) . "%'".$cond4.")";
                }
            }
            if($cond2!=""){
                $cond = $cond . "and (((B.fk_location_type_id is null or B.fk_location_type_id = '' or B.location is null or B.location = '' or B.fk_location_type_id <> '4') and 
                                (A.city is null or A.city  = '') and (A.pincode is null or A.pincode  = '')) or (" . $cond2 . "))";
            }

            $cond2 = "";
            $cond3 = "";
            foreach($location as $data2){
                if(isset($data2->fk_location_type_id) && $data2->fk_location_type_id!='' && isset($data2->location) && $data2->location!=''){
                    if(!is_numeric($data2->location)){
                        $cond4 = " or soundex(H.location) like concat('%', soundex('" . trim(str_replace("'", "", $data2->location)) . "'), '%')";
                    } else {
                        $cond4 = "";
                    }
                    if($data2->fk_location_type_id=='5'){
                        if($cond2==""){
                            $cond2 = $cond2 . "(H.fk_location_type_id = '5' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        } else {
                            $cond2 = $cond2 . " or (H.fk_location_type_id = '5' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "H.fk_location_type_id <> '5'";
                        } else {
                            $cond3 = $cond3 . " and H.fk_location_type_id <> '5'";
                        }
                    }
                    if($data2->fk_location_type_id=='2'){
                        if($cond2==""){
                            $cond2 = $cond2 . "(H.fk_location_type_id = '2' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        } else {
                            $cond2 = $cond2 . " or (H.fk_location_type_id = '2' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "H.fk_location_type_id <> '2'";
                        } else {
                            $cond3 = $cond3 . " and H.fk_location_type_id <> '2'";
                        }
                    }
                    if($data2->fk_location_type_id=='3'){
                        if($cond2==""){
                            $cond2 = $cond2 . "(H.fk_location_type_id = '3' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        } else {
                            $cond2 = $cond2 . " or (H.fk_location_type_id = '3' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "H.fk_location_type_id <> '3'";
                        } else {
                            $cond3 = $cond3 . " and H.fk_location_type_id <> '3'";
                        }
                    }
                    if($data2->fk_location_type_id=='1'){
                        if($cond2==""){
                            $cond2 = $cond2 . "(H.fk_location_type_id = '1' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        } else {
                            $cond2 = $cond2 . " or (H.fk_location_type_id = '1' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "H.fk_location_type_id <> '1'";
                        } else {
                            $cond3 = $cond3 . " and H.fk_location_type_id <> '1'";
                        }
                    }
                }
            }
            if($cond2!="" || $cond3!=""){
                $cond = $cond . " and ((H.fk_location_type_id is null or H.fk_location_type_id = '' or H.location is null or H.location = '') or 
                                    (" . $cond2 . ") or (" . $cond3 . "))";
            }

            $cond2 = "";
            if(isset($data->property_type) && $data->property_type!=''){
                if(!is_numeric($data->property_type)){
                    $cond4 = " or soundex(A.property_type) like concat('%', soundex('" . trim(str_replace("'", "", $data->property_type)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                $cond2 = $cond2 . "A.property_type is null or A.property_type  = '' or (A.property_type like '%" . trim(str_replace("'", "", $data->property_type)) . "%'".$cond4.")";
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
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(C.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(C.fk_property_no_type_id = '9' and (C.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (C.fk_property_no_type_id = '9' and (C.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(A.apartment_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(A.apartment_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4.")";
                                } else {
                                    $cond2 = $cond2 . " or (A.apartment_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4.")";
                                }
                            }
                        }
                    }
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.apartment_no is null or A.apartment_no  = '') and (C.fk_property_no_type_id != '9' or 
                                        C.fk_property_no_type_id is null or C.fk_property_no_type_id = '' or C.property_no is null or C.property_no = '')) or 
                                        (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->floor) && $data->floor!=''){
                if(!is_numeric($data->floor)){
                    $cond4 = " or soundex(A.floor) like concat('%', soundex('" . trim(str_replace("'", "", $data->floor)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                $cond2 = "(A.floor like '%" . trim(str_replace("'", "", $data->floor)) . "%'".$cond4.")";
            }
            if(isset($data->wing) && $data->wing!=''){
                if(!is_numeric($data->wing)){
                    $cond4 = " or soundex(A.wing) like concat('%', soundex('" . trim(str_replace("'", "", $data->wing)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                if($cond2==""){
                    $cond2 = "(A.wing like '%" . trim(str_replace("'", "", $data->wing)) . "%'".$cond4.")";
                } else {
                    $cond2 = $cond2 . " or (A.wing like '%" . trim(str_replace("'", "", $data->wing)) . "%'".$cond4.")";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.floor is null or A.floor  = '') and (A.wing is null or A.wing  = '')) or (" . $cond2 . "))";
            }

            $cond2 = "";
            $cond3 = "";
            foreach($property_no as $data2){
                if(isset($data2->fk_property_no_type_id) && $data2->fk_property_no_type_id!='' && isset($data2->property_no) && $data2->property_no!=''){
                    if($data2->fk_property_no_type_id=='1'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(I.fk_property_no_type_id = '1' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (I.fk_property_no_type_id = '1' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '1'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '1'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='2'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(I.fk_property_no_type_id = '2' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (I.fk_property_no_type_id = '2' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '2'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '2'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='3'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(I.fk_property_no_type_id = '3' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (I.fk_property_no_type_id = '3' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '3'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '3'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='4'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(I.fk_property_no_type_id = '4' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (I.fk_property_no_type_id = '4' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '4'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '4'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='5'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(I.fk_property_no_type_id = '5' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (I.fk_property_no_type_id = '5' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '5'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '5'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='6'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(I.fk_property_no_type_id = '6' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (I.fk_property_no_type_id = '6' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '6'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '6'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='7'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(I.fk_property_no_type_id = '7' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (I.fk_property_no_type_id = '7' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '7'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '7'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='8'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(I.fk_property_no_type_id = '8' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (I.fk_property_no_type_id = '8' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '8'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '8'";
                        }
                    }
                }
            }
            if($cond2!="" || $cond3!=""){
                $cond = $cond . " and ((I.fk_property_no_type_id is null or I.fk_property_no_type_id = '' or I.property_no is null or I.property_no = '') or 
                                    (" . $cond2 . ") or (" . $cond3 . "))";
            }

            $cond2 = "";
            $cond3 = "";
            foreach($property_no as $data2){
                if(isset($data2->fk_property_no_type_id) && $data2->fk_property_no_type_id!='' && isset($data2->property_no) && $data2->property_no!=''){
                    if($data2->fk_property_no_type_id=='10'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(J.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(J.fk_property_no_type_id = '10' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (J.fk_property_no_type_id = '10' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "J.fk_property_no_type_id <> '10'";
                        } else {
                            $cond3 = $cond3 . " and J.fk_property_no_type_id <> '10'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='11'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(J.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(J.fk_property_no_type_id = '11' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (J.fk_property_no_type_id = '11' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "J.fk_property_no_type_id <> '11'";
                        } else {
                            $cond3 = $cond3 . " and J.fk_property_no_type_id <> '11'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='12'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(J.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(J.fk_property_no_type_id = '12' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (J.fk_property_no_type_id = '12' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "J.fk_property_no_type_id <> '12'";
                        } else {
                            $cond3 = $cond3 . " and J.fk_property_no_type_id <> '12'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='13'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(J.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(J.fk_property_no_type_id = '13' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (J.fk_property_no_type_id = '13' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "J.fk_property_no_type_id <> '13'";
                        } else {
                            $cond3 = $cond3 . " and J.fk_property_no_type_id <> '13'";
                        }
                    }
                }
            }
            if($cond2!="" || $cond3!=""){
                $cond = $cond . " and ((J.fk_property_no_type_id is null or J.fk_property_no_type_id = '' or J.property_no is null or J.property_no = '') or 
                                    (" . $cond2 . ") or (" . $cond3 . "))";
            }

            $sql = "select fk_certificate_no_type_id, certificate_no from pn_notice_certificate_no_details where fk_notice_id = '".$data->id."'";
            $certificate_no = DB::select($sql);
            $cond2 = "";
            $cond3 = "";
            foreach($certificate_no as $data2){
                if(isset($data2->fk_certificate_no_type_id) && $data2->fk_certificate_no_type_id!='' && isset($data2->certificate_no) && $data2->certificate_no!=''){
                    if($data2->fk_certificate_no_type_id=='1'){
                        $check_arr = explode(',', $data2->certificate_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(D.certificate_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(D.fk_certificate_no_type_id = '1' and (D.certificate_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (D.fk_certificate_no_type_id = '1' and (D.certificate_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "D.fk_certificate_no_type_id <> '1'";
                        } else {
                            $cond3 = $cond3 . " and D.fk_certificate_no_type_id <> '1'";
                        }
                    }
                    if($data2->fk_certificate_no_type_id=='2'){
                        $check_arr = explode(',', $data2->certificate_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(D.certificate_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(D.fk_certificate_no_type_id = '2' and (D.certificate_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (D.fk_certificate_no_type_id = '2' and (D.certificate_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "D.fk_certificate_no_type_id <> '2'";
                        } else {
                            $cond3 = $cond3 . " and D.fk_certificate_no_type_id <> '2'";
                        }
                    }
                    if($data2->fk_certificate_no_type_id=='3'){
                        $check_arr = explode(',', $data2->certificate_no);

                        foreach ($check_arr as $check_val) {
                            if(isset($check_val) && $check_val!=''){
                                if(!is_numeric($check_val)){
                                    $cond4 = " or soundex(D.certificate_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                                } else {
                                    $cond4 = "";
                                }
                                if($cond2==""){
                                    $cond2 = $cond2 . "(D.fk_certificate_no_type_id = '3' and (D.certificate_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                } else {
                                    $cond2 = $cond2 . " or (D.fk_certificate_no_type_id = '3' and (D.certificate_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                                }
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "D.fk_certificate_no_type_id <> '3'";
                        } else {
                            $cond3 = $cond3 . " and D.fk_certificate_no_type_id <> '3'";
                        }
                    }
                }
            }
            if($cond2!="" || $cond3!=""){
                $cond = $cond . " and ((D.fk_certificate_no_type_id is null or D.fk_certificate_no_type_id = '' or D.certificate_no is null or D.certificate_no = '') or 
                                    (" . $cond2 . ") or (" . $cond3 . "))";
            }

            $cond2 = "";
            if(isset($data->address) && $data->address!=''){
                if(!is_numeric($data->address)){
                    $cond4 = " or soundex(A.property_name) like concat('%', soundex('" . trim(str_replace("'", "", $data->address)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                if($cond2==""){
                    $cond2 = $cond2 . "(A.property_name like '%" . trim(str_replace("'", "", $data->address)) . "%'".$cond4.")";
                } else {
                    $cond2 = $cond2 . " or (A.property_name like '%" . trim(str_replace("'", "", $data->address)) . "%'".$cond4.")";
                }
            }
            if(isset($data->building_name) && $data->building_name!=''){
                if(!is_numeric($data->building_name)){
                    $cond4 = " or soundex(A.building_name) like concat('%', soundex('" . trim(str_replace("'", "", $data->building_name)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                if($cond2==""){
                    $cond2 = $cond2 . "(A.building_name like '%" . trim(str_replace("'", "", $data->building_name)) . "%'".$cond4.")";
                } else {
                    $cond2 = $cond2 . " or (A.building_name like '%" . trim(str_replace("'", "", $data->building_name)) . "%'".$cond4.")";
                }
            }
            if(isset($data->society_name) && $data->society_name!=''){
                if(!is_numeric($data->society_name)){
                    $cond4 = " or soundex(A.society_name) like concat('%', soundex('" . trim(str_replace("'", "", $data->society_name)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                if($cond2==""){
                    $cond2 = $cond2 . "(A.society_name like '%" . trim(str_replace("'", "", $data->society_name)) . "%'".$cond4.")";
                } else {
                    $cond2 = $cond2 . " or (A.society_name like '%" . trim(str_replace("'", "", $data->society_name)) . "%'".$cond4.")";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.property_name is null or A.property_name  = '') and 
                                (A.building_name is null or A.building_name  = '') and (A.society_name is null or A.society_name  = '')) 
                                or (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->address) && $data->address!=''){
                if(!is_numeric($data->address)){
                    $cond4 = " or soundex(A.address) like concat('%', soundex('" . trim(str_replace("'", "", $data->address)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                $cond2 = $cond2 . "(A.address like '%" . trim(str_replace("'", "", $data->address)) . "%'".$cond4.")";
            }
            if(isset($data->property_description) && $data->property_description!=''){
                if(!is_numeric($data->property_description)){
                    $cond4 = " or soundex(A.description) like concat('%', soundex('" . trim(str_replace("'", "", $data->property_description)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                if($cond2==""){
                    $cond2 = $cond2 . "(A.description like '%" . trim(str_replace("'", "", $data->property_description)) . "%'".$cond4.")";
                } else {
                    $cond2 = $cond2 . " or (A.description like '%" . trim(str_replace("'", "", $data->property_description)) . "%'".$cond4.")";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.address is null or A.address  = '') and (A.description is null or A.description  = '')) 
                                or (" . $cond2 . "))";
            }


            $sql = "select legal_owner_name from pn_notice_legal_owner_names where fk_notice_id = '".$data->id."'";
            $legal_owner_name = DB::select($sql);
            $cond2 = "";
            foreach($legal_owner_name as $data2){
                if(isset($data2->legal_owner_name) && $data2->legal_owner_name!=''){
                    if(!is_numeric($data2->legal_owner_name)){
                        $cond4 = " or soundex(E.legal_owner_name) like concat('%', soundex('" . trim(str_replace("'", "", $data2->legal_owner_name)) . "'), '%')";
                    } else {
                        $cond4 = "";
                    }
                    if($cond2==""){
                        $cond2 = $cond2 . "(E.legal_owner_name like '%" . trim(str_replace("'", "", $data2->legal_owner_name)) . "%'".$cond4.")";
                    } else {
                        $cond2 = $cond2 . " or (E.legal_owner_name like '%" . trim(str_replace("'", "", $data2->legal_owner_name)) . "%'".$cond4.")";
                    }
                }
            }
            $sql = "select purchased_from from pn_notice_purchased_froms where fk_notice_id = '".$data->id."'";
            $purchased_from = DB::select($sql);
            foreach($purchased_from as $data2){
                if(isset($data2->purchased_from) && $data2->purchased_from!=''){
                    if(!is_numeric($data2->purchased_from)){
                        $cond4 = " or soundex(F.purchased_from) like concat('%', soundex('" . trim(str_replace("'", "", $data2->purchased_from)) . "'), '%')";
                    } else {
                        $cond4 = "";
                    }
                    if($cond2==""){
                        $cond2 = $cond2 . "(F.purchased_from like '%" . trim(str_replace("'", "", $data2->purchased_from)) . "%'".$cond4.")";
                    } else {
                        $cond2 = $cond2 . " or (F.purchased_from like '%" . trim(str_replace("'", "", $data2->purchased_from)) . "%'".$cond4.")";
                    }
                }
            }
            $sql = "select company_name from pn_notice_company_names where fk_notice_id = '".$data->id."'";
            $company_name = DB::select($sql);
            foreach($company_name as $data2){
                if(isset($data2->company_name) && $data2->company_name!=''){
                    if(!is_numeric($data2->company_name)){
                        $cond4 = " or soundex(G.company_name) like concat('%', soundex('" . trim(str_replace("'", "", $data2->company_name)) . "'), '%')";
                    } else {
                        $cond4 = "";
                    }
                    if($cond2==""){
                        $cond2 = $cond2 . "(G.company_name like '%" . trim(str_replace("'", "", $data2->company_name)) . "%'".$cond4.")";
                    } else {
                        $cond2 = $cond2 . " or (G.company_name like '%" . trim(str_replace("'", "", $data2->company_name)) . "%'".$cond4.")";
                    }
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((E.legal_owner_name is null or E.legal_owner_name  = '') and (F.purchased_from is null or F.purchased_from  = '')
                                and (G.company_name is null or G.company_name  = '')) or (" . $cond2 . "))";
            }

            $sql = "select distinct A.id from pn_properties A 
                    left join pn_property_location_details B on (A.id = B.fk_property_id) 
                    left join pn_property_prop_no_details C on (A.id = C.fk_property_id) 
                    left join pn_property_certificate_no_details D on (A.id = D.fk_property_id) 
                    left join pn_property_legal_owner_names E on (A.id = E.fk_property_id) 
                    left join pn_property_purchased_froms F on (A.id = F.fk_property_id) 
                    left join pn_property_company_names G on (A.id = G.fk_property_id) 
                    left join pn_property_location_details H on (A.id = H.fk_property_id) 
                    left join pn_property_prop_no_details I on (A.id = I.fk_property_id) 
                    left join pn_property_prop_no_details J on (A.id = J.fk_property_id) 
                    where A.status = 'approved' and 
                    A.id not in (select distinct fk_property_id from pn_property_notices where fk_notice_id='".$data->id."') and 
                    (B.fk_location_type_id is not null or B.fk_location_type_id <> '' or B.location is not null or B.location <> '' or 
                        A.city is not null or A.city <> '' or A.pincode is not null or A.pincode <> '' or 
                        A.property_type is not null or A.property_type <> '' or C.fk_property_no_type_id is not null or C.fk_property_no_type_id <> '' or 
                        C.property_no is not null or C.property_no <> '' or A.floor is not null or A.floor <> '' or A.wing is not null or A.wing <> '' or 
                        A.property_name is not null or A.property_name <> '' or 
                        D.fk_certificate_no_type_id is not null or D.fk_certificate_no_type_id <> '' or 
                        D.certificate_no is not null or D.certificate_no <> '' or A.building_name is not null or A.building_name <> '' or 
                        A.society_name is not null or A.society_name <> '' or A.address is not null or A.address <> '' or 
                        A.description is not null or A.description <> '' or 
                        E.legal_owner_name is not null or E.legal_owner_name <> '' or 
                        F.purchased_from is not null or F.purchased_from <> '' or 
                        G.company_name is not null or G.company_name <> '') " . $cond;
            $property = DB::select($sql);
            // echo $sql;
            // echo '<br/>';
            // echo json_encode($property);
            // echo '<br/>';

            foreach($property as $data2){
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

    public function match_notice($notice_id){
        // $property_id = '1';
        // $property = Pn_property::where('id',$property_id)->orderBy('updated_at','desc')->get();
        $property = Pn_property::orderBy('updated_at','desc')->get();
        
        // echo count($property);
        // echo '<br/>';

        foreach($property as $data){
            $cond = "";

            $sql = "select fk_location_type_id, location from pn_property_location_details where fk_property_id = '".$data->id."'";
            $location = DB::select($sql);
            $cond2 = "";
            foreach($location as $data2){
                if(!is_numeric($data2->location)){
                    $cond4 = " or soundex(B.location) like concat('%', soundex('" . trim(str_replace("'", "", $data2->location)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                if($data2->fk_location_type_id=='4' && isset($data2->location) && $data2->location!=''){
                    if($cond2==""){
                        $cond2 = $cond2 . "(B.fk_location_type_id = '4' and (B.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                    } else {
                        $cond2 = $cond2 . " or (B.fk_location_type_id = '4' and (B.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                    }
                }
            }
            if(isset($data->city) && $data->city!=''){
                if(!is_numeric($data->city)){
                    $cond4 = " or soundex(A.city) like concat('%', soundex('" . trim(str_replace("'", "", $data->city)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                if($cond2==""){
                    $cond2 = "(A.city like '%" . trim(str_replace("'", "", trim(str_replace("'", "", $data->city)))) . "%'".$cond4.")";
                } else {
                    $cond2 = $cond2 . " or (A.city like '%" . trim(str_replace("'", "", $data->city)) . "%'".$cond4.")";
                }
            }
            if(isset($data->pincode) && $data->pincode!=''){
                if(!is_numeric($data->pincode)){
                    $cond4 = " or soundex(A.pincode) like concat('%', soundex('" . trim(str_replace("'", "", $data->pincode)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                if($cond2==""){
                    $cond2 = "(A.pincode like '%" . trim(str_replace("'", "", $data->pincode)) . "%'".$cond4.")";
                } else {
                    $cond2 = $cond2 . " or (A.pincode like '%" . trim(str_replace("'", "", $data->pincode)) . "%'".$cond4.")";
                }
            }
            if($cond2!=""){
                $cond = $cond . "and (((B.fk_location_type_id is null or B.fk_location_type_id = '' or B.location is null or B.location = '' or B.fk_location_type_id <> '4') and 
                                (A.city is null or A.city  = '') and (A.pincode is null or A.pincode  = '')) or (" . $cond2 . "))";
            }

            $cond2 = "";
            $cond3 = "";
            foreach($location as $data2){
                if(isset($data2->fk_location_type_id) && $data2->fk_location_type_id!='' && isset($data2->location) && $data2->location!=''){
                    if(!is_numeric($data2->location)){
                        $cond4 = " or soundex(H.location) like concat('%', soundex('" . trim(str_replace("'", "", $data2->location)) . "'), '%')";
                    } else {
                        $cond4 = "";
                    }
                    if($data2->fk_location_type_id=='5'){
                        if($cond2==""){
                            $cond2 = $cond2 . "(H.fk_location_type_id = '5' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        } else {
                            $cond2 = $cond2 . " or (H.fk_location_type_id = '5' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "H.fk_location_type_id <> '5'";
                        } else {
                            $cond3 = $cond3 . " and H.fk_location_type_id <> '5'";
                        }
                    }
                    if($data2->fk_location_type_id=='2'){
                        if($cond2==""){
                            $cond2 = $cond2 . "(H.fk_location_type_id = '2' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        } else {
                            $cond2 = $cond2 . " or (H.fk_location_type_id = '2' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "H.fk_location_type_id <> '2'";
                        } else {
                            $cond3 = $cond3 . " and H.fk_location_type_id <> '2'";
                        }
                    }
                    if($data2->fk_location_type_id=='3'){
                        if($cond2==""){
                            $cond2 = $cond2 . "(H.fk_location_type_id = '3' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        } else {
                            $cond2 = $cond2 . " or (H.fk_location_type_id = '3' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "H.fk_location_type_id <> '3'";
                        } else {
                            $cond3 = $cond3 . " and H.fk_location_type_id <> '3'";
                        }
                    }
                    if($data2->fk_location_type_id=='1'){
                        if($cond2==""){
                            $cond2 = $cond2 . "(H.fk_location_type_id = '1' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        } else {
                            $cond2 = $cond2 . " or (H.fk_location_type_id = '1' and (H.location like '%" . trim(str_replace("'", "", $data2->location)) . "%'".$cond4."))";
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "H.fk_location_type_id <> '1'";
                        } else {
                            $cond3 = $cond3 . " and H.fk_location_type_id <> '1'";
                        }
                    }
                }
            }
            if($cond2!="" || $cond3!=""){
                $cond = $cond . " and ((H.fk_location_type_id is null or H.fk_location_type_id = '' or H.location is null or H.location = '') or 
                                    (" . $cond2 . ") or (" . $cond3 . "))";
            }

            $cond2 = "";
            if(isset($data->property_type) && $data->property_type!=''){
                if(!is_numeric($data->property_type)){
                    $cond4 = " or soundex(A.property_type) like concat('%', soundex('" . trim(str_replace("'", "", $data->property_type)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                $cond2 = $cond2 . "A.property_type is null or A.property_type  = '' or (A.property_type like '%" . trim(str_replace("'", "", $data->property_type)) . "%'".$cond4.")";
            }
            if($cond2!=""){
                $cond = $cond . " and (" . $cond2 . ")";
            }

            $sql = "select fk_property_no_type_id, property_no from pn_property_prop_no_details where fk_property_id = '".$data->id."'";
            $property_no = DB::select($sql);
            $cond2 = "";
            foreach($property_no as $data2){
                if(isset($data2->fk_property_no_type_id) && $data2->fk_property_no_type_id!='' && isset($data2->property_no) && $data2->property_no!=''){
                    if($data2->fk_property_no_type_id=='9'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(C.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(C.fk_property_no_type_id = '9' and (C.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (C.fk_property_no_type_id = '9' and (C.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                    }
                }
            }
            if(isset($data->apartment_no) && $data->apartment_no!=''){
                $check_arr = explode(',', $data->apartment_no);

                foreach ($check_arr as $check_val) {
                    if(!is_numeric($check_val)){
                        $cond4 = " or soundex(C.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                    } else {
                        $cond4 = "";
                    }
                    if($cond2==""){
                        $cond2 = $cond2 . "(C.fk_property_no_type_id = '9' and (C.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                    } else {
                        $cond2 = $cond2 . " or (C.fk_property_no_type_id = '9' and (C.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                    }
                }
            }
            if($cond2!=""){
                $cond = $cond . " and ((C.fk_property_no_type_id != '9' or C.fk_property_no_type_id is null or C.fk_property_no_type_id = '' or C.property_no is null or C.property_no = '') or 
                                        (" . $cond2 . "))";
            }

            $cond2 = "";
            if(isset($data->floor) && $data->floor!=''){
                if(!is_numeric($data->floor)){
                    $cond4 = " or soundex(A.floor) like concat('%', soundex('" . trim(str_replace("'", "", $data->floor)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                $cond2 = "(A.floor like '%" . trim(str_replace("'", "", $data->floor)) . "%'".$cond4.")";
            }
            if(isset($data->wing) && $data->wing!=''){
                if(!is_numeric($data->wing)){
                    $cond4 = " or soundex(A.wing) like concat('%', soundex('" . trim(str_replace("'", "", $data->wing)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                if($cond2==""){
                    $cond2 = "(A.wing like '%" . trim(str_replace("'", "", $data->wing)) . "%'".$cond4.")";
                } else {
                    $cond2 = $cond2 . " or (A.wing like '%" . trim(str_replace("'", "", $data->wing)) . "%'".$cond4.")";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.floor is null or A.floor  = '') and (A.wing is null or A.wing  = '')) or (" . $cond2 . "))";
            }

            $cond2 = "";
            $cond3 = "";
            foreach($property_no as $data2){
                if(isset($data2->fk_property_no_type_id) && $data2->fk_property_no_type_id!='' && isset($data2->property_no) && $data2->property_no!=''){
                    if($data2->fk_property_no_type_id=='1'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(I.fk_property_no_type_id = '1' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (I.fk_property_no_type_id = '1' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '1'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '1'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='2'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(I.fk_property_no_type_id = '2' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (I.fk_property_no_type_id = '2' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '2'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '2'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='3'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(I.fk_property_no_type_id = '3' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (I.fk_property_no_type_id = '3' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '3'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '3'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='4'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(I.fk_property_no_type_id = '4' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (I.fk_property_no_type_id = '4' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '4'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '4'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='5'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(I.fk_property_no_type_id = '5' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (I.fk_property_no_type_id = '5' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '5'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '5'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='6'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(I.fk_property_no_type_id = '6' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (I.fk_property_no_type_id = '6' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '6'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '6'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='7'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(I.fk_property_no_type_id = '7' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (I.fk_property_no_type_id = '7' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '7'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '7'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='8'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(I.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(I.fk_property_no_type_id = '8' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (I.fk_property_no_type_id = '8' and (I.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "I.fk_property_no_type_id <> '8'";
                        } else {
                            $cond3 = $cond3 . " and I.fk_property_no_type_id <> '8'";
                        }
                    }
                }
            }
            if($cond2!="" || $cond3!=""){
                $cond = $cond . " and ((I.fk_property_no_type_id is null or I.fk_property_no_type_id = '' or I.property_no is null or I.property_no = '') or 
                                    (" . $cond2 . ") or (" . $cond3 . "))";
            }

            $cond2 = "";
            $cond3 = "";
            foreach($property_no as $data2){
                if(isset($data2->fk_property_no_type_id) && $data2->fk_property_no_type_id!='' && isset($data2->property_no) && $data2->property_no!=''){
                    if($data2->fk_property_no_type_id=='10'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(J.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(J.fk_property_no_type_id = '10' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (J.fk_property_no_type_id = '10' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "J.fk_property_no_type_id <> '10'";
                        } else {
                            $cond3 = $cond3 . " and J.fk_property_no_type_id <> '10'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='11'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(J.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(J.fk_property_no_type_id = '11' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (J.fk_property_no_type_id = '11' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "J.fk_property_no_type_id <> '11'";
                        } else {
                            $cond3 = $cond3 . " and J.fk_property_no_type_id <> '11'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='12'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(J.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(J.fk_property_no_type_id = '12' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (J.fk_property_no_type_id = '12' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "J.fk_property_no_type_id <> '12'";
                        } else {
                            $cond3 = $cond3 . " and J.fk_property_no_type_id <> '12'";
                        }
                    }
                    if($data2->fk_property_no_type_id=='13'){
                        $check_arr = explode(',', $data2->property_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(J.property_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(J.fk_property_no_type_id = '13' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (J.fk_property_no_type_id = '13' and (J.property_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "J.fk_property_no_type_id <> '13'";
                        } else {
                            $cond3 = $cond3 . " and J.fk_property_no_type_id <> '13'";
                        }
                    }
                }
            }
            if($cond2!="" || $cond3!=""){
                $cond = $cond . " and ((J.fk_property_no_type_id is null or J.fk_property_no_type_id = '' or J.property_no is null or J.property_no = '') or 
                                    (" . $cond2 . ") or (" . $cond3 . "))";
            }

            $sql = "select fk_certificate_no_type_id, certificate_no from pn_property_certificate_no_details where fk_property_id = '".$data->id."'";
            $certificate_no = DB::select($sql);
            $cond2 = "";
            $cond3 = "";
            foreach($certificate_no as $data2){
                if(isset($data2->fk_certificate_no_type_id) && $data2->fk_certificate_no_type_id!='' && isset($data2->certificate_no) && $data2->certificate_no!=''){
                    if($data2->fk_certificate_no_type_id=='1'){
                        $check_arr = explode(',', $data2->certificate_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(D.certificate_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(D.fk_certificate_no_type_id = '1' and (D.certificate_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (D.fk_certificate_no_type_id = '1' and (D.certificate_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "D.fk_certificate_no_type_id <> '1'";
                        } else {
                            $cond3 = $cond3 . " and D.fk_certificate_no_type_id <> '1'";
                        }
                    }
                    if($data2->fk_certificate_no_type_id=='2'){
                        $check_arr = explode(',', $data2->certificate_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(D.certificate_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(D.fk_certificate_no_type_id = '2' and (D.certificate_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (D.fk_certificate_no_type_id = '2' and (D.certificate_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "D.fk_certificate_no_type_id <> '2'";
                        } else {
                            $cond3 = $cond3 . " and D.fk_certificate_no_type_id <> '2'";
                        }
                    }
                    if($data2->fk_certificate_no_type_id=='3'){
                        $check_arr = explode(',', $data2->certificate_no);

                        foreach ($check_arr as $check_val) {
                            if(!is_numeric($check_val)){
                                $cond4 = " or soundex(D.certificate_no) like concat('%', soundex('" . trim(str_replace("'", "", $check_val)) . "'), '%')";
                            } else {
                                $cond4 = "";
                            }
                            if($cond2==""){
                                $cond2 = $cond2 . "(D.fk_certificate_no_type_id = '3' and (D.certificate_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            } else {
                                $cond2 = $cond2 . " or (D.fk_certificate_no_type_id = '3' and (D.certificate_no like '%" . trim(str_replace("'", "", $check_val)) . "%'".$cond4."))";
                            }
                        }
                        if($cond3==""){
                            $cond3 = $cond3 . "D.fk_certificate_no_type_id <> '3'";
                        } else {
                            $cond3 = $cond3 . " and D.fk_certificate_no_type_id <> '3'";
                        }
                    }
                }
            }
            if($cond2!="" || $cond3!=""){
                $cond = $cond . " and ((D.fk_certificate_no_type_id is null or D.fk_certificate_no_type_id = '' or D.certificate_no is null or D.certificate_no = '') or 
                                    (" . $cond2 . ") or (" . $cond3 . "))";
            }

            $cond2 = "";
            if(isset($data->property_name) && $data->property_name!=''){
                if(!is_numeric($data->property_name)){
                    $cond4 = " or soundex(A.address) like concat('%', soundex('" . trim(str_replace("'", "", $data->property_name)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                if($cond2==""){
                    $cond2 = $cond2 . "(A.address like '%" . trim(str_replace("'", "", $data->property_name)) . "%'".$cond4.")";
                } else {
                    $cond2 = $cond2 . " or (A.address like '%" . trim(str_replace("'", "", $data->property_name)) . "%'".$cond4.")";
                }
            }
            if(isset($data->building_name) && $data->building_name!=''){
                if(!is_numeric($data->building_name)){
                    $cond4 = " or soundex(A.building_name) like concat('%', soundex('" . trim(str_replace("'", "", $data->building_name)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                if($cond2==""){
                    $cond2 = $cond2 . "(A.building_name like '%" . trim(str_replace("'", "", $data->building_name)) . "%'".$cond4.")";
                } else {
                    $cond2 = $cond2 . " or (A.building_name like '%" . trim(str_replace("'", "", $data->building_name)) . "%'".$cond4.")";
                }
            }
            if(isset($data->society_name) && $data->society_name!=''){
                if(!is_numeric($data->society_name)){
                    $cond4 = " or soundex(A.society_name) like concat('%', soundex('" . trim(str_replace("'", "", $data->society_name)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                if($cond2==""){
                    $cond2 = $cond2 . "(A.society_name like '%" . trim(str_replace("'", "", $data->society_name)) . "%'".$cond4.")";
                } else {
                    $cond2 = $cond2 . " or (A.society_name like '%" . trim(str_replace("'", "", $data->society_name)) . "%'".$cond4.")";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.address is null or A.address  = '') and 
                                (A.building_name is null or A.building_name  = '') and (A.society_name is null or A.society_name  = '')) 
                                or (" . $cond2 . "))";
            }
            // if($cond2!=""){
            //     $cond = $cond . " and (((A.building_name is null or A.building_name  = '') and (A.society_name is null or A.society_name  = '')) 
            //                     or (" . $cond2 . "))";
            // }

            $cond2 = "";
            if(isset($data->address) && $data->address!=''){
                if(!is_numeric($data->address)){
                    $cond4 = " or soundex(A.address) like concat('%', soundex('" . trim(str_replace("'", "", $data->address)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                $cond2 = $cond2 . "(A.address like '%" . trim(str_replace("'", "", $data->address)) . "%'".$cond4.")";
            }
            if(isset($data->description) && $data->description!=''){
                if(!is_numeric($data->description)){
                    $cond4 = " or soundex(A.property_description) like concat('%', soundex('" . trim(str_replace("'", "", $data->description)) . "'), '%')";
                } else {
                    $cond4 = "";
                }
                if($cond2==""){
                    $cond2 = $cond2 . "(A.property_description like '%" . trim(str_replace("'", "", $data->description)) . "%'".$cond4.")";
                } else {
                    $cond2 = $cond2 . " or (A.property_description like '%" . trim(str_replace("'", "", $data->description)) . "%'".$cond4.")";
                }
            }
            if($cond2!=""){
                $cond = $cond . " and (((A.address is null or A.address  = '') and (A.property_description is null or A.property_description  = '')) 
                                or (" . $cond2 . "))";
            }


            $sql = "select legal_owner_name from pn_property_legal_owner_names where fk_property_id = '".$data->id."'";
            $legal_owner_name = DB::select($sql);
            $cond2 = "";
            foreach($legal_owner_name as $data2){
                if(isset($data2->legal_owner_name) && $data2->legal_owner_name!=''){
                    if(!is_numeric($data2->legal_owner_name)){
                        $cond4 = " or soundex(E.legal_owner_name) like concat('%', soundex('" . trim(str_replace("'", "", $data2->legal_owner_name)) . "'), '%')";
                    } else {
                        $cond4 = "";
                    }
                    if($cond2==""){
                        $cond2 = $cond2 . "(E.legal_owner_name like '%" . trim(str_replace("'", "", $data2->legal_owner_name)) . "%'".$cond4.")";
                    } else {
                        $cond2 = $cond2 . " or (E.legal_owner_name like '%" . trim(str_replace("'", "", $data2->legal_owner_name)) . "%'".$cond4.")";
                    }
                }
            }
            $sql = "select purchased_from from pn_property_purchased_froms where fk_property_id = '".$data->id."'";
            $purchased_from = DB::select($sql);
            foreach($purchased_from as $data2){
                if(isset($data2->purchased_from) && $data2->purchased_from!=''){
                    if(!is_numeric($data2->purchased_from)){
                        $cond4 = " or soundex(F.purchased_from) like concat('%', soundex('" . trim(str_replace("'", "", $data2->purchased_from)) . "'), '%')";
                    } else {
                        $cond4 = "";
                    }
                    if($cond2==""){
                        $cond2 = $cond2 . "(F.purchased_from like '%" . trim(str_replace("'", "", $data2->purchased_from)) . "%'".$cond4.")";
                    } else {
                        $cond2 = $cond2 . " or (F.purchased_from like '%" . trim(str_replace("'", "", $data2->purchased_from)) . "%'".$cond4.")";
                    }
                }
            }
            $sql = "select company_name from pn_property_company_names where fk_property_id = '".$data->id."'";
            $company_name = DB::select($sql);
            foreach($company_name as $data2){
                if(isset($data2->company_name) && $data2->company_name!=''){
                    if(!is_numeric($data2->company_name)){
                        $cond4 = " or soundex(G.company_name) like concat('%', soundex('" . trim(str_replace("'", "", $data2->company_name)) . "'), '%')";
                    } else {
                        $cond4 = "";
                    }
                    if($cond2==""){
                        $cond2 = $cond2 . "(G.company_name like '%" . trim(str_replace("'", "", $data2->company_name)) . "%'".$cond4.")";
                    } else {
                        $cond2 = $cond2 . " or (G.company_name like '%" . trim(str_replace("'", "", $data2->company_name)) . "%'".$cond4.")";
                    }
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
                    where A.status = 'approved' and A.id = '$notice_id' and 
                    A.id not in (select distinct fk_notice_id from pn_property_notices where fk_property_id='".$data->id."') and 
                    (B.fk_location_type_id is not null or B.fk_location_type_id <> '' or B.location is not null or B.location <> '' or 
                        A.city is not null or A.city <> '' or A.pincode is not null or A.pincode <> '' or 
                        A.property_type is not null or A.property_type <> '' or C.fk_property_no_type_id is not null or C.fk_property_no_type_id <> '' or 
                        C.property_no is not null or C.property_no <> '' or A.floor is not null or A.floor <> '' or A.wing is not null or A.wing <> '' or 
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
                $user_id = auth()->user()->gu_id;;
                $data3['updated_by'] = $user_id;
                $data3['status'] = 'pending';
                $data3['created_by'] = $user_id;
                Pn_property_notice::create($data3);
            }
        }
    }

    public function match_criteria($criteria1, $criteria2){
        $bl_criteria = false;
        $matching_criteria = '';

        if(stripos($criteria1, $criteria2)!==false || stripos($criteria2, $criteria1)!==false){
            $bl_criteria = true;
            $matching_criteria = 'Whole word match.';
            goto Label1;
        }
        if(is_numeric($criteria1)==false && is_numeric($criteria2)==false){
            if(metaphone($criteria1)==metaphone($criteria2) || soundex($criteria1)==soundex($criteria2)){
                $bl_criteria = true;
                $matching_criteria = 'Whole word sounds like match.';
                goto Label1;
            }
        }

        $criteria1 = preg_replace('/[^A-Za-z0-9]/', '', $criteria1);
        $criteria2 = preg_replace('/[^A-Za-z0-9]/', '', $criteria2);

        $i = 0;
        $substr = substr($criteria1, $i, 7);
        while (strlen($substr)>=7) {
            if(stripos($criteria2, $substr)!==false){
                $bl_criteria = true;
                $matching_criteria = 'Seven characters match.';
                goto Label1;
            }
            $i = $i + 1;
            $substr = substr($criteria1, $i, 7);
        }

        $i = 0;
        $substr = substr($criteria2, $i, 7);
        while (strlen($substr)>=7) {
            if(stripos($criteria1, $substr)!==false){
                $bl_criteria = true;
                $matching_criteria = 'Seven characters match.';
                goto Label1;
            }
            $i = $i + 1;
            $substr = substr($criteria2, $i, 7);
        }

        // $i = 0;
        // $substr1 = substr($criteria1, $i, 5);
        // $substr2 = substr($criteria2, $i, 5);
        // while (strlen($substr1)>=5 && strlen($substr2)>=5) {
        //     if(is_numeric($substr1)==false && is_numeric($substr2)==false){
        //         // if(metaphone($substr1)==metaphone($substr2) || soundex($substr1)==soundex($substr2)){
        //         if(soundex($substr1)==soundex($substr2)){
        //             $bl_criteria = true;
        //             goto Label1;
        //         }
        //     }

        //     $i = $i + 1;
        //     $substr1 = substr($criteria1, $i, 5);
        //     $substr2 = substr($criteria2, $i, 5);
        // }

        Label1:

        return $matching_criteria;
    }

    public function match_no_old($criteria1, $criteria2){
        $bl_criteria = false;

        // $check_arr1 = preg_replace('/[^A-Za-z0-9]/', '', $criteria1);
        // $check_arr2 = preg_replace('/[^A-Za-z0-9]/', '', $criteria2);

        $check_arr1 = preg_replace('/[^0-9]/', '', $criteria1);
        $check_arr2 = preg_replace('/[^0-9]/', '', $criteria2);

        if(stripos($check_arr1, $check_arr2)!==false || stripos($check_arr2, $check_arr1)!==false){
            $bl_criteria = true;
            goto Label1;
        }

        // $check_arr1 = preg_replace('/[^A-Za-z0-9\,]/', '', $criteria1);
        // $check_arr2 = preg_replace('/[^A-Za-z0-9\,]/', '', $criteria2);

        $check_arr1 = preg_replace('/[^0-9\,]/', '', $criteria1);
        $check_arr2 = preg_replace('/[^0-9\,]/', '', $criteria2);

        $check_arr = explode(',', $check_arr1);
        foreach ($check_arr as $check_val) {
            if(isset($check_val) && $check_val!=''){
                if(stripos($check_arr2, $check_val)!==false){
                    $bl_criteria = true;
                    goto Label1;
                }
            }
        }

        $check_arr = explode(',', $check_arr2);
        foreach ($check_arr as $check_val) {
            if(isset($check_val) && $check_val!=''){
                if(stripos($check_arr1, $check_val)!==false){
                    $bl_criteria = true;
                    goto Label1;
                }
            }
        }

        Label1:

        return $bl_criteria;
    }

    public function get_no($criteria){
        $result='';
        preg_match('/\d+/', $criteria, $matches);
        if(count($matches)>0) $result=$matches[0];
        return $result;
    }

    public function match_no($criteria1, $criteria2){
        $bl_criteria = false;
        $check_arr1 = array();
        $check_arr2 = array();
        $matching_criteria = '';

        $j=0;
        $check_arr = explode(',', $criteria1);
        for($i=0; $i<count($check_arr); $i++){
            $result=$this->get_no($check_arr[$i]);
            if($result!=''){
                $check_arr1[$j]=$result;
                $j++;
            }
        }

        $j=0;
        $check_arr = explode(',', $criteria2);
        for($i=0; $i<count($check_arr); $i++){
            $result=$this->get_no($check_arr[$i]);
            if($result!=''){
                $check_arr2[$j]=$result;
                $j++;
            }
        }

        for($i=0; $i<count($check_arr1); $i++){
            for($j=0; $j<count($check_arr2); $j++){
                if($check_arr1[$i]==$check_arr2[$j]){
                    $bl_criteria = true;
                    $matching_criteria = 'No - '.$check_arr1[$i].' match.';
                    goto Label1;
                }
            }
        }

        Label1:

        return $bl_criteria;
    }

    public function match_property_notice($notice_id){
        // $notice_id = '1';
        $notice = Pn_notice::where('id',$notice_id)->orderBy('updated_at','desc')->get();
        // $property = Pn_property::orderBy('updated_at','desc')->get();
        
        // echo count($notice);
        // echo '<br/>';
        
        foreach($notice as $data){
            $cond = "";

            $sql = "select fk_location_type_id, location from pn_notice_location_details where fk_notice_id = '".$data->id."'";
            $location = DB::select($sql);

            $sql = "select fk_property_no_type_id, property_no from pn_notice_property_no_details where fk_notice_id = '".$data->id."'";
            $property_no = DB::select($sql);

            $sql = "select legal_owner_name from pn_notice_legal_owner_names where fk_notice_id = '".$data->id."'";
            $legal_owner_name = DB::select($sql);

            $sql = "select company_name from pn_notice_company_names where fk_notice_id = '".$data->id."'";
            $company_name = DB::select($sql);

            $sql = "select purchased_from from pn_notice_purchased_froms where fk_notice_id = '".$data->id."'";
            $purchased_from = DB::select($sql);

            $sql = "select A.* from pn_properties A where A.status = 'approved' and 
                    A.id not in (select distinct fk_property_id from pn_property_notices where fk_notice_id='".$data->id."')";
            $property = DB::select($sql);
            foreach($property as $data1){

                // echo 'Notice Id - ' . $data->id;
                // echo '<br/>';

                // echo 'Property Id - ' . $data1->id;
                // echo '<br/>';
                $matching_criteria_array = [];

                $sql = "select fk_location_type_id, location from pn_property_location_details where fk_property_id = '".$data1->id."'";
                $location1 = DB::select($sql);

                $sql = "select fk_property_no_type_id, property_no from pn_property_prop_no_details where fk_property_id = '".$data1->id."'";
                $property_no1 = DB::select($sql);

                $sql = "select legal_owner_name from pn_property_legal_owner_names where fk_property_id = '".$data1->id."'";
                $legal_owner_name1 = DB::select($sql);

                $sql = "select company_name from pn_property_company_names where fk_property_id = '".$data1->id."'";
                $company_name1 = DB::select($sql);
                
                $sql = "select purchased_from from pn_property_purchased_froms where fk_property_id = '".$data1->id."'";
                $purchased_from1 = DB::select($sql);

                $bl_city = false;
                $city_exist = false;
                
                $bl_location = false;
                $pincode_exist = false;
                $location_exist = false;
                // $district_exist = false;
                // $village_exist = false;
                // $taluka_exist = false;
                // $post_exist = false;
                // $division_exist = false;

                // $bl_property_type = false;
                // $property_type_exist = false;

                $bl_property_nos = false;
                $property_no_exist = false;
                // $sheet_no_exist = false;
                // $room_no_exist = false;
                // $block_no_exist = false;
                // $ward_no_exist = false;
                // $khata_no_exist = false;
                // $sr_no_exist = false;
                // $plot_no_exist = false;
                // $scheme_no_exist = false;
                // $cts_no_exist = false;
                // $survey_no_exist = false;
                // $gut_no_exist = false;
                // $hissa_no_exist = false;
                // $cs_no_exist = false;

                $bl_property_names = false;
                $building_name_exist = false;
                $society_name_exist = false;

                $bl_owner_names = false;
                $legal_owner_name_exist = false;
                $company_name_exist = false;
                $purchased_from_exist = false;

                foreach($legal_owner_name as $data2){
                    $notice_legal_owner_name = preg_replace('/[^A-Za-z0-9 ]/', '', $data2->legal_owner_name);

                    if(isset($notice_legal_owner_name) && $notice_legal_owner_name!=''){
                        foreach($legal_owner_name1 as $data3){
                            $property_legal_owner_name = preg_replace('/[^A-Za-z0-9 ]/', '', $data3->legal_owner_name);
                            if(isset($property_legal_owner_name) && $property_legal_owner_name!=''){
                                // echo 'legal_owner_name_exist';
                                // echo '<br/>';
                                
                                $legal_owner_name_exist = true;
                                $matching_criteria = $this->match_criteria($notice_legal_owner_name, $property_legal_owner_name);
                                if($matching_criteria!=''){
                                    $bl_owner_names = true;

                                    /* $match_criteria_val .= 'Notice Legal Owner Name = '.$notice_legal_owner_name.' ,  <br>';
                                    $match_criteria_val .= 'Property Legal Owner Name = '.$property_legal_owner_name.' ,  <br>';*/
                                    $matching_criteria_array[] = array("parameter"=>'Owner Name',"notice"=>$notice_legal_owner_name,"property"=>$property_legal_owner_name,"matching_criteria"=>$matching_criteria);
                                    // echo 'Legal Owner Name Matched';
                                    // echo '<br/>';

                                    // $row = $row . '<td>'.$notice_legal_owner_name.'</td>';
                                    // $row = $row . '<td>'.$property_legal_owner_name.'</td>';
                                    // $row = $row . '<td>Legal Owner Name Matched</td>';

                                    goto Insert_Record;
                                }
                            }
                        }
                    }
                }

                foreach($company_name as $data2){
                    $notice_company_name = preg_replace('/[^A-Za-z0-9 ]/', '', $data2->company_name);

                    if(isset($notice_company_name) && $notice_company_name!=''){
                        foreach($company_name1 as $data3){
                            $property_company_name = preg_replace('/[^A-Za-z0-9 ]/', '', $data3->company_name);
                            if(isset($property_company_name) && $property_company_name!=''){
                                // echo 'company_name_exist';
                                // echo '<br/>';
                                
                                $company_name_exist = true;
                                $matching_criteria = $this->match_criteria($notice_company_name, $property_company_name);
                                if($matching_criteria!=''){
                                    $bl_owner_names = true;

                                    /*$match_criteria_val .= 'Notice Company Name  = '.$notice_company_name.' , <br>';
                                    $match_criteria_val .= 'Property Company Name  = '.$property_company_name.' , <br>';*/

                                    $matching_criteria_array[] = array("parameter"=>'Company Name',"notice"=>$notice_company_name,"property"=>$property_company_name,"matching_criteria"=>$matching_criteria);
                                    // echo 'Company Name Matched';
                                    // echo '<br/>';

                                    // $row = $row . '<td>'.$notice_company_name.'</td>';
                                    // $row = $row . '<td>'.$property_company_name.'</td>';
                                    // $row = $row . '<td>Company Name Matched</td>';

                                    goto Insert_Record;
                                }
                            }
                        }
                    }
                }

                foreach($purchased_from as $data2){
                    $notice_purchased_from = preg_replace('/[^A-Za-z0-9 ]/', '', $data2->purchased_from);

                    if(isset($notice_purchased_from) && $notice_purchased_from!=''){
                        foreach($purchased_from1 as $data3){
                            $property_purchased_from = preg_replace('/[^A-Za-z0-9 ]/', '', $data3->purchased_from);
                            if(isset($property_purchased_from) && $property_purchased_from!=''){
                                // echo 'purchased_from_exist';
                                // echo '<br/>';
                                
                                $purchased_from_exist = true;
                                $matching_criteria = $this->match_criteria($notice_purchased_from, $property_purchased_from);
                                if($matching_criteria!=''){
                                    $bl_owner_names = true;

                                    /*$match_criteria_val .= 'Notice Purchase From = '.$notice_purchased_from.' , <br>';
                                    $match_criteria_val .= 'Property Purchase From = '.$property_purchased_from.' , <br>';*/

                                    $matching_criteria_array[] = array("parameter"=>'Purchase From',"notice"=>$notice_purchased_from,"property"=>$property_purchased_from,"matching_criteria"=>$matching_criteria);
                                    // echo 'Company Name Matched';
                                    // echo '<br/>';

                                    // $row = $row . '<td>'.$notice_purchased_from.'</td>';
                                    // $row = $row . '<td>'.$property_purchased_from.'</td>';
                                    // $row = $row . '<td>Purchased From Matched</td>';

                                    goto Insert_Record;
                                }
                            }
                        }
                    }
                }



                $notice_city = preg_replace('/[^A-Za-z0-9 ]/', '', $data->city);
                $property_city = preg_replace('/[^A-Za-z0-9 ]/', '', $data1->city);
                if(isset($notice_city) && $notice_city!=''){
                    if(isset($property_city) && $property_city!=''){
                        // echo 'city_exist';
                        // echo '<br/>';

                        $city_exist = true;
                        $matching_criteria = $this->match_criteria($notice_city, $property_city);
                        if($matching_criteria!=''){
                            $bl_city = true;

                            /*$match_criteria_val .= 'Notice City = '.$notice_city.' , <br>';
                            $match_criteria_val .= 'Property City = '.$property_city.' , <br>';*/

                            $matching_criteria_array[] = array("parameter"=>'City',"notice"=>$notice_city,"property"=>$property_city,"matching_criteria"=>$matching_criteria);


                            // echo $notice_city;
                            // echo '<br/>';
                            // echo $property_city;
                            // echo '<br/>';
                            // echo 'City Matched 1';
                            // echo '<br/>';

                            // $row = $row . '<td>'.$notice_city.'</td>';
                            // $row = $row . '<td>'.$property_city.'</td>';
                            // $row = $row . '<td>City Matched 1</td>';

                            goto Check_Property_Location;
                        }
                    }

                    foreach($location1 as $data3){
                        if($data3->fk_location_type_id=='4'){
                            $property_location = preg_replace('/[^A-Za-z0-9 ]/', '', $data3->location);
                            if(isset($property_location) && $property_location!=''){
                                // echo 'city_exist';
                                // echo '<br/>';

                                $city_exist = true;
                                $matching_criteria = $this->match_criteria($notice_city, $property_location);
                                if($matching_criteria!=''){
                                    $bl_city = true;

                                    /*$match_criteria_val .= 'Notice City = '.$notice_city.' , <br>';
                                    $match_criteria_val .= 'Property City = '.$property_location.' , <br>';*/

                                    $matching_criteria_array[] = array("parameter"=>'City',"notice"=>$notice_city,"property"=>$property_location,"matching_criteria"=>$matching_criteria);
                                    // echo 'City Matched 2';
                                    // echo '<br/>';

                                    // $row = $row . '<td>'.$notice_city.'</td>';
                                    // $row = $row . '<td>'.$property_location.'</td>';
                                    // $row = $row . '<td>City Matched 2</td>';

                                    goto Check_Property_Location;
                                }
                            }
                        }
                    }
                }

                if(isset($property_city) && $property_city!=''){
                    if(isset($notice_city) && $notice_city!=''){
                        // echo 'city_exist';
                        // echo '<br/>';

                        $city_exist = true;
                        $matching_criteria = $this->match_criteria($property_city, $notice_city);
                        if($matching_criteria!=''){
                            $bl_city = true;

                            /* $match_criteria_val .= 'Notice City = '.$notice_city.' , <br>';
                              $match_criteria_val .= 'Property City = '.$property_city.' , <br>';
                            */
                              $matching_criteria_array[] = array("parameter"=>'City',"notice"=>$notice_city,"property"=>$property_city,"matching_criteria"=>$matching_criteria);
                            // echo 'City Matched 3';
                            // echo '<br/>';

                            // $row = $row . '<td>'.$property_city.'</td>';
                            // $row = $row . '<td>'.$notice_city.'</td>';
                            // $row = $row . '<td>City Matched 3</td>';

                            goto Check_Property_Location;
                        }
                    }

                    foreach($location as $data2){
                        if($data2->fk_location_type_id=='4'){
                            $property_location = preg_replace('/[^A-Za-z0-9 ]/', '', $data2->location);
                            if(isset($property_location) && $property_location!=''){
                                // echo 'city_exist';
                                // echo '<br/>';
                                
                                $city_exist = true;
                                $matching_criteria = $this->match_criteria($property_city, $property_location);
                                if($matching_criteria!=''){
                                    $bl_city = true;
                                    
                                    /*$match_criteria_val .= 'Property City = '.$property_city.' , <br>';

                                    $match_criteria_val .= 'Property Location = '.$property_location.' , <br>';*/

                                    $matching_criteria_array[] = array("parameter"=>'City',"notice"=>$property_city,"property"=>$property_location,"matching_criteria"=>$matching_criteria);
                                    // echo 'City Matched 4';
                                    // echo '<br/>';

                                    // $row = $row . '<td>'.$property_city.'</td>';
                                    // $row = $row . '<td>'.$property_location.'</td>';
                                    // $row = $row . '<td>City Matched 4</td>';

                                    goto Check_Property_Location;
                                }
                            }
                        }
                    }
                }

                Check_Property_Location:

                $notice_pincode = preg_replace('/[^A-Za-z0-9]/', '', $data->pincode);
                $property_pincode = preg_replace('/[^A-Za-z0-9]/', '', $data1->pincode);
                if(isset($notice_pincode) && $notice_pincode!='' && isset($property_pincode) && $property_pincode!=''){
                    // echo 'pincode_exist';
                    // echo '<br/>';
                    
                    $pincode_exist = true;
                    $matching_criteria = $this->match_no($notice_pincode, $property_pincode);
                    if($matching_criteria!=''){
                        $bl_location = true;
                       
                        /* $match_criteria_val .= 'Notice Pincode = '.$notice_pincode.' , <br>';

                         $match_criteria_val .= 'Property Pincode = '.$property_pincode.' , <br>';*/
                        $matching_criteria_array[] = array("parameter"=>'Pincode',"notice"=>$notice_pincode,"property"=>$property_pincode,"matching_criteria"=>$matching_criteria);
                        // echo 'Pincode Matched';
                        // echo '<br/>';

                        // $row = $row . '<td>'.$notice_pincode.'</td>';
                        // $row = $row . '<td>'.$property_pincode.'</td>';
                        // $row = $row . '<td>Pincode Matched</td>';

                        goto Check_Property_Nos;
                    }
                }
                
                foreach($location as $data2){
                    $notice_location = preg_replace('/[^A-Za-z0-9 ]/', '', $data2->location);
                    if(isset($notice_location) && $notice_location!=''){
                        foreach($location1 as $data3){
                            $property_location = preg_replace('/[^A-Za-z0-9 ]/', '', $data3->location);
                            if(isset($property_location) && $property_location!=''){
                                // echo 'location_exist';
                                // echo '<br/>';
                                
                                $location_exist = true;
                                $matching_criteria = $this->match_criteria($notice_location, $property_location);
                                if($matching_criteria!=''){
                                    $bl_location = true;

                                    /* $match_criteria_val .= 'Notice Location = '.$notice_location.' , <br>';

                                    $match_criteria_val .= 'Property Location = '.$property_location.' , <br>';*/

                                    $matching_criteria_array[] = array("parameter"=>'Location',"notice"=>$notice_location,"property"=>$property_location,"matching_criteria"=>$matching_criteria);


                                    // echo 'Location Matched';
                                    // echo '<br/>';

                                    // $row = $row . '<td>'.$notice_location.'</td>';
                                    // $row = $row . '<td>'.$property_location.'</td>';
                                    // $row = $row . '<td>Location Matched</td>';

                                    goto Check_Property_Nos;
                                }
                            }
                        }
                    }
                }
                
                Check_Property_Nos:

                foreach($property_no as $data2){
                    $notice_property_no = $data2->property_no;

                    if(isset($notice_property_no) && $notice_property_no!=''){
                        foreach($property_no1 as $data3){
                            $property_property_no = $data3->property_no;
                            if(isset($property_property_no) && $property_property_no!=''){
                                // echo 'property_no_exist';
                                // echo '<br/>';
                                
                                $property_no_exist = true;
                                $matching_criteria = $this->match_no($notice_property_no, $property_property_no);
                                if($matching_criteria!=''){
                                    $bl_property_nos = true;

                                    /*
                                    $match_criteria_val .= 'Notice Property Number = '.$notice_property_no.' , <br>';

                                    $match_criteria_val .= 'Property - Property Number = '.$property_property_no.' , <br>';*/

                                    $matching_criteria_array[] = array("parameter"=>'Property Number',"notice"=>$notice_property_no,"property"=>$property_property_no,"matching_criteria"=>$matching_criteria);
                                    // echo 'Property No Matched';
                                    // echo '<br/>';

                                    // $row = $row . '<td>'.$notice_property_no.'</td>';
                                    // $row = $row . '<td>'.$property_property_no.'</td>';
                                    // $row = $row . '<td>Property No Matched</td>';

                                    goto Check_Property_Names;
                                }
                            }
                        }
                    }
                }

                Check_Property_Names:

                $notice_building_name = preg_replace('/[^A-Za-z0-9 ]/', '', $data->building_name);
                $property_building_name = preg_replace('/[^A-Za-z0-9 ]/', '', $data1->building_name);
                if(isset($notice_building_name) && $notice_building_name!='' && isset($property_building_name) && $property_building_name!=''){
                    // echo 'building_name_exist';
                    // echo '<br/>';
                    
                    $building_name_exist = true;
                    $matching_criteria = $this->match_criteria($notice_building_name, $property_building_name);

                    if($matching_criteria!=''){
                        $bl_property_names = true;

                        /*$match_criteria_val .= 'Notice Building Name = '.$notice_building_name.' , <br>';

                         $match_criteria_val .= 'Property Building Name= '.$property_building_name.' , <br>';*/

                        $matching_criteria_array[] = array("parameter"=>'Building Name',"notice"=>$notice_building_name,"property"=>$property_building_name,"matching_criteria"=>$matching_criteria);
                        // echo 'Building Name Matched 1';
                        // echo '<br/>';

                        // $row = $row . '<td>'.$notice_building_name.'</td>';
                        // $row = $row . '<td>'.$property_building_name.'</td>';
                        // $row = $row . '<td>Building Name Matched 1</td>';

                        goto Check_Owner_Names;
                    }
                }
                
                $notice_building_name = preg_replace('/[^A-Za-z0-9 ]/', '', $data->building_name);
                $property_society_name = preg_replace('/[^A-Za-z0-9 ]/', '', $data1->society_name);
                if(isset($notice_building_name) && $notice_building_name!='' && isset($property_society_name) && $property_society_name!=''){
                    // echo 'building_name_exist';
                    // echo '<br/>';
                    
                    $building_name_exist = true;
                    $matching_criteria = $this->match_criteria($notice_building_name, $property_society_name);
                    if($matching_criteria!=''){
                        $bl_property_names = true;

                        /*$match_criteria_val .= 'Notice Society Name = '.$notice_building_name.' , <br>';

                        $match_criteria_val .= 'Property Society Name = '.$property_society_name.' , <br>';*/

                        $matching_criteria_array[] = array("parameter"=>'Society Name',"notice"=>$notice_building_name,"property"=>$property_society_name,"matching_criteria"=>$matching_criteria);
                        // echo 'Building Name Matched 2';
                        // echo '<br/>';

                        // $row = $row . '<td>'.$notice_building_name.'</td>';
                        // $row = $row . '<td>'.$property_society_name.'</td>';
                        // $row = $row . '<td>Building Name Matched 2</td>';

                        goto Check_Owner_Names;
                    }
                }
                
                $notice_society_name = preg_replace('/[^A-Za-z0-9 ]/', '', $data->society_name);
                $property_society_name = preg_replace('/[^A-Za-z0-9 ]/', '', $data1->society_name);
                if(isset($notice_society_name) && $notice_society_name!='' && isset($property_society_name) && $property_society_name!=''){
                    // echo 'society_name_exist';
                    // echo '<br/>';
                    
                    $society_name_exist = true;
                    $matching_criteria = $this->match_criteria($notice_society_name, $property_society_name);
                    if($matching_criteria!=''){
                        $bl_property_names = true;

                        /*$match_criteria_val .= 'Notice Society Name  = '.$notice_society_name.' , <br>';

                        $match_criteria_val .= 'Property Society Name = '.$property_society_name.' , <br>';*/

                        $matching_criteria_array[] = array("parameter"=>'Society Name',"notice"=>$notice_society_name,"property"=>$property_society_name,"matching_criteria"=>$matching_criteria);
                        // echo 'Society Name Matched 1';
                        // echo '<br/>';

                        // $row = $row . '<td>'.$notice_society_name.'</td>';
                        // $row = $row . '<td>'.$property_society_name.'</td>';
                        // $row = $row . '<td>Society Name Matched 1</td>';

                        goto Check_Owner_Names;
                    }
                }
                
                $notice_society_name = preg_replace('/[^A-Za-z0-9 ]/', '', $data->society_name);
                $property_building_name = preg_replace('/[^A-Za-z0-9 ]/', '', $data1->building_name);
                if(isset($notice_society_name) && $notice_society_name!='' && isset($property_building_name) && $property_building_name!=''){
                    // echo 'society_name_exist';
                    // echo '<br/>';
                    
                    $society_name_exist = true;
                    $matching_criteria = $this->match_criteria($notice_society_name, $property_building_name);
                    if($matching_criteria!=''){
                        $bl_property_names = true;
                        
                        /*$match_criteria_val .= 'Notice Society Name  = '.$notice_building_name.' , <br>';

                        $match_criteria_val .= 'Property Building  Name = '.$property_building_name.' , <br>';*/

                        $matching_criteria_array[] = array("parameter"=>'Society Name',"notice"=>$notice_society_name,"property"=>$property_building_name,"matching_criteria"=>$matching_criteria);
                        // echo 'Society Name Matched 2';
                        // echo '<br/>';

                        // $row = $row . '<td>'.$notice_society_name.'</td>';
                        // $row = $row . '<td>'.$property_building_name.'</td>';
                        // $row = $row . '<td>Society Name Matched 2</td>';

                        goto Check_Owner_Names;
                    }
                }
                
                Check_Owner_Names:

                

                // echo ($bl_location==true)?'Location - True':'Location - False';
                // echo '<br/>';
                // echo ($bl_property_nos==true)?'Property No - True':'Property No - False';
                // echo '<br/>';
                // echo ($bl_property_names==true)?'Property Name - True':'Property Name - False';
                // echo '<br/>';

                // $row = $row . '<td>'.(($bl_city==true)?'City - True':'City - False').'</td>';
                // $row = $row . '<td>'.(($bl_location==true)?'Location - True':'Location - False').'</td>';
                // $row = $row . '<td>'.(($bl_property_nos==true)?'Property No - True':'Property No - False').'</td>';
                // $row = $row . '<td>'.(($bl_property_names==true)?'Property Name - True':'Property Name - False').'</td>';

                if($bl_city==true && $bl_location==true && ($bl_property_nos==true || $bl_property_names==true)){
                    goto Insert_Record;
                }

                if($bl_property_nos==true && $bl_property_names==true){
                    goto Insert_Record;
                }

                if($bl_owner_names==false && $city_exist == false && $location_exist == false & $pincode_exist == false && $property_no_exist == false && $building_name_exist == false && $society_name_exist == false){

                    goto Next_Record;
                }

                if($city_exist == false){
                    $bl_city = true;
                }
                if($location_exist == false && $pincode_exist == false){
                    $bl_location = true;
                }
                if($property_no_exist == false && $building_name_exist == false && $society_name_exist == false){
                    $bl_property_nos = true;
                }
                if($property_no_exist == false && $building_name_exist == false && $society_name_exist == false){
                    $bl_property_names = true;
                }

                // echo ($bl_location==true)?'Location - True':'Location - False';
                // echo '<br/>';
                // echo ($bl_property_nos==true)?'Property No - True':'Property No - False';
                // echo '<br/>';
                // echo ($bl_property_names==true)?'Property Name - True':'Property Name - False';
                // echo '<br/>';

                // $row = $row . '<td>'.(($bl_city==true)?'City - True':'City - False').'</td>';
                // $row = $row . '<td>'.(($bl_location==true)?'Location - True':'Location - False').'</td>';
                // $row = $row . '<td>'.(($bl_property_nos==true)?'Property No - True':'Property No - False').'</td>';
                // $row = $row . '<td>'.(($bl_property_names==true)?'Property Name - True':'Property Name - False').'</td>';

                if($bl_city==false || $bl_location==false || ($bl_property_nos==false && $bl_property_names==false)){
                    goto Next_Record;
                }

                Insert_Record:

                // echo 'Insert_Record';
                // echo '<br/>';

                $data3 = array();
                $data3['fk_notice_id'] = $data->id;
                $data3['fk_property_id'] = $data1->id;
                $user_id = '1';
                $data3['updated_by'] = $user_id;
                $data3['status'] = 'pending';
                $data3['created_by'] = $user_id;
                $insertid = Pn_property_notice::create($data3)->id;
                for($i=0;$i<count($matching_criteria_array);$i++)
                {
                    $matching_criteria_array[$i]['pn_property_notice_id'] = $insertid;
                }
                Pn_notice_criteria::insert($matching_criteria_array);
                Next_Record:
            }
        }
    }

    public function save(Request $request){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_insert']=='1' || $access['Properties']['r_edit']=='1' || $access['Properties']['r_delete']=='1' || $access['Properties']['r_approvals']=='1') {
                $date_of_notice = $this->FormatDate($request->get('date_of_notice'));

                $temp_notice_file = $request->get('temp_notice_file');
                $notice_file = $request->get('notice_file');
                if($temp_notice_file!=''){
                    $data['notice_file'] = $temp_notice_file;
                } else {
                    $data['notice_file'] = $notice_file;
                }
                
                $data['id'] = $request->get('id');
                $data['fk_notice_type_id'] = $request->get('fk_notice_type_id');
                $data['details'] = $request->get('details');
                $data['notice_title'] = $request->get('notice_title');
                // $data['date_of_notice'] = $request->get('date_of_notice');
                $data['date_of_notice'] = $date_of_notice;
                $data['fk_newspaper_id'] = $request->get('fk_newspaper_id');
                // $data['name_of_property'] = $request->get('name_of_property');
                $data['property_type'] = $request->get('property_type');
                $data['building_name'] = $request->get('building_name');
                $data['society_name'] = $request->get('society_name');
                $data['floor'] = $request->get('floor');
                $data['wing'] = $request->get('wing');
                $data['address'] = $request->get('address');
                $data['city'] = $request->get('city');
                $data['pincode'] = $request->get('pincode');
                $data['state'] = $request->get('state');
                $data['country'] = $request->get('country');
                $data['parking'] = $request->get('parking');
                $data['property_description'] = $request->get('property_description');
                $data['issued_by'] = $request->get('issued_by');
                $data['page_number'] = $request->get('page_number');

                $user_id = auth()->user()->gu_id;
                $data['updated_by'] = $user_id;
                $data['status'] = 'approved';
                if(isset($data['id'])){
                    $id = $data['id'];
                    Pn_notice::find($id)->update($data);
                    Session::flash('success_msg', 'Notice updated successfully!');
                } else {
                    $data['created_by'] = $user_id;
                    $id = Pn_notice::create($data)->id;
                    Session::flash('success_msg', 'Notice added successfully!');
                }

                if($temp_notice_file!=''){
                    $imageName = 'Notice_' . $id . '.png';
                    $imagePath = base_path() . '/public/uploads/notices/';
                    rename(base_path().'/public/uploads/scans/temp/'.$temp_notice_file, $imagePath.$imageName);
                    $data['notice_file'] = $imageName;
                    Pn_notice::find($id)->update($data);
                }
                
                $notice_file = $request->file('notice_file_file');
                if(isset($notice_file)){
                    $imageName = 'Notice_' . $id . '.' . $notice_file->getClientOriginalExtension();
                    $imagePath = base_path() . '/public/uploads/notices/';
                    $notice_file->move($imagePath, $imageName);
                    $data['notice_file'] = $imageName;
                    Pn_notice::find($id)->update($data);
                }

                $fk_property_no_type_id = $request->get('fk_property_no_type_id');
                $property_no = $request->get('property_no');
                Pn_notice_property_no_detail::where('fk_notice_id', $id)->delete();
                $property_no_data = array();
                for($i=0; $i<count($fk_property_no_type_id); $i++){
                    $property_no_data[] = array('fk_notice_id'=>$id, 'fk_property_no_type_id'=>$fk_property_no_type_id[$i], 'property_no'=>$property_no[$i]);
                }
                if(count($property_no_data)>0){
                    Pn_notice_property_no_detail::insert($property_no_data);
                }

                $fk_location_type_id = $request->get('fk_location_type_id');
                $location = $request->get('location');
                Pn_notice_location_detail::where('fk_notice_id', $id)->delete();
                $location_data = array();
                for($i=0; $i<count($fk_location_type_id); $i++){
                    $location_data[] = array('fk_notice_id'=>$id, 'fk_location_type_id'=>$fk_location_type_id[$i], 'location'=>$location[$i]);
                }
                if(count($location_data)>0){
                    Pn_notice_location_detail::insert($location_data);
                }

                $fk_certificate_no_type_id = $request->get('fk_certificate_no_type_id');
                $certificate_no = $request->get('certificate_no');
                Pn_notice_certificate_no_detail::where('fk_notice_id', $id)->delete();
                $certificate_no_data = array();
                for($i=0; $i<count($fk_certificate_no_type_id); $i++){
                    $certificate_no_data[] = array('fk_notice_id'=>$id, 'fk_certificate_no_type_id'=>$fk_certificate_no_type_id[$i], 'certificate_no'=>$certificate_no[$i]);
                }
                if(count($certificate_no_data)>0){
                    Pn_notice_certificate_no_detail::insert($certificate_no_data);
                }

                $legal_owner_name = $request->get('legal_owner_name');
                Pn_notice_legal_owner_name::where('fk_notice_id', $id)->delete();
                $legal_owner_name_data = array();
                for($i=0; $i<count($legal_owner_name); $i++){
                    $legal_owner_name_data[] = array('fk_notice_id'=>$id, 'legal_owner_name'=>$legal_owner_name[$i]);
                }
                if(count($legal_owner_name_data)>0){
                    Pn_notice_legal_owner_name::insert($legal_owner_name_data);
                }

                $purchased_from = $request->get('purchased_from');
                Pn_notice_purchased_from::where('fk_notice_id', $id)->delete();
                $purchased_from_data = array();
                for($i=0; $i<count($purchased_from); $i++){
                    $purchased_from_data[] = array('fk_notice_id'=>$id, 'purchased_from'=>$purchased_from[$i]);
                }
                if(count($purchased_from_data)>0){
                    Pn_notice_purchased_from::insert($purchased_from_data);
                }

                $company_name = $request->get('company_name');
                Pn_notice_company_name::where('fk_notice_id', $id)->delete();
                $company_name_data = array();
                for($i=0; $i<count($company_name); $i++){
                    $company_name_data[] = array('fk_notice_id'=>$id, 'company_name'=>$company_name[$i]);
                }
                if(count($company_name_data)>0){
                    Pn_notice_company_name::insert($company_name_data);
                }

                $guarantor = $request->get('guarantor');
                Pn_notice_guarantor::where('fk_notice_id', $id)->delete();
                $guarantor_data = array();
                for($i=0; $i<count($guarantor); $i++){
                    $guarantor_data[] = array('fk_notice_id'=>$id, 'guarantor'=>$guarantor[$i]);
                }
                if(count($guarantor_data)>0){
                    Pn_notice_guarantor::insert($guarantor_data);
                }

                $othername = $request->get('othername');
                Pn_notice_othername::where('fk_notice_id', $id)->delete();
                $othername_data = array();
                for($i=0; $i<count($othername); $i++){
                    $othername_data[] = array('fk_notice_id'=>$id, 'othername'=>$othername[$i]);
                }
                if(count($othername_data)>0){
                    Pn_notice_othername::insert($othername_data);
                }

                // $this->match_property($id);
                // $this->match_notice($id);

                $this->match_property_notice($id);
                
                return redirect('index.php/notice');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function map_notice(Request $request){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_insert']=='1') {
                $notice_id = $request->get('notice_id');
                $notice_newspaper_id = $request->get('notice_newspaper_id');

                if($notice_id!='' && $notice_newspaper_id!=''){
                    $notice_data = Pn_notice::find($notice_id);

                    $data['notice_title'] = $notice_data->notice_title;
                    $data['date_of_notice'] = $notice_data->date_of_notice;
                    $data['notice_file'] = $notice_data->notice_file;
                    $data['details'] = $notice_data->details;
                    $data['fk_newspaper_id'] = $notice_newspaper_id;
                    $data['days_for_respond'] = $notice_data->days_for_respond;
                    $data['issued_by'] = $notice_data->issued_by;
                    $data['reason_for_notice'] = $notice_data->reason_for_notice;
                    $data['issued_for'] = $notice_data->issued_for;
                    $data['subject_matter'] = $notice_data->subject_matter;
                    // $data['name_of_property'] = $notice_data->name_of_property;
                    $data['date_of_purchase'] = $notice_data->date_of_purchase;
                    $data['property_status'] = $notice_data->property_status;
                    $data['property_type'] = $notice_data->property_type;
                    $data['property_description'] = $notice_data->property_description;
                    $data['building_name'] = $notice_data->building_name;
                    $data['unit_no'] = $notice_data->unit_no;
                    $data['floor'] = $notice_data->floor;
                    $data['wing'] = $notice_data->wing;
                    $data['address'] = $notice_data->address;
                    $data['landmark'] = $notice_data->landmark;
                    $data['village'] = $notice_data->village;
                    $data['city'] = $notice_data->city;
                    $data['pincode'] = $notice_data->pincode;
                    $data['state'] = $notice_data->state;
                    $data['country'] = $notice_data->country;
                    $data['google_map_address'] = $notice_data->google_map_address;
                    $data['cts_no'] = $notice_data->cts_no;
                    $data['area'] = $notice_data->area;
                    $data['parking'] = $notice_data->parking;
                    $data['legal_owner_name'] = $notice_data->legal_owner_name;
                    $data['legal_owner_pan'] = $notice_data->legal_owner_pan;
                    $data['legal_owner_address'] = $notice_data->legal_owner_address;
                    $data['company_name'] = $notice_data->company_name;
                    $data['company_registration_no'] = $notice_data->company_registration_no;
                    $data['fk_notice_type_id'] = $notice_data->fk_notice_type_id;
                    $data['society_name'] = $notice_data->society_name;
                    $data['page_number'] = $notice_data->page_number;

                    $user_id = auth()->user()->gu_id;
                    $data['updated_by'] = $user_id;
                    $data['status'] = 'approved';
                    $data['created_by'] = $user_id;
                    $id = Pn_notice::create($data)->id;
                    Session::flash('success_msg', 'Notice mapped successfully!');

                    DB::insert("insert into pn_notice_property_no_details (fk_notice_id, fk_property_no_type_id, property_no) 
                                select " . $id . ", fk_property_no_type_id, property_no from pn_notice_property_no_details where fk_notice_id = " . $notice_id);

                    DB::insert("insert into pn_notice_location_details (fk_notice_id, fk_location_type_id, location) 
                                select " . $id . ", fk_location_type_id, location from pn_notice_location_details where fk_notice_id = " . $notice_id);

                    DB::insert("insert into pn_notice_certificate_no_details (fk_notice_id, fk_certificate_no_type_id, certificate_no) 
                                select " . $id . ", fk_certificate_no_type_id, certificate_no from pn_notice_certificate_no_details where fk_notice_id = " . $notice_id);

                    DB::insert("insert into pn_notice_legal_owner_names (fk_notice_id, legal_owner_name) 
                                select " . $id . ", legal_owner_name from pn_notice_legal_owner_names where fk_notice_id = " . $notice_id);

                    DB::insert("insert into pn_notice_purchased_froms (fk_notice_id, purchased_from) 
                                select " . $id . ", purchased_from from pn_notice_purchased_froms where fk_notice_id = " . $notice_id);

                    DB::insert("insert into pn_notice_company_names (fk_notice_id, company_name) 
                                select " . $id . ", company_name from pn_notice_company_names where fk_notice_id = " . $notice_id);

                    DB::insert("insert into pn_notice_guarantors (fk_notice_id, guarantor) 
                                select " . $id . ", guarantor from pn_notice_guarantors where fk_notice_id = " . $notice_id);
                }
                
                return redirect('index.php/notice');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function delete(Request $request){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_delete']=='1') {
                $data['id'] = $request->get('notice_id');
                $user_id = auth()->user()->gu_id;
                $data['updated_by'] = $user_id;
                $data['status'] = 'inactive';
                if(isset($data['id'])){
                    Pn_notice::find($data['id'])->update($data);
                    Session::flash('success_msg', 'Notice deleted successfully!');
                }

                return redirect('index.php/notice');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function scan(){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_view']=='1' || $access['Properties']['r_insert']=='1' || $access['Properties']['r_edit']=='1' || $access['Properties']['r_delete']=='1' || $access['Properties']['r_approvals']=='1' || $access['Properties']['r_export']=='1') {
                $newspaper_list = Pn_newspaper::orderBy('paper_name','asc')->get();
                return view('notice.scan', ['access' => $access, 'newspaper_list' => $newspaper_list]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function save_scan(Request $request){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_insert']=='1' || $access['Properties']['r_edit']=='1' || $access['Properties']['r_delete']=='1' || $access['Properties']['r_approvals']=='1') {
                $date_of_notice = $this->FormatDate($request->get('date_of_notice'));
                $fk_newspaper_id = $request->get('fk_newspaper_id');
                $page_number = $request->get('page_number');
                $section = $request->get('section');

                $data['id'] = $request->get('id');
                $data['date_of_notice'] = $date_of_notice;
                $data['notice_file'] = $request->get('notice_file');
                $data['fk_newspaper_id'] = $fk_newspaper_id;
                $data['page_number'] = $page_number;
                $data['section'] = $section;

                $user_id = auth()->user()->gu_id;
                $data['updated_by'] = $user_id;
                $data['status'] = 'approved';
                
                $sql = "select * from pn_notice_scans where date_of_notice = '".$date_of_notice."' and 
                        fk_newspaper_id = '".$fk_newspaper_id."' and page_number = '".$page_number."'";
                $result = DB::select($sql);
                if(count($result)){
                    $data['id'] = $result[0]->id;
                }

                if(isset($data['id'])){
                    $id = $data['id'];
                    Pn_notice_scan::find($id)->update($data);
                    Session::flash('success_msg', 'Notice updated successfully!');
                } else {
                    $data['created_by'] = $user_id;
                    $id = Pn_notice_scan::create($data)->id;
                    Session::flash('success_msg', 'Notice added successfully!');
                }

                $notice_file = $request->file('notice_file_file');
                if(isset($notice_file)){
                    $imageName = 'Notice_' . $id . '.' . $notice_file->getClientOriginalExtension();
                    $imagePath = base_path() . '/public/uploads/scans/';
                    $notice_file->move($imagePath, $imageName);
                    $data['notice_file'] = $imageName;
                    Pn_notice_scan::find($id)->update($data);
                }

                return redirect('index.php/notice/scan');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function get_notice_count(Request $request){
        $data = $request->all();

        $date_of_notice = $this->FormatDate($data['date_of_notice2']);
        $newspaper_id = $data['newspaper_id2'];
        // $date_of_notice = '2018-08-29';

        $total_notice_count = 0;
        $relevant_notice_count = 0;
        $non_relevant_notice_count = 0;
        $diff_notice_count = 0;
        $notice_count = 0;
        $i=1;

        $sql = "select E.*, (E.relevant_notice_count-E.no_of_notices) as diff_notice_count from 
                (select C.*, (C.notice_count-C.non_relevant_notice_count) as relevant_notice_count, ifnull(D.no_of_notices,0) as no_of_notices from 
                (select A.*, ifnull(B.notice_count,0) as notice_count, ifnull(B.non_relevant_notice_count,0) as non_relevant_notice_count from 
                (select * from pn_newspapers where status = 'approved' and id = '$newspaper_id') A 
                left join 
                (select * from pn_notice_counts where date(date_of_notice) = date('$date_of_notice') and fk_newspaper_id = '$newspaper_id') B 
                on (A.id=B.fk_newspaper_id)) C 
                left join 
                (select fk_newspaper_id, count(id) as no_of_notices from pn_notices where status = 'approved' and 
                    date(date_of_notice) = date('$date_of_notice') and fk_newspaper_id = '$newspaper_id' group by fk_newspaper_id) D 
                on (C.id=D.fk_newspaper_id)) E 
                order by E.paper_name, E.updated_at desc";

        $newspapers = DB::select($sql);
        foreach($newspapers as $data){
            $total_notice_count = $total_notice_count + intval($data->notice_count);
            $relevant_notice_count = $relevant_notice_count + intval($data->relevant_notice_count);
            $non_relevant_notice_count = $non_relevant_notice_count + intval($data->non_relevant_notice_count);
            $diff_notice_count = $diff_notice_count + intval($data->diff_notice_count);
            $notice_count = $notice_count + intval($data->no_of_notices);
        }

        $result['total_notice_count'] = $total_notice_count;
        $result['relevant_notice_count'] = $relevant_notice_count;
        $result['non_relevant_notice_count'] = $non_relevant_notice_count;
        $result['diff_notice_count'] = $diff_notice_count;
        $result['notice_count'] = $notice_count;

        echo json_encode($result);
    }

    public function set_non_relevant_count(Request $request){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_insert']=='1' || $access['Properties']['r_edit']=='1' || $access['Properties']['r_delete']=='1' || $access['Properties']['r_approvals']=='1') {
                $date_of_notice = $this->FormatDate($request->get('date_of_notice2'));
                $newspaper_id = $request->get('newspaper_id2');
                $total_non_relevant = $request->get('total_non_relevant');
                $user_id = auth()->user()->gu_id;

                $affected = DB::update("update pn_notice_counts set non_relevant_notice_count = '".$total_non_relevant."', 
                                    status = 'approved', updated_by = ".$user_id.", updated_at = now() 
                                    where date(date_of_notice) = date('".$date_of_notice."') and 
                                    fk_newspaper_id = '".$newspaper_id."'");
            
                if($affected==0){
                    $data['date_of_notice'] = $date_of_notice;
                    $data['fk_newspaper_id'] = $newspaper_id;
                    $data['non_relevant_notice_count'] = $total_non_relevant;
                    $data['status'] = 'approved';
                    $data['created_by'] = $user_id;
                    $id = Pn_notice_count::create($data)->id;
                }

                Session::flash('success_msg', 'Non Relevant Notice count updated!');
                return redirect('index.php/notice');
            } else {
                return view('message', ['access' => $access, 'title' => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title' => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function get_matching_log(){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_view']=='1' || $access['Properties']['r_insert']=='1' || $access['Properties']['r_edit']=='1' || $access['Properties']['r_delete']=='1' || $access['Properties']['r_approvals']=='1' || $access['Properties']['r_export']=='1') {
                // $notice = Pn_notice::with(array(
                //                     'Pn_newspaper'=>function($query){$query->select('id','paper_name');},
                //                     'Pn_notice_type'=>function($query){$query->select('id','notice_type');}
                //                     ))->orderBy('updated_at','desc')->get();
                return view('notice.matching_log', ['access' => $access]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function get_log(Request $request){
        $data = $request->all();

        $from_date = $this->FormatDate($data['from_date']);
        $to_date = $this->FormatDate($data['to_date']);
        // $from_date = '2018-08-29';

        $sql = "select A.date_of_notice, B.fk_notice_id, C.* 
                from pn_notices A 
                left join pn_property_notices B on (A.id = B.fk_notice_id) 
                left join pn_notice_criterias C on (B.id = C.pn_property_notice_id) 
                where A.date_of_notice>='$from_date' and A.date_of_notice<='$to_date' and C.pn_notice_criteria_id is not null";

        $match_criteria = DB::select($sql);
        $rows = '';
        $i = 1;
        foreach($match_criteria as $data){
            $rows = $rows . '<tr>
                                <td class="table-text">
                                    <div>'.$i++.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.date('d/m/Y',strtotime($data->date_of_notice)).'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->fk_notice_id.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->notice.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->property.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->parameter.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->matching_criteria.'</div>
                                </td>
                            </tr>';
        }

        $result['rows'] = $rows;

        echo json_encode($result);
    }
}
