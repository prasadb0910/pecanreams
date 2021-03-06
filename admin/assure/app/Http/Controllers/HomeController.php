<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\Pn_notice;
use App\Pn_newspaper;
use App\Pn_property;
use DB;
use DateTime;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function public_notice() {
        session(['module' => 'public_notice']);
        return $this->index();
    }

    public function idata() {
        session(['module' => 'idata']);
        return $this->index();
    }

    public function reams() {
        session(['module' => 'reams']);

        $user_id = auth()->user()->gu_id;
        $sql = "select * from group_users where gu_id = '$user_id'";
        $data = DB::select($sql);
        if(count($data)>0){
            $email_id = $data[0]->gu_email;
            $token = rand(100000,999999);
            $token = md5($token);

            $sql = "Insert into user_login_emails (user_id, email, token, isVerified) values ('$user_id', '$email_id', '$token', '0')";
            DB::insert($sql);
        }

        return Redirect::to('httP://localhost/pecan_reams/index.php/login/get_laravel_session/'.$token);
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index() {   
        if(session('module')==null){
            session(['module' => 'public_notice']);
        }
        if(session('module')=='idata'){
            $sql = "select max(updated_at) as max_updation_date from project_details";
            $result = DB::select($sql);
            $data['max_updation_date'] = $result[0]->max_updation_date;

            $sql = "select distinct location, sub_location from 
                    (select distinct location, sub_location from project_details where status ='approved' 
                    union all 
                    select 'Mumbai' as location, ' Entire Mumbai' as sub_location from project_details where status ='approved') A
                    group by location, sub_location order by location, sub_location";
            $location = DB::select($sql);
            $data['location'] = $location;

            $sql = "select distinct project_type from apartment_details where status ='approved' and project_type != 'Plots'";
            $project_type = DB::select($sql);
            $data['project_type'] = $project_type;

            // return view('adminlte::home');
            return view('dashboard', $data);
        } else {
            $user = new User();
            $access = $user->get_access();
            $blFlag = false;
            if(isset($access['AdminDashboard'])) {
                if($access['AdminDashboard']['r_view']=='1' || $access['AdminDashboard']['r_insert']=='1' || $access['AdminDashboard']['r_edit']=='1' || $access['AdminDashboard']['r_delete']=='1' || $access['AdminDashboard']['r_approvals']=='1' || $access['AdminDashboard']['r_export']=='1') {
                    $blFlag = true;
                    $date = new DateTime('-30 day');
                    $from_date = $date;
                    $from_date = $from_date->format('Y-m-d');

                    // $notice = Pn_notice::with(array(
                    //                     'Pn_newspaper'=>function($query){$query->select('id','paper_name');},
                    //                     'Pn_notice_type'=>function($query){$query->select('id','notice_type');}
                    //                     ))->where('date_of_notice','>=',$from_date)->orderBy('updated_at','desc')->get();
                    $sql = "select AA.*, BB.legal_owner_name from 
                            (select A.*, B.paper_name, C.notice_type 
                            from pn_notices A 
                            left join pn_newspapers B on (A.fk_newspaper_id = B.id) 
                            left join pn_notice_types C on (A.fk_notice_type_id = C.id) 
                            where A.status = 'approved' and date_of_notice>='$from_date') AA 
                            left join 
                            (select fk_notice_id, group_concat(legal_owner_name) as legal_owner_name 
                            from pn_notice_legal_owner_names group by fk_notice_id) BB 
                            on (AA.id = BB.fk_notice_id) 
                            order by AA.updated_at desc";
                    $notice = DB::select($sql);

                    // $newspapers = Pn_newspaper::orderBy('updated_at','desc')->get();
                    $sql = "select A.*, B.no_of_notices from 
                            (select * from pn_newspapers where status = 'approved') A 
                            left join 
                            (select fk_newspaper_id, count(id) as no_of_notices 
                            from pn_notices where status = 'approved' and date_of_notice>='$from_date' 
                            group by fk_newspaper_id) B 
                            on (A.id = B.fk_newspaper_id) 
                            order by A.updated_at desc";
                    $newspapers = DB::select($sql);


                    $notice_cnt = array();
                    $today = new DateTime();
                    $today->format('Y-m-d');
                    $i = 0;
                    while($date<=$today){
                        // $from_date = $date;
                        $from_date = $today->format('Y-m-d');

                        // echo $from_date;
                        // echo '<br/>';

                        // $sql = "select A.news_type, count(A.id) as no_of_newspapers, 
                        //             sum(case when B.no_of_notices is null then 0 else 1 end) as no_of_newspapers_with_notice, 
                        //             sum(case when B.no_of_notices is null then 1 else 0 end) as no_of_newspapers_without_notice, 
                        //             sum(B.no_of_notices) as no_of_notices from 
                        //         (select id, news_type from pn_newspapers where status = 'approved') A 
                        //         left join 
                        //         (select fk_newspaper_id, count(id) as no_of_notices 
                        //         from pn_notices where status = 'approved' and date_of_notice='$from_date' 
                        //         group by fk_newspaper_id) B 
                        //         on (A.id = B.fk_newspaper_id) 
                        //         group by A.news_type
                        //         order by A.news_type";

                        $sql = "select C.news_type, count(C.id) as no_of_newspapers, 
                                    sum(case when C.no_of_notices is null then case when D.fk_newspaper_id is null then 0 else 1 end else 1 end) as no_of_newspapers_with_notice, 
                                    sum(case when C.no_of_notices is null then case when D.fk_newspaper_id is null then 1 else 0 end else 0 end) as no_of_newspapers_without_notice, 
                                    sum(C.no_of_notices) as no_of_notices from 
                                (select A.id, A.news_type, B.no_of_notices from 
                                (select id, news_type from pn_newspapers where status = 'approved') A 
                                left join 
                                (select fk_newspaper_id, count(id) as no_of_notices 
                                from pn_notices where status = 'approved' and date_of_notice = '$from_date' 
                                group by fk_newspaper_id) B 
                                on (A.id = B.fk_newspaper_id)) C 
                                left join 
                                (select distinct fk_newspaper_id from pn_no_notices where status = 'approved' and date_of_notice = '$from_date') D 
                                on (C.id = D.fk_newspaper_id) 
                                group by C.news_type 
                                order by C.news_type";
                        $result = DB::select($sql);
                        if(count($result)>0){
                            foreach ($result as $data) {
                                $notice_cnt[$i]['date'] = $from_date;
                                $notice_cnt[$i]['news_type'] = $data->news_type;
                                $notice_cnt[$i]['no_of_newspapers'] = $data->no_of_newspapers;
                                $notice_cnt[$i]['no_of_newspapers_with_notice'] = $data->no_of_newspapers_with_notice;
                                $notice_cnt[$i]['no_of_newspapers_without_notice'] = $data->no_of_newspapers_without_notice;
                                $notice_cnt[$i]['no_of_notices'] = $data->no_of_notices;

                                $i = $i + 1;
                            }
                        }

                        $today->modify('-1 day');
                    }
                    
                    // echo json_encode($notice_cnt);

                    return view('dashboard.admin_dashboard', ['access' => $access, 'notice' => $notice, 'newspapers' => $newspapers, 'notice_cnt' => $notice_cnt]);
                }
            } else if(isset($access['UserDashboard'])) {
                if($access['UserDashboard']['r_view']=='1' || $access['UserDashboard']['r_insert']=='1' || $access['UserDashboard']['r_edit']=='1' || $access['UserDashboard']['r_delete']=='1' || $access['UserDashboard']['r_approvals']=='1' || $access['UserDashboard']['r_export']=='1') {
                    $blFlag = true;
                    $user_id = auth()->user()->gu_id;

                    $property = Pn_property::where('created_by',$user_id)->orderBy('updated_at','desc')->get();

                    $sql = "select A.id, A.fk_property_id, A.fk_notice_id, A.status, B.property_name, B.address, 
                            C.notice_title, C.notice_file, D.paper_name, E.notice_type 
                            from pn_property_notices A 
                            left join pn_properties B on (A.fk_property_id=B.id) 
                            left join pn_notices C on (A.fk_notice_id=C.id) 
                            left join pn_newspapers D on (C.fk_newspaper_id=D.id) 
                            left join pn_notice_types E on (C.fk_notice_type_id=E.id) 
                            where A.status = 'approved' and B.created_by = '$user_id' and B.property_name is not null";
                    $notice = DB::select($sql);

                    return view('dashboard.user_dashboard', ['access' => $access, 'property' => $property, 'notice' => $notice]);
                }
            }
            if($blFlag==false){
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Dashboard', 'msg' => 'You donot have access to this page.']);
            }
            
            // return view('adminlte::home', ['access' => $access]);
        }
    }

    public function get_data(Request $request){
        $input = $request->all();

        // $input['locations'] = ["Entire Mumbai"];
        // $input['project_types'] = ["Residential"];
        // $input['entity_type'] = 'Include Government Housing';

        $locations = "";
        $project_types = "";
        $entity_type = "";
        $cond = "";
        $cond2 = "";
        $blEntireMumbai = false;

        if(isset($input['locations'])){
            foreach ($input['locations'] as $location){
                if($location == 'Entire Mumbai'){
                    $blEntireMumbai = true;
                }
            }
            
            foreach ($input['locations'] as $location){
                $locations = $locations . "'" . $location . "', ";
            }
            if($locations!=""){
                $locations = substr($locations, 0, strlen($locations)-2);
            }

            if($blEntireMumbai == true){
                if($locations!=""){
                    $cond = $cond . " and (location = 'Mumbai' or sub_location in (" . $locations . "))";
                } else {
                    $cond = $cond . " and location = 'Mumbai'";
                }
            } else {
                if($locations!=""){
                    $cond = $cond . " and sub_location in (" . $locations . ")";
                }
            }
        }
        
        if(isset($input['project_types'])){
            foreach ($input['project_types'] as $project_type){
                $project_types = $project_types . "'" . $project_type . "', ";
            }
            if($project_types!=""){
                $project_types = substr($project_types, 0, strlen($project_types)-2);
            }

            if($project_types!=""){
                $cond2 = $cond2 . " and project_type in (" . $project_types . ")";
            }
        }
        
        if(isset($input['entity_type'])){
            $entity_type = $input['entity_type'];

            if($entity_type=="Do Not Include Government Housing"){
                $cond2 = $cond2 . " and entity_type != 'Govt'";
            } else if($entity_type=="Show Only Government Housing"){
                $cond2 = $cond2 . " and entity_type = 'Govt'";
            }
        }

        // $cond = " and (location = 'Mumbai' or sub_location in (' Entire Mumbai', 'Central Mumbai- East', 'Central Mumbai- West', 
        //             'Eastern Suburbs', 'South Mumbai', 'Thane Extensions', 'Western Suburbs - Andheri to Bandra', 
        //             'Western Suburbs - North of Jogeshwari to Dahisar', 'Western Suburbs Extension - Mira Road to Virar', 
        //             'New Mumbai', 'Pune City East', 'Pune City West', 'Rest Of Maharashtra', 'Nagpur', 'Nasik', 'Rest Of Maharashtra', 
        //             'Thane Central', 'Thane Extensions'))";
        // $cond2 = " and entity_type = 'Include Government Housing'";

        // echo $cond;
        // echo '<br/>';
        // echo $cond2;
        // echo '<br/>';


        // $sql = "select count(distinct A.master_project_name) as master_proj_cnt from 
        //         (select project_sr_no, master_project_name from project_details where status ='approved'" . $cond . ") A 
        //         left join 
        //         (select distinct project_sr_no from apartment_details where status ='approved'" . $cond2 . ") B
        //         on (A.project_sr_no = B.project_sr_no) 
        //         where B.project_sr_no is not null";
        // $result = DB::select($sql);
        // $data['master_proj_cnt'] = $result[0]->master_proj_cnt;

        // $sql = "select count(distinct A.id) as total_cnt from 
        //         (select project_sr_no, id from project_details where status ='approved'" . $cond . ") A 
        //         left join 
        //         (select distinct project_sr_no from apartment_details where status ='approved'" . $cond2 . ") B
        //         on (A.project_sr_no = B.project_sr_no) 
        //         where B.project_sr_no is not null";
        // $result = DB::select($sql);
        // $data['total_cnt'] = $result[0]->total_cnt;


        $sql = "select count(distinct master_project_name) as master_proj_cnt from apartment_details where status ='approved'" . $cond . $cond2;
        $result = DB::select($sql);
        $data['master_proj_cnt'] = $result[0]->master_proj_cnt;

        $sql = "select count(distinct project_sr_no) as total_cnt from apartment_details where status ='approved'" . $cond . $cond2;
        $result = DB::select($sql);
        $data['total_cnt'] = $result[0]->total_cnt;


        // $sql = "select sum(total_carpet_area) as total_carpet_area, sum(sold_carpet_area) as sold_carpet_area, 
        //             sum(total_carpet_area-sold_carpet_area) as unsold_carpet_area, sum(no_of_apt) as total_units, 
        //             sum(no_of_bk_apt) as sold_units, sum(no_of_apt-no_of_bk_apt) as unsold_units from 
        //         (select A.project_sr_no, B.carpet_area*B.number_of_apartment as total_carpet_area, 
        //             B.carpet_area*B.no_of_booked_apartment as sold_carpet_area, 
        //             B.no_of_apt, B.no_of_bk_apt from 
        //         (select distinct project_sr_no from project_details where status ='approved'" . $cond . ") A 
        //         left join 
        //         (select project_sr_no, ifnull(carpet_area_sqft,0) as carpet_area, 
        //             ifnull(number_of_apartment,0) as number_of_apartment, 
        //             ifnull(no_of_booked_apartment,0) as no_of_booked_apartment, 
        //             ifnull(case when apartment_type_updated = 'Others' then 0 else number_of_apartment end,0) as no_of_apt, 
        //             ifnull(case when apartment_type_updated = 'Others' then 0 else no_of_booked_apartment end,0) as no_of_bk_apt 
        //         from apartment_details where status ='approved'" . $cond2 . ") B 
        //         on(A.project_sr_no = B.project_sr_no) 
        //         where B.project_sr_no is not null) C";
        $sql = "select sum(total_carpet_area) as total_carpet_area, 
                    sum(sold_carpet_area) as sold_carpet_area, 
                    sum(unsold_carpet_area) as unsold_carpet_area, 
                    sum(case when apartment_type_updated = 'Others' then 0 else number_of_apartment end) as total_units, 
                    sum(case when apartment_type_updated = 'Others' then 0 else no_of_booked_apartment end) as sold_units, 
                    sum(case when apartment_type_updated = 'Others' then 0 else unsold_units end) as unsold_units 
                from apartment_details where status ='approved'" . $cond . $cond2;
        $result = DB::select($sql);
        $total_carpet_area = $result[0]->total_carpet_area;
        $total_units = $result[0]->total_units;
        $data['total_carpet_area'] = $this->moneyFormatIndia(round($total_carpet_area/100000,0));
        $data['sold_carpet_area'] = round($result[0]->sold_carpet_area,0);
        $data['unsold_carpet_area'] = round($result[0]->unsold_carpet_area,0);
        $data['total_units'] = $this->moneyFormatIndia(round($total_units,0));
        $data['sold_units'] = round($result[0]->sold_units,0);
        $data['unsold_units'] = round($result[0]->unsold_units,0);
        
        $sql = "select sum(A.builtup_area_in_proposed_fsi) as proposed_fsi, sum(A.builtup_area_in_approved_fsi) as approved_fsi, 
                        sum(A.total_fsi) as total_fsi from 
                (select project_sr_no, builtup_area_in_proposed_fsi, builtup_area_in_approved_fsi, total_fsi 
                    from project_details where status ='approved'" . $cond . ") A 
                left join 
                (select distinct project_sr_no from apartment_details where status ='approved'" . $cond2 . ") B
                on (A.project_sr_no = B.project_sr_no) 
                where B.project_sr_no is not null";
        $result = DB::select($sql);
        if(count($result)>0){
            $proposed_fsi = $result[0]->proposed_fsi;
            $approved_fsi = $result[0]->approved_fsi;
            $total_fsi = $result[0]->total_fsi;

            if($total_fsi>0){
                $proposed_fsi_per = round(($proposed_fsi/$total_fsi)*100,0);
                $approved_fsi_per = round(($approved_fsi/$total_fsi)*100,0);
            } else {
                $proposed_fsi_per = 0;
                $approved_fsi_per = 0;
            }
            
        } else {
            $proposed_fsi = 0;
            $approved_fsi = 0;
            $total_fsi = 0;
            $proposed_fsi_per = 0;
            $approved_fsi_per = 0;
        }
        $data['proposed_fsi'] = round($proposed_fsi/100000,0);
        $data['approved_fsi'] = round($approved_fsi/100000,0);
        $data['total_fsi'] = round($total_fsi/100000,0);
        $data['proposed_fsi_per'] = $proposed_fsi_per;
        $data['approved_fsi_per'] = $approved_fsi_per;

        // $sql = "select apartment_type_updated, round(sum(total_carpet_area),0) as total_carpet_area, 
        //             round(sum(sold_carpet_area),0) as sold_carpet_area, 
        //             round(sum(total_carpet_area-sold_carpet_area),0) as unsold_carpet_area, 
        //             round(sum(no_of_apt),0) as total_units, round(sum(no_of_bk_apt),0) as sold_units, 
        //             round(sum(no_of_apt-no_of_bk_apt),0) as unsold_units from 
        //         (select A.project_sr_no, B.apartment_type_updated, B.carpet_area*B.number_of_apartment as total_carpet_area, 
        //             B.carpet_area*B.no_of_booked_apartment as sold_carpet_area, B.no_of_apt, 
        //             B.no_of_bk_apt from 
        //         (select distinct project_sr_no from project_details where status ='approved'" . $cond . ") A 
        //         left join 
        //         (select project_sr_no, case when apartment_type_updated='1 RK' then '1 BHK' 
        //                                     when apartment_type_updated='1.5 BHK' then '1 BHK'
        //                                     when apartment_type_updated='2.5 BHK' then '2 BHK'
        //                                     when apartment_type_updated='3.5 BHK' then '3 BHK'
        //                                     when apartment_type_updated='4+ BHK' then '4+ BHK'
        //                                     else apartment_type_updated end as apartment_type_updated, 
        //             ifnull(carpet_area_sqft,0) as carpet_area, 
        //             ifnull(number_of_apartment,0) as number_of_apartment, 
        //             ifnull(no_of_booked_apartment,0) as no_of_booked_apartment, 
        //             ifnull(case when apartment_type_updated = 'Others' then 0 else number_of_apartment end,0) as no_of_apt, 
        //             ifnull(case when apartment_type_updated = 'Others' then 0 else no_of_booked_apartment end,0) as no_of_bk_apt 
        //         from apartment_details where status ='approved'" . $cond2 . ") B 
        //         on(A.project_sr_no = B.project_sr_no) 
        //         where B.project_sr_no is not null) C 
        //         group by apartment_type_updated";
        $sql = "select apartment_type_updated, sum(total_carpet_area) as total_carpet_area, sum(sold_carpet_area) as sold_carpet_area, 
                    sum(unsold_carpet_area) as unsold_carpet_area, sum(total_units) as total_units, 
                    sum(sold_units) as sold_units, sum(unsold_units) as unsold_units from 
                (select case when apartment_type_updated='1 RK' then '1 BHK' 
                            when apartment_type_updated='1.5 BHK' then '1 BHK'
                            when apartment_type_updated='2.5 BHK' then '2 BHK'
                            when apartment_type_updated='3.5 BHK' then '3 BHK'
                            when apartment_type_updated='4 BHK' then '4+ BHK'
                            when apartment_type_updated='4.5 BHK' then '4+ BHK'
                            when apartment_type_updated='5 BHK' then '4+ BHK'
                            when apartment_type_updated='5.5 BHK' then '4+ BHK'
                            when apartment_type_updated='6 BHK' then '4+ BHK'
                            when apartment_type_updated='6.5 BHK' then '4+ BHK'
                            when apartment_type_updated='7 BHK' then '4+ BHK'
                            when apartment_type_updated='7.5 BHK' then '4+ BHK'
                            when apartment_type_updated='8 BHK' then '4+ BHK'
                            when apartment_type_updated='8.5 BHK' then '4+ BHK'
                            when apartment_type_updated='9 BHK' then '4+ BHK'
                            when apartment_type_updated='9.5 BHK' then '4+ BHK'
                            when apartment_type_updated='10 BHK' then '4+ BHK'
                            else apartment_type_updated end as apartment_type_updated, 
                    ifnull(total_carpet_area,0) as total_carpet_area, 
                    ifnull(sold_carpet_area,0) as sold_carpet_area, 
                    ifnull(unsold_carpet_area,0) as unsold_carpet_area, 
                    case when apartment_type_updated = 'Others' then 0 else number_of_apartment end as total_units, 
                    case when apartment_type_updated = 'Others' then 0 else no_of_booked_apartment end as sold_units, 
                    case when apartment_type_updated = 'Others' then 0 else unsold_units end as unsold_units 
                from apartment_details where status ='approved'" . $cond . $cond2 . ") A 
                group by apartment_type_updated";
        $result = DB::select($sql);
        $apartment_area = [];
        $apartment_units = [];
        $apartment_type_bhk = [];
        $sold_carpet_area_bhk = [];
        $unsold_carpet_area_bhk = [];
        $apartment_type_units_bhk = [];
        $sold_units_bhk = [];
        $unsold_units_bhk = [];
        $j = 0;
        $k = 0;
        for($i=0; $i<count($result); $i++){
            $apartment_type_updated = $result[$i]->apartment_type_updated;
            $tot_carpet_area = $result[$i]->total_carpet_area;
            $tot_units = $result[$i]->total_units;
            $sold_carpet_area = $result[$i]->sold_carpet_area;
            $unsold_carpet_area = $result[$i]->unsold_carpet_area;
            $sold_units = $result[$i]->sold_units;
            $unsold_units = $result[$i]->unsold_units;

            if($tot_carpet_area>0){
                // $sold_carpet_area = round(($sold_carpet_area/$tot_carpet_area)*100,0);
                $sold_carpet_area = round($sold_carpet_area/100000,1);
                // $unsold_carpet_area = round(($unsold_carpet_area/$tot_carpet_area)*100,0);
                $unsold_carpet_area = round($unsold_carpet_area/100000,1);
            } else {
                $sold_carpet_area = 0;
                $unsold_carpet_area = 0;
            }
            if($tot_units>0){
                $sold_units = round($sold_units,1);
                $unsold_units = round($unsold_units,1);
            } else {
                $sold_units = 0;
                $unsold_units = 0;
            }

            if($total_carpet_area!=0){
                $total_carpet_area_per = round(($tot_carpet_area/$total_carpet_area)*100,0);
            } else {
                $total_carpet_area_per = 0;
            }
            if($total_units!=0){
                $total_units_per = round(($tot_units/$total_units)*100,0);
            } else {
                $total_units_per = 0;
            }
            $apartment_type_area = $apartment_type_updated . ' <br>' . round($tot_carpet_area/100000,2) . ' <br>' . $total_carpet_area_per . '%';
            $apartment_type_units = $apartment_type_updated . ' <br>' . $this->moneyFormatIndia($tot_units) . ' <br>' . $total_units_per . '%';

            if($sold_carpet_area>0 || $unsold_carpet_area>0){
                $apartment_area[$j] = [ $apartment_type_area,$sold_carpet_area, $unsold_carpet_area];
                $apartment_type_bhk[$j] = [ $apartment_type_area ];
                $sold_carpet_area_bhk[$j] = [ $sold_carpet_area ];
                $unsold_carpet_area_bhk[$j] = [ $unsold_carpet_area ];
                $j = $j + 1;
            }
            if($sold_units>0 || $unsold_units>0){
                $apartment_units[$k] = [ $apartment_type_units,$sold_units, $unsold_units];
                $apartment_type_units_bhk[$k] = [ $apartment_type_units ];
                $sold_units_bhk[$k] = [ $sold_units ];
                $unsold_units_bhk[$k] = [ $unsold_units ];
                $k = $k + 1;
            }
        }
        $data['apartment_area'] = $apartment_area;
        $data['apartment_units'] = $apartment_units;

        $data['apartment_type_bhk']=$apartment_type_bhk;
        $data['sold_carpet_area_bhk']=$sold_carpet_area_bhk;
        $data['unsold_carpet_area_bhk']=$unsold_carpet_area_bhk;

        $data['apartment_type_units_bhk']=$apartment_type_units_bhk;
        $data['sold_units_bhk']=$sold_units_bhk;
        $data['unsold_units_bhk']=$unsold_units_bhk;


        // $sql = "select case when year_of_completion is null then 0 when year_of_completion='H1CY17' then 1 
        //                     when year_of_completion='H2CY17' then 2 when year_of_completion='H1CY18' then 3 
        //                     when year_of_completion='H2CY18' then 4 when year_of_completion='CY19' then 5 
        //                     when year_of_completion='CY20' then 6 when year_of_completion='CY21' then 7 else 8 end as sr_no, 
        //                 year_of_completion, round(sum(total_carpet_area),0) as total_carpet_area, 
        //                 round(sum(sold_carpet_area),0) as sold_carpet_area, 
        //                 round(sum(total_carpet_area-sold_carpet_area),0) as unsold_carpet_area, 
        //                 round(sum(no_of_apt),0) as total_units, round(sum(no_of_bk_apt),0) as sold_units, 
        //                 round(sum(no_of_apt-no_of_bk_apt),0) as unsold_units from 
        //         (select A.project_sr_no, case when A.date_of_completion is null then null 
        //             when A.date_of_completion<'2017-07-01' then 'H1CY17' 
        //             when A.date_of_completion<'2018-01-01' then 'H2CY17' when A.date_of_completion<'2018-07-01' then 'H1CY18' 
        //             when A.date_of_completion<'2019-01-01' then 'H2CY18' when A.date_of_completion<'2020-01-01' then 'CY19' 
        //             when A.date_of_completion<'2021-01-01' then 'CY20' 
        //             when A.date_of_completion<'2022-01-01' then 'CY21' else 'CY22' end as year_of_completion, 
        //             B.carpet_area*B.number_of_apartment as total_carpet_area, 
        //             B.carpet_area*B.no_of_booked_apartment as sold_carpet_area, B.no_of_apt, 
        //             B.no_of_bk_apt from 
        //         (select distinct project_sr_no, 
        //             ifnull(revised_proposed_date_of_completion, proposed_date_of_completion) as date_of_completion 
        //         from project_details where status ='approved'" . $cond . ") A 
        //         left join 
        //         (select project_sr_no, ifnull(carpet_area_sqft,0) as carpet_area, 
        //             ifnull(number_of_apartment,0) as number_of_apartment, 
        //             ifnull(no_of_booked_apartment,0) as no_of_booked_apartment, 
        //             ifnull(case when apartment_type_updated = 'Others' then 0 else number_of_apartment end,0) as no_of_apt, 
        //             ifnull(case when apartment_type_updated = 'Others' then 0 else no_of_booked_apartment end,0) as no_of_bk_apt 
        //         from apartment_details where status ='approved'" . $cond2 . ") B 
        //         on(A.project_sr_no = B.project_sr_no) 
        //         where A.date_of_completion is not null) C 
        //         group by year_of_completion 
        //         order by sr_no";
        $sql = "select case when year_of_completion is null then 0 when year_of_completion='H1CY17' then 1 
                            when year_of_completion='H2CY17' then 2 when year_of_completion='H1CY18' then 3 
                            when year_of_completion='H2CY18' then 4 when year_of_completion='CY19' then 5 
                            when year_of_completion='CY20' then 6 when year_of_completion='CY21' then 7 else 8 end as sr_no, 
                    year_of_completion, sum(total_carpet_area) as total_carpet_area, sum(sold_carpet_area) as sold_carpet_area, 
                    sum(unsold_carpet_area) as unsold_carpet_area, sum(total_units) as total_units, 
                    sum(sold_units) as sold_units, sum(unsold_units) as unsold_units from 
                (select case when date_of_completion is null then null 
                            when date_of_completion<'2017-07-01' then 'H1CY17' 
                            when date_of_completion<'2018-01-01' then 'H2CY17' when date_of_completion<'2018-07-01' then 'H1CY18' 
                            when date_of_completion<'2019-01-01' then 'H2CY18' when date_of_completion<'2020-01-01' then 'CY19' 
                            when date_of_completion<'2021-01-01' then 'CY20' 
                            when date_of_completion<'2022-01-01' then 'CY21' else 'CY22' end as year_of_completion, 
                    ifnull(total_carpet_area,0) as total_carpet_area, 
                    ifnull(sold_carpet_area,0) as sold_carpet_area, 
                    ifnull(unsold_carpet_area,0) as unsold_carpet_area, 
                    case when apartment_type_updated = 'Others' then 0 else number_of_apartment end as total_units, 
                    case when apartment_type_updated = 'Others' then 0 else no_of_booked_apartment end as sold_units, 
                    case when apartment_type_updated = 'Others' then 0 else unsold_units end as unsold_units 
                from apartment_details where status ='approved'" . $cond . $cond2 . ") A 
                group by year_of_completion 
                order by sr_no";
        $result = DB::select($sql);
        $completion_area = [];
        $completion_units = [];
        $year_of_completion_area_year = [];
        $sold_carpet_area_year = [];
        $unsold_carpet_area_year = [];
        $year_of_completion_units_year = [];
        $sold_units_year = [];
        $unsold_units_year = [];

        $j = 0;
        $k = 0;
        for($i=0; $i<count($result); $i++){
            $year_of_completion = $result[$i]->year_of_completion;
            $tot_carpet_area = $result[$i]->total_carpet_area;
            $tot_units = $result[$i]->total_units;
            $sold_carpet_area = $result[$i]->sold_carpet_area;
            $unsold_carpet_area = $result[$i]->unsold_carpet_area;
            $sold_units = $result[$i]->sold_units;
            $unsold_units = $result[$i]->unsold_units;

            if($tot_carpet_area>0){
                $sold_carpet_area = round($sold_carpet_area/100000,1);
                $unsold_carpet_area = round($unsold_carpet_area/100000,1);
            } else {
                $sold_carpet_area = 0;
                $unsold_carpet_area = 0;
            }
            if($tot_units>0){
                $sold_units = round($sold_units,1);
                $unsold_units = round($unsold_units,1);
            } else {
                $sold_units = 0;
                $unsold_units = 0;
            }

            if($total_carpet_area!=0){
                $total_carpet_area_per = round(($tot_carpet_area/$total_carpet_area)*100,0);
            } else {
                $total_carpet_area_per = 0;
            }
            if($total_units!=0){
                $total_units_per = round(($tot_units/$total_units)*100,0);
            } else {
                $total_units_per = 0;
            }
            $year_of_completion_area = $year_of_completion . ' <br>' . round($tot_carpet_area/100000,1) . ' <br>' . $total_carpet_area_per . '%';
            $year_of_completion_units = $year_of_completion . ' <br>' . $this->moneyFormatIndia($tot_units) . ' <br>' . $total_units_per . '%';

            if($sold_carpet_area>0 || $unsold_carpet_area>0){
                $completion_area[$j] = [$year_of_completion_area,$sold_carpet_area, $unsold_carpet_area];
                $year_of_completion_area_year[$j] = [ $year_of_completion_area ];
                $sold_carpet_area_year[$j] = [ $sold_carpet_area ];
                $unsold_carpet_area_year[$j] = [ $unsold_carpet_area ];
                $j = $j + 1;
            }
            if($sold_units>0 || $unsold_units>0){
                $completion_units[$k] = [$year_of_completion_units,$sold_units, $unsold_units];
                $year_of_completion_units_year[$k] = [ $year_of_completion_units ];
                $sold_units_year[$k] = [ $sold_units ];
                $unsold_units_year[$k] = [ $unsold_units ];
                $k = $k + 1;
            }
        }
        $data['completion_area'] = $completion_area;
        $data['completion_units'] = $completion_units;

        $data['year_of_completion_area_year']=$year_of_completion_area_year;
        $data['sold_carpet_area_year']=$sold_carpet_area_year;
        $data['unsold_carpet_area_year']=$unsold_carpet_area_year;

        $data['year_of_completion_units_year']=$year_of_completion_units_year;
        $data['sold_units_year']=$sold_units_year;
        $data['unsold_units_year']=$unsold_units_year;

        // $sql = "select sub_location, round(sum(total_carpet_area),0) as total_carpet_area, 
        //             round(sum(sold_carpet_area),0) as sold_carpet_area, 
        //             round(sum(total_carpet_area-sold_carpet_area),0) as unsold_carpet_area, 
        //             round(sum(no_of_apt),0) as total_units, round(sum(no_of_bk_apt),0) as sold_units, 
        //             round(sum(no_of_apt-no_of_bk_apt),0) as unsold_units from 
        //         (select A.project_sr_no, A.sub_location, B.carpet_area*B.number_of_apartment as total_carpet_area, 
        //             B.carpet_area*B.no_of_booked_apartment as sold_carpet_area, B.no_of_apt, 
        //             B.no_of_bk_apt from 
        //         (select distinct project_sr_no, sub_location from project_details where status ='approved'" . $cond . ") A 
        //         left join 
        //         (select project_sr_no, ifnull(carpet_area_sqft,0) as carpet_area, 
        //             ifnull(number_of_apartment,0) as number_of_apartment, 
        //             ifnull(no_of_booked_apartment,0) as no_of_booked_apartment, 
        //             ifnull(case when apartment_type_updated = 'Others' then 0 else number_of_apartment end,0) as no_of_apt, 
        //             ifnull(case when apartment_type_updated = 'Others' then 0 else no_of_booked_apartment end,0) as no_of_bk_apt 
        //         from apartment_details where status ='approved'" . $cond2 . ") B 
        //         on(A.project_sr_no = B.project_sr_no) 
        //         where B.project_sr_no is not null) C 
        //         group by sub_location";
        $sql = "select sub_location, sum(total_carpet_area) as total_carpet_area, sum(sold_carpet_area) as sold_carpet_area, 
                    sum(unsold_carpet_area) as unsold_carpet_area, 
                    sum(case when apartment_type_updated = 'Others' then 0 else number_of_apartment end) as total_units, 
                    sum(case when apartment_type_updated = 'Others' then 0 else no_of_booked_apartment end) as sold_units, 
                    sum(case when apartment_type_updated = 'Others' then 0 else unsold_units end) as unsold_units 
                from apartment_details where status ='approved'" . $cond . $cond2 . " 
                group by sub_location";
        $result = DB::select($sql);
        $subregion_area = [];
        $subregion_units = [];
        $sub_location_area_loc = [];
        $sold_carpet_area_loc = [];
        $unsold_carpet_area_loc = [];
        $sub_location_units_loc = [];
        $sold_units_loc = [];
        $unsold_units_loc = [];

        $j = 0;
        $k = 0;
        for($i=0; $i<count($result); $i++){
            $sub_location = $result[$i]->sub_location;
            $tot_carpet_area = $result[$i]->total_carpet_area;
            $tot_units = $result[$i]->total_units;
            $sold_carpet_area = $result[$i]->sold_carpet_area;
            $unsold_carpet_area = $result[$i]->unsold_carpet_area;
            $sold_units = $result[$i]->sold_units;
            $unsold_units = $result[$i]->unsold_units;

            if($tot_carpet_area>0){
                $sold_carpet_area = round($sold_carpet_area/100000,1);
                $unsold_carpet_area = round($unsold_carpet_area/100000,1);
            } else {
                $sold_carpet_area = 0;
                $unsold_carpet_area = 0;
            }
            if($tot_units>0){
                $sold_units = round($sold_units,1);
                $unsold_units = round($unsold_units,1);
            } else {
                $sold_units = 0;
                $unsold_units = 0;
            }
            
            if($total_carpet_area!=0){
                $total_carpet_area_per = round(($tot_carpet_area/$total_carpet_area)*100,0);
            } else {
                $total_carpet_area_per = 0;
            }
            if($total_units!=0){
                $total_units_per = round(($tot_units/$total_units)*100,0);
            } else {
                $total_units_per = 0;
            }
            $sub_location_area = $sub_location . ' <br>' . round($tot_carpet_area/100000,1) . ' <br>' . $total_carpet_area_per . '%';
            $sub_location_units = $sub_location . ' <br>' . $this->moneyFormatIndia($tot_units) . ' <br>' . $total_units_per . '%';

            if($sold_carpet_area>0 || $unsold_carpet_area>0){
                $subregion_area[$j] = [$sub_location_area,$sold_carpet_area, $unsold_carpet_area];
                $sub_location_area_loc[$j] = [ $sub_location_area ];
                $sold_carpet_area_loc[$j] = [ $sold_carpet_area ];
                $unsold_carpet_area_loc[$j] = [ $unsold_carpet_area ];
                $j = $j + 1;
            }
            if($sold_units>0 || $unsold_units>0){
                $subregion_units[$k] = [$sub_location_units,$sold_units, $unsold_units ];
                $sub_location_units_loc[$k] = [ $sub_location_units ];
                $sold_units_loc[$k] = [ $sold_units ];
                $unsold_units_loc[$k] = [ $unsold_units ];
                $k = $k + 1;
            }
        }
        $data['subregion_area'] = $subregion_area;
        $data['subregion_units'] = $subregion_units;

        $data['sub_location_area_loc']=$sub_location_area_loc;
        $data['sold_carpet_area_loc']=$sold_carpet_area_loc;
        $data['unsold_carpet_area_loc']=$unsold_carpet_area_loc;

        $data['sub_location_units_loc']=$sub_location_units_loc;
        $data['sold_units_loc']=$sold_units_loc;
        $data['unsold_units_loc']=$unsold_units_loc;

        // $sql = "select master_project_name, group_concat(id) as project_id, 
        //                 group_concat(project_name) as project_name, 
        //                 group_concat(location) as location, group_concat(pin_code) as project_name, 
        //                 group_concat(sub_location) as sub_location, 
        //                 round(sum(total_carpet_area),0) as total_carpet_area, 
        //                 round(sum(sold_carpet_area),0) as sold_carpet_area, 
        //                 round(sum(total_carpet_area)-sum(sold_carpet_area),0) as unsold_carpet_area, 
        //                 round(sum(number_of_apartment),0) as total_units, 
        //                 round(sum(no_of_booked_apartment),0) as sold_units, 
        //                 round(sum(number_of_apartment)-sum(no_of_booked_apartment),0) as unsold_units from 
        //         (select A.id, A.master_project_name, A.project_sr_no, A.project_name, A.location, A.pin_code, A.sub_location, 
        //                 builtup_area_in_proposed_fsi, builtup_area_in_approved_fsi, total_fsi, 
        //                 (B.carpet_area*B.number_of_apartment) as total_carpet_area, 
        //                 (B.carpet_area*B.no_of_booked_apartment) as sold_carpet_area, 
        //                 (B.number_of_apartment) as number_of_apartment, 
        //                 (B.no_of_booked_apartment) as no_of_booked_apartment from 
        //         (select id, master_project_name, project_sr_no, project_name, location, pin_code, sub_location from project_details 
        //             where status ='approved'" . $cond . ") A 
        //         left join 
        //         (select project_sr_no, carpet_area_sqft, number_of_apartment, no_of_booked_apartment from apartment_details 
        //                 where status ='approved') B 
        //         on(A.project_sr_no = B.project_sr_no) 
        //         group by A.id, A.master_project_name, A.project_sr_no, A.project_name, A.location, A.pin_code, A.sub_location) C";

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
        //                 from apartment_details where status ='approved'" . $cond2 . " group by project_sr_no) B 
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
                        from apartment_details where status ='approved'" . $cond2 . " group by project_sr_no) B 
                on(A.project_sr_no = B.project_sr_no) where B.project_sr_no is not null) C order by total_fsi desc limit 25";
        $result = DB::select($sql);
        $tbody = '';
        $blInsert = false;
        $tot_cnt=0;
        $total_fsi_tot=0;
        $approved_fsi_tot=0;
        $proposed_fsi_tot=0;
        $tot_carpet_area_tot=0;
        $sold_carpet_area_tot=0;
        $sold_carpet_area_per_tot=0;
        $tot_units_tot=0;
        $sold_units_tot=0;
        $sold_units_per_tot=0;
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

    function moneyFormatIndia($num) {
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
}