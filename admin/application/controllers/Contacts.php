<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Contacts extends CI_Controller
{
    public function __construct() {
        parent::__construct();
       
        $this->load->helper('common_functions');
        $this->load->model('contact_model');
        $this->load->model('document_model');
    }

    public function index(){
        $roleid=$this->session->userdata('role_id');
        //echo '<script>alert('.$roleid.')</script>';
        $data=$this->contact_model->getContactDetails($roleid);
        if(count($data) > 0){
            load_view('contacts/contact_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    
    public function addnew($location=NULL){
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $gid=$this->session->userdata('groupid');

            // $query=$this->db->query("select d_type_id, d_type, d_m_status, '' as doc_doc_id, '' as doc_documentname, 
            //                         '' as doc_description, '' as doc_ref_no, '' as doc_doi, 
            //                         '' as doc_doe, '' as doc_document, '' as document_name 
            //                         from document_type_master");
            // $result=$query->result();
            // $data['documents']=$result;

            // for($i=0; $i<count($result); $i++){
            //     $d_type_id = $result[$i]->d_type_id;

            //     $query=$this->db->query("select A.d_id, B.d_documentname from 
            //                             (select * from document_types where d_type_id='$d_type_id') A 
            //                             left join 
            //                             (select * from document_master) B 
            //                             on (A.d_id=B.d_id)");

            //     $data['docs'][$d_type_id]=$query->result();
            // }
            
            $data=$this->document_model->add_new_doc('d_cat_individual');


            // $query=$this->db->query("select d_type, d_documentname as kyc_doc_name, d_description as kyc_doc_desc, 
            //                         '' as kyc_doc_ref,'' as kyc_issuedate, '' as kyc_expirydate,'' as kyc_document, 
            //                         '' as kyc_document_name, d_show_expiry_date from document_master 
            //                         where d_cat_individual='Yes'");
            // $result=$query->result();
            // $data['editcontdoc']=$result;

            // $query=$this->db->query("SELECT * FROM document_master WHERE d_type like '%ID Proof%' AND d_cat_individual='Yes'");
            // $result=$query->result();
            // $data['id_proof_doc']=$result;

            // $query=$this->db->query("SELECT * FROM document_master WHERE d_type like '%Address Proof%' AND d_cat_individual='Yes'");
            // $result=$query->result();
            // $data['address_proof_doc']=$result;

            // $query=$this->db->query("SELECT * FROM document_master WHERE d_type like '%Others%' AND d_cat_individual='Yes'");
            // $result=$query->result();
            // $data['other_doc']=$result;

            $query=$this->db->query("SELECT * FROM contact_type_master WHERE g_id = '$gid' order by contact_type");
            $result=$query->result();
            $data['contact_type']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('contacts/contact_details', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function saveContact(){
        $roleid=$this->session->userdata('role_id');
		$curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $now=date('Y-m-d H:i:s');

            $maker_checker = $this->session->userdata('maker_checker');
            if($maker_checker!='yes'){
                $c_status='Approved';
            } else {
                $c_status='In Process';
            }
            
            if ($this->input->post('con_last_name')!=""){
                $data = array(
                            'c_name' => $this->input->post('con_first_name'),
                            'c_middle_name' => $this->input->post('con_middle_name'),
                            'c_last_name' =>  $this->input->post('con_last_name'),
                            'c_emailid1' => $this->input->post('con_email_id1'),
                            'c_mobile1' => $this->input->post('con_mobile_no1'),
                            'c_status' => $c_status,
                            'c_gid' => $this->session->userdata('groupid'),
                            'c_createdate' => $now,
                            'c_createdby' => $curusr,
                            'c_modifieddate' => $now,
                            'maker_remark'=>$this->input->post('maker_remark')
                        );
                $this->db->insert('contact_master',$data);
                $cid=$this->db->insert_id();
                $logarray['table_id']=$cid;
                $logarray['module_name']='Contact';
                $logarray['cnt_name']='contacts';
                $logarray['action']='Contact Record Inserted';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);

                // $data = array(
                //             // 'gu_name' => $this->input->post('con_first_name'),
                //             'gu_email' => $this->input->post('con_email_id1'),
                //             // 'gu_mobile' => $this->input->post('con_mobile_no1'),
                //             'gu_role' => 'User',
                //             'gu_cid' => $cid,
                //             'gu_gid' => $this->session->userdata('groupid'),
                //             'add_date' => $now,
                //             'create_date' => $now,
                //             'create_by' => $curusr,
                //             'modified_date' => $now,
                //         );
                // $this->db->insert('group_users', $data);
                
                echo $cid;
            }
            
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function saveRecord(){
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $now=date('Y-m-d H:i:s');
            if($this->input->post('date_of_birth')!='') {
                $dob=FormatDate($this->input->post('date_of_birth'));
            } else {
                $dob=NULL;
            }
            if($this->input->post('date_of_anniversary')!='') {
                $doe=FormatDate($this->input->post('date_of_anniversary'));
            } else {
                $doe=NULL;
            }
            if($this->input->post('submit')=='Submit For Approval') {
                $c_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $c_status='Approved';
            } else {
                $c_status='In Process';
            }
            if($this->input->post('type')=='Others'){
                $c_last_name = $this->input->post('owner_type');
            } else {
                $c_last_name = $this->input->post('c_last_name');
            }

            if ($this->input->post('c_name')!=""){
                $data = array(
                    'c_name' => $this->input->post('c_name'),
                    'c_company' => $this->input->post('company'),
                    'c_middle_name' => $this->input->post('c_middle_name'),
                    'c_last_name' =>  $c_last_name,
                    'c_dob' => $dob ,
                    'c_anniversarydate' => $doe,
                    'c_gender' => $this->input->post('gender'),
                    'c_designation' => $this->input->post('designation'),
                    'c_guardian' => $this->input->post('guardian'),
                    'c_relation' => $this->input->post('guardian_relation'),
                    'c_address' => $this->input->post('address'),
                    'c_landmark' => $this->input->post('landmark'),
                    'c_state' => $this->input->post('state'),
                    'c_city' => $this->input->post('city'),
                    'c_country' => $this->input->post('country'),
                    'c_pincode' => $this->input->post('pincode'),
                    'c_emailid1' => $this->input->post('email_id1'),
                    'c_emailid2' => $this->input->post('email_id2'),
                    'c_mobile1' => $this->input->post('mobile_no1'),
                    'c_mobile2' => $this->input->post('mobile_no2'),
                    'c_type' => $this->input->post('type'),
                    'c_kyc_required' => $this->input->post('kyc'),
                    'c_contact_type' => (is_numeric($this->input->post('contact_type'))?$this->input->post('contact_type'):null),
                    'c_pan_card' => $this->input->post('pan_card'),
                    'c_status' => $c_status,
                    'c_gid' => $this->session->userdata('groupid'),
                    'c_createdate' => $now,
    				'c_createdby' => $curusr,
                    'c_modifieddate' => $now,
                    'c_modifiedby' => $curusr,
                    'maker_remark' => $this->input->post('maker_remark')
                );

                $this->db->insert('contact_master',$data);
                $cid=$this->db->insert_id();
                $logarray['table_id']=$cid;
                $logarray['module_name']='Contact';
                $logarray['cnt_name']='contacts';
                $logarray['action']='Contact Record Inserted';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);

                // $data = array (
                //     // 'gu_name' => $this->input->post('c_name'),
                //     // 'gu_designation' => $this->input->post('designation'),
                //     // 'gu_mobile' => $this->input->post('mobile_no1'),
                //     'gu_email' => $this->input->post('email_id1'),
                //     'gu_role' => 'User',
                //     'gu_cid' => $cid,
                //     'gu_gid' => $this->session->userdata('groupid'),
                //     'add_date' => $now,
                //     'create_by' => $curusr,
                //     'create_date' => $now,
                //     'assigned_status' => $c_status,
                //     'modified_date' => $now,
                //     'modified_by' => $curusr
                // );  

                // $this->db->insert('group_users', $data);

                if($this->input->post('kyc')=="1") {
                    // $doctype=$this->input->post('doc_type[]');
                    // $docname=$this->input->post('doc_name[]');
                    // $docdesc=$this->input->post('doc_desc[]');
                    // $docref=$this->input->post('ref_no[]');
                    // $docdoi=$this->input->post('date_issue[]');
                    // $docdoe=$this->input->post('date_expiry[]');

                    // $doccnt=0;

                    // for ($k=0; $k <  count($docname); $k++) {
                    //     if(isset($docname[$k]) and $docname[$k]!="") {
                    //         // $docname=str_replace('/', '_', $docname);
                    //         $docname[$k]=str_replace('/', '_', $docname[$k]);
                            
                    //         if($docdoe[$k]=="") {
                    //             $doe = NULL;
                    //         } else {
                    //             $doe = FormatDate($docdoe[$k]);
                    //         }

                    //         if($docdoi[$k]=="") {
                    //             $doi = NULL;
                    //         } else {
                    //             $doi = FormatDate($docdoi[$k]);
                    //         }

                    //         $filePath='uploads/client/';
                    //         $upload_path = './' . $filePath;
                    //         if(!is_dir($upload_path)) {
                    //             mkdir($upload_path, 0777, TRUE);
                    //         }
                    //         $filePath='uploads/client/client_'.$cid.'/';
                    //         $upload_path = './' . $filePath;
                    //         if(!is_dir($upload_path)) {
                    //             mkdir($upload_path, 0777, TRUE);
                    //         }

                    //         $confi['upload_path']=$upload_path;
                    //         $confi['allowed_types']='*';
                    //         $this->load->library('upload', $confi);
                    //         $extension="";

                    //         // $file_nm='doc_'.$k;
                    //         $file_nm='doc_'.$doccnt;

                    //         while (!isset($_FILES[$file_nm]['name'])) {
                    //             $doccnt = $doccnt + 1;
                    //             $file_nm = 'doc_'.$doccnt;
                    //         }

                    //         if(!empty($_FILES[$file_nm]['name'])) {
                    //             if($this->upload->do_upload($file_nm)) {
                    //                 echo "Uploaded <br>";
                    //             } else {
                    //                 echo "Failed<br>";
                    //                 echo $this->upload->data();
                    //             }   

                    //             $upload_data=$this->upload->data();
                    //             $fileName=$upload_data['file_name'];
                    //             $extension=$upload_data['file_ext'];
                                
                    //             $data = array(
                    //                 'kyc_cid' => $cid,
                    //                 'kyc_doc_type' => $doctype[$k],
                    //                 'kyc_doc_name' => $docname[$k],
                    //                 'kyc_doc_desc' => $docdesc[$k],
                    //                 'kyc_doc_ref' => $docref[$k],
                    //                 'kyc_issuedate' => $doi,
                    //                 'kyc_expirydate' => $doe,
                    //                 'kyc_document' => $filePath.$fileName,
                    //                 'kyc_document_name' => $fileName,
                    //             );
                    //             $this->db->insert('contact_kyc_details', $data);
                    //             echo "Main<br>";
                    //         } else {
                    //             echo "Other<br>";
                    //             $data = array(
                    //                 'kyc_cid' => $cid,
                    //                 'kyc_doc_type' => $doctype[$k],
                    //                 'kyc_doc_name' => $docname[$k],
                    //                 'kyc_doc_desc' => $docdesc[$k],
                    //                 'kyc_doc_ref' => $docref[$k],
                    //                 'kyc_issuedate' => $doi,
                    //                 'kyc_expirydate' => $doe,
                    //                 'kyc_document' => '',
                    //                 'kyc_document_name' => '',
                    //             );
                    //             $this->db->insert('contact_kyc_details', $data);
                    //         }
                    //     }

                    //     $doccnt = $doccnt + 1;
                    // }

                    $this->document_model->insert_doc($cid, 'Contacts');

                    $nominee=$this->input->post('nm_name[]');
                    $relation=$this->input->post('nm_relation[]');

                    for ($i=0; $i < count($nominee) ; $i++) { 
                        $data = array(
                            'nm_cid' => $cid,
                            'nm_name' => $nominee[$i],
                            'nm_relation' => $relation[$i]
                        );    

                        $this->db->insert('contact_nominee_details',$data);
                    }
                    
                }
            }

            redirect(base_url().'index.php/Contacts');
            
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function viewrecord($cid) {
		$roleid=$this->session->userdata('role_id');
		$query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1  or $result[0]->r_approvals==1 ) {
                $gid=$this->session->userdata('groupid');
                $data['access']=$result;
			}
		}
		
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' and r_view=1");
        $result=$query->result();
        if(count($result)>0) {
            $gid=$this->session->userdata('groupid');
            $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
            $result=$query->result();
            $data['contacts']=$result;
			
			//$data['contactby']=($result[0]->c_modifiedby=='')?$result[0]->c_createdby:$result[0]->c_modifiedby;
			$data['contactby']=$this->session->userdata('session_id');
            //$data['contactby']=$result[0]->c_createdby;
            $query=$this->db->query("SELECT * FROM contact_master WHERE c_id='$cid'");
            $result=$query->result();
            $data['editcontact']=$result;

            if(count($result)>0){
                $gd=$result[0]->c_guardian;
                if($gd!='Select') {
                    $query=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$gd'");
                    $result=$query->result();
                    if(count($result)>0) {
                        $data['guardian']=$result[0]->c_name . ' ' . $result[0]->c_last_name . ' - ' . $result[0]->c_emailid1 . ' - ' . $result[0]->c_mobile1 . ' - ' . $result[0]->c_company;
                    }
                }
            }
            

            // $query=$this->db->query("SELECT * FROM contact_kyc_details WHERE kyc_cid='$cid' order by kyc_id");
            // $result=$query->result();
            // if(count($result)>0) {
            //     $data['contdoc']=$result;
            // }

            // $query=$this->db->query("select kyc_id, kyc_doc_type as d_type, kyc_doc_name as d_documentname, kyc_doc_desc as d_description, kyc_doc_name, 
            //                         kyc_doc_desc, kyc_doc_type, kyc_doc_ref, kyc_issuedate, kyc_expirydate, kyc_document, 
            //                         kyc_document_name from contact_kyc_details where kyc_cid='$cid' order by kyc_id");
            // $result=$query->result();
            // if(count($result)>0) {
            //     $data['editcontdoc']=$result;
            // } else {
            //     $query=$this->db->query("select d_type, d_documentname as kyc_doc_name, d_description as kyc_doc_desc, 
            //                             '' as kyc_doc_ref,'' as kyc_issuedate, '' as kyc_expirydate,'' as kyc_document, 
            //                             '' as kyc_document_name, d_m_status from document_master 
            //                             where d_cat_individual='Yes'");

            //     // $query=$this->db->query("select A.d_type, A.d_documentname, A.d_description, B.kyc_doc_name, B.kyc_doc_desc, 
            //     //                         B.kyc_doc_type, B.kyc_doc_ref, B.kyc_issuedate, B.kyc_expirydate, B.kyc_document, 
            //     //                         B.kyc_document_name from 
            //     //                         (select d_type, d_documentname, d_description from document_master 
            //     //                             where d_cat_individual='Yes' 
            //     //                         union all 
            //     //                         (select '' as d_type, '' as d_documentname, '' as d_description 
            //     //                             from document_master limit 1)) A 
            //     //                         left join 
            //     //                         (select kyc_doc_name, kyc_doc_desc, kyc_doc_type, kyc_doc_ref, kyc_issuedate, 
            //     //                             kyc_expirydate, kyc_document, kyc_document_name from contact_kyc_details 
            //     //                             where kyc_cid='$cid') B 
            //     //                         on (A.d_type like concat('%',B.kyc_doc_type,'%'))");
            //     $result=$query->result();
            //     if(count($result)>0) {
            //         $data['editcontdoc']=$result;
            //     }
            // }

            // $query=$this->db->query("SELECT * FROM document_master WHERE d_type like '%ID Proof%' and d_cat_individual='Yes'");
            // $result=$query->result();
            // $data['id_proof_doc']=$result;

            // $query=$this->db->query("SELECT * FROM document_master WHERE d_type like '%Address Proof%' and d_cat_individual='Yes'");
            // $result=$query->result();
            // $data['address_proof_doc']=$result;

            // $query=$this->db->query("SELECT * FROM document_master WHERE d_type like '%Others%' and d_cat_individual='Yes'");
            // $result=$query->result();
            // $data['other_doc']=$result;

            $docs=$this->document_model->view_doc('d_cat_individual', $cid, 'Contacts');
            $data=array_merge($data, $docs);

            $query=$this->db->query("SELECT A.nm_name, A.nm_relation, concat(ifnull(B.c_name,''), ' ', ifnull(B.c_last_name,''), ' - ', ifnull(B.c_emailid1,''), ' - ', ifnull(B.c_mobile1,''), ' - ', ifnull(B.c_company,'')) as c_name FROM contact_nominee_details A, contact_master B WHERE A.nm_cid='$cid' and A.nm_name = B.c_id");
            $result=$query->result();
            $data['editcontnom']=$result;

            $query=$this->db->query("SELECT * FROM contact_type_master WHERE g_id = '$gid'");
            $result=$query->result();
            $data['contact_type']=$result;

            $query=$this->db->query("select A.property_id, B.p_property_name from 
                                    (select distinct txn_id as property_id from purchase_txn where txn_status='Approved' and 
                                        gp_id='$gid' and txn_id in (select distinct ref_id from related_party_details 
                                            where contact_id='$cid' and type='purchase') 
                                    union all 
                                    select distinct property_id from sales_txn where txn_status='Approved' and gp_id='$gid' and 
                                    txn_id in (select distinct ref_id from related_party_details 
                                        where contact_id='$cid' and type='sale')
                                    union all 
                                    select distinct property_id from rent_txn where txn_status='Approved' and gp_id='$gid' and 
                                    txn_id in (select distinct ref_id from related_party_details 
                                        where contact_id='$cid' and type='rent')) A 
                                    left join 
                                    (select * from purchase_txn where txn_status='Approved' and gp_id='$gid') B 
                                    on A.property_id = B.txn_id");
            $result=$query->result();
            $data['related_properties']=$result;

            $data['c_id']=$cid;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('contacts/contact_view', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function editRecord($cid) {
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1  or $result[0]->r_approvals==1 ) {
                $gid=$this->session->userdata('groupid');
                $data['access']=$result;
                
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid' order by c_id desc");
                $result=$query->result();
                $data['contacts']=$result;
                
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_fkid = '$cid'");
                $result=$query->result();
                if (count($result)>0){
                    $cid = $result[0]->c_id;
                }

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_id='$cid'");
                $result=$query->result();
                $data['editcontact']=$result;
				
				$gd=$result[0]->c_guardian;
				if($gd!='Select' and $gd!='') {
					$query=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$gd'");
					$result=$query->result();
					if(count($result)>0) {
						$data['guardian']=$result[0]->c_name;
					}
				}

				// $query=$this->db->query("SELECT * FROM contact_kyc_details WHERE kyc_cid='$cid' order by kyc_id");
				// $result=$query->result();
				// if(count($result)>0) {
				// 	$data['contdoc']=$result;
				// }

                //             // $query=$this->db->query("SELECT * FROM contact_kyc_details WHERE kyc_cid='$cid'");

                //             $query=$this->db->query("select A.kyc_id, A.d_type, A.d_documentname, A.d_description, A.kyc_doc_name, A.kyc_doc_desc, A.kyc_doc_type, 
                //                                     A.kyc_doc_ref, A.kyc_issuedate, A.kyc_expirydate, A.kyc_document, A.kyc_document_name, B.d_m_status from 
                //                                     (select kyc_id, kyc_doc_type as d_type, kyc_doc_name as d_documentname, kyc_doc_desc as d_description, kyc_doc_name, 
                //                                     kyc_doc_desc, kyc_doc_type, kyc_doc_ref, kyc_issuedate, kyc_expirydate, kyc_document, 
                //                                     kyc_document_name from contact_kyc_details where kyc_cid='$cid' order by kyc_id) A 
                //                                     left join 
                //                                     (SELECT * FROM document_master WHERE d_cat_individual='Yes') B 
                //                                     on((B.d_type like concat('%',A.kyc_doc_type,'%')) and A.d_documentname = B.d_documentname)");
                //             $result=$query->result();
                //             if(count($result)>0) {
                //                 $data['editcontdoc']=$result;
                //             } else {
                //                 $query=$this->db->query("select d_type, d_documentname as kyc_doc_name, d_description as kyc_doc_desc, 
                //                                         '' as kyc_doc_ref,'' as kyc_issuedate, '' as kyc_expirydate,'' as kyc_document, 
                //                                         '' as kyc_document_name, d_m_status from document_master 
                //                                         where d_cat_individual='Yes'");

                //                 // $query=$this->db->query("select A.d_type, A.d_documentname, A.d_description, A.d_m_status, B.kyc_doc_name, 
                //                 //                         B.kyc_doc_desc, B.kyc_doc_type, B.kyc_doc_ref, B.kyc_issuedate, B.kyc_expirydate, 
                //                 //                         B.kyc_document, B.kyc_document_name from 
                //                 //                         (select d_type, d_documentname, d_description, d_m_status from document_master 
                //                 //                             where d_cat_individual='Yes' 
                //                 //                         union all 
                //                 //                         (select '' as d_type, '' as d_documentname, '' as d_description, '' as d_m_status 
                //                 //                             from document_master limit 1)) A 
                //                 //                         left join 
                //                 //                         (select kyc_doc_name, kyc_doc_desc, kyc_doc_type, kyc_doc_ref, kyc_issuedate, 
                //                 //                             kyc_expirydate, kyc_document, kyc_document_name from contact_kyc_details 
                //                 //                             where kyc_cid='$cid') B 
                //                 //                         on (A.d_type like concat('%',B.kyc_doc_type,'%'))");
                //                 $result=$query->result();
                //                 if(count($result)>0) {
                //                     $data['editcontdoc']=$result;
                //                 }
                //             }

                //             // for($i=0;$i<count($result); $i++) {
                //             //     $this->downloaddocs($cid, $result[$i]->kyc_id);
                //             // }

                //             /*echo "Yes";
                //             for ($i=0; $i < count($result); $i++) { 
                //                 $this->downloaddocument($cid, $i);
                //             }
                //             */

                //             $query=$this->db->query("SELECT * FROM document_master WHERE d_type like '%ID Proof%' AND d_cat_individual='Yes'");
                //             $result=$query->result();
                //             $data['id_proof_doc']=$result;

                //             $query=$this->db->query("SELECT * FROM document_master WHERE d_type like '%Address Proof%' AND d_cat_individual='Yes'");
                //             $result=$query->result();
                //             $data['address_proof_doc']=$result;

                //             $query=$this->db->query("SELECT * FROM document_master WHERE d_type like '%Others%' AND d_cat_individual='Yes'");
                //             $result=$query->result();
                //             $data['other_doc']=$result;

                $docs=$this->document_model->edit_view_doc('d_cat_individual', $cid, 'Contacts');
                $data=array_merge($data, $docs);

                $query=$this->db->query("SELECT A.nm_name, A.nm_relation, concat(ifnull(B.c_name,''), ' ', ifnull(B.c_last_name,''), ' - ', ifnull(B.c_emailid1,''), ' - ', ifnull(B.c_mobile1,''), ' - ', ifnull(B.c_company,'')) as c_name FROM contact_nominee_details A, contact_master B WHERE A.nm_cid='$cid' and A.nm_name = B.c_id");
                $result=$query->result();
                $data['editcontnom']=$result;

                $query=$this->db->query("SELECT * FROM contact_type_master WHERE g_id = '$gid' order by contact_type");
                $result=$query->result();
                $data['contact_type']=$result;

                $data['c_id']=$cid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('contacts/contact_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    // public function downloaddocs($cid, $docid) {
    //     $query=$this->db->query("SELECT * FROM contact_kyc_details WHERE kyc_id='$docid'");
    //     $result=$query->result();
    //     $this->load->library('ftp');

    //     $ftp_config['hostname'] = '127.0.0.1';
    //     $ftp_config['username'] = 'user1';
    //     $ftp_config['password'] = 'password';
    //     $ftp_config['debug'] = TRUE;

    //     $this->ftp->connect($ftp_config);
    //     $source=$result[0]->kyc_document;
    //     if(!is_dir('./downloads/client/'.$cid.'/')) {
    //         mkdir('./downloads/client/'.$cid.'/', 0777, TRUE);
    //     }

    //     $source=$result[0]->kyc_document;
    //     $destination='./downloads/client/'.$cid.'/'.$result[0]->kyc_document_name;
    //     $this->ftp->download($source, $destination);   
    //     $this->ftp->close();
    // }

    public function updateRecord($cid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid'");
        $result=$query->result();
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $c_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $c_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $c_status='Approved';
            } else  {
                $c_status='In Process';
            }

            if($c_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    $query=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cid'");
                    $res=$query->result();
                    if(count($res)>0) {
                        $rec_status = $res[0]->c_status;
                        $c_fkid = $res[0]->c_fkid;
                        $c_gid = $res[0]->c_gid;
                    } else {
                        $rec_status = '';
                        $c_fkid = '';
                        $c_gid = null;
                    }

                    if ($rec_status=="Approved") {
                        $txn_remarks = $this->input->post('status_remarks');

                        if($maker_checker!='yes'){
                            $c_status = 'Inactive';

                            $this->db->query("update contact_master set c_status='$c_status', txn_remarks='$txn_remarks', c_modifiedby='$curusr', 
                                            c_modifieddate='$modnow' WHERE c_id = '$cid'");

                            $logarray['table_id']=$cid;
                            $logarray['module_name']='Contact';
                            $logarray['cnt_name']='contacts';
                            $logarray['action']='Contact Record ' . $c_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM contact_master WHERE c_fkid = '$cid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $cid = $result[0]->c_id;

                                $this->db->query("Update contact_master set c_status='$c_status', txn_remarks='$txn_remarks', 
                                                 c_modifieddate='$modnow', c_modifiedby='$curusr' 
                                                 WHERE c_id = '$cid'");
                                $logarray['table_id']=$cid;
                                $logarray['module_name']='Contact';
                                $logarray['cnt_name']='contacts';
                                $logarray['action']='Contact Record Delete approved';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                            } else {
                                $this->db->query("Insert into contact_master (c_name, c_company, c_gid, c_dob, c_anniversarydate, c_gender, c_designation, 
                                                 c_guardian, c_relation, c_address, c_landmark, c_state, c_city, c_country, c_pincode, c_emailid1, c_emailid2, 
                                                 c_mobile1, c_mobile2, c_kyc_required, c_createdate, c_status, c_middle_name, c_last_name, c_type, c_createdby, 
                                                 c_modifieddate, c_modifiedby, c_approveddate, c_approvedby, txn_remarks, c_fkid, c_rejectedby, c_rejecteddate,
                                                 c_contact_type, c_pan_card, maker_remark)  
                                                 Select c_name, c_company, c_gid, c_dob, c_anniversarydate, c_gender, c_designation, 
                                                 c_guardian, c_relation, c_address, c_landmark, c_state, c_city, c_country, c_pincode, c_emailid1, c_emailid2, 
                                                 c_mobile1, c_mobile2, c_kyc_required, c_createdate, '$c_status', c_middle_name, c_last_name, c_type, c_createdby, 
                                                 '$modnow', '$curusr', c_approveddate, c_approvedby, '$txn_remarks', '$cid', c_rejectedby, c_rejecteddate,
                                                 c_contact_type, c_pan_card, maker_remark 
                                                 FROM contact_master WHERE c_id = '$cid'");
                                $new_cid=$this->db->insert_id();

                                // $this->db->query("Insert into contact_kyc_details (kyc_cid, kyc_doc_type, kyc_doc_name, kyc_doc_desc, kyc_doc_ref, 
                                //                  kyc_issuedate, kyc_expirydate, kyc_document, kyc_document_name)  
                                //                  Select '$new_cid', kyc_doc_type, kyc_doc_name, kyc_doc_desc, kyc_doc_ref, 
                                //                  kyc_issuedate, kyc_expirydate, kyc_document, kyc_document_name 
                                //                  FROM contact_kyc_details WHERE kyc_cid = '$cid'");

                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name)  
                                                 Select '$new_cid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$cid' and doc_ref_type = 'Contacts'");


                                $this->db->query("Insert into contact_nominee_details (nm_cid, nm_name, nm_relation, nm_designation, 
                                                 nm_mobile, nm_emailid) 
                                                 Select '$new_cid', nm_name, nm_relation, nm_designation, 
                                                 nm_mobile, nm_emailid 
                                                 FROM contact_nominee_details WHERE nm_cid = '$cid'");

                                $logarray['table_id']=$cid;
                                $logarray['module_name']='Contact';
                                $logarray['cnt_name']='contacts';
                                $logarray['action']='Contact Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            }
                        }
                    } else {
                        $this->db->where('c_id', $cid);
                        $this->db->delete('contact_master');

                        // $this->db->where('kyc_cid', $cid);
                        // $this->db->delete('contact_kyc_details');

                        $this->db->where('doc_ref_id', $cid);
                        $this->db->where('doc_ref_type', 'Contacts');
                        $this->db->delete('document_details');

                        $this->db->where('nm_cid', $cid);
                        $this->db->delete('contact_nominee_details');

                        $logarray['table_id']=$cid;
                        $logarray['module_name']='Contact';
                        $logarray['cnt_name']='contacts';
                        $logarray['action']='Contact Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        // $this->db->where('gu_cid', $cid);
                        // $this->db->delete('group_users');
                    }

                    redirect(base_url().'index.php/Contacts');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit == 1) {
                    $query=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cid'");
                    $res=$query->result();
                    if(count($res)>0) {
                        $rec_status = $res[0]->c_status;
                        $c_fkid = $res[0]->c_fkid;
                        $c_gid = $res[0]->c_gid;
                        $c_createdby = $res[0]->c_createdby;
                        $c_createdate = $res[0]->c_createdate;
                    } else {
                        $rec_status = '';
                        $c_fkid = '';
                        $c_gid = null;
                        $c_createdby = $curusr;
                        $c_createdate = $now;
                    }

                    if($this->input->post('date_of_birth')!='') {
                        $dob=FormatDate($this->input->post('date_of_birth'));
                    } else {
                        $dob=NULL;
                    }
                    if($this->input->post('date_of_anniversary')!='') {
                        $doe=FormatDate($this->input->post('date_of_anniversary'));
                    } else {
                        $doe=NULL;
                    }
                    if($this->input->post('type')=='Others'){
                        $c_last_name = $this->input->post('owner_type');
                    } else {
                        $c_last_name = $this->input->post('c_last_name');
                    }

                    $data = array(
                        'c_name' => $this->input->post('c_name'),
                        'c_company' => $this->input->post('company'),
                        'c_middle_name' => $this->input->post('c_middle_name'),
                        'c_last_name' =>  $c_last_name,
                        'c_gid' => $c_gid,
                        'c_dob' =>  $dob,
                        'c_anniversarydate' => $doe,
                        'c_gender' => $this->input->post('gender'),
                        'c_designation' => $this->input->post('designation'),
                        'c_guardian' => $this->input->post('guardian'),
                        'c_relation' => $this->input->post('guardian_relation'),
                        'c_address' => $this->input->post('address'),
                        'c_landmark' => $this->input->post('landmark'),
                        'c_state' => $this->input->post('state'),
                        'c_city' => $this->input->post('city'),
                        'c_country' => $this->input->post('country'),
                        'c_pincode' => $this->input->post('pincode'),
                        'c_emailid1' => $this->input->post('email_id1'),
                        'c_emailid2' => $this->input->post('email_id2'),
                        'c_mobile1' => $this->input->post('mobile_no1'),
                        'c_mobile2' => $this->input->post('mobile_no2'),
                        'c_type' => $this->input->post('type'),
                        'c_kyc_required' => $this->input->post('kyc'),
                        'c_contact_type' => (is_numeric($this->input->post('contact_type'))?$this->input->post('contact_type'):null),
                        'c_pan_card' => $this->input->post('pan_card'),
                        'c_status' => $c_status,
                        'c_createdate' => $c_createdate,
                        'c_createdby' => $c_createdby,
                        'c_modifieddate' => $modnow,
                        'c_modifiedby' => $curusr,
                        'maker_remark' => $this->input->post('maker_remark')
                    );
                    
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $c_fkid = $cid;
                        $data['c_fkid'] = $cid;

                        $this->db->insert('contact_master',$data);
                        $cid=$this->db->insert_id();
                        $logarray['table_id']=$c_fkid;
                        $logarray['module_name']='Contact';
                        $logarray['cnt_name']='contacts';
                        $logarray['action']='Contact Approved Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        // if ($c_status=='Delete') {
                        //     $this->db->where('c_id', $cid);
                        //     $this->db->delete('contact_master');

                        //     $this->db->where('gu_cid', $cid);
                        //     $this->db->delete('group_users');
                        // } else {
                            
                            $this->db->where('c_id', $cid);
                            $this->db->update('contact_master',$data);
                            $logarray['table_id']=$cid;
                            $logarray['module_name']='Contact';
                            $logarray['cnt_name']='contacts';
                            $logarray['action']='Contact Record Modified';
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        // }
                    }

                    if($this->input->post('kyc')=="1") {
                        $this->document_model->insert_doc($cid, 'Contacts');
                        
                        // if ($rec_status!="Approved") {
                        //     $query=$this->db->query("SELECT * FROM contact_kyc_details WHERE kyc_cid = '$cid'");
                        //     $result=$query->result();
                        //     $file_path_db=NULL;
                        //     $file_path_count=0;

                        //     for ($i=0; $i < count($result) ; $i++) { 
                        //         $file_path_db[$i]['docname']=$result[$i]->kyc_doc_name;
                        //         $file_path_db[$i]['docdesc']=$result[$i]->kyc_doc_desc;
                        //         $file_path_db[$i]['docrefno']=$result[$i]->kyc_doc_ref;
                        //         $file_path_db[$i]['docdoi']=$result[$i]->kyc_issuedate;
                        //         $file_path_db[$i]['docdoe']=$result[$i]->kyc_expirydate;
                        //         $file_path_db[$i]['docpath']=$result[$i]->kyc_document;
                        //         $file_path_db[$i]['docfilename']=$result[$i]->kyc_document_name;
                        //         $file_path_count=$i;
                        //     }

                        //     print_r($file_path_db);

                        //     $this->db->where('kyc_cid', $cid);
                        //     $this->db->delete('contact_kyc_details');
                        // }

                        // if ($c_status!="Delete" || $rec_status=="Approved") {
                        //     $doctype=$this->input->post('doc_type[]');
                        //     $docname=$this->input->post('doc_name[]');
                        //     $docdesc=$this->input->post('doc_desc[]');
                        //     $docref=$this->input->post('ref_no[]');
                        //     $docdoi=$this->input->post('date_issue[]');
                        //     $docdoe=$this->input->post('date_expiry[]');

                        //     $doccnt = 0;

                        //     for ($k=0; $k <  count($docname); $k++) {
                        //         if(isset($docname[$k]) and $docname[$k]!="") {
                        //             // $docname=str_replace('/', '_', $docname);
                        //             $docname[$k]=str_replace('/', '_', $docname[$k]);
                                    
                        //             if($docdoe[$k]=="") {
                        //                 $doe = NULL;
                        //             } else {
                        //                 $doe = FormatDate($docdoe[$k]);
                        //             }

                        //             if($docdoi[$k]=="") {
                        //                 $doi = NULL;
                        //             } else {
                        //                 $doi = FormatDate($docdoi[$k]);
                        //             }

                        //             $filePath='uploads/client/';
                        //             $upload_path = './' . $filePath;
                        //             if(!is_dir($upload_path)) {
                        //                 mkdir($upload_path, 0777, TRUE);
                        //             }
                        //             $filePath='uploads/client/client_'.$cid.'/';
                        //             $upload_path = './' . $filePath;
                        //             if(!is_dir($upload_path)) {
                        //                 mkdir($upload_path, 0777, TRUE);
                        //             }

                        //             $confi['upload_path']=$upload_path;
                        //             $confi['allowed_types']='*';
                        //             $this->load->library('upload', $confi);
                        //             $extension="";

                        //             // $file_nm='doc_'.$k;
                        //             $file_nm='doc_'.$doccnt;

                        //             while (!isset($_FILES[$file_nm]['name'])) {
                        //                 $doccnt = $doccnt + 1;
                        //                 $file_nm = 'doc_'.$doccnt;
                        //             }

                        //             if(!empty($_FILES[$file_nm]['name'])) {
                        //                 if($this->upload->do_upload($file_nm)) {
                        //                     echo "Uploaded <br>";
                        //                 } else {
                        //                     echo "Failed<br>";
                        //                     echo $this->upload->data();
                        //                 }   

                        //                 $upload_data=$this->upload->data();
                        //                 $fileName=$upload_data['file_name'];
                        //                 $extension=$upload_data['file_ext'];

                        //                 $data = array(
                        //                     'kyc_cid' => $cid,
                        //                     'kyc_doc_type' => $doctype[$k],
                        //                     'kyc_doc_name' => $docname[$k],
                        //                     'kyc_doc_desc' => $docdesc[$k],
                        //                     'kyc_doc_ref' => $docref[$k],
                        //                     'kyc_issuedate' => $doi,
                        //                     'kyc_expirydate' => $doe,
                        //                     'kyc_document' => $filePath.$fileName,
                        //                     'kyc_document_name' => $fileName,
                        //                 );
                        //                 $this->db->insert('contact_kyc_details', $data);
                        //                 echo "Main<br>";
                        //             } else {
                        //                 if($file_path_count>=$k) {
                        //                     $path=$file_path_db[$k]['docpath'];
                        //                     $flnm=$file_path_db[$k]['docfilename'];
                        //                 } else {
                        //                     $path="";
                        //                     $flnm="";
                        //                 }
                        //                 echo "Other<br>";
                        //                 $data = array(
                        //                     'kyc_cid' => $cid,
                        //                     'kyc_doc_type' => $doctype[$k],
                        //                     'kyc_doc_name' => $docname[$k],
                        //                     'kyc_doc_desc' => $docdesc[$k],
                        //                     'kyc_doc_ref' => $docref[$k],
                        //                     'kyc_issuedate' => $doi,
                        //                     'kyc_expirydate' => $doe,
                        //                     'kyc_document' => $path,
                        //                     'kyc_document_name' => $flnm,
                        //                 );
                        //                 $this->db->insert('contact_kyc_details', $data);
                        //             }
                        //         }
                        //         $doccnt = $doccnt + 1;
                        //     }

                        //     $file_path_db=NULL;
                        // }
                        
                        
                        if ($rec_status!="Approved" || $maker_checker!='yes') {
                            $this->db->where('nm_cid', $cid);
                            $this->db->delete('contact_nominee_details');
                        }

                        if ($c_status!="Delete" || $rec_status=="Approved" || $maker_checker!='yes') {
                            $nominee=$this->input->post('nm_name[]');
                            $relation=$this->input->post('nm_relation[]');

                            for ($i=0; $i < count($nominee) ; $i++) { 
                                $data = array(
                                    'nm_cid' => $cid,
                                    'nm_name' => $nominee[$i],
                                    'nm_relation' => $relation[$i]
                                );    

                                $this->db->insert('contact_nominee_details',$data);
                            }
                        }
                    }

                    redirect(base_url().'index.php/Contacts');
                } else {
                    echo "Unauthorized access.";
                }
            }
            
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approverecord($cid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid'");
        $result=$query->result();
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->c_status;
                    $c_fkid = $res[0]->c_fkid;
                    $c_gid = $res[0]->c_gid;
                } else {
                    $rec_status = '';
                    $c_fkid = '';
                    $c_gid = null;
                }

                if($this->input->post('submit')=='Approve') {
                    $c_status='Approved';
                } else  {
                    $c_status='Rejected';
                }
                $txn_remarks = $this->input->post('status_remarks');

                if ($c_status=='Rejected') {
                    $this->db->query("update contact_master set c_status='Rejected', txn_remarks='$txn_remarks', c_rejectedby='$curusr', c_rejecteddate='$modnow' WHERE c_id = '$cid'");
                    // $this->db->query("update group_users set assigned_status='Rejected', rejected_by='$curusr', rejected_date='$modnow' WHERE gu_cid = '$cid'");

                    $logarray['table_id']=$cid;
                    $logarray['module_name']='Contact';
                    $logarray['cnt_name']='contacts';
                    $logarray['action']='Contact Record ' . $c_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($c_fkid=='' || $c_fkid==null) {
                        $this->db->query("update contact_master set c_status='Approved',txn_remarks='$txn_remarks', c_approvedby='$curusr', c_approveddate='$modnow' WHERE c_id = '$cid'");
                        // $this->db->query("update group_users set assigned_status='Approved', approved_by='$curusr', approved_date='$modnow' WHERE gu_cid = '$cid'");

                        $logarray['table_id']=$cid;
                        $logarray['module_name']='Contact';
                        $logarray['cnt_name']='contacts';
                        $logarray['action']='Contact Record ' . $c_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $c_status='Inactive';
                        }
                        $this->db->query("update contact_master A, contact_master B set A.c_name=B.c_name, 
                                         A.c_company=B.c_company, A.c_gid=B.c_gid, A.c_dob=B.c_dob, 
                                         A.c_anniversarydate=B.c_anniversarydate, A.c_gender=B.c_gender, 
                                         A.c_designation=B.c_designation, A.c_guardian=B.c_guardian, A.c_relation=B.c_relation, 
                                         A.c_address=B.c_address, A.c_landmark=B.c_landmark, A.c_state=B.c_state, 
                                         A.c_city=B.c_city, A.c_country=B.c_country, A.c_pincode=B.c_pincode, 
                                         A.c_emailid1=B.c_emailid1, A.c_emailid2=B.c_emailid2, A.c_mobile1=B.c_mobile1, 
                                         A.c_mobile2=B.c_mobile2, A.c_kyc_required=B.c_kyc_required, 
                                         A.c_createdate=B.c_createdate, A.c_status='$c_status', A.c_middle_name=B.c_middle_name, 
                                         A.c_last_name=B.c_last_name, A.c_type=B.c_type, A.c_createdby=B.c_createdby, 
                                         A.c_modifieddate=B.c_modifieddate, A.c_modifiedby=B.c_modifiedby, 
                                         A.c_approveddate='$modnow', A.c_approvedby='$curusr', 
                                         A.txn_remarks='$txn_remarks', A.c_contact_type=B.c_contact_type, A.c_pan_card=B.c_pan_card,
                                         A.maker_remark=B.maker_remark 
                                         WHERE B.c_id = '$cid' and A.c_id=B.c_fkid");
                        
                        // $this->db->query("update group_users A, contact_master B set A.gu_name=B.c_name, 
                        //                  A.gu_designation=B.c_designation, A.gu_email=B.c_emailid1, A.gu_mobile=B.c_mobile1, 
                        //                  A.assigned_status='$c_status', 
                        //                  A.approved_date='$modnow', A.approved_by='$curusr' 
                        //                  WHERE B.c_id = '$cid' and A.gu_cid=B.c_fkid");

                        $this->db->query("update group_users A, contact_master B set A.name=B.c_name, A.gu_email=B.c_emailid1, 
                                         A.assigned_status='$c_status', A.approved_date='$modnow', A.approved_by='$curusr' 
                                         WHERE B.c_id = '$cid' and A.gu_cid=B.c_fkid");

                        // $this->db->where('kyc_cid', $c_fkid);
                        // $this->db->delete('contact_kyc_details');

                        $this->db->where('doc_ref_id', $c_fkid);
                        $this->db->where('doc_ref_type', 'Contacts');
                        $this->db->delete('document_details');

                        $this->db->where('nm_cid', $c_fkid);
                        $this->db->delete('contact_nominee_details');

                        // $this->db->query("update contact_kyc_details set kyc_cid = '$c_fkid' WHERE kyc_cid = '$cid'");

                        $this->db->query("update document_details set doc_ref_id = '$c_fkid' WHERE doc_ref_id = '$cid' and doc_ref_type = 'Contacts'");

                        $this->db->query("update contact_nominee_details set nm_cid = '$c_fkid' WHERE nm_cid = '$cid'");

                        $this->db->query("delete from contact_master WHERE c_id = '$cid'");
                        
                        $logarray['table_id']=$c_fkid;
                        $logarray['module_name']='Contact';
                        $logarray['cnt_name']='contacts';
                        $logarray['action']='Contact Record ' . $c_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }
            }
        }

       redirect(base_url().'index.php/Contacts');
    }
    
    public function checkstatus($status='') {
		if($status=='InProcess') {
			$status='In Process';
            $cond="contact_master.c_status='In Process'";
		} else if($status=='Pending') {
            $cond="(contact_master.c_status='Pending' or contact_master.c_status='Delete')";
        } else {
            $cond="contact_master.c_status='$status'";
        }
		$roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' AND (r_view = 1 or r_insert = 1 or r_edit = 1 or r_delete = 1 or r_approvals = 1)");
        $result=$query->result();
        if(count($result)>0) {
            $data['access']=$result;
            $gid=$this->session->userdata('groupid');

            if($status!='All') {
                $query=$this->db->query("SELECT * FROM contact_master LEFT JOIN group_master ON contact_master.c_gid=group_master.g_id  WHERE contact_master.c_gid = '$gid' and " . $cond . " ORDER BY contact_master.c_modifieddate DESC");
                $result=$query->result();
                $data['contacts']=$result;
            } else {
                $query=$this->db->query("SELECT * FROM contact_master LEFT JOIN group_master ON contact_master.c_gid=group_master.g_id  WHERE contact_master.c_gid = '$gid' and contact_master.c_status!='Inactive' ORDER BY contact_master.c_modifieddate DESC");
                $result=$query->result();
                $data['contacts']=$result;
                $data['all']=$result;
            }
            $result=$query->result();
            $data['contacts']=$result;

            $query=$this->db->query("SELECT * FROM contact_master LEFT JOIN group_master ON contact_master.c_gid=group_master.g_id  WHERE contact_master.c_gid = '$gid' and contact_master.c_status!='Inactive' ORDER BY contact_master.c_modifieddate DESC");
            $result=$query->result();
            $data['all']=$result;

            $query=$this->db->query("SELECT * FROM contact_master WHERE c_status='In Process' AND c_gid='$gid'");
            $result=$query->result();
            $data['inprocess']=$result;

            $query=$this->db->query("SELECT * FROM contact_master WHERE c_status='Approved' AND c_gid='$gid'");
            $result=$query->result();
            $data['approved']=$result;

            $query=$this->db->query("SELECT * FROM contact_master WHERE (c_status='Pending' or c_status='Delete') AND c_gid='$gid'");
            $result=$query->result();
            $data['pending']=$result;

            $query=$this->db->query("SELECT * FROM contact_master WHERE c_status='Rejected' AND c_gid='$gid'");
            $result=$query->result();
            $data['rejected']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('contacts/contact_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
	}

    function check_availablity() {
        $gid=$this->session->userdata('groupid');
        $c_id = html_escape($this->input->post('c_id'));
        $c_name = html_escape($this->input->post('c_name'));
        $c_last_name = html_escape($this->input->post('c_last_name'));
        $email_id1 = html_escape($this->input->post('email_id1'));
        $mobile_no1 = html_escape($this->input->post('mobile_no1'));

        // $c_name = "Swapnil";
        // $c_last_name = "Darekar";
        // $email_id1 = "swapnil.darekar@otbconsulting.co.in";
        // $mobile_no1 = "9821311980";

        $result = $this->contact_model->check_availablity($gid, $c_id, $c_name, $c_last_name, $email_id1, $mobile_no1);
        echo $result;
    }

    function get_m_status() {
        $doc_name = html_escape($this->input->post('doc_name'));
        $doc_type = html_escape($this->input->post('doc_type'));

        // $doc_name = "Adhar Card";
        // $doc_type = "ID Proof";

        $result = $this->contact_model->get_m_status($doc_name, $doc_type);
        echo $result;
    }

    function check_contact_availablity() {
        $gid=$this->session->userdata('groupid');
        $c_name = html_escape($this->input->post('con_first_name'));
        $c_last_name = html_escape($this->input->post('con_last_name'));
        $email_id1 = html_escape($this->input->post('con_email_id1'));
        $mobile_no1 = html_escape($this->input->post('con_mobile_no1'));

        // $c_name = "Test";
        // $c_last_name = "Test";
        // $email_id1 = "ad@bd.com";
        // $mobile_no1 = "9833449918";

        $result = $this->contact_model->check_contact_availablity($gid, $c_name, $c_last_name, $email_id1, $mobile_no1);
        echo $result;
    }

}
?>