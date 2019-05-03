<?php

namespace App\Http\Controllers;

use App\User;
use App\Pn_notice;
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
                                    <div><a href="'.url('index.php/upload_property/download_file/'.$data->id).'" target="_new"><i class="fa export fa-download"></i></a></div>
                                </td>
                                <td class="table-text">
                                    <div>'.(($data->status=='approved')?'uploaded':'uploading').'</div>
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
                                    <div><a href="'.url('index.php/upload_property_notice/download_report/'.$data->id).'" target="_blank"><i class="fa export fa-download"></i></a></div>
                                </td>
                                <td class="table-text">
                                    <div><a href="'.url('index.php/upload_property_notice/send_report/'.$data->id).'" class="label label-primary">Send</a></div>
                                </td>
                                <td>
                                    <a href="'.url('index.php/upload_property_notice/index/'.$data->id).'" class="label label-primary">View</a>
                                    <button type="button" id="notice_'.$data->id.'" class="label label-danger" onClick="show_modal(this)">Delete</button>
                                </td>
                            </tr>';
        }

        $result['rows'] = $rows;
        echo json_encode($result);
    }

    public function download_file($file_id=''){
        $property_file = Pn_property_file::where('id',$file_id)->get();

        if(count($property_file)>0){
            $file_path = base_path().'/public/uploads/property_file/'.$property_file[0]->file_name;

            return response()->download($file_path);
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

    public function upload_file(Request $request){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_insert']=='1' || $access['Properties']['r_edit']=='1' || $access['Properties']['r_delete']=='1' || $access['Properties']['r_approvals']=='1') {
                $user_id = auth()->user()->gu_id;
                $from_date = $request->get('from_date');
                $to_date = $request->get('to_date');
                $property_file = $request->file('property_file');

                $from_date = $this->FormatDate($from_date);
                $to_date = $this->FormatDate($to_date);

                if(isset($property_file)){
                    $imageName = $property_file->getClientOriginalName();
                    $filename = pathinfo($imageName, PATHINFO_FILENAME);
                    $extension = pathinfo($imageName, PATHINFO_EXTENSION);
                    $filename = $filename.'_'.date('Ymdhis').'.'.$extension;

                    // $imagePath = base_path() . '\public\uploads\property_file\\';
                    $imagePath = base_path() . '/public/uploads/property_file/';

                    // echo $imageName;
                    // echo '<br/>';
                    // echo $imagePath;
                    // echo '<br/>';
                    // echo $filename;
                    // echo '<br/>';
                    // echo $extension;
                    // echo '<br/>';

                    $property_file->move($imagePath, $filename);

                    $data['from_date'] = $from_date;
                    $data['to_date'] = $to_date;
                    $data['file_name'] = $filename;
                    $data['file_path'] = $imagePath;
                    $data['status'] = 'pending';
                    $data['created_by'] = $user_id;
                    $data['updated_by'] = $user_id;
                    $id = Pn_property_file::create($data)->id;
                    
                    if($request->hasFile('property_file')){
                        // $path = $request->file('property_file')->getRealPath();
                        $path = $imagePath.$filename;

                        // echo $path;
                        // echo '<br/>';

                        $data = Excel::load($path, function($reader) {})->get();
                        $data2 = array();

                        if(!empty($data) && $data->count()){
                            foreach ($data->toArray() as $key => $value) {
                                if(!empty($value)){
                                    $insert = ['fk_file_id' => $id,
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

                                    Pn_file_property::create($insert);
                                }
                            }
                        }
                    }
                }

                $this->match_property_notice($id);

                Session::flash('success_msg', 'File uploaded successfully!');
                return redirect('index.php/upload_property');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
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

    public function match_property_notice($file_id=''){
        $property_file = Pn_property_file::where('id',$file_id)->get();
        $from_date = '';
        $to_date = '';
        if(count($property_file)>0){
            $from_date = $property_file[0]->from_date;
            $to_date = $property_file[0]->to_date;
        }
        $property = Pn_file_property::where("fk_file_id",$file_id)->get();

        $sql = "select * from pn_notices where status='approved' and date_of_notice>='$from_date' and 
                date_of_notice<='$to_date' order by updated_at desc";
        $notice = DB::select($sql);
        
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

            // $sql = "select A.* from pn_properties A where A.status = 'approved' and 
            //         A.id not in (select distinct fk_property_id from pn_property_notices where fk_notice_id='".$data->id."')";
            // $property = DB::select($sql);
            foreach($property as $data1){

                // echo 'Notice Id - ' . $data->id;
                // echo '<br/>';

                // echo 'Property Id - ' . $data1->id;
                // echo '<br/>';
                $matching_criteria_array = [];

                // $sql = "select fk_location_type_id, location from pn_property_location_details where fk_property_id = '".$data1->id."'";
                // $location1 = DB::select($sql);
                $location1 = array();
                $i = 0;
                if(isset($data1->division)){
                    if($data1->division!=''){
                        $location1[$i]['fk_location_type_id'] = 1;
                        $location1[$i]['location'] = $data1->division;
                        $i = $i + 1;
                    }
                }
                if(isset($data1->taluka)){
                    if($data1->taluka!=''){
                        $location1[$i]['fk_location_type_id'] = 2;
                        $location1[$i]['location'] = $data1->taluka;
                        $i = $i + 1;
                    }
                }
                if(isset($data1->post)){
                    if($data1->post!=''){
                        $location1[$i]['fk_location_type_id'] = 3;
                        $location1[$i]['location'] = $data1->post;
                        $i = $i + 1;
                    }
                }
                if(isset($data1->area)){
                    if($data1->area!=''){
                        $location1[$i]['fk_location_type_id'] = 4;
                        $location1[$i]['location'] = $data1->area;
                        $i = $i + 1;
                    }
                }
                if(isset($data1->village)){
                    if($data1->village!=''){
                        $location1[$i]['fk_location_type_id'] = 5;
                        $location1[$i]['location'] = $data1->village;
                        $i = $i + 1;
                    }
                }

                // $sql = "select fk_property_no_type_id, property_no from pn_property_prop_no_details where fk_property_id = '".$data1->id."'";
                // $property_no1 = DB::select($sql);
                $property_no1 = array();
                $i = 0;
                if(isset($data1->unit_no)){
                    if($data1->unit_no!=''){
                        $property_no1[$i]['fk_property_no_type_id'] = 9;
                        $property_no1[$i]['property_no'] = $data1->unit_no;
                        $i = $i + 1;
                    }
                }
                if(isset($data1->cs_no)){
                    if($data1->cs_no!=''){
                        $property_no1[$i]['fk_property_no_type_id'] = 14;
                        $property_no1[$i]['property_no'] = $data1->cs_no;
                        $i = $i + 1;
                    }
                }
                if(isset($data1->cts_no)){
                    if($data1->cts_no!=''){
                        $property_no1[$i]['fk_property_no_type_id'] = 10;
                        $property_no1[$i]['property_no'] = $data1->cts_no;
                        $i = $i + 1;
                    }
                }
                if(isset($data1->gut_no)){
                    if($data1->gut_no!=''){
                        $property_no1[$i]['fk_property_no_type_id'] = 12;
                        $property_no1[$i]['property_no'] = $data1->gut_no;
                        $i = $i + 1;
                    }
                }
                if(isset($data1->hissa_no)){
                    if($data1->hissa_no!=''){
                        $property_no1[$i]['fk_property_no_type_id'] = 13;
                        $property_no1[$i]['property_no'] = $data1->hissa_no;
                        $i = $i + 1;
                    }
                }
                if(isset($data1->plot_no)){
                    if($data1->plot_no!=''){
                        $property_no1[$i]['fk_property_no_type_id'] = 7;
                        $property_no1[$i]['property_no'] = $data1->plot_no;
                        $i = $i + 1;
                    }
                }

                // $sql = "select legal_owner_name from pn_property_legal_owner_names where fk_property_id = '".$data1->id."'";
                // $legal_owner_name1 = DB::select($sql);
                $owner_name1 = explode(',', $data1->owner_name);
                $legal_owner_name1 = array();
                $i = 0;
                if(isset($owner_name1)){
                    if(count($owner_name1)>0){
                        for($i=0; $i<count($owner_name1); $i++){
                            $legal_owner_name1[$i]['legal_owner_name'] = $owner_name1[$i];
                        }
                    }
                }

                // $sql = "select company_name from pn_property_company_names where fk_property_id = '".$data1->id."'";
                // $company_name1 = DB::select($sql);
                
                // $sql = "select purchased_from from pn_property_purchased_froms where fk_property_id = '".$data1->id."'";
                // $purchased_from1 = DB::select($sql);

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
                            $property_legal_owner_name = preg_replace('/[^A-Za-z0-9 ]/', '', $data3['legal_owner_name']);
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
                        if($data3['fk_location_type_id']=='4'){
                            $property_location = preg_replace('/[^A-Za-z0-9 ]/', '', $data3['location']);
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
                            $property_location = preg_replace('/[^A-Za-z0-9 ]/', '', $data3['location']);
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

                $bl_floor = false;
                $bl_wing = false;
                $bl_address = false;
                $bl_state = false;

                $floor_exist = false;
                $wing_exist = false;
                $address_exist = false;
                $state_exist = false;

                $notice_floor = preg_replace('/[^A-Za-z0-9 ]/', '', $data->floor);
                $property_floor = preg_replace('/[^A-Za-z0-9 ]/', '', $data1->floor);
                if(isset($notice_floor) && $notice_floor!='' && isset($property_floor) && $property_floor!=''){
                    $floor_exist = true;
                    $matching_criteria = $this->match_criteria($notice_floor, $property_floor);
                    if($matching_criteria!=''){
                        $bl_floor = true;
                        $matching_criteria_array[] = array("parameter"=>'Floor',"notice"=>$notice_floor,"property"=>$property_floor,"matching_criteria"=>$matching_criteria);
                    }
                }
                $notice_wing = preg_replace('/[^A-Za-z0-9 ]/', '', $data->wing);
                $property_wing = preg_replace('/[^A-Za-z0-9 ]/', '', $data1->wing);
                if(isset($notice_wing) && $notice_wing!='' && isset($property_wing) && $property_wing!=''){
                    $wing_exist = true;
                    $matching_criteria = $this->match_criteria($notice_wing, $property_wing);
                    if($matching_criteria!=''){
                        $bl_wing = true;
                        $matching_criteria_array[] = array("parameter"=>'Wing',"notice"=>$notice_wing,"property"=>$property_wing,"matching_criteria"=>$matching_criteria);
                    }
                }
                $notice_address = preg_replace('/[^A-Za-z0-9 ]/', '', $data->address);
                $property_address = preg_replace('/[^A-Za-z0-9 ]/', '', $data1->address);
                if(isset($notice_address) && $notice_address!='' && isset($property_address) && $property_address!=''){
                    $address_exist = true;
                    $matching_criteria = $this->match_criteria($notice_address, $property_address);
                    if($matching_criteria!=''){
                        $bl_address = true;
                        $matching_criteria_array[] = array("parameter"=>'Address',"notice"=>$notice_address,"property"=>$property_address,"matching_criteria"=>$matching_criteria);
                    }
                }
                $notice_address = preg_replace('/[^A-Za-z0-9 ]/', '', $data->address);
                $property_road = preg_replace('/[^A-Za-z0-9 ]/', '', $data1->road);
                if(isset($notice_address) && $notice_address!='' && isset($property_road) && $property_road!=''){
                    $address_exist = true;
                    $matching_criteria = $this->match_criteria($notice_address, $property_road);
                    if($matching_criteria!=''){
                        $bl_address = true;
                        $matching_criteria_array[] = array("parameter"=>'Road',"notice"=>$notice_address,"property"=>$property_road,"matching_criteria"=>$matching_criteria);
                    }
                }
                $notice_state = preg_replace('/[^A-Za-z0-9 ]/', '', $data->state);
                $property_state = preg_replace('/[^A-Za-z0-9 ]/', '', $data1->state);
                if(isset($notice_state) && $notice_state!='' && isset($property_state) && $property_state!=''){
                    $state_exist = true;
                    $matching_criteria = $this->match_criteria($notice_state, $property_state);
                    if($matching_criteria!=''){
                        $bl_state = true;
                        $matching_criteria_array[] = array("parameter"=>'State',"notice"=>$notice_state,"property"=>$property_state,"matching_criteria"=>$matching_criteria);
                    }
                }

                if($bl_floor==false && $bl_wing==false && $bl_address==false){
                    goto Check_Property_Nos;
                }

                if($floor_exist==false && $wing_exist==false && $address_exist==false){
                    goto Check_Property_Nos;
                } else {
                    if($floor_exist==false) $bl_floor = true;
                    if($wing_exist==false) $bl_wing = true;
                    if($address_exist==false) $bl_address = true;
                    if($state_exist==false) $bl_state = true;
                }

                if($bl_floor==true && $bl_wing==true && $bl_address==true && $bl_state==true){
                    $bl_location = true;
                    goto Check_Property_Nos;
                }
                
                Check_Property_Nos:

                foreach($property_no as $data2){
                    $notice_property_no = $data2->property_no;

                    if(isset($notice_property_no) && $notice_property_no!=''){
                        foreach($property_no1 as $data3){
                            $property_property_no = $data3['property_no'];
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
                $insertid = Pn_file_property_notice::create($data3)->id;

                for($i=0;$i<count($matching_criteria_array);$i++){
                    $matching_criteria_array[$i]['pn_property_notice_id'] = $insertid;
                }
                Pn_file_notice_criteria::insert($matching_criteria_array);

                Next_Record:
            }
        }

        $data = array();
        $data['status'] = 'approved';
        if(isset($file_id)){
            Pn_property_file::find($file_id)->update($data);
        }
    }

    public function delete(Request $request){
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Properties'])) {
            if($access['Properties']['r_delete']=='1') {
                $file_id = $request->get('file_id');
                $user_id = auth()->user()->gu_id;
                $data['updated_by'] = $user_id;
                $data['status'] = 'inactive';
                if(isset($file_id)){
                    Pn_property_file::find($file_id)->update($data);
                    Session::flash('success_msg', 'File deleted successfully!');
                }

                return redirect('index.php/upload_property');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice', 'msg' => 'You donot have access to this page.']);
        }
    }
}
