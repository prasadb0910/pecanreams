<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;


class SearchController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        // $this->middleware('CheckOtp');
    }

    public function index(){
        return view('search');
    }

    public function get_data(Request $request){
        $input = $request->all();

        // $input['search'] = 'nisarg';
        // $input['criteria'] = ['Project Name'];

        $search = $input['search'];
        $cond = "";
        foreach ($input['criteria'] as $criteria){
            if($criteria=='Project Name'){
                $cond = $cond . " (master_project_name like '%".$search."%' or project_name like '%".$search."%') or";
            } else if($criteria=='Orgnization'){
                $cond = $cond . " owner_name like '%".$search."%' or";
            } else if($criteria=='Developer'){
                $cond = $cond . " (developer_1 like '%".$search."%' or developer_2 like '%".$search."%' or 
                                    developer_3 like '%".$search."%' or developer_4 like '%".$search."%') or";
            } else if($criteria=='Location'){
                $cond = $cond . " (location like '%".$search."%' or sub_location like '%".$search."%') or";
            }
        }
        if(isset($cond)){
            $cond = substr($cond, 0, strlen($cond)-2);
            $cond = " and (" . $cond . ")";
        }

        // $sql = "select A.*, TRIM(TRAILING ',' FROM replace(replace(replace(concat_ws(',' , developer_1, developer_2, 
        //         developer_3, developer_4),',,,',','),',,',','),',,',',')) as developer 
        //         from project_details A where status ='approved'" . $cond;
        // $result = DB::select($sql);
        // $tbody = "";
        // for($i=0; $i<count($result); $i++){
        //     $master_project_name = $result[$i]->master_project_name;
        //     $project_name = $result[$i]->project_name;
        //     $owner_name = $result[$i]->owner_name;
        //     $developer = $result[$i]->developer;
        //     $location = $result[$i]->location;
        //     $project_type = $result[$i]->project_type;
        //     $builtup_area_in_approved_fsi = $result[$i]->builtup_area_in_approved_fsi;
        //     $builtup_area_in_proposed_fsi = $result[$i]->builtup_area_in_proposed_fsi;
        //     $total_fsi = $result[$i]->total_fsi;
        //     $website_url = $result[$i]->website_url;
            
        //     $encrypted = Crypt::encryptString($result[$i]->project_sr_no);
        //     $tbody = $tbody . '<tr>
        //                             <td><a href="'.url("/index.php/search/get_details/".$encrypted).'" target="_blank">View</a></td>
        //                             <td>'.($i+1).'</td>
        //                             <td>'.$master_project_name.'</td>
        //                             <td>'.$project_name.'</td>
        //                             <td>'.$owner_name.'</td>
        //                             <td>'.$developer.'</td>
        //                             <td>'.$location.'</td>
        //                             <td>'.$project_type.'</td>
        //                             <td>'.$builtup_area_in_approved_fsi.'</td>
        //                             <td>'.$builtup_area_in_proposed_fsi.'</td>
        //                             <td>'.$total_fsi.'</td>
        //                             <td>'.$website_url.'</td>
        //                         </tr>';
        // }

        // $sql = "select project_sr_no, master_project_name, project_name, pin_code, location, sub_location, 
        //         round(builtup_area_in_proposed_fsi,0) as proposed_fsi, 
        //         round(builtup_area_in_approved_fsi,0) as approved_fsi, 
        //         round(total_fsi,0) as total_fsi, 
        //         round(total_carpet_area,0) as total_carpet_area, 
        //         round(sold_carpet_area,0) as sold_carpet_area, round(total_carpet_area-sold_carpet_area,0) as unsold_carpet_area, 
        //         round(no_of_apt,0) as total_units, round(no_of_bk_apt,0) as sold_units, 
        //         round(no_of_apt-no_of_bk_apt,0) as unsold_units from 
        //         (select A.project_sr_no, A.master_project_name, A.project_name, A.pin_code, A.location, A.sub_location, 
        //                 A.builtup_area_in_proposed_fsi, A.builtup_area_in_approved_fsi, A.total_fsi, 
        //                 B.total_carpet_area, B.sold_carpet_area, B.no_of_apt, B.no_of_bk_apt from 
        //         (select project_sr_no, master_project_name, project_name, pin_code, location, sub_location, 
        //                 builtup_area_in_proposed_fsi, builtup_area_in_approved_fsi, total_fsi from project_details 
        //             where status ='approved'" . $cond . ") A 
        //         left join 
        //         (select project_sr_no, sum(carpet_area_sqft*number_of_apartment) as total_carpet_area, 
        //                 sum(carpet_area_sqft*no_of_booked_apartment) as sold_carpet_area, 
        //                 sum(number_of_apartment) as number_of_apartment, 
        //                 sum(no_of_booked_apartment) as no_of_booked_apartment, 
        //                 sum(case when apartment_type_updated = 'Others' then 0 else number_of_apartment end) as no_of_apt, 
        //                 sum(case when apartment_type_updated = 'Others' then 0 else no_of_booked_apartment end) as no_of_bk_apt 
        //                 from apartment_details where status ='approved' group by project_sr_no) B 
        //         on(A.project_sr_no = B.project_sr_no) where B.project_sr_no is not null) C order by total_fsi desc limit 25";
        
        $sql = "select project_sr_no, master_project_name, project_name, pin_code, location, sub_location, 
                round(builtup_area_in_proposed_fsi,0) as proposed_fsi, 
                round(builtup_area_in_approved_fsi,0) as approved_fsi, 
                round(total_fsi,0) as total_fsi, 
                round(total_carpet_area,0) as total_carpet_area, 
                round(sold_carpet_area,0) as sold_carpet_area, 
                round(unsold_carpet_area,0) as unsold_carpet_area, 
                round(no_of_apt,0) as total_units, 
                round(no_of_bk_apt,0) as sold_units, 
                round(unsold_units,0) as unsold_units from 
                (select A.project_sr_no, A.master_project_name, A.project_name, A.pin_code, A.location, A.sub_location, 
                        A.builtup_area_in_proposed_fsi, A.builtup_area_in_approved_fsi, A.total_fsi, 
                        B.total_carpet_area, B.sold_carpet_area, B.unsold_carpet_area, B.no_of_apt, B.no_of_bk_apt, B.unsold_units from 
                (select project_sr_no, master_project_name, project_name, pin_code, location, sub_location, 
                        builtup_area_in_proposed_fsi, builtup_area_in_approved_fsi, total_fsi from project_details 
                    where status ='approved'" . $cond . ") A 
                left join 
                (select project_sr_no, sum(total_carpet_area) as total_carpet_area, 
                        sum(sold_carpet_area) as sold_carpet_area, 
                        sum(unsold_carpet_area) as unsold_carpet_area, 
                        sum(case when apartment_type_updated = 'Others' then 0 else number_of_apartment end) as no_of_apt, 
                        sum(case when apartment_type_updated = 'Others' then 0 else no_of_booked_apartment end) as no_of_bk_apt, 
                        sum(case when apartment_type_updated = 'Others' then 0 else unsold_units end) as unsold_units 
                        from apartment_details where status ='approved' group by project_sr_no) B 
                on(A.project_sr_no = B.project_sr_no) where B.project_sr_no is not null) C order by total_fsi desc limit 25";
        $result = DB::select($sql);
        $tbody = '';
        // $blInsert = false;
        // $tot_cnt=0;
        // $total_fsi_tot=0;
        // $approved_fsi_tot=0;
        // $proposed_fsi_tot=0;
        // $tot_carpet_area_tot=0;
        // $sold_carpet_area_tot=0;
        // $sold_carpet_area_per_tot=0;
        // $tot_units_tot=0;
        // $sold_units_tot=0;
        // $sold_units_per_tot=0;
        for($i=0; $i<count($result); $i++){
            $master_project_name = $result[$i]->master_project_name;
            $project_name = $result[$i]->project_name;
            $pin_code = $result[$i]->pin_code;
            $location = $result[$i]->location;
            $sub_location = $result[$i]->sub_location;
            $proposed_fsi = $result[$i]->proposed_fsi;
            $approved_fsi = $result[$i]->approved_fsi;
            $total_fsi = $result[$i]->total_fsi;
            $tot_carpet_area = $result[$i]->total_carpet_area;
            $sold_carpet_area = $result[$i]->sold_carpet_area;
            if($tot_carpet_area>0){
                $sold_carpet_area_per = round(($sold_carpet_area/$tot_carpet_area)*100,0);
            } else {
                $sold_carpet_area_per = 0;
            }
            $tot_units = $result[$i]->total_units;
            $sold_units = $result[$i]->sold_units;
            if($tot_units>0){
                $sold_units_per = round(($sold_units/$tot_units)*100,0);
            } else {
                $sold_units_per = 0;
            }

            // $tot_cnt = $tot_cnt + 1;
            // $total_fsi_tot = $total_fsi_tot + $total_fsi;
            // $proposed_fsi_tot = $proposed_fsi_tot + $proposed_fsi;
            // $approved_fsi_tot = $approved_fsi_tot + $approved_fsi;
            // $tot_carpet_area_tot = $tot_carpet_area_tot + $tot_carpet_area;
            // $sold_carpet_area_tot = $sold_carpet_area_tot + $sold_carpet_area;
            // $sold_carpet_area_per_tot = $sold_carpet_area_per_tot + $sold_carpet_area_per;
            // $tot_units_tot = $tot_units_tot + $tot_units;
            // $sold_units_tot = $sold_units_tot + $sold_units;
            // $sold_units_per_tot = $sold_units_per_tot + $sold_units_per;

            setlocale(LC_MONETARY, 'en_IN');
            $encrypted = Crypt::encryptString($result[$i]->project_sr_no);
            $tbody = $tbody . '<tr>
                                    <td>'.($i+1).'</td>
                                    <td>'.$master_project_name.'</td>
                                    <td><a href="'.url("/index.php/search/get_details/".$encrypted).'" target="_blank">'.$project_name.'</a></td>
                                    <td style="text-align:right;padding-left: 0;padding-right: 0;">'.$this->moneyFormatIndia($total_fsi).'</td>
                                    <td style="text-align:right;padding-left: 0;padding-right: 0;">'.$this->moneyFormatIndia($approved_fsi).'</td>
                                    <td style="text-align:right;padding-left: 0;padding-right: 0;">'.$this->moneyFormatIndia($proposed_fsi).'</td>
                                    <td style="text-align:right;padding-left: 0;padding-right: 0;">'.$this->moneyFormatIndia($tot_carpet_area).'</td>
                                    <td style="text-align:right;padding-left: 0;padding-right: 0;">'.$this->moneyFormatIndia($sold_carpet_area).'</td>
                                    <td style="text-align:right;padding-left: 0;padding-right: 0;">'.$this->moneyFormatIndia($sold_carpet_area_per).'</td>
                                    <td style="text-align:right;padding-left: 0;padding-right: 0;">'.$this->moneyFormatIndia($tot_units).'</td>
                                    <td style="text-align:right;padding-left: 0;padding-right: 0;">'.$this->moneyFormatIndia($sold_units).'</td>
                                    <td style="text-align:right;padding-left: 0;padding-right: 0;">'.$this->moneyFormatIndia($sold_units_per).'</td>
                                    <td>'.$location.'</td>
                                    <td>'.$pin_code.'</td>
                                    <td>'.$sub_location.'</td>
                                </tr>';

            // $blInsert = false;
            // if($i==count($result)-1){
            //     $blInsert = true;
            // } else if($result[$i]->master_project_name!=$result[$i+1]->master_project_name) {
            //     $blInsert = true;
            // }
            
            // if($blInsert == true){
            //     $tbody = $tbody . '<tr>
            //                         <td></td>
            //                         <td style="font-weight:bold;">Total</td>
            //                         <td></td>
            //                         <td style="text-align:right;padding-left: 0;padding-right: 0;font-weight:bold;">'.$this->moneyFormatIndia($total_fsi_tot).'</td>
            //                         <td style="text-align:right;padding-left: 0;padding-right: 0;font-weight:bold;">'.$this->moneyFormatIndia($approved_fsi_tot).'</td>
            //                         <td style="text-align:right;padding-left: 0;padding-right: 0;font-weight:bold;">'.$this->moneyFormatIndia($proposed_fsi_tot).'</td>
            //                         <td style="text-align:right;padding-left: 0;padding-right: 0;font-weight:bold;">'.$this->moneyFormatIndia($tot_carpet_area_tot).'</td>
            //                         <td style="text-align:right;padding-left: 0;padding-right: 0;font-weight:bold;">'.$this->moneyFormatIndia($sold_carpet_area_tot).'</td>
            //                         <td style="text-align:right;padding-left: 0;padding-right: 0;font-weight:bold;">'.$this->moneyFormatIndia($sold_carpet_area_per_tot/$tot_cnt).'</td>
            //                         <td style="text-align:right;padding-left: 0;padding-right: 0;font-weight:bold;"'.$this->moneyFormatIndia($tot_units_tot).'</td>
            //                         <td style="text-align:right;padding-left: 0;padding-right: 0;font-weight:bold;">'.$this->moneyFormatIndia($sold_units_tot).'</td>
            //                         <td style="text-align:right;padding-left: 0;padding-right: 0;font-weight:bold;">'.$this->moneyFormatIndia($sold_units_per_tot/$tot_cnt).'</td>
            //                         <td></td>
            //                         <td></td>
            //                         <td></td>
            //                     </tr>';

            //     $tot_cnt=0;
            //     $total_fsi_tot=0;
            //     $approved_fsi_tot=0;
            //     $proposed_fsi_tot=0;
            //     $tot_carpet_area_tot=0;
            //     $sold_carpet_area_tot=0;
            //     $sold_carpet_area_per_tot=0;
            //     $tot_units_tot=0;
            //     $sold_units_tot=0;
            //     $sold_units_per_tot=0;
            // }
        }
        $data['project_details'] = $tbody;

        echo json_encode($data);
    }

    public function get_details($project_sr_no){
        $project_sr_no = Crypt::decryptString($project_sr_no);

        $sql = "select * from project_details where status ='approved' and project_sr_no = '$project_sr_no'";
        $project_details = DB::select($sql);
        if(count($project_details)>0){
            $project_sr_no = $project_details[0]->project_sr_no;
        } else {
            $project_sr_no = '';
        }
        
        $sql = "select * from property_details where status ='approved' and project_sr_no = '$project_sr_no'";
        $prop_details = DB::select($sql);
        $apt_details = array();
        $task_details = array();
        for($i=0; $i<count($prop_details); $i++){
            $property_sr_no = $prop_details[$i]->property_sr_no;
            $sql = "select * from apartment_details where status ='approved' and project_sr_no = '$project_sr_no' and 
                    property_sr_no = '$property_sr_no'";
            $apt_details[$i] = DB::select($sql);
            
            $sql = "select * from task_details where status ='approved' and project_sr_no = '$project_sr_no' and 
                    property_sr_no = '$property_sr_no'";
            $task_details[$i] = DB::select($sql);
        }

        $data['project_details'] = $project_details;
        $data['prop_details'] = $prop_details;
        $data['apt_details'] = $apt_details;
        $data['task_details'] = $task_details;

        return view('details', $data);
    }

    function moneyFormatIndia($num) {
        try{
            $explrestunits = "" ;
            if(strlen($num)>3) {
                $lastthree = substr($num, strlen($num)-3, strlen($num));
                $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
                $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
                $expunit = str_split($restunits, 2);
                for($i=0; $i<sizeof($expunit); $i++) {
                    // creates each of the 2's group and adds a comma to the end
                    if($i==0) {
                        $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
                    } else {
                        $explrestunits .= $expunit[$i].",";
                    }
                }
                $thecash = $explrestunits.$lastthree;
            } else {
                $thecash = $num;
            }
            return $thecash; // writes the final format where $currency is the currency symbol.
        }
        catch(Exception $e) {

        }
    }
}