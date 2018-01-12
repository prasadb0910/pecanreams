<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Profile extends CI_Controller
{
    public function __construct() {
        parent::__construct();
       
        $this->load->helper('common_functions');
        $this->load->model('contact_model');
    }

    public function index(){
        $cid=$this->session->userdata('session_id');

        $query=$this->db->query("SELECT * FROM contact_master WHERE c_id='$cid'");
        $result=$query->result();
        $data['editcontact']=$result;

        $data['c_id'] = $cid;

        if(count($data) > 0){
            load_view('contacts/your_profile', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updateRecord($cid){
        $roleid=$this->session->userdata('role_id');
		$curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');

        $now=date('Y-m-d H:i:s');

        if($this->input->post('c_dob')!='') {
            $c_dob=FormatDate($this->input->post('c_dob'));
        } else {
            $c_dob=NULL;
        }

        if ($this->input->post('c_last_name')!=""){
            $data = array(
                        'c_name' => $this->input->post('c_name'),
                        'c_middle_name' => $this->input->post('c_middle_name'),
                        'c_last_name' =>  $this->input->post('c_last_name'),
                        'c_dob' => $c_dob,
                        'c_mobile1' => $this->input->post('mobile_no1'),
                        'c_mobile2' => $this->input->post('mobile_no2'),
                        'c_emailid1' => $this->input->post('email_id1'),
                        'c_company' => $this->input->post('c_company'),
                        'c_pan_card' => $this->input->post('c_pan_card'),
                        'c_aadhar_card' => $this->input->post('c_aadhar_card'),
                        'c_address' => $this->input->post('c_address'),
                        'c_modifiedby' => $curusr,
                        'c_modifieddate' => $now
                    );
            $this->db->where('c_id', $cid);
            $this->db->update('contact_master',$data);
            $logarray['table_id']=$cid;
            $logarray['module_name']='Contact';
            $logarray['cnt_name']='contacts';
            $logarray['action']='Contact Record Modified';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);

            $file_nm='c_image_file';

            if(!empty($_FILES[$file_nm]['name'])) {
                $c_image_file = $_FILES[$file_nm]['name'];
                $c_image_file=str_replace('/', '_', $c_image_file);
                
                $filePath='uploads/client/';
                $upload_path = './' . $filePath;
                if(!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, TRUE);
                }
                $filePath='uploads/client/client_'.$cid.'/';
                $upload_path = './' . $filePath;
                if(!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, TRUE);
                }

                $confi['upload_path']=$upload_path;
                $confi['allowed_types']='*';
                $this->load->library('upload', $confi);
                $extension="";

                if(!empty($_FILES[$file_nm]['name'])) {
                    if($this->upload->do_upload($file_nm)) {
                        echo "Uploaded <br>";
                    } else {
                        echo "Failed<br>";
                        echo $this->upload->data();
                    }   

                    $upload_data=$this->upload->data();
                    $fileName=$upload_data['file_name'];
                    $extension=$upload_data['file_ext'];

                    $data = array(
                                'c_image' => $filePath.$fileName,
                                'c_image_name' => $fileName
                            );
                    $this->db->where('c_id', $cid);
                    $this->db->update('contact_master',$data);
                }
            }
        }

        redirect(base_url().'index.php/dashboard');
    }
}
?>