<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use DateTime;
use Session;
use Mail;

class IdataLogController extends Controller
{
	
	 public function get_list()
	 {
	 	 //$user = new User();
        //$access = $user->get_access();

         $sql = "Select * from (Select u.*,
					if(g.first_name!='',g.first_name,g.gu_email) as username
					from user_tracking u left join group_users g on u.user_id=g.gu_id ) as E Order by E.track_id DESC";
         $assure_track = DB::select($sql);
         $data['assure_track'] = $assure_track;
          return view('idatalog',$data);
         
	 }	

}
?>