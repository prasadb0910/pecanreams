<?php

namespace App\Http\Controllers;

use App\Location_master;
use Illuminate\Http\Request;
use DB;
use Session;

class ProjectController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        // $this->middleware('CheckOtp');
    }

    public function index(){
        $sql = "select * from old_project_details where status='approved'";
        $projects = DB::select($sql);
        $data['projects'] = $projects;

        return view('project', $data);
    }

	
	 public function get_details($id){
       // $id = Crypt::decryptString($id);
     $sql = "select distinct location from location_master";
        $location = DB::select($sql);

        $sql = "select distinct sub_location from location_master";
        $sub_location = DB::select($sql);

        $sql = "select A.*, B.total_carpet_area, 
                case when B.total_carpet_area=0 then 0 else ifnull(A.total_fsi,0)/ifnull(B.total_carpet_area,0) end as fsi_to_carpet_area_ratio from 
                (select * from old_project_details where status = 'approved' and project_sr_no = '$id') A 
                left join 
                (select project_sr_no, sum(total_carpet_area) as total_carpet_area from old_apartment_details 
                    where status = 'approved' and project_sr_no = '$id' group by project_sr_no) B 
                on (A.project_sr_no = B.project_sr_no)";
        $project_details = DB::select($sql);
     
        if(count($project_details)>0){
            $project_sr_no = $project_details[0]->project_sr_no;
        } else {
            $project_sr_no = '';
        }
        
        $sql = "select * from old_property_details where status ='approved' and project_sr_no = '$project_sr_no'";
        $prop_details = DB::select($sql);
        $apt_details = array();
        $task_details = array();
        for($i=0; $i<count($prop_details); $i++){
            $property_sr_no = $prop_details[$i]->property_sr_no;
            $sql = "select * from old_apartment_details where status ='approved' and project_sr_no = '$project_sr_no' and 
                    property_sr_no = '$property_sr_no'";
            $apt_details[$i] = DB::select($sql);
            
            $sql = "select * from old_task_details where status ='approved' and project_sr_no = '$project_sr_no' and 
                    property_sr_no = '$property_sr_no'";
            $task_details[$i] = DB::select($sql);
        }

         $data['location'] = $location;
        $data['sub_location'] = $sub_location;
        $data['apt_details'] = $apt_details;
        $data['task_details'] = $task_details;
        $data['project_details'] = $project_details;
        $data['prop_details'] = $prop_details;

        return view('project_dtl', $data);
    }

	
	
	
  
	 public function save(Request $request)
    {	
	      
        $data = $request->all();
		      
       $id = $data['id'] ;

	
	DB::table('old_project_details')->where('id', $id)->update([

            'master_project_name'      => $request->input('master_project_name'),
            'developer_1'             => $request->input('developer_1'),
            'developer_2' => $request->input('developer_2'),
            'developer_3'      => $request->input('developer_3'),
            'developer_4'      => $request->input('developer_4'),
            'location'      => $request->input('location'),
            'sub_location'      => $request->input('sub_location'),
            'entity_type'      => $request->input('entity_type'),
           
        
    ]);
		
	   Session::flash('success_msg', 'Project Details updated successfully!');
	   return redirect('index.php/project/details/'.$id.'');   

 /*
        $user_id = auth()->user()->id;
        $data['updated_by'] = $user_id;
        $data['status'] = 'approved';
        if(isset($data['id'])){
			   DB::table('old_project_details')->whereIn('id', $data['id'])->update($request->all());
       
            Session::flash('success_msg', 'Project Details updated successfully!');
        } 

  return redirect('index.php');
    }*/
		   
}	

  
	 public function save1(Request $request)
    {	
        $data = $request->all();
		      
       $id = $data['id'] ; 
        
	DB::table('old_project_details')->where('id', $id)->update([
           'builtup_area_in_proposed_fsi'   => $request->input('builtup_area_in_proposed_fsi'),
            'builtup_area_in_approved_fsi'  => $request->input('builtup_area_in_approved_fsi'),
            'total_fsi'      => $request->input('total_fsi'),
            'total_carpet_area' => $request->input('total_carpet_area'),
            'fsi_to_carpet_area_ratio' => $request->input('fsi_to_carpet_area_ratio'),
              
       
    ]);
	  Session::flash('success_msg', 'FSI Details updated successfully!');
	  return redirect('index.php/project/details/'.$id.'');   
}




	 public function save2(Request $request)
    {	
        $data = $request->all();
		      
  
       $project_sr_no = $data['project_sr_no'] ; 
DB::table('old_apartment_details')->where('project_sr_no', $project_sr_no)->update([

            'apartment_type'      => $request->input('apartment_type'),
            'mistake_type'      => $request->input('mistake_type'),
            'apartment_type_updated' => $request->input('apartment_type_updated'),
            'carpet_area_sqft' => $request->input('carpet_area_sqft'),
            'number_of_apartment'      => $request->input('number_of_apartment'),
            'no_of_booked_apartment'      => $request->input('no_of_booked_apartment'),

           
        
    ]);
		
	
	    
Session::flash('success_msg', 'Appartment Details Updated Successfully!');
	  return redirect('index.php/project/details/'.$project_sr_no.'');   	   
}	



 public function Update()
 {
	
	 DB::table('old_project_details')
            ->where('id',4)
            ->update(['status' => notapproved]);
			 Session::flash('success_msg', 'Project List Updated!');
	  return redirect('index.php/project/'); 
 }


/*

      $master_project_name = $request->input('master_project_name');
      DB::update('update old_project_details set master_project_name = ? where id = ?',[$master_project_name,$id]);
      echo "Record updated successfully.<br/>";
   
	     return redirect('index.php');   
   }

}
  
	 public function save(Request $request)
    {	
        $data = $request->all();
      
       $id = $data['id'] ;
	
	DB::table('old_project_details')->where('id', 1)->update([
        [
            'master_project_name'      => $data['master_project_name'],
            'developer_1'             => $data['developer_1'],
            'developer_2' => $data['developer_2'],
            'developer_3'      => $data['developer_3'],
            'developer_4'      => $data['developer_4'],
            'location'      => $data['location'],
            'sub_location'      => $data['sub_location'],
	'entity_type'      => $data['entity_type'],
        
            
        ]
    ]);
	   return redirect('index.php');     
}	
*/
}