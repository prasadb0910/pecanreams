<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use DateTime;
use Session;
use Mail;

class LogController extends Controller
{
	
	 public function get_list($id='')
	 {
	 	 //$user = new User();
        //$access = $user->get_access();
/*
         $sql = "Select * from (
					Select u.track_id,u.ip_address,u.user_id,u.searched_from,u.search_type,u.type_id,u.type_text,u.searched_on,
					u.module_name,u.action,u.match_keyword,u.newspaper,
					if(g.first_name!='',g.first_name,g.gu_email) as username, 
					 u.type_id as type_name , 
					if(u.start_date IS NOT NULL ,u.start_date,'NA') as start_date, if(u.end_date IS NOT NULL ,u.end_date,'NA') as end_date, 
					newspaper as newspapers 
					from user_tracking_assure u left join group_users g on u.user_id=g.gu_id ) as E Order by E.track_id DESC Union Select * ,'' as newspapers,'' as start_date,'' as end_date  from (Select u.*,
					if(g.first_name!='',g.first_name,g.gu_email) as username
					from user_tracking u left join group_users g on u.user_id=g.gu_id ) as E Order by E.track_id DESC";*/

		if($id==1)
		{
			$sql = "Select u.track_id,u.ip_address,u.user_id,u.searched_from,u.search_type,u.type_id as 	type_name,u.type_text,u.searched_on,
			u.module_name,u.action,u.match_keyword,u.newspaper as newspapers,
			if(u.user_id IS NOT NULL ,(Select if(g.first_name!='',g.first_name,g.gu_email) as name from group_users g Where g.gu_id=user_id ) , '') as username,
			if(u.start_date IS NOT NULL ,u.start_date,'NA') as start_date, if(u.end_date IS NOT NULL ,u.end_date,'NA') as end_date, 
			'' as property_type , '' as entity_type , 'Assure' as model_type
			from user_tracking_assure u  Order By u.searched_on DESC ";	
		}
		else if($id==2)
		{
				$sql = "
				Select u.track_id,u.ip_address,u.user_id,u.searched_from,u.search_type, '' as type_name,u.type_text,u.searched_on,
				u.module_name,u.action,'' as match_keyword, '' as  newspapers,
				if(u.user_id IS NOT NULL ,(Select if(g.first_name!='',g.first_name,g.gu_email) as name from group_users g Where g.gu_id=user_id ) , '') as username, '' as start_date,'' as end_date,property_type,entity_type , 'Idata' as model_type
				from user_tracking u Order By u.searched_on DESC ";	
		}
		else{
			$id = "";
			$sql = "Select * from (Select u.track_id,u.ip_address,u.user_id,u.searched_from,u.search_type,u.type_id as 	type_name,u.type_text,u.searched_on,
				u.module_name,u.action,u.match_keyword,u.newspaper as newspapers,
				if(u.user_id IS NOT NULL ,(Select if(g.first_name!='',g.first_name,g.gu_email) as name from group_users g Where g.gu_id=user_id ) , '') as username, 
				if(u.start_date IS NOT NULL ,u.start_date,'NA') as start_date, if(u.end_date IS NOT NULL ,u.end_date,'NA') as end_date, 
				'' as property_type , '' as entity_type , 'Assure' as model_type
				from user_tracking_assure u 
				Union 
				Select u.track_id,u.ip_address,u.user_id,u.searched_from,u.search_type, '' as type_name,u.type_text,u.searched_on,
				u.module_name,u.action,'' as match_keyword, '' as  newspapers,
				if(u.user_id IS NOT NULL ,(Select if(g.first_name!='',g.first_name,g.gu_email) as name from group_users g Where g.gu_id=user_id ) , '') as username, '' as start_date,'' as end_date,property_type,entity_type , 'Idata' as model_type
				from user_tracking u ) as E Order By E.searched_on DESC";	
		}			
				
         $assure_track = DB::select($sql);
         $data['assure_track'] = $assure_track;
         $data['model_type'] = $id;
          return view('log',$data);
         
	 }	

}
?>