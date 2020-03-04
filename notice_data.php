<?php 
	include_once('db.php');

	$params = $columns = $totalRecords = $data = array();
	$params = $_REQUEST;
	$ip_address =  $_SERVER['REMOTE_ADDR'];
	$date = date("Y-m-d H:i:s");

	// $params['draw'] = 1;
	// $params['start'] = 0;
	// $params['length'] = 10;
	// $params['notice_type_id'] = 0;
	// $params['newspaper'] = 'All';
	// $params['keyword'] = 'ABC';
	// $params['match_word'] = "any";
	
	if(isset($params['notice_type_id'])) {
		$notice_type_id = $params['notice_type_id'];
	} else {
		$notice_type_id = '';
	}
	if(isset($params['newspaper'])) {
		$newspaper = $params['newspaper'];
	} else {
		$newspaper = '';
	}
	if(isset($params['from_date'])) {
		$from_date = $params['from_date'];
	} else {
		$from_date = '';
	}
	if(isset($params['to_date'])) {
		$to_date = $params['to_date'];
	} else {
		$to_date = '';
	}
	if(isset($params['keyword'])) {
		$keyword = $params['keyword'];
	} else {
		$keyword =  "" ;
	}
	if(isset($params['match_word'])) {
		$match_word = $params['match_word'];
	} else {
		$match_word = "";
	}
	if(isset($params['search']['value'])) {
		$search_value = $params['search']['value'];
	} else {
		$search_value = '';
	}

	$cond = "";

	if(isset($notice_type_id)){
		if($notice_type_id>0){
			$cond = $cond . " and A.fk_notice_type_id = '$notice_type_id'";
		}
	}

	if($newspaper!="All" && $newspaper!=""){
		$cond = $cond . " and A.fk_newspaper_id = '$newspaper'";
	}
	if($from_date!=""){
		$returnDate = null;
        $dateInput = explode('/',$from_date);
        $returnDate = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
        $from_date = $returnDate;
        if($from_date!=null){
        	$cond = $cond . " and A.date_of_notice >= '$from_date'";
        }
	}
	if($to_date!=""){
		$returnDate = null;
        $dateInput = explode('/',$to_date);
        $returnDate = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
        $to_date = $returnDate;
        if($to_date!=null){
        	$cond = $cond . " and A.date_of_notice <= '$to_date'";
        }
	}

	$criteria = "";
	$match = "";

	

	if($match_word=='exact'){
		if($keyword!=''){
			$criteria = " ='".$keyword."' ";
		
		}
	} else {
		if($keyword!=''){
			$criteria = " like '%".$keyword."%' ";
		}
	}

	if(isset($_POST['noticetypetext']))
		$noticetypetext =  $_POST['noticetypetext'];
	else
		$noticetypetext =  '';

	
	if(isset($_POST['newspapertext']))
		$newspapertext =  $_POST['newspapertext'];
	else
		$newspapertext =  '';	
	

	$sql2 = "INSERT INTO 
	 		user_tracking_assure (ip_address,searched_from,search_type,type_id,type_text,module_name,searched_on,action,start_date,end_date,match_keyword,newspaper)
			VALUES ('$ip_address', 'Web Page','Notice Type','$noticetypetext','$keyword','Search Notice','$date','Clicked On Search Data','$from_date','$to_date','$match_word','$newspapertext')";
	$conn->query($sql2);

	$notice_id = array();
	$i=0;
	if($criteria==''){
		$posts = [];
		$sql = "select A.id from pn_notices A where A.status = 'approved' " . $cond;
		$result=mysqli_query($conn, $sql);
		while($row = mysqli_fetch_array($result)) {
		    $posts[] = $row['id'];
		}

		if(count($posts)>0)
		{
			$ids =  implode(",", $posts);
		}
		else
		{
			$ids =  0;
		}

		$sql = "select distinct A.id from pn_notices A 
                where A.id in ($ids) and A.status = 'approved' and 
                	(A.city like '%".$search_value."%' or A.pincode like '%".$search_value."%' or A.property_type like '%".$search_value."%' or 
					A.floor like '%".$search_value."%' or A.wing like '%".$search_value."%' or A.building_name like '%".$search_value."%' or 
					A.society_name like '%".$search_value."%' or A.address like '%".$search_value."%'  or A.property_description like '%".$search_value."%'  or A.notice_title like '%".$search_value."%' or A.state like '%".$search_value."%')";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
			}

    		$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_location_details B on (A.id = B.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and B.location like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_property_no_details C on (A.id = C.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and C.property_no like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_certificate_no_details D on (A.id = D.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and D.certificate_no like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_legal_owner_names E on (A.id = E.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and E.legal_owner_name like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_purchased_froms F on (A.id = F.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and F.purchased_from like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_company_names G on (A.id = G.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and G.company_name like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
			}

		/*
			$sql = "select A.* from pn_notices A where A.status = 'approved' " . $cond;

			$result=mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_assoc($result)){
			$sql = "select distinct A.id from pn_notices A 
	                where A.id in ($ids) and A.status = 'approved' and 
	                	(A.city like '%".$search_value."%' or A.pincode like '%".$search_value."%' or A.property_type like '%".$search_value."%' or 
						A.floor like '%".$search_value."%' or A.wing like '%".$search_value."%' or A.building_name like '%".$search_value."%' or 
						A.society_name like '%".$search_value."%' or A.address like '%".$search_value."%' or 
						A.property_description like '%".$search_value."%')";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				goto Next1;
			}

    		$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_location_details B on (A.id = B.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and B.location like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				goto Next1;
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_property_no_details C on (A.id = C.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and C.property_no like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				goto Next1;
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_certificate_no_details D on (A.id = D.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and D.certificate_no like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				goto Next1;
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_legal_owner_names E on (A.id = E.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and E.legal_owner_name like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				goto Next1;
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_purchased_froms F on (A.id = F.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and F.purchased_from like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				goto Next1;
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_company_names G on (A.id = G.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and G.company_name like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				goto Next1;
			}

			Next1:
			}
		*/
	} else {

		$sql = "select A.id from pn_notices A where A.status = 'approved' " . $cond;
		$result=mysqli_query($conn, $sql);
		$posts = [];
		while($row = mysqli_fetch_array($result)) {
		    $posts[] = $row['id'];
		}

		if(count($posts)>0)
		{
			$ids =  implode(",", $posts);
		}
		else
		{
			$ids =  0;
		}
		

		 $sql = "select distinct A.id from pn_notices A 
	                where A.id  in ($ids) and A.status = 'approved' and 
	                	(A.city ".$criteria." or A.pincode ".$criteria." or A.property_type ".$criteria." or A.floor ".$criteria." or 
	                    A.wing ".$criteria." or A.building_name ".$criteria." or A.society_name ".$criteria." or A.address ".$criteria." or 
	                    A.property_description ".$criteria." or A.notice_title ".$criteria."
	              		  or A.state ".$criteria." ) and 
						(A.city like '%".$search_value."%' or A.pincode like '%".$search_value."%' or A.property_type like '%".$search_value."%' or 
						A.floor like '%".$search_value."%' or A.wing like '%".$search_value."%' or A.building_name like '%".$search_value."%' or 
						A.society_name like '%".$search_value."%' or A.address like '%".$search_value."%' or A.property_description like '%".$search_value."%' or A.notice_title like '%".$search_value."%' or A.state like '%".$search_value."%')";

			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0)
			{
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				/*if(count($notice_id)>0)
				{
					goto Next2;
				}*/
				
			}


    		$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_location_details B on (A.id = B.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and 
	                	B.location ".$criteria." and B.location like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				/*if(count($notice_id)>0)
				{
					goto Next2;
				}*/
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_property_no_details C on (A.id = C.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and 
	                	C.property_no ".$criteria." and C.property_no like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				/*if(count($notice_id)>0)
				{
					goto Next2;
				}*/
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_certificate_no_details D on (A.id = D.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and 
	                	D.certificate_no ".$criteria." and D.certificate_no like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				/*if(count($notice_id)>0)
				{
					goto Next2;
				}*/
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_legal_owner_names E on (A.id = E.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and 
	                	E.legal_owner_name ".$criteria." and E.legal_owner_name like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				/*if(count($notice_id)>0)
				{
					goto Next2;
				}*/
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_purchased_froms F on (A.id = F.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and 
	                	F.purchased_from ".$criteria." and F.purchased_from like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				/*if(count($notice_id)>0)
				{
					goto Next2;
				}*/
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_company_names G on (A.id = G.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and 
	                	G.company_name ".$criteria." and G.company_name like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				/*if(count($notice_id)>0)
				{
					goto Next2;
				}*/
			}

		/*	$sql = "select A.* from pn_notices A where A.status = 'approved' " . $cond;
	    	$result=mysqli_query($conn, $sql);
	    	while ($row = mysqli_fetch_assoc($result)){

			$sql = "select distinct A.id from pn_notices A 
	                where A.id in ($ids) and A.status = 'approved' and 
	                	(A.city ".$criteria." or A.pincode ".$criteria." or A.property_type ".$criteria." or A.floor ".$criteria." or 
	                    A.wing ".$criteria." or A.building_name ".$criteria." or A.society_name ".$criteria." or A.address ".$criteria." or 
	                    A.property_description ".$criteria.") and 
						(A.city like '%".$search_value."%' or A.pincode like '%".$search_value."%' or A.property_type like '%".$search_value."%' or 
						A.floor like '%".$search_value."%' or A.wing like '%".$search_value."%' or A.building_name like '%".$search_value."%' or 
						A.society_name like '%".$search_value."%' or A.address like '%".$search_value."%' or 
						A.property_description like '%".$search_value."%')";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				if(count($notice_id)>0)
				{
					goto Next2;
				}	
				
			}

    		$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_location_details B on (A.id = B.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and 
	                	B.location ".$criteria." and B.location like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				goto Next2;
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_property_no_details C on (A.id = C.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and 
	                	C.property_no ".$criteria." and C.property_no like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				if(count($notice_id)>0)
				{
					goto Next2;
				}
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_certificate_no_details D on (A.id = D.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and 
	                	D.certificate_no ".$criteria." and D.certificate_no like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				if(count($notice_id)>0)
				{
					goto Next2;
				}
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_legal_owner_names E on (A.id = E.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and 
	                	E.legal_owner_name ".$criteria." and E.legal_owner_name like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				if(count($notice_id)>0)
				{
					goto Next2;
				}
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_purchased_froms F on (A.id = F.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and 
	                	F.purchased_from ".$criteria." and F.purchased_from like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				if(count($notice_id)>0)
				{
					goto Next2;
				}
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_company_names G on (A.id = G.fk_notice_id) 
	                where A.id in ($ids) and A.status = 'approved' and 
	                	G.company_name ".$criteria." and G.company_name like '%".$search_value."%'";
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				if(count($notice_id)>0)
				{
					goto Next2;
				}
			}

			Next2:
    	}*/
    }
    
 	
    // $totalRecords = 0;
    // if(count($notice_id)>0){
    // 	$sql = "select count(id) as tot_cnt from pn_notices where status='approved' and id in (".implode(',', $notice_id).")";
    // 	$queryTot=mysqli_query($conn, $sql);
    // 	// $totalRecords = mysqli_num_rows($queryTot);
    // 	if(count($queryTot)>0){
    // 		foreach($queryTot as $data){
    // 			$totalRecords = $data['tot_cnt'];
    // 		}
    // 	}
    // }

    $totalRecords = count($notice_id);
    
    $notice = array();
    if(count($notice_id)>0){
    	$sql = "select id, date_of_notice, address, notice_file, notice_title from pn_notices where status='approved' and id in (".implode(',', $notice_id).") order by date_of_notice desc 
				LIMIT ".$params['start'].", ".$params['length'];
    	$notice=mysqli_query($conn, $sql);
    }

    $notice_data = array();
    if(count($notice)>0){
    	foreach($notice as $data){
    		$row = array(
                        '<a href="'.$base_url.'/admin/assure/public/uploads/notices/'.$data['notice_file'].'" target="_new">
                    	<img src="'.$base_url.'/admin/assure/public/uploads/notices/'.$data['notice_file'].'" style="width: 120px; height: 135px;">
                        </a>',
                        '<div style="font-weight: bold; font-size: 15px;">'.$data['notice_title'].'</div>
                        <div>'.date('d/m/Y',strtotime($data['date_of_notice'])).'</div>
                        <div style="line-height: 15px;">'.$data['address'].'</div>
                        <div><a href="'.$base_url.'/admin/assure/public/uploads/notices/'.$data['notice_file'].'" target="_new">Read More</a></div>'
                    );
    		$notice_data[] = $row;
    	}
    }

	$json_data = array(
				"draw"            => intval( $params['draw'] ),   
				"recordsTotal"    => intval($totalRecords),  
				"recordsFiltered" => intval($totalRecords),
				"data"            => $notice_data
				);

	echo json_encode($json_data);
?>