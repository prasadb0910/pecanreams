<?php include('db.php') ?>
<?php
    // $notice_type_id = $_POST['notice_type_id'];
    // $draw = $_GET['draw'];
    // $start = $_GET['start'];
    // $length = $_GET['length'];
    // $draw = $_POST['draw'];
    // $draw = 1;
    $notice_type = 'All';
	$notice_title = 'All';
	$notice_description = 'All';

    $notice_type_id = '1';
	$newspaper = '6';
	$from_date = '';
	$to_date = '';
	$keyword = '';
	$match_word = '';

    $result=mysqli_query($conn,"select * from pn_notice_types where status='approved' and id = '$notice_type_id'");
    if(count($result)>0){
		while ($row = mysqli_fetch_assoc($result)){
			$notice_type = $row['notice_type'];
			$notice_title = $row['title'];
			$notice_description = $row['description'];
		}
    }
    
	// if(isset($_POST["newspaper"])) {
	// 	$newspaper = $_POST["newspaper"];
	// } else {
	// 	$newspaper = '';
	// }
	// if(isset($_POST["from_date"])) {
	// 	$from_date = $_POST["from_date"];
	// } else {
	// 	$from_date = '';
	// }
	// if(isset($_POST["to_date"])) {
	// 	$to_date = $_POST["to_date"];
	// } else {
	// 	$to_date = '';
	// }
	// if(isset($_POST["keyword"])) {
	// 	$keyword = $_POST["keyword"];
	// } else {
	// 	$keyword = '';
	// }
	// if(isset($_POST["match_word"])) {
	// 	$match_word = $_POST["match_word"];
	// } else {
	// 	$match_word = '';
	// }

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
	if($match_word=='exact'){
		if($keyword!=''){
			$criteria = " ='".$keyword."' ";
		}
	} else {
		if($keyword!=''){
			$criteria = " like '%".$keyword."%' ";
		}
	}

	$notice_id = array();
	$i=0;
	if($criteria==''){
		$sql = "select A.* from pn_notices A where A.status = 'approved' " . $cond . " order by A.date_of_notice desc";

		// echo $sql;
		// echo '<br>';

		$result=mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_assoc($result)){
			$notice_id[$i++] = $row['id'];
		}
	} else {
		$sql = "select A.* from pn_notices A where A.status = 'approved' order by A.date_of_notice desc";
    	$result=mysqli_query($conn, $sql);
    	while ($row = mysqli_fetch_assoc($result)){
			$sql = "select distinct A.id from pn_notices A 
	                where A.id = '".$row['id']."' and A.status = 'approved' and 
	                	(A.city ".$criteria." or A.pincode ".$criteria." or A.property_type ".$criteria." or A.floor ".$criteria." or 
	                    A.wing ".$criteria." or A.building_name ".$criteria." or A.society_name ".$criteria." or A.address ".$criteria." or 
	                    A.property_description ".$criteria.") " . $cond;
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				goto Next;
			}

    		$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_location_details B on (A.id = B.fk_notice_id) 
	                where A.id = '".$row['id']."' and A.status = 'approved' and 
	                	(B.location ".$criteria.") " . $cond;
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				goto Next;
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_property_no_details C on (A.id = C.fk_notice_id) 
	                where A.id = '".$row['id']."' and A.status = 'approved' and 
	                	(C.property_no ".$criteria.") " . $cond;
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				goto Next;
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_certificate_no_details D on (A.id = D.fk_notice_id) 
	                where A.id = '".$row['id']."' and A.status = 'approved' and 
	                	(D.certificate_no ".$criteria.") " . $cond;
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				goto Next;
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_legal_owner_names E on (A.id = E.fk_notice_id) 
	                where A.id = '".$row['id']."' and A.status = 'approved' and 
	                	(E.legal_owner_name ".$criteria.") " . $cond;
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				goto Next;
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_purchased_froms F on (A.id = F.fk_notice_id) 
	                where A.id = '".$row['id']."' and A.status = 'approved' and 
	                	(F.purchased_from ".$criteria.") " . $cond;
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				goto Next;
			}

			$sql = "select distinct A.id from pn_notices A 
	                left join pn_notice_company_names G on (A.id = G.fk_notice_id) 
	                where A.id = '".$row['id']."' and A.status = 'approved' and 
	                	(G.company_name ".$criteria.") " . $cond;
			$result2=mysqli_query($conn, $sql);
			if(count($result2)>0){
				while ($row2 = mysqli_fetch_assoc($result2)){
					$notice_id[$i++] = $row2['id'];
				}
				goto Next;
			}

			Next:
    	}
    }

    $notice = array();
    if(count($notice_id)>0){
    	$sql = "select * from pn_notices where status='approved' and id in (".implode(',', $notice_id).")";
    	$notice=mysqli_query($conn, $sql);
    }

    $notice_data = array();
    if(count($notice)>0){
    	foreach($notice as $data){
    		$row = array(
    					'image'=>'<a href="admin/public/uploads/notices/'.$data['notice_file'].'" target="_new">
                    	<img src="admin/public/uploads/notices/'.$data['notice_file'].'" style="width: 120px; height: 135px;">
                        </a>',
                        'title'=>'<div style="font-weight: bold; font-size: 15px;">'.$data['notice_title'].'</div>
                        <div>'.date('d/m/Y',strtotime($data['date_of_notice'])).'</div>
                        <div style="line-height: 15px;">'.$data['address'].'</div>
                        <div><a href="admin/public/uploads/notices/'.$data['notice_file'].'" target="_new">Read More</a></div>'
                    );
    		// $row = array();
      //       $row[] = $data['id'];
            // $row[] = $data['notice_title'];

    		// $notice_data[] = array($data['notice_file'], $data['notice_title']);

    		$notice_data[] = $row;
    	}
    }

	// $output = array(
	//             "draw" => $draw,
	//             "recordsTotal" => count($notice_data),
	//             "recordsFiltered" => count($notice_data),
	//             "data" => $notice_data
	//         );

	$output = array(
			 	"sEcho" => 1,
				"iTotalRecords" => count($notice_data),
				"iTotalDisplayRecords" => count($notice_data),
				"aaData"=>$notice_data
			);

	// $output = array(
	//             "draw" => $draw,
	//             "recordsTotal" => 1,
	//             "recordsFiltered" => 1,
	//             "data" => array('1','aaaa')
	//         );

    echo json_encode($output);
    // echo $output;

 //    $result = [
	// 			"draw"=> $draw,
	// 			"recordsTotal"=> 1,
	// 			"recordsFiltered"=> 1,
	// 			"data"=> [
	// 						[
	// 							"Airi",
	// 							"Satou"
	// 						]
	// 					]
	// 		];
	// echo json_encode($result);
?>