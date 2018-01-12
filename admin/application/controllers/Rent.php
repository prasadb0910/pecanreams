<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Rent extends CI_Controller
{
    public function __construct() 
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model("rent_model");
        $this->load->model('transaction_model');
        $this->load->model('document_model');
        $this->load->library('excel');
    }

    //index function
    public function index() {
        $this->checkstatus('All');
    }

    public function loaddocuments($pid) {
        $document_details=null;

        $query=$this->db->query("SELECT * FROM purchase_txn WHERE txn_id = '$pid'");
        $result=$query->result();

        if (count($result)>0) {
            $pcolname="";
            $ptype=$result[0]->p_type;

            if($ptype=='Building'){
                $pcolname="d_type_building";
            } else if($ptype=='Apartment'){
                $pcolname="d_type_apartment";
            } else if($ptype=='Bunglow'){
                $pcolname="d_type_bunglow";
            } else if($ptype=='Commercial'){
                $pcolname="d_type_commercial";
            } else if($ptype=='Retail'){
                $pcolname="d_type_retail";
            } else if($ptype=='Industrial'){
                $pcolname="d_type_industry";
            } else if($ptype=='Land-Agriculture'){
                $pcolname="d_type_landagriculture";
            } else if($ptype=='Land-Non Agriculture'){
                $pcolname="d_type_landnonagricultural";
            } 

            if ($pcolname!="") {
                // $query=$this->db->query("SELECT * FROM document_master WHERE d_t_type like '%Rent%' and " . $pcolname . " = 'Yes'");
                // $result=$query->result();
                // $i=0;
                
                // foreach ($result as $row) {
                //     $document_details[$i] = array("d_documentname"=> $row->d_documentname, "d_description"=> $row->d_description);
                //     $i=$i+1;
                // }


                    //             $query=$this->db->query("select d_type_id, d_type, d_m_status, '' as doc_doc_id, 
                    //                             '' as doc_documentname, '' as d_show_expiry_date, 
                    //                             '' as doc_description, '' as doc_ref_no, '' as doc_doi, 
                    //                             '' as doc_doe, '' as doc_document, '' as document_name 
                    //                             from document_type_master");
				// $result=$query->result();
				// $data['documents']=$result;

                // $query=$this->db->query("select C.*, D.d_documentname as doc_documentname, d_show_expiry_date from 
                //                         (select A.*, B.d_type_id, B.d_type, B.d_m_status from 
                //                         (select * from document_details where doc_ref_id='$pid' and doc_ref_type='Property_Purchase') A 
                //                         left join 
                //                         (select * from document_type_master) B 
                //                         on (A.doc_type_id=B.d_type_id)) C 
                //                         left join 
                //                         (select * from document_master) D 
                //                         on (C.doc_doc_id=D.d_id)");
                // $result=$query->result();
                // $data['documents']=$result;

                // for($i=0; $i<count($result); $i++){
                //     $d_type_id = $result[$i]->d_type_id;

                //     $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                //                             (select * from document_types where d_type_id='$d_type_id') A 
                //                             left join 
                //                             (select * from document_master where d_t_type like '%rent%' and $pcolname='Yes') B 
                //                             on (A.d_id=B.d_id)) C where C.d_documentname is not null");

                //     $data['docs'][$d_type_id]=$query->result();
                // }

                $query=$this->db->query("select d_type_id, d_type, d_m_status, '' as doc_doc_id, 
                                        '' as doc_documentname, '' as d_show_expiry_date, 
                                        '' as doc_description, '' as doc_ref_no, '' as doc_doi, 
                                        '' as doc_doe, '' as doc_document, '' as document_name, '' as doc_doc_name 
                                        from document_type_master");
                $result=$query->result();
                $data['documents']=$result;

                for($i=0; $i<count($result); $i++){
                    $d_type_id = $result[$i]->d_type_id;

                    $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                                            (select * from document_types where d_type_id='$d_type_id') A 
                                            left join 
                                            (select * from document_master where d_t_type like '%rent%' and $pcolname='Yes') B 
                                            on (A.d_id=B.d_id)) C where C.d_documentname is not null");

                    $data['docs'][$d_type_id]=$query->result();
                }
            }
        }

        // echo json_encode($document_details);
        $document_data=$this->load->view('templates/document_dynamic',$data,true);
        $returnarray=array('status'=>true,"data"=>$document_data);
        echo json_encode($returnarray);
    }
    
    public function addnew($prop=NULL){
		$gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%rent%' AND status = '1' AND tax_action='1'");
            $result=$query->result();
            $data['tax']=$result;

            $data['selid']=$prop;
            
            // $query=$this->db->query("SELECT * FROM document_master WHERE d_t_type like '%Rent%'");
            // $result=$query->result();
            // $data['docs']=$result;
            
            $query=$this->db->query("select d_type_id, d_type, d_m_status, '' as doc_doc_id, 
                                    '' as doc_documentname, '' as d_show_expiry_date, 
                                    '' as doc_description, '' as doc_ref_no, '' as doc_doi, 
                                    '' as doc_doe, '' as doc_document, '' as document_name, '' as doc_doc_name 
                                    from document_type_master");
            $result=$query->result();
            $data['documents']=$result;

            for($i=0; $i<count($result); $i++){
                $d_type_id = $result[$i]->d_type_id;

                $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                                        (select * from document_types where d_type_id='$d_type_id') A 
                                        left join 
                                        (select * from document_master where d_t_type like '%rent%') B 
                                        on (A.d_id=B.d_id)) C where C.d_documentname is not null");

                $data['docs'][$d_type_id]=$query->result();
            }

            $query=$this->db->query("select * from document_type_master");
            $result=$query->result();
            $data['doc_types']=$result;

            $data['property']= $this->rent_model->getPropertyDetails();

            $query=$this->db->query("SELECT * FROM contact_type_master where g_id = '$gid' order by id desc");
            $result=$query->result();
            $data['contact_type']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('rent/tenant_details',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_sub_property() {
        $property_id = html_escape($this->input->post('property_id'));
        $txn_id = html_escape($this->input->post('txn_id'));

        // $property_id = 42;
        // $txn_id = 0;

        $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_id='$txn_id'");
        $result=$query->result();
        if (count($result)>0) {
            $sub_property_id = $result[0]->sub_property_id;
        } else {
            $sub_property_id = '0';
        }

        $result= $this->rent_model->getSubPropertyDetails($txn_id, $property_id);

        $sub_property_list = '<option value="" Selected>Select Sub Property</option>';

        foreach ($result as $row) {
            if ($sub_property_id == $row->sp_id) {
                $sub_property_list = $sub_property_list . '<option value="' . $row->sp_id . '" selected>' . $row->sp_name . '</option>';
            } else {
                $sub_property_list = $sub_property_list . '<option value="' . $row->sp_id . '">' . $row->sp_name . '</option>';
            }
        }

        echo $sub_property_list;
    }

    public function saverecord(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $now=date('Y-m-d H:i:s');
            $modnow=date('Y-m-d H:i:s');

            if($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $deposit_paid_date=$this->input->post('deposit_paid_date');
            if(validateDate($deposit_paid_date)) {
                $deposit_paid_date=FormatDate($deposit_paid_date);
            } else {
                $deposit_paid_date=null;
            }

            $possession_date=$this->input->post('possession_date');
            if(validateDate($possession_date)) {
                $possession_date=FormatDate($possession_date);
            } else {
                $possession_date=null;
            }

            $termination_date=$this->input->post('termination_date');
            if(validateDate($termination_date)) {
                $termination_date=FormatDate($termination_date);
            } else {
                $termination_date=null;
            }

            $sub_property_id = $this->input->post('sub_property');
            if($sub_property_id==''){
                $sub_property_id = null;
            }
            $data = array(
                'gp_id' => $gid,
                'property_id' => $this->input->post('property'),
                'sub_property_id' => $sub_property_id,
                'tenant_id' => $this->input->post('owners'),
                'attorney_id'=>$this->input->post('attorney'),
                'rent_amount' => format_number($this->input->post('rent_amount'),2),
                'free_rent_period' => format_number($this->input->post('free_rent_period'),2),
                'deposit_amount' => format_number($this->input->post('deposit_amount'),2),
                'deposit_paid_date' => $deposit_paid_date,
                'possession_date' => $possession_date,
                'lease_period' => format_number($this->input->post('lease_period'),2),
                'rent_due_day' => format_number($this->input->post('rent_due_day'),2),
                'termination_date' => $termination_date,
                'txn_status' => $txn_status,
                'create_date' => $now,
                'created_by' => $curusr,
                'modified_date' => $now,
                'modified_by' => $curusr,
                'maker_remark' => $this->input->post('maker_remark'),
                'maintenance_by' => $this->input->post('maintenance_by'),
                'property_tax_by' => $this->input->post('property_tax_by')
                 );
            $this->db->insert('rent_txn', $data);
            $rid=$this->db->insert_id();

            $logarray['table_id']=$rid;
            $logarray['module_name']='Rent';
            $logarray['cnt_name']='Rent';
            $logarray['action']='Rent Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);

            $response_purchase_consideration=$this->rent_model->insertSchedule($rid, $txn_status);

            $this->transaction_model->insertRPDetails($rid, 'rent');
            $this->transaction_model->insertPendingActivity($rid, 'rent');

            // $docid=$this->input->post('doc_id[]');
            // $docname=$this->input->post('doc_name[]');
            // $docdesc=$this->input->post('doc_desc[]');
            // $docref=$this->input->post('ref_no[]');
            // $docdoi=$this->input->post('date_issue[]');
            // $docdoe=$this->input->post('date_expiry[]');

            // $do_type = 'property_rent';

            // $filePath='uploads/property_rent/'.$do_type.'_'.$rid.'/property_rent_documents/';
            // $upload_path = './' . $filePath;
            // if(!is_dir($upload_path)) {
            //     mkdir($upload_path, 0777, TRUE);
            // }

            // $confi['upload_path']=$upload_path;
            // $confi['allowed_types']='*';
            // $this->load->library('upload', $confi);

            // $doccnt=0;

            // for ($k=0; $k < count($docname); $k++) {
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
                        
            //             $data = array(
            //                 'rt_doc_rentid' => $rid,
            //                 'rt_doc_name' => $docname[$k],
            //                 'rt_doc_description' => $docdesc[$k],
            //                 'rt_doc_ref_no' => $docref[$k],
            //                 'rt_doc_doi' => $doi,
            //                 'rt_doc_doe' => $doe,
            //                 'rt_document' => $filePath.$fileName,
            //                 'rt_document_name' => $fileName,
            //                 'fk_d_id' => $docid[$k]
            //             );
            //             $this->db->insert('rent_document_details', $data);
            //             echo "Main<br>";
            //         } else {
            //             echo "Other<br>";
            //             $data = array(
            //                 'rt_doc_rentid' => $rid,
            //                 'rt_doc_name' => $docname[$k],
            //                 'rt_doc_description' => $docdesc[$k],
            //                 'rt_doc_ref_no' => $docref[$k],
            //                 'rt_doc_doi' => $doi,
            //                 'rt_doc_doe' => $doe,
            //                 'rt_document' => '',
            //                 'rt_document_name' => '',
            //                 'fk_d_id' => $docid[$k]
            //             );
            //             $this->db->insert('rent_document_details', $data);
            //         }
            //     }

            //     $doccnt = $doccnt + 1;
            // }

            $this->document_model->insert_doc($rid, 'Property_Rent');

            $this->rent_model->send_rent_intimation($rid);

            redirect(base_url().'index.php/Rent');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($rid){
        $data['tax_details']=$this->rent_model->getAllTaxes('rent');

        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1) {
                $data['access']=$result;
                $ptype = '';

                $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_fkid = '$rid'");
                $result1=$query->result();
                if (count($result1)>0){
                    $rid = $result1[0]->txn_id;
                }

                $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%Rent%' AND status = '1' AND tax_action='1'"); 
                $result=$query->result();
                $data['tax']=$result;

                $data['property']= $this->rent_model->getPropertyDetails($rid);

                // $query=$this->db->query("SELECT * FROM document_master WHERE d_t_type like '%Rent%'");
                // $result=$query->result();
                // $data['docs']=$result;

                $query=$this->db->query("select G.*, H.a_name from 
                                        (select E.*, F.c_name from 
                                        (select C.*, D.sp_name from 
                                        (select A.*, B.p_property_name, B.p_display_name, B.p_type from 
                                        (select * from rent_txn where txn_id = '$rid') A 
                                        left join 
                                        (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') B 
                                        on A.property_id = B.txn_id) C 
                                        left join 
                                        (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved') D 
                                        on C.sub_property_id = D.txn_id) E 
                                        left join 
                                        (select concat('c_',c_id) as c_id, contact_name as c_name from 
                                        (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                                            ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
                                        (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                                        left join 
                                        (select * from contact_type_master where g_id='$gid') B 
                                        on (A.c_contact_type = B.id)) C 
                                        union all 
                                        select concat('o_',ow_id) as c_id, owner_name as c_name from 
                                        (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                                            when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                                            when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                                            when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                                            when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                                            from (select ow_gid, ow_id, ow_type, 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                                    where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                                                ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                                                ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
                                        where ow_status='Approved' and ow_gid='$gid') A) B 
                                        where ow_gid='$gid') F 
                                        on (E.tenant_id = F.c_id)) G 
                                        left join 
                                        (select c_id, concat(ifnull(c_name,''),' ',ifnull(c_last_name,''),' - ',ifnull(c_emailid1,''),' - ',
                                            ifnull(c_mobile1,''),' - ',ifnull(c_company,'')) as a_name from contact_master 
                                        where c_status='Approved' and c_gid='$gid') H 
                                        on (G.attorney_id = H.c_id)");
                $result=$query->result();
                if(count($result)>0) {
                    $ptype = $result[0]->p_type;

                    $data['editrent']=$result;
                    if ($result[0]->txn_status=="Approved") {
                        $txn_status=1;
                    } else {
                        $txn_status=3;
                    }
                    $property_id=$result[0]->property_id;
                } else {
                    $txn_status=3;
                    $property_id='0';
                }

                // $query=$this->db->query("SELECT A.*, B.d_m_status FROM (SELECT * FROM rent_document_details WHERE rt_doc_rentid='$rid') A LEFT JOIN (SELECT * FROM document_master) B ON (A.fk_d_id=B.d_id)");
                // $result=$query->result();
                // $data['editdocs']=$result;

                if($ptype=='Building'){
                    $pcolname="d_type_building";
                } else if($ptype=='Apartment'){
                    $pcolname="d_type_apartment";
                } else if($ptype=='Bunglow'){
                    $pcolname="d_type_bunglow";
                } else if($ptype=='Commercial'){
                    $pcolname="d_type_commercial";
                } else if($ptype=='Retail'){
                    $pcolname="d_type_retail";
                } else if($ptype=='Industrial'){
                    $pcolname="d_type_industry";
                } else if($ptype=='Land-Agriculture'){
                    $pcolname="d_type_landagriculture";
                } else if($ptype=='Land-NonAgriculture'){
                    $pcolname="d_type_landnonagricultural";
                }

                $query=$this->db->query("select C.*, D.d_documentname as doc_documentname, d_show_expiry_date from 
                                        (select A.*, B.d_type_id, B.d_type, B.d_m_status from 
                                        (select * from document_details where doc_ref_id='$rid' and doc_ref_type='Property_Rent') A 
                                        left join 
                                        (select * from document_type_master) B 
                                        on (A.doc_type_id=B.d_type_id)) C 
                                        left join 
                                        (select * from document_master) D 
                                        on (C.doc_doc_id=D.d_id)");
                $result=$query->result();
                $data['documents']=$result;

                if(count($result)>0){
                    for($i=0; $i<count($result); $i++){
                        $d_type_id = $result[$i]->d_type_id;

                        $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                                                (select * from document_types where d_type_id='$d_type_id') A 
                                                left join 
                                                (select * from document_master where d_t_type like '%rent%' and $pcolname='Yes') B 
                                                on (A.d_id=B.d_id)) C where C.d_documentname is not null");

                        $data['docs'][$d_type_id]=$query->result();
                    }
                } else {
                    $query=$this->db->query("select d_type_id, d_type, d_m_status, '' as doc_doc_id, 
                                            '' as doc_documentname, '' as d_show_expiry_date, 
                                            '' as doc_description, '' as doc_ref_no, '' as doc_doi, 
                                            '' as doc_doe, '' as doc_document, '' as document_name 
                                            from document_type_master");
                    $result=$query->result();
                    $data['documents']=$result;

                    for($i=0; $i<count($result); $i++){
                        $d_type_id = $result[$i]->d_type_id;

                        $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                                                (select * from document_types where d_type_id='$d_type_id') A 
                                                left join 
                                                (select * from document_master where d_t_type like '%rent%') B 
                                                on (A.d_id=B.d_id)) C where C.d_documentname is not null");

                        $data['docs'][$d_type_id]=$query->result();
                    }
                }

                $query=$this->db->query("select * from document_type_master");
                $result=$query->result();
                $data['doc_types']=$result;

                $query=$this->db->query("SELECT * FROM contact_type_master where g_id = '$gid' order by id desc");
                $result=$query->result();
                $data['contact_type']=$result;

                $sql = "select A.*, B.contact_name, B.c_contact_type, B.contact_type from
                        (select * from related_party_details where ref_id = '$rid' and type = 'rent') A 
                        left join 
                        (select * from 
                        (select A.c_id, A.c_contact_type, B.contact_type, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',
                            ifnull(A.c_emailid1,''),' - ',ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',
                            ifnull(B.contact_type,'')) as contact_name from 
                        (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                        left join 
                        (select * from contact_type_master where g_id='$gid') B 
                        on A.c_contact_type = B.id) C) B 
                        on A.contact_id = B.c_id";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    $data['related_party']=$result;
                }

                $query=$this->db->query("SELECT * FROM pending_activity WHERE ref_id = '$rid' and type = 'rent'");
                $result=$query->result();
                if(count($result)>0){
                    $data['pending_activity']=$result;
                }

                $data['sub_property']= $this->rent_model->getSubPropertyDetails($rid, $property_id);

                $distict_tax=$this->rent_model->getDistinctTaxDetail($rid, $txn_status);
                $data['tax_name']=$distict_tax;
                // print_r($distict_tax);
                // $data['tax_name']=$distict_tax;
                $event_type='';
                $event_name='';
                $basic_amount=0;
                $net_amount=0;
                $sql="SELECT event_type,sum(basic_cost) as basic_cost,sum(net_amount) as net_amount FROM rent_schedule 
                        WHERE rent_id = '".$rid."' and status = '$txn_status' GROUP BY event_type";
                //$query=$this->db->query("SELECT * FROM temp_schedule WHERE txn_type = '".$rid."' and status = '1' ");
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['p_schedule']=array();
                //echo $rid;
               
                $k=0;
                if(count($result)>0) {
                    foreach($result as $row){                     

                        $data['p_schedule'][$k]['event_type']=$row->event_type;
                        $data['p_schedule'][$k]['event_name']=$event_name;
                        $data['p_schedule'][$k]['basic_cost']=$row->basic_cost;
                        $data['p_schedule'][$k]['net_amount']=$row->net_amount;
                            //distint tax name
                        $query=$this->db->query("SELECT tax_type,sum(tax_amount) as tax_amount FROM rent_schedule_taxation 
                                                WHERE rent_id = '".$rid."' and event_type = '".$row->event_type."' and status = '$txn_status' 
                                                group by tax_type order by tax_type asc ");
                        $result_tax=$query->result();
                        $j=0;
                        if(count($result_tax) > 0){
                            foreach($result_tax as $taxrow){
                                $data['p_schedule'][$k]['tax_type'][$j]=$taxrow->tax_type;
                                $data['p_schedule'][$k]['tax_amount'][$j]=$taxrow->tax_amount;
                                //$data['p_schedule'][$k]['tax_percent'][$j]=$taxrow->tax_percent;
                                $j++;
                            }
                        }

                        $k++;
                    }
                }

                $query=$this->db->query("SELECT tax_type, sum(tax_amount) as total_tax_amount FROM rent_schedule_taxation 
                                        WHERE rent_id = '".$rid."'  and status = '$txn_status' group by tax_type order by tax_type asc ");
                $result_tax=$query->result();
                //echo $this->db->last_query();
                $k=0;
                foreach($result_tax as $row){
                    $data['total_tax_amount'][$k]=$row->total_tax_amount;
                    $k++;
                }


                //for edit
               $sql="SELECT * FROM rent_schedule  WHERE rent_id = '".$rid."' and status = '$txn_status' ";
                //$query=$this->db->query("SELECT * FROM temp_schedule WHERE txn_type = '".$rid."' and status = '1' ");
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['p_schedule1']=array();
                //echo $rid;
               
                $k=0;
                if(count($result)>0) {
                    foreach($result as $row) {
                        $data['p_schedule1'][$k]['schedule_id']=$row->sch_id;
                        $data['p_schedule1'][$k]['event_type']=$row->event_type;
                        $data['p_schedule1'][$k]['event_name']=$row->event_name;
                        $data['p_schedule1'][$k]['basic_cost']=$row->basic_cost;
                        $data['p_schedule1'][$k]['net_amount']=$row->net_amount;
                        $data['p_schedule1'][$k]['event_date']=$row->event_date;

                        //distint tax name
                        // $query=$this->db->query("SELECT * FROM rent_schedule_taxation WHERE rent_id = '".$rid."' and event_type = '".$row->event_type."' and status = '$txn_status' order by tax_master_id Asc ");
                        $query=$this->db->query("SELECT * FROM rent_schedule_taxation WHERE rent_id = '".$rid."' and sch_id = '".$row->sch_id."' and status = '$txn_status' order by tax_master_id Asc ");
                        $result_tax=$query->result();
                        $j=0;
                        if(count($result_tax) > 0){
                            foreach($result_tax as $taxrow){
                                $data['p_schedule1'][$k]['tax_id'][$j]=$taxrow->txsc_id;
                                $data['p_schedule1'][$k]['tax_master_id'][$j]=$taxrow->tax_master_id;                            
                                $data['p_schedule1'][$k]['tax_type'][$j]=$taxrow->tax_type;
                                $data['p_schedule1'][$k]['tax_amount'][$j]=$taxrow->tax_amount;
                                $data['p_schedule1'][$k]['tax_percent'][$j]=$taxrow->tax_percent;
                                $j++;
                            }
                        }

                        //$data['p_schtxn']=$result;
                        $k++;
                    }
                }

                $data['r_id']=$rid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('rent/tenant_details',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function view($rid) {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $data['rentby']=$this->session->userdata('session_id');
        
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1) {
                $data['access']=$result;
                $ptype = '';

                $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%Rent%' AND status = '1' AND tax_action='1'");
                $result=$query->result();
                $data['tax']=$result;

                $query=$this->db->query("select G.*, H.a_name from 
                                        (select E.*, F.c_name from 
                                        (select C.*, D.sp_name from 
                                        (select A.*, B.p_property_name, B.p_display_name, B.p_type from 
                                        (select * from rent_txn where txn_id = '$rid') A 
                                        left join 
                                        (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') B 
                                        on A.property_id = B.txn_id) C 
                                        left join 
                                        (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved') D 
                                        on C.sub_property_id = D.txn_id) E 
                                        left join 
                                        (select concat('c_',c_id) as c_id, contact_name as c_name from 
                                        (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                                            ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
                                        (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                                        left join 
                                        (select * from contact_type_master where g_id='$gid') B 
                                        on (A.c_contact_type = B.id)) C 
                                        union all 
                                        select concat('o_',ow_id) as c_id, owner_name as c_name from 
                                        (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                                            when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                                            when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                                            when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                                            when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                                            from (select ow_gid, ow_id, ow_type, 
                                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                                    where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                                                ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                                                ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
                                        where ow_status='Approved' and ow_gid='$gid') A) B 
                                        where ow_gid='$gid') F 
                                        on (E.tenant_id = F.c_id)) G 
                                        left join 
                                        (select c_id, concat(ifnull(c_name,''),' ',ifnull(c_last_name,''),' - ',ifnull(c_emailid1,''),' - ',
                                            ifnull(c_mobile1,''),' - ',ifnull(c_company,'')) as a_name from contact_master 
                                        where c_status='Approved' and c_gid='$gid') H 
                                        on (G.attorney_id = H.c_id)");
                $result=$query->result();
                if(count($result)>0) {
                    $ptype=$result[0]->p_type;

                    $data['editrent']=$result;
                    $editrent=$result;
                    if ($result[0]->txn_status=="Approved") {
                        $txn_status=1;
                    } else {
                        $txn_status=3;
                    }
                } else {
                    $txn_status=3;
                }

                $distict_tax=$this->rent_model->getDistinctTaxDetail($rid, $txn_status);
                $data['tax_name']=$distict_tax;
                $event_type='';
                $event_name='';
                $basic_amount=0;
                $net_amount=0;
                $sql="SELECT event_type,sum(basic_cost) as basic_cost,sum(net_amount) as net_amount FROM rent_schedule 
                        WHERE rent_id = '".$rid."' and status = '$txn_status' GROUP BY event_type";
                //$query=$this->db->query("SELECT * FROM temp_schedule WHERE txn_type = '".$rid."' and status = '1' ");
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['p_schedule1']=array();
                //echo $rid;
               
                $k=0;
                if(count($result)>0) {
                    foreach($result as $row){
                        $data['p_schedule1'][$k]['event_type']=$row->event_type;
                        $data['p_schedule1'][$k]['event_name']=$event_name;
                        $data['p_schedule1'][$k]['basic_cost']=$row->basic_cost;
                        $data['p_schedule1'][$k]['net_amount']=$row->net_amount;
                        //distint tax name
                        $query=$this->db->query("SELECT tax_type,sum(tax_amount) as tax_amount FROM rent_schedule_taxation 
                                                    WHERE rent_id = '".$rid."' and event_type = '".$row->event_type."' and status = '$txn_status' 
                                                    group by tax_type order by tax_type asc ");
                        $result_tax=$query->result();
                        $j=0;
                        if(count($result_tax) > 0){
                            foreach($result_tax as $taxrow){
                                $data['p_schedule1'][$k]['tax_type'][$j]=$taxrow->tax_type;
                                $data['p_schedule1'][$k]['tax_amount'][$j]=$taxrow->tax_amount;
                                //$data['p_schedule'][$k]['tax_percent'][$j]=$taxrow->tax_percent;
                                $j++;
                            }
                        }

                        //$data['p_schtxn']=$result;
                        $k++;
                    }
                }

                $query=$this->db->query("SELECT tax_type, sum(tax_amount) as total_tax_amount FROM rent_schedule_taxation 
                                        WHERE rent_id = '".$rid."'  and status = '$txn_status' group by tax_type order by tax_type asc ");
                $result_tax=$query->result();
                $k=0;
                foreach($result_tax as $row){
                    $data['total_tax_amount'][$k]=$row->total_tax_amount;
                    $k++;
                }

                $query=$this->db->query("SELECT * FROM rent_schedule WHERE rent_id = '$rid' and status = '$txn_status' ");
                $result=$query->result();
                $data['p_schedule']=array();
                //echo $rid;
               
                $k=0;
                if(count($result)>0) {
                    foreach($result as $row){
                        $data['p_schedule'][$k]['schedule_id']=$row->sch_id;
                        $data['p_schedule'][$k]['event_type']=$row->event_type;
                        $data['p_schedule'][$k]['event_name']=$row->event_name;
                        $data['p_schedule'][$k]['basic_cost']=$row->basic_cost;
                        $data['p_schedule'][$k]['net_amount']=$row->net_amount;
                        $data['p_schedule'][$k]['event_date']=$row->event_date;

                            //distint tax name
                         $query=$this->db->query("SELECT * FROM rent_schedule_taxation WHERE rent_id = '$rid' and sch_id = '$row->sch_id' and status = '$txn_status' order by tax_master_id Asc ");
                        $result_tax=$query->result();
                        //echo $this->db->last_query();

                        $j=0;
                        if(count($result_tax) > 0){
                            //print_r($result_tax);
                            foreach($result_tax as $taxrow){
                                $data['p_schedule'][$k]['tax_id'][$j]=$taxrow->txsc_id;
                                $data['p_schedule'][$k]['tax_master_id'][$j]=$taxrow->tax_master_id;                            
                                $data['p_schedule'][$k]['tax_type'][$j]=$taxrow->tax_type;
                                $data['p_schedule'][$k]['tax_amount'][$j]=$taxrow->tax_amount;
                                $data['p_schedule'][$k]['tax_percent'][$j]=$taxrow->tax_percent;
                        $j++;
                            }
                        }

                        //$data['p_schtxn']=$result;
                        $k++;
                    }
                
                }

                $query=$this->db->query("SELECT * FROM contact_type_master where g_id = '$gid' order by id desc");
                $result=$query->result();
                $data['contact_type']=$result;

                $sql = "select A.*, B.contact_name, B.c_contact_type, B.contact_type from
                        (select * from related_party_details where ref_id = '$rid' and type = 'rent') A 
                        left join 
                        (select * from 
                        (select A.c_id, A.c_contact_type, B.contact_type, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',
                            ifnull(A.c_emailid1,''),' - ',ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',
                            ifnull(B.contact_type,'')) as contact_name from 
                        (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                        left join 
                        (select * from contact_type_master where g_id='$gid') B 
                        on A.c_contact_type = B.id) C) B 
                        on A.contact_id = B.c_id";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    $data['related_party']=$result;
                }

                // $query=$this->db->query("SELECT A.*, B.d_m_status FROM (SELECT * FROM rent_document_details WHERE rt_doc_rentid='$rid') A LEFT JOIN (SELECT * FROM document_master) B ON (A.fk_d_id=B.d_id)");
                // $result=$query->result();
                // $data['editdocs']=$result;
                
                $query=$this->db->query("select C.*, D.d_documentname as doc_documentname, d_show_expiry_date from 
                                        (select A.*, B.d_type_id, B.d_type, B.d_m_status from 
                                        (select * from document_details where doc_ref_id='$rid' and doc_ref_type='Property_Rent') A 
                                        left join 
                                        (select * from document_type_master) B 
                                        on (A.doc_type_id=B.d_type_id)) C 
                                        left join 
                                        (select * from document_master) D 
                                        on (C.doc_doc_id=D.d_id)");
                $result=$query->result();
                $data['documents']=$result;

                if($ptype=='Building'){
                    $pcolname="d_type_building";
                } else if($ptype=='Apartment'){
                    $pcolname="d_type_apartment";
                } else if($ptype=='Bunglow'){
                    $pcolname="d_type_bunglow";
                } else if($ptype=='Commercial'){
                    $pcolname="d_type_commercial";
                } else if($ptype=='Retail'){
                    $pcolname="d_type_retail";
                } else if($ptype=='Industrial'){
                    $pcolname="d_type_industry";
                } else if($ptype=='Land-Agriculture'){
                    $pcolname="d_type_landagriculture";
                } else if($ptype=='Land-NonAgriculture'){
                    $pcolname="d_type_landnonagricultural";
                }

                for($i=0; $i<count($result); $i++){
                    $d_type_id = $result[$i]->d_type_id;

                    $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                                            (select * from document_types where d_type_id='$d_type_id') A 
                                            left join 
                                            (select * from document_master where d_t_type like '%purchase%' and $pcolname='Yes') B 
                                            on (A.d_id=B.d_id)) C where C.d_documentname is not null");

                    $data['docs'][$d_type_id]=$query->result();
                }

                $query=$this->db->query("SELECT * FROM pending_activity WHERE ref_id = '$rid' and type = 'rent'");
                $result=$query->result();
                if(count($result)>0){
                    $data['pending_activity']=$result;
                }

                $query=$this->db->query("select * from document_type_master");
                $result=$query->result();
                $data['doc_types']=$result;

                // $query=$this->db->query("SELECT * FROM document_master WHERE d_t_type like '%Rent%'");
                // $result=$query->result();
                // $data['docs']=$result;
                
                $data['r_id']=$rid;

                 $query=$this->db->query("SELECT A.pr_client_id, A.pr_ownership_percent,case when B.ow_type = '0' then 
                                                    (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name 
                                                        from contact_master where c_id = B.ow_ind_id) 
                                                    when B.ow_type = '1' then B.ow_huf_name 
                                                    when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                                    when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                                    when B.ow_type = '4' then B.ow_llp_comapny_name 
                                                    when B.ow_type = '5' then B.ow_prt_comapny_name 
                                                    when B.ow_type = '6' then B.ow_aop_comapny_name 
                                                    when B.ow_type = '7' then B.ow_trs_comapny_name 
                                                    else B.ow_proprietorship_comapny_name end as owner_name 
                                        FROM purchase_ownership_details A, owner_master B 
                                        WHERE A.purchase_id = '".$editrent[0]->property_id."' and A.pr_client_id=B.ow_id");
                $result=$query->result();
                //echo $this->db->last_query();
                $data['s_owner']=$result;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('rent/tenant_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    // public function downloadrentdocs($rid, $docid) {
    //     $query=$this->db->query("SELECT * FROM rent_document_details WHERE rt_doc_id='$docid'");
    //     $result=$query->result();
    //     $this->load->library('ftp');
        
    //     $ftp_config['hostname'] = 'localhost';
    //     $ftp_config['username'] = 'otb@techbloomers.com';
    //     $ftp_config['password'] = 'Otb@12345';$ftp_config['port'] = 21;
    //     $ftp_config['debug'] = FALSE;

    //     $this->ftp->connect($ftp_config);
    //     $source=$result[0]->rt_document;
    //     if(!is_dir('./downloads/rent/'.$rid.'/')) {
    //         mkdir('./downloads/rent/'.$rid.'/', 0777, TRUE);
    //     }

    //     $destination='./downloads/rent/'.$rid.'/'.$result[0]->rt_document_name;
    //     $this->ftp->download($source, $destination);   
    //     $this->ftp->close();
    // }
    
    public function updaterecord($rid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $txn_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_id = '$rid'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->txn_status;
                $txn_fkid = $res[0]->txn_fkid;
                $gp_id = $res[0]->gp_id;
                $created_by = $res[0]->created_by;
                $create_date = $res[0]->create_date;
            } else {
                $rec_status = 'In Process';
                $txn_fkid = '';
                $gp_id = $gid;
                $created_by = $curusr;
                $create_date = $now;
            }

            if($txn_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $txn_status = 'Inactive';

                            $this->db->query("update rent_txn set txn_status='$txn_status', remarks='$txnremarks', modified_by='$curusr', 
                                            modified_date='$modnow' WHERE txn_id = '$rid'");
                            $logarray['table_id']=$rid;
                            $logarray['module_name']='Rent';
                            $logarray['cnt_name']='Rent';
                            $logarray['action']='Rent Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_fkid = '$rid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $rid = $result[0]->txn_id;

                                $this->db->query("Update rent_txn set txn_status='$txn_status', remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE txn_id = '$rid'");
                                
                                $logarray['table_id']=$rid;
                                $logarray['module_name']='Rent';
                                $logarray['cnt_name']='Rent';
                                $logarray['action']='Rent Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into rent_txn (gp_id, property_id, sub_property_id, tenant_id, rent_amount, 
                                                 free_rent_period, deposit_amount, deposit_paid_date, possession_date, lease_period, 
                                                 rent_due_day, termination_date, txn_status, create_date, created_by, 
                                                 modified_date, modified_by, approved_by, approved_date, remarks, txn_fkid, 
                                                 rejected_by, rejected_date, maker_remark, maintenance_by, property_tax_by) 
                                                 Select '$gp_id', property_id, sub_property_id, tenant_id, rent_amount, 
                                                 free_rent_period, deposit_amount, deposit_paid_date, possession_date, lease_period, 
                                                 rent_due_day, termination_date, '$txn_status', '$create_date', '$created_by', 
                                                 '$modnow', '$curusr', approved_by, approved_date, '$txnremarks', '$rid', 
                                                 rejected_by, rejected_date, maker_remark, maintenance_by, property_tax_by 
                                                 FROM rent_txn WHERE txn_id = '$rid'");
                                $new_rid=$this->db->insert_id();

                                $logarray['table_id']=$rid;
                                $logarray['module_name']='Rent';
                                $logarray['cnt_name']='Rent';
                                $logarray['action']='Rent Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                // $this->db->query("Insert into rent_document_details (rt_doc_rentid, rt_doc_name, rt_doc_description, 
                                //                  rt_doc_ref_no, rt_doc_doi, rt_doc_doe, rt_document, rt_document_name, fk_d_id) 
                                //                  Select '$new_rid', rt_doc_name, rt_doc_description, 
                                //                  rt_doc_ref_no, rt_doc_doi, rt_doc_doe, rt_document, rt_document_name, fk_d_id 
                                //                  FROM rent_document_details WHERE rt_doc_rentid = '$rid'");

                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name)  
                                                 Select '$new_rid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$rid' and doc_ref_type = 'Property_Rent'");

                                $query=$this->db->query("SELECT * FROM rent_schedule WHERE rent_id = '$rid'");
                                $result=$query->result();
                                if (count($result)>0){
                                    for($i=0; $i<count($result); $i++) {
                                        $sch_id = $result[$i]->sch_id;
                                        $sch_create_date = $result[$i]->create_date;
                                        $sch_create_by = $result[$i]->create_by;

                                        $this->db->query("Insert into rent_schedule (rent_id, event_name, event_type, event_date, basic_cost, 
                                                         net_amount, sch_status, create_date, create_by, modified_date, modified_by, status) 
                                                         Select '$new_rid', event_name, event_type, event_date, basic_cost, net_amount, '3', 
                                                         '$sch_create_date', '$sch_create_by', '$modnow', '$curusr', '3' 
                                                         FROM rent_schedule WHERE rent_id = '$rid' and sch_id = '$sch_id'");
                                        $new_sch_id=$this->db->insert_id();

                                        $this->db->query("Insert into rent_schedule_taxation (sch_id, tax_master_id, tax_type, tax_percent, 
                                                         tax_amount, rent_id, event_type, status) 
                                                         Select '$new_sch_id', tax_master_id, tax_type, tax_percent, tax_amount, '$new_rid', 
                                                         event_type, '3' 
                                                         FROM rent_schedule_taxation WHERE rent_id = '$rid' and sch_id = '$sch_id'");
                                    }
                                }

                                $this->db->query("Insert into related_party_details (ref_id, type, contact_id, remarks) 
                                                 Select '$new_rid', type, contact_id, remarks FROM related_party_details 
                                                 WHERE ref_id = '$rid' and type = 'rent'");

                                $this->db->query("Insert into pending_activity (ref_id, type, pending_activity) 
                                                 Select '$new_rid', type, pending_activity FROM pending_activity 
                                                 WHERE ref_id = '$rid' and type = 'rent'");
                            
                            }
                        }
                    } else {
                        $this->db->where('txn_id', $rid);
                        $this->db->delete('rent_txn');

                        // $this->db->where('rt_doc_rentid', $rid);
                        // $this->db->delete('rent_document_details');

                        $this->db->where('doc_ref_id', $rid);
                        $this->db->where('doc_ref_type', 'Property_Rent');
                        $this->db->delete('document_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_schedule');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_schedule_taxation');

                        $this->db->where('ref_id', $rid);
                        $this->db->where('type', 'rent');
                        $this->db->delete('related_party_details');

                        $this->db->where('ref_id', $rid);
                        $this->db->where('type', 'rent');
                        $this->db->delete('pending_activity');

                        $logarray['table_id']=$rid;
                        $logarray['module_name']='Rent';
                        $logarray['cnt_name']='Rent';
                        $logarray['action']='Rent Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Rent');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    $deposit_paid_date=$this->input->post('deposit_paid_date');
                    if(validateDate($deposit_paid_date)) {
                        $deposit_paid_date=FormatDate($deposit_paid_date);
                    } else {
                        $deposit_paid_date=null;
                    }

                    $possession_date=$this->input->post('possession_date');
                    if(validateDate($possession_date)) {
                        $possession_date=FormatDate($possession_date);
                    } else {
                        $possession_date=null;
                    }

                    $termination_date=$this->input->post('termination_date');
                    if(validateDate($termination_date)) {
                        $termination_date=FormatDate($termination_date);
                    } else {
                        $termination_date=null;
                    }

                    $sub_property_id = $this->input->post('sub_property');
                    if($sub_property_id==''){
                        $sub_property_id = null;
                    }
                    
                    $data = array(
                        'gp_id' => $gp_id,
                        'property_id' => $this->input->post('property'),
                        'sub_property_id' => $sub_property_id,
                        'tenant_id' => $this->input->post('owners'),
                        'rent_amount' => format_number($this->input->post('rent_amount'),2),
                        'free_rent_period' => format_number($this->input->post('free_rent_period'),2),
                        'deposit_amount' => format_number($this->input->post('deposit_amount'),2),
                        'deposit_paid_date' => $deposit_paid_date,
                        'possession_date' => $possession_date,
                        'lease_period' => format_number($this->input->post('lease_period'),2),
                        'rent_due_day' => format_number($this->input->post('rent_due_day'),2),
                        'termination_date' => $termination_date,
                        'txn_status' => $txn_status,
                        'maker_remark'=>$this->input->post('maker_remark'),
                        'maintenance_by' => $this->input->post('maintenance_by'),
                        'property_tax_by' => $this->input->post('property_tax_by')
                        );
                    
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $txn_fkid = $rid;
                        $data['txn_fkid'] = $txn_fkid;
                        $data['create_date'] = $create_date;
                        $data['created_by'] = $created_by;
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->insert('rent_txn',$data);
                        $rid=$this->db->insert_id();

                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Rent';
                        $logarray['cnt_name']='Rent';
                        $logarray['action']='Rent Approved Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        // $this->db->query("Insert into rent_document_details (rt_doc_rentid, rt_doc_name, 
                        //                  rt_doc_description, rt_doc_ref_no, rt_doc_doi, rt_doc_doe, rt_document, 
                        //                  rt_document_name, fk_d_id) 
                        //                  Select '$rid', rt_doc_name, rt_doc_description, rt_doc_ref_no, rt_doc_doi, 
                        //                  rt_doc_doe, rt_document, rt_document_name, fk_d_id FROM rent_document_details 
                        //                  WHERE rt_doc_rentid = '$txn_fkid'");
                    } else {
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->where('txn_id', $rid);
                        $this->db->update('rent_txn',$data);

                        $logarray['table_id']=$rid;
                        $logarray['module_name']='Rent';
                        $logarray['cnt_name']='Rent';
                        $logarray['action']='Rent Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_schedule');
                        
                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_schedule_taxation');

                        $this->db->where('ref_id', $rid);
                        $this->db->where('type', 'rent');
                        $this->db->delete('related_party_details');
                        
                        $this->db->where('ref_id', $rid);
                        $this->db->where('type', 'rent');
                        $this->db->delete('pending_activity');
                    }

                    // if ($txn_status!="Delete" || $rec_status=="Approved") {
                        // if ($this->input->post('brokername')!='') {
                        //     $afftectedRows=0;
                        //     $data = array(
                        //         'bro_contactid' => $this->input->post('brokername'),
                        //         'bro_remarks' => $this->input->post('brokerage_remarks')
                        //         );
                        //     $this->db->where('rent_id', $rid);
                        //     $this->db->update('rent_brokerage_details', $data);
                        //     $afftectedRows=$this->db->affected_rows();

                        //     if($afftectedRows==0) {
                        //         $data = array(
                        //             'rent_id' => $rid,
                        //             'bro_contactid' => $this->input->post('brokername'),
                        //             'bro_remarks' => $this->input->post('brokerage_remarks')
                        //             );
                        //         $this->db->insert('rent_brokerage_details', $data);
                        //     }
                        // }


                        $this->rent_model->insertSchedule($rid, $txn_status);

                        $this->transaction_model->insertRPDetails($rid, 'rent');
                        $this->transaction_model->insertPendingActivity($rid, 'rent');


                        // $query=$this->db->query("SELECT * FROM rent_document_details WHERE rt_doc_rentid = '$rid'");
                        // $result=$query->result();
                        // $file_path_db=NULL;
                        // $file_path_count=0;

                        // for ($i=0; $i < count($result) ; $i++) { 
                        //     $file_path_db[$i]['docname']=$result[$i]->rt_doc_name;
                        //     $file_path_db[$i]['docdesc']=$result[$i]->rt_doc_description;
                        //     $file_path_db[$i]['docrefno']=$result[$i]->rt_doc_ref_no;
                        //     $file_path_db[$i]['docdoi']=$result[$i]->rt_doc_doi;
                        //     $file_path_db[$i]['docdoe']=$result[$i]->rt_doc_doe;
                        //     $file_path_db[$i]['docpath']=$result[$i]->rt_document;
                        //     $file_path_db[$i]['docfilename']=$result[$i]->rt_document_name;
                        //     $file_path_db[$i]['docid']=$result[$i]->fk_d_id;
                        //     $file_path_count=$i;
                        // }

                        // // if ($rec_status!="Approved") {
                        //     $this->db->where('rt_doc_rentid', $rid);
                        //     $this->db->delete('rent_document_details');
                        // // }

                        // $docid=$this->input->post('doc_id[]');
                        // $docname=$this->input->post('doc_name[]');
                        // $docdesc=$this->input->post('doc_desc[]');
                        // $docref=$this->input->post('ref_no[]');
                        // $docdoi=$this->input->post('date_issue[]');
                        // $docdoe=$this->input->post('date_expiry[]');

                        // $do_type = 'property_rent';

                        // $filePath='uploads/property_rent/'.$do_type.'_'.$rid.'/property_rent_documents/';
                        // $upload_path = './' . $filePath;
                        // if(!is_dir($upload_path)) {
                        //     mkdir($upload_path, 0777, TRUE);
                        // }

                        // $confi['upload_path']=$upload_path;
                        // $confi['allowed_types']='*';
                        // $this->load->library('upload', $confi);
                        // $this->upload->initialize($confi);
                        
                        // $doccnt=0;

                        // for ($k=0; $k <  count($docname); $k++) {
                        //     if(isset($docname[$k]) and $docname[$k]!="") {
                        //         $docname=str_replace('/', '_', $docname);
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
                                    
                        //             $source='./uploads/'.$fileName;
                        //             $extension=$upload_data['file_ext'];

                        //             $data = array(
                        //                 'rt_doc_rentid' => $rid,
                        //                 'rt_doc_name' => $docname[$k],
                        //                 'rt_doc_description' => $docdesc[$k],
                        //                 'rt_doc_ref_no' => $docref[$k],
                        //                 'rt_doc_doi' => $doi,
                        //                 'rt_doc_doe' => $doe,
                        //                 'rt_document' => $filePath.$fileName,
                        //                 'rt_document_name' => $fileName,
                        //                 'fk_d_id' => $docid[$k]
                        //             );
                        //             $this->db->insert('rent_document_details', $data);
                        //             echo "Main<br>";
                        //         } else {
                        //             if($file_path_count>=$k) {
                        //                 $path=$file_path_db[$k]['docpath'];
                        //                 $flnm=$file_path_db[$k]['docfilename'];
                        //             } else {
                        //                 $path="";
                        //                 $flnm="";
                        //             }
                        //             echo "Other<br>";
                        //             $data = array(
                        //                 'rt_doc_rentid' => $rid,
                        //                 'rt_doc_name' => $docname[$k],
                        //                 'rt_doc_description' => $docdesc[$k],
                        //                 'rt_doc_ref_no' => $docref[$k],
                        //                 'rt_doc_doi' => $doi,
                        //                 'rt_doc_doe' => $doe,
                        //                 'rt_document' => $path,
                        //                 'rt_document_name' => $flnm,
                        //                 'fk_d_id' => $docid[$k]
                        //             );
                        //             $this->db->insert('rent_document_details', $data);
                        //         }
                        //     }

                        //     $doccnt = $doccnt + 1;
                        // }

                        $this->document_model->insert_doc($rid, 'Property_Rent');

                    // }

                    redirect(base_url().'index.php/Rent');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approve($rid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_id = '$rid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->txn_status;
                    $txn_fkid = $res[0]->txn_fkid;
                    $gp_id = $res[0]->gp_id;
                } else {
                    $rec_status = 'In Process';
                    $txn_fkid = '';
                    $gp_id = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $txn_status='Approved';
                } else  {
                    $txn_status='Rejected';
                }
                $remarks = $this->input->post('status_remarks');

                if ($txn_status=='Rejected') {
                    $this->db->query("update rent_txn set txn_status='Rejected', remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE txn_id = '$rid'");

                    $logarray['table_id']=$rid;
                    $logarray['module_name']='Rent';
                    $logarray['cnt_name']='Rent';
                    $logarray['action']='Rent Record ' . $txn_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($txn_fkid=='' || $txn_fkid==null) {
                        $this->db->query("update rent_txn set txn_status='Approved', remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE txn_id = '$rid'");
                        $this->db->query("update rent_schedule set sch_status = '1', status='1' WHERE rent_id = '$rid'");
                        $this->db->query("update rent_schedule_taxation set status='1' WHERE rent_id = '$rid'");

                        $logarray['table_id']=$rid;
                        $logarray['module_name']='Rent';
                        $logarray['cnt_name']='Rent';
                        $logarray['action']='Rent Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                        }
                        $this->db->query("update rent_txn A, rent_txn B set A.gp_id=B.gp_id, A.property_id=B.property_id, 
                                         A.sub_property_id=B.sub_property_id, A.tenant_id=B.tenant_id, 
                                         A.rent_amount=B.rent_amount, A.free_rent_period=B.free_rent_period, 
                                         A.deposit_amount=B.deposit_amount, A.deposit_paid_date=B.deposit_paid_date, 
                                         A.possession_date=B.possession_date, A.lease_period=B.lease_period, 
                                         A.rent_due_day=B.rent_due_day, A.termination_date=B.termination_date, 
                                         A.txn_status='$txn_status', A.create_date=B.create_date, A.created_by=B.created_by, 
                                         A.modified_date=B.modified_date, A.modified_by=B.modified_by, 
                                         A.approved_by='$curusr', A.approved_date='$modnow', 
                                         A.remarks='$remarks', A.rejected_by=B.rejected_by, 
                                         A.rejected_date=B.rejected_date, A.maker_remark=B.maker_remark, 
                                         A.maintenance_by=B.maintenance_by, A.property_tax_by=B.property_tax_by 
                                         WHERE B.txn_id = '$rid' and A.txn_id=B.txn_fkid");

                        // $this->db->where('rt_doc_rentid', $txn_fkid);
                        // $this->db->delete('rent_document_details');
                        // $this->db->query("update rent_document_details set rt_doc_rentid = '$txn_fkid' WHERE rt_doc_rentid = '$rid'");

                        $this->db->where('doc_ref_id', $txn_fkid);
                        $this->db->where('doc_ref_type', 'Property_Rent');
                        $this->db->delete('document_details');
                        $this->db->query("update document_details set doc_ref_id = '$txn_fkid' WHERE doc_ref_id = '$rid' and doc_ref_type = 'Property_Rent'");

                        $this->db->query("update rent_schedule set sch_status = '2', status='2' WHERE rent_id = '$txn_fkid'");
                        $this->db->query("update rent_schedule set rent_id = '$txn_fkid', sch_status = '1', status='1' WHERE rent_id = '$rid'");

                        $this->db->query("update rent_schedule_taxation set status='2' WHERE rent_id = '$txn_fkid'");
                        $this->db->query("update rent_schedule_taxation set rent_id = '$txn_fkid', status='1' WHERE rent_id = '$rid'");

                        $this->db->where('ref_id', $txn_fkid);
                        $this->db->where('type', 'rent');
                        $this->db->delete('related_party_details');
                        $this->db->query("update related_party_details set ref_id = '$txn_fkid' WHERE ref_id = '$rid' and type = 'rent'");

                        $this->db->where('ref_id', $txn_fkid);
                        $this->db->delete('pending_activity');
                        $this->db->query("update pending_activity set ref_id = '$txn_fkid' WHERE ref_id = '$rid' and type = 'rent'");

                        $this->db->query("delete from rent_txn WHERE txn_id = '$rid'");

                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Rent';
                        $logarray['cnt_name']='Rent';
                        $logarray['action']='Rent Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Rent');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function checkstatus($status=''){
        $result=$this->rent_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;
            $data['rent']=$this->rent_model->rentData($status);

            $count_data=$this->rent_model->getAllCountData();
            $approved=0;
            $pending=0;
            $rejected=0;
            $inprocess=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->txn_status))=="APPROVED")
                        $approved=$approved+1;
                    else if (strtoupper(trim($count_data[$i]->txn_status))=="PENDING" || strtoupper(trim($count_data[$i]->txn_status))=="DELETE")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]->txn_status))=="REJECTED")
                        $rejected=$rejected+1;
                    else if (strtoupper(trim($count_data[$i]->txn_status))=="IN PROCESS")
                        $inprocess=$inprocess+1;
                }
            }

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inprocess']=$inprocess;
            $data['all']=count($count_data);

            $data['propertynorent']=$this->rent_model->getPropertyNotOnRent();

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('rent/tenant_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }


    //function bulk upload temp view for excel upload
    function saveTempBulkUpload() {
        $upload_txn_type=$this->input->post('upload_txn_type');
        $_FILES['data_file']['name'];
        $data_array=array();
        $file=explode(".", $_FILES['data_file']['name']);
        //echo $file[1];
        $file_name="excel"."_".$file[0]."_".date('dmy').".xls";
        $upload_path = './uploads/schedule_bulk_upload/';
            
        $this->load->library('upload');
        $this->upload->initialize(array(
            "upload_path"       => $upload_path,
            "encrypt_name"      => FALSE,
            "remove_spaces"     => TRUE,    
            "allowed_types"     => '*',
            "file_name"         => $file_name,
            "max_size"          => '20000000'
        ));

        if (!$this->upload->do_upload("data_file")){
            //echo "Not uploaded";
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
        }else{
            //echo "uploaded";
            $data = array('upload_data' => $this->upload->data());
        }
        $excel=PHPExcel_IOFactory::load($data['upload_data']['full_path']);
        $sheet=$excel->setActiveSheetIndex(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $mistake=0;
        $tax_available='';
        $errormsg='';
        for ($row = 2; $row <= $highestRow; ++$row) {
            if($sheet->getCellByColumnAndRow(1, $row)->getValue()==''){
                $event_type.=$row.",";
                $mistake++;
            }                
            // if($sheet->getCellByColumnAndRow(3, $row)->getValue()==''){
            //     $basic_cost.=$row.",";
            //     $mistake++;
            // }
            $tax_available=$tax_available.','.addslashes($sheet->getCellByColumnAndRow(4, $row)->getValue());
        }

        //echo $mistake;
        //echo $tax_available;
        
        $getAllTaxes=$this->rent_model->getAllTaxes($upload_txn_type);
        $alltaxes=array();
        foreach($getAllTaxes as $row){
            $alltaxes[]=$row->tax_name;
        }
        $tax_available=explode(',',$tax_available);
       // print_r($alltaxes);
       // print_r($tax_available);
        $tax_available=array_filter($tax_available);
        $result_array=array_diff($tax_available,$alltaxes);
        //print_r($result_array);
        if(count($result_array) > 0 ){
            $mistake++;
            $tax_not_available="following taxes are not availbale please update in Tax master.\n".implode(',',$result_array);
            $errormsg=$errormsg.$tax_not_available;
        }

        if($mistake > 0 ){
            $response=array("status"=>false,"errormsg"=>$errormsg);
        }
        else{
            for ($row = 2; $row <= $highestRow; ++$row) {
                $InvDate=$sheet->getCellByColumnAndRow(4,$row)->getValue();
                $event_date= date($format = "d/m/Y", PHPExcel_Shared_Date::ExcelToPHP($InvDate));
                $data['p_schedule'][$row]['event_type']=addslashes($sheet->getCellByColumnAndRow(1, $row)->getValue());
                $data['p_schedule'][$row]['event_name']=addslashes($sheet->getCellByColumnAndRow(1,$row)->getValue());
                // $data['p_schedule'][$row]['sch_pay_type']=addslashes($sheet->getCellByColumnAndRow(2,$row)->getValue());
                // $data['p_schedule'][$row]['sch_agree_value']=addslashes($sheet->getCellByColumnAndRow(3,$row)->getValue());

                $data['p_schedule'][$row]['event_date']=$event_date;
                $data['p_schedule'][$row]['basic_cost']=addslashes($sheet->getCellByColumnAndRow(3,$row)->getValue());
                $tax_apply=explode(',',addslashes($sheet->getCellByColumnAndRow(4,$row)->getValue()));
                for($i=0;$i<count($tax_apply);$i++){
                    $data['p_schedule'][$row]['tax_type'][$i]=$tax_apply[$i];
                }
            }
            $rowcounter=$highestRow;
            $data['tax_details']=$this->rent_model->getAllTaxes($upload_txn_type);                
            $bulkuploaddata=$this->load->view('rent/bulk_upload_view',$data,true);
            $response=array("status"=>true,"data"=>$bulkuploaddata,"rowcounter"=>$rowcounter);
        }

        echo json_encode($response);
    }

##################################RENT RECEIVE################################

    public function recieve_new($schid=NULL){
        $query=$this->db->query("SELECT * FROM rent_schedule WHERE sch_id = '$schid'");
        $result=$query->result();
        $data['rec']=$result;

        if(count($result) >0 ) {
            $rtid=$result[0]->rent_id;

            $query=$this->db->query("SELECT * FROM rent_txn LEFT JOIN purchase_txn ON rent_txn.property_id=purchase_txn.txn_id WHERE rent_txn.txn_id ='$rtid'");
            $result=$query->result();
            $data['rent_txn']=$result;

            $query=$this->db->query("SELECT * FROM rent_payment_notes WHERE sch_id='$schid'");
            $result=$query->result();
            $data['rent_note']=$result;
        }

        $data['sch_id']=$schid;
        load_view('rent/rent_payment_receive', $data);
    }

    public function savepayment($schid){
        $modnow=date('Y-m-d H:i:s');
        $query=$this->db->query("SELECT * FROM rent_schedule WHERE sch_id='$schid'");
        $result=$query->result();

        $netamt=$result[0]->net_amount;
        $paid=format_number($this->input->post('payment_amount'),2);
        $balance=$netamt-$paid;

        $status='Pending';

        if($balance==0){
            $status='Paid';
        }

                $confi['upload_path']='./uploads/';
                $confi['allowed_types']='*';
                $this->load->library('upload', $confi);
                $extension="";

                if(!empty($_FILES['attach']['name'])) {
                    if($this->upload->do_upload('attach')) {
                        echo "Uploaded <br>";
                    } else {
                        echo "Failed<br>";
                        echo $this->upload->data();
                    }   

                    $upload_data=$this->upload->data();
                    $fileName=$upload_data['file_name'];
                    
                    $source='./uploads/'.$fileName;
                    $extension=$upload_data['file_ext'];

                    echo $fileName;
                    echo "<br>".$extension."<br>";

                    $this->load->library('ftp');

                    $ftp_config['hostname'] = 'localhost';
                    $ftp_config['username'] = 'user1';
                    $ftp_config['password'] = 'password';
                    $ftp_config['port'] = 21;
                    $ftp_config['debug'] = FALSE;

                    $dir='test/rent/schedule/';
                    $this->ftp->connect($ftp_config);
            
                    $dirlst=$this->ftp->list_files($dir.'sch_'.$schid);
                    
                    $existsdir=false;

                    for($l=0;$l<count($dirlst); $l++) {
                        if ($dirlst[$l]==$dir) {
                            $existsdir=true;
                        }
                    }

                    if ($existsdir==true) {
                        $destination=$dir.'sch_'.$schid.$extension;
                        $this->ftp->upload($source, $destination, 0777);
                    } else {
                        echo "Yo!!!<br>";
                        $this->ftp->mkdir($dir.'sch_'.$schid);
                        $destination=$dir.'sch_'.$extension;
                        $this->ftp->upload($source, $destination, 0777);
                    }
                    $this->ftp->close();
                    
                    @unlink($source);
                    
                    $data = array
                    (
                        'sch_status' => $status,
                        'pay_rec_date' => $this->input->post('rec_date'),
                        'pay_amount' => $paid,
                        'pay_balance' => $balance,
                        'pay_method' => $this->input->post('method'),
                        'pay_filepath' => $destination,
                        'pay_filename' => 'sch_'.$schid.$extension,
                        'modified_date' => $modnow,
                    );

                    $this->db->where('sch_id', $schid);
                    $this->db->update('rent_schedule', $data);
                    echo "Main<br>";
                } else {
                    echo "Other<br>";
                    $data = array
                    (
                        'sch_status' => $status,
                        'pay_rec_date' => $this->input->post('rec_date'),
                        'pay_amount' => $paid,
                        'pay_balance' => $balance,
                        'pay_method' => $this->input->post('method'),
                        'pay_filepath' => '',
                        'pay_filename' => '',
                        'modified_date' => $modnow,
                    );
                    $this->db->where('sch_id', $schid);
                    $this->db->update('rent_schedule', $data);
                }

                $this->db->where('sch_id', $schid);
                $this->db->delete('rent_payment_notes');

                $account=$this->input->post('account[]');
                $bal=$this->input->post('balance[]');
                $amt=$this->input->post('amount[]');

                for ($i=0; $i < count($account) ; $i++) { 
                    $data = array
                    (
                        'sch_id' => $schid,
                        'account_number' => $account[$i],
                        'balance' => format_number($bal[$i],2),
                        'amount' => format_number($amt[$i],2),
                    );
                    $this->db->insert('rent_payment_notes', $data);   
                }
    }

    function send_mail_test(){
        $this->rent_model->send_rent_intimation('24');
    }

}
?>