<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Task extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('task_model');
        $this->load->library('table');
    }

    public function index($tasktype=false){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            // $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Task' AND role_id='$roleid' AND r_view = 1");
            // $result=$query->result();
            // if(count($result)>0) {
                //var_dump($_SESSION);
                // $data['allTask']=$this->task_model->getTaskCount('all');//count for all task list
                // $data['myTask']=$this->task_model->getTaskCount('mytask');//count for My  task list task assign to myself
                // $data['pendingTask']=$this->task_model->getTaskCount('pending');//count for My  task list task assign to myself


                $allTask=$this->task_model->getTaskList($this->session->userdata('session_id'),'all');
                $myTask=$this->task_model->getTaskList($this->session->userdata('session_id'),'mytask');
                $pendingTask=$this->task_model->getTaskList($this->session->userdata('session_id'),'pending');

                $data['allTask']=count($allTask);//count for all task list
                $data['myTask']=count($myTask);//count for My  task list task assign to myself
                $data['pendingTask']=count($pendingTask);//count for My  task list task assign to myself

                $data['tasklist']=$this->task_model->getTaskList($this->session->userdata('session_id'),$tasktype);
                $data['property']= $this->task_model->getPropertyDetails();
                load_view('task/task_list',$data);
            // } else {
            //     echo '<script>alert("You donot have access to this page.");</script>';
            //     $this->load->view('login/main_page');
            // }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
	}

	public function task_view($id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            // $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Task' AND role_id='$roleid' AND r_view = 1");
            // $result=$query->result();
            // if(count($result)>0) {
                $data=$this->get_task_data($id);
                
                load_view('task/task_view',$data);
            // } else {
            //     echo '<script>alert("You donot have access to this page.");</script>';
            //     $this->load->view('login/main_page');
            // }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
	}

	public function task_edit($id=false){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            // $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Task' AND role_id='$roleid' AND r_edit = 1");
            // $result=$query->result();
            // if(count($result)>0) {
                $data=$this->get_task_data($id);

                load_view('task/task_details',$data);
            // } else {
            //     echo '<script>alert("You donot have access to this page.");</script>';
            //     $this->load->view('login/main_page');
            // }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
	}

    function get_task_data($id) {
        $task_id=urldecode($id);
        $userid=$this->session->userdata('session_id');
        $data['property']= $this->task_model->getPropertyDetails();
        if($task_id !=''){
            $data['taskdetail']=$this->task_model->getTaskDetail($task_id);
            $data['comment']=$this->task_model->getCommentDetail($task_id);

            $property_id = $data['taskdetail']->property_id;
            $data['sub_property']= $this->task_model->getSubPropertyDetails($property_id);

            if(count($data['taskdetail'])>0){
                $fk_task_id=$data['taskdetail']->task_id;
            } else {
                $fk_task_id='';
            }

            $data['editcontact']=$this->task_model->getTaskUsers($fk_task_id);
            $data['editfollower']=$this->task_model->getTaskFollower($fk_task_id);

            $data['self']=$this->task_model->checkSelfTask($fk_task_id);
        }

        return $data;
    }

    function getUsersContact(){
        $userid=$this->session->userdata('session_id');
        $response=$this->task_model->getUsers($userid);
        echo json_encode($response);
    }

    function insertDetails(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            // $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Task' AND role_id='$roleid' AND (r_insert = 1 or r_edit = 1)");
            // $result=$query->result();
            // if(count($result)>0) {
                $form_data=$this->input->post(null,true);
                //print_r($form_data);
                // $response=$this->task_model->testFormData($form_data);
                $response=$this->task_model->insertDetails($form_data);
                redirect('Task',Refresh);
            // } else {
            //     echo '<script>alert("You donot have access to this page.");</script>';
            //     $this->load->view('login/main_page');
            // }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function loadTaskListGrid(){
       /* $rp = "Datatables::myurlencode(id)";    
    
                $this->datatables->distinct()
                     ->select("ut.id as id,concat_ws(' ',cm.c_name,cm.c_last_name) name, ut.subject_detail,ut.message_detail,ut.priority,ut.from_date,ut.to_date,ut.status")
                     ->where("cm.c_gid = ut.user_id and ut.user_id = ".$this->session->userdata('session_id')." and ut.status='1' ")
                     ->from("user_task_master ut ,contact_master cm ")
                     //->order_by('d.id','desc')
                     ->add_column('c_view','<button id="$1" name="view_btn" class="btn btn-primary" onclick="view_details(this.id)">View</button>',$rp)
                     ->add_column('c_edit','<a id="$1" href="#" name="edit_btn"  onclick="edit_details(this.id)"><span class="glyphicon glyphicon-edit" Title="Edit this Record">Edit</span></a>',$rp)
                     ->add_column('c_delete','<a id="$1" href="#" name="delete_btn"  onclick="delete_record(this.id)"><span class="glyphicon glyphicon-trash" title="Delete Record">Delete</span></a>',$rp);
                echo $this->datatables->generate(); */

                //$response=$this->task_model->getTaskList($this->session->userdata('session_id'));
    }

    function deleteRecord(){
        $task_id=$this->input->post('task_id');
        $response=$this->task_model->deleteRecord($task_id);
        echo json_encode($response);
    }

    function completeTask(){
        $task_id=$this->input->post('task_id');
        $response=$this->task_model->completeTask($task_id);
        echo json_encode($response);
    }


    function addCommentTask(){
        $task_id=$this->input->post('task_id');
        $task_comment=$this->input->post('task_comment');
        $user_id=$this->session->userdata('session_id');
        $comm_array=array(
            'task_id'=>$task_id,
            'comment'=>$task_comment,
            'user_id'=>$user_id);
        $insert=$this->task_model->addCommentTask($comm_array);
    }

    public function get_sub_property() {
        $property_id = html_escape($this->input->post('property_id'));
        $task_id = html_escape($this->input->post('task_id'));

        $query=$this->db->query("SELECT * FROM user_task_detail WHERE id='$task_id'");
        $result=$query->result();
        if (count($result)>0) {
            $sub_property_id = $result[0]->sub_property_id;
        } else {
            $sub_property_id = '0';
        }

        $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE property_id='$property_id' AND txn_status='Approved'");
        $result=$query->result();

        $sub_property_list = '<option value="" Selected>Select Sub Property</option>';

        foreach ($result as $row) {
            if ($sub_property_id == $row->sp_id) {
                $sub_property_list = $sub_property_list . '<option value="' . $row->txn_id . '" selected>' . $row->sp_name . '</option>';
            } else {
                $sub_property_list = $sub_property_list . '<option value="' . $row->txn_id . '">' . $row->sp_name . '</option>';
            }
        }

        echo $sub_property_list;
    }

}
 ?>