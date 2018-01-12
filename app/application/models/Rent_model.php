<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Rent_model Extends CI_Model{

    function __Construct(){
    	parent :: __construct();
        $this->load->helper('common_functions');
        $this->load->model('purchase_model');
    }

    function rentData($status='', $property_id='', $r_id=''){
        if($status=='All'){
            $cond="";
            $cond3="";
        } else if($status=='InProcess'){
            $status='In Process';
            $cond="and E.txn_status='In Process'";
            $cond3="where E.txn_status='In Process'";
        } else if($status=='Pending'){
            $cond="and (E.txn_status='Pending' or E.txn_status='Delete')";
            $cond3="where (E.txn_status='Pending' or E.txn_status='Delete')";
        } else {
            $cond="and E.txn_status='$status'";
            $cond3="where E.txn_status='$status'";
        }

        if($property_id!=""){
            $cond2=" and property_id='" . $property_id . "'";
        } else {
            $cond2="";
        }

        if($r_id!=""){
            $cond2=" and txn_id='" . $r_id . "'";
        }

        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();

        if (count($result)>0) {
            $sql="select * from 
                (select C.txn_id, D.owner_name, C.c_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.rent_amount, 
                C.possession_date, C.termination_date, C.txn_status, C.p_property_name, C.p_display_name, 
                C.p_type, C.p_status from 
                (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.tenant_id, A.c_name, A.gp_id, A.rent_amount, 
                    A.possession_date, A.termination_date, A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
                (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.tenant_id, A.c_name, A.gp_id, A.rent_amount, 
                    A.possession_date, A.termination_date, A.txn_status from 
                (select AA.*, BB.c_name from 
                (select * from rent_txn where gp_id = '$gid' and 
                    property_id in (select distinct purchase_id from purchase_ownership_details 
                                        where pr_client_id in (select distinct owner_id from user_role_owners 
                                            where user_id = '$session_id'))" . $cond2 . ") AA 
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
                where ow_gid='$gid') BB 
                on (AA.tenant_id=BB.c_id)) A 
                left join 
                (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
                on A.sub_property_id = B.txn_id) A 
                left join 
                (select * from purchase_txn where gp_id = '$gid') B 
                on A.property_id=B.txn_id) C 
                left join 
                (select A.purchase_id, A.pr_client_id, 
                        case when B.ow_type = '0' then 
                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                where c_id = B.ow_ind_id) 
                            when B.ow_type = '1' then B.ow_huf_name 
                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                            else B.ow_proprietorship_comapny_name end as owner_name 
                from purchase_ownership_details A, owner_master B 
                where A.pr_client_id=B.ow_id and A.pr_client_id in (select min(pr_client_id) from purchase_ownership_details 
                where purchase_id=A.purchase_id and pr_client_id in (select distinct owner_id from user_role_owners 
                where user_id = '$session_id') group by purchase_id)) D 
                on C.property_id=D.purchase_id) E 
                where E.owner_name is not null and E.owner_name<>'' " . $cond;
        } else {
            $sql="select * from 
                (select C.txn_id, D.owner_name, C.c_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.rent_amount, 
                C.possession_date, C.termination_date, C.txn_status, C.p_property_name, C.p_display_name, 
                C.p_type, C.p_status from 
                (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.tenant_id, A.c_name, A.gp_id, A.rent_amount, 
                    A.possession_date, A.termination_date, A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
                (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.tenant_id, A.c_name, A.gp_id, A.rent_amount, 
                    A.possession_date, A.termination_date, A.txn_status from 
                (select AA.*, BB.c_name from 
                (select * from rent_txn where gp_id = '$gid' " . $cond2 . ") AA 
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
                where ow_gid='$gid') BB 
                on (AA.tenant_id=BB.c_id)) A 
                left join 
                (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
                on A.sub_property_id = B.txn_id) A 
                left join 
                (select * from purchase_txn where gp_id = '$gid') B 
                on A.property_id=B.txn_id) C 
                left join 
                (select A.purchase_id, A.pr_client_id, 
                        case when B.ow_type = '0' then 
                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                where c_id = B.ow_ind_id) 
                            when B.ow_type = '1' then B.ow_huf_name 
                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                            else B.ow_proprietorship_comapny_name end as owner_name 
                from purchase_ownership_details A, owner_master B 
                where A.pr_client_id=B.ow_id and A.pr_client_id in (select min(pr_client_id) from purchase_ownership_details 
                where purchase_id=A.purchase_id group by purchase_id)) D 
                on C.property_id=D.purchase_id) E " . $cond3;
        }

        $query=$this->db->query($sql);
        // echo $this->db->last_query();
        return $query->result();
    }

    function getAllCountData(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();

        if (count($result)>0) {
            $sql="select * from 
                (select C.txn_id, D.owner_name, C.c_name, C.property_id, C.gp_id, C.rent_amount, 
                C.possession_date, C.termination_date, C.txn_status, C.p_property_name, C.p_display_name, 
                C.p_type, C.p_status from 
                (select A.txn_id, A.property_id, A.tenant_id, A.c_name, A.gp_id, A.rent_amount, A.possession_date, 
                    A.termination_date, A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
                (select AA.*, BB.c_name from 
                (select * from rent_txn where gp_id = '$gid' and 
                    property_id in (select distinct purchase_id from purchase_ownership_details 
                                        where pr_client_id in (select distinct owner_id from user_role_owners 
                                            where user_id = '$session_id'))) AA 
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
                where ow_gid='$gid') BB 
                on (AA.tenant_id=BB.c_id)) A 
                left join 
                (select * from purchase_txn where gp_id = '$gid') B 
                on A.property_id=B.txn_id) C 
                left join 
                (select A.purchase_id, A.pr_client_id, 
                        case when B.ow_type = '0' then 
                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                where c_id = B.ow_ind_id) 
                            when B.ow_type = '1' then B.ow_huf_name 
                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                            else B.ow_proprietorship_comapny_name end as owner_name 
                from purchase_ownership_details A, owner_master B 
                where A.pr_client_id=B.ow_id and A.pr_client_id in (select min(pr_client_id) from purchase_ownership_details 
                where purchase_id=A.purchase_id and pr_client_id in (select distinct owner_id from user_role_owners 
                where user_id = '$session_id') group by purchase_id)) D 
                on C.property_id=D.purchase_id) E";
        } else {
            $sql="select * from 
                    (select C.txn_id, D.owner_name, C.c_name, C.property_id, C.gp_id, C.rent_amount, 
                    C.possession_date, C.termination_date, C.txn_status, C.p_property_name, C.p_display_name, 
                    C.p_type, C.p_status from 
                    (select A.txn_id, A.property_id, A.tenant_id, A.c_name, A.gp_id, A.rent_amount, A.possession_date, 
                        A.termination_date, A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
                    (select AA.*, BB.c_name from 
                    (select * from rent_txn where gp_id = '$gid') AA 
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
                    where ow_gid='$gid') BB 
                    on (AA.tenant_id=BB.c_id)) A 
                    left join 
                    (select * from purchase_txn where gp_id = '$gid') B 
                    on A.property_id=B.txn_id) C 
                    left join 
                    (select A.purchase_id, A.pr_client_id, 
                            case when B.ow_type = '0' then 
                                    (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                    where c_id = B.ow_ind_id) 
                                when B.ow_type = '1' then B.ow_huf_name 
                                when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                when B.ow_type = '4' then B.ow_llp_comapny_name 
                                when B.ow_type = '5' then B.ow_prt_comapny_name 
                                when B.ow_type = '6' then B.ow_aop_comapny_name 
                                when B.ow_type = '7' then B.ow_trs_comapny_name 
                                else B.ow_proprietorship_comapny_name end as owner_name 
                    from purchase_ownership_details A, owner_master B 
                    where A.pr_client_id=B.ow_id and A.pr_client_id in (select min(pr_client_id) from purchase_ownership_details 
                    where purchase_id=A.purchase_id group by purchase_id)) D 
                    on C.property_id=D.purchase_id) E";
        }

        $query=$this->db->query($sql);
        $result=$query->result();
        return $result;
    }

    // function getAllTaxes(){
    // 	$this->db->select('tax_id,tax_name,tax_percent,txn_type');
    // 	$this->db->where('status = "1" and txn_type = "Rent"  and tax_action="1"');
    // 	$this->db->from('tax_master');
    // 	$result=$this->db->get();
    // 	return $result->result();
    // }

    function getAllTaxes($txn_type){
        $this->db->select('tax_id,tax_name,tax_percent,txn_type');
        $this->db->where('status = "1" and tax_action="1"');
        if($txn_type !=''){
            $this->db->where('txn_type like "%'.$txn_type.'%" ');
        }
        else{
            $this->db->where('txn_type like "%Rent%" ');
        }
        $this->db->from('tax_master');
        $result=$this->db->get();
        //echo $this->db->last_query();
        return $result->result();
    }

    function getAccess(){
    	$gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1)");
        $result=$query->result();
        return $result;
    }

    function insertSchedule($pid, $txn_status){
        //echo "hi";
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
    	// $sch_type=$this->input->post('sch_type');
    	$sch_event=$this->input->post('sch_event');
        $sch_date=$this->input->post('sch_date');
        $sch_basiccost=$this->input->post('sch_basiccost');
        // print_r($sch_event);

        if($txn_status=='Approved'){
            $sch_status = '1';
        } else {
            $sch_status = '3';
        }

        for ($i=0; $i < count($sch_event) ; $i++) {
            //echo "date".$sch_date[$i];

            if($sch_date[$i]==NULL){
                $scdt=NULL;
            } else {
                //echo $sch_date[$i];
                $scdt=formatdate($sch_date[$i]);
                //exit;
            }

            $sch_tax='';
            $sch_tax=$this->input->post('sch_tax_'.($i+1));
            //   print_r($sch_tax); echo "<br>".($i+1)."<br>";
            $sch_basiccost[$i]=format_number($sch_basiccost[$i],2);
            if(count($sch_tax) > 0){
                $tax_detail=$this->getTaxDetailsCalculation($sch_tax,$sch_basiccost[$i]);

                $data = array(
                    'rent_id' => $pid ,
                    // 'event_type'=>$sch_type[$i],
                    'event_type'=>$sch_event[$i],
                    'event_name' => $sch_event[$i],
                    'event_date' => $scdt ,
                    'basic_cost' => $sch_basiccost[$i] ,
                    'net_amount' => $tax_detail["netamount"],
                    'create_date' => date('Y-m-d'),
                    'create_by' => $curusr,
                    'sch_status'=>$sch_status,
                    'status'=>$sch_status
                );
            }
            else{
                $data = array(
                    'rent_id' => $pid ,
                    // 'event_type'=>$sch_type[$i],
                    'event_type'=>$sch_event[$i],
                    'event_name' => $sch_event[$i],
                    'event_date' => $scdt ,
                    'basic_cost' => $sch_basiccost[$i],
                    'net_amount' => $sch_basiccost[$i],
                    'create_date' => date('Y-m-d'),
                    'create_by' => $curusr,
                    'sch_status'=>$sch_status,
                    'status'=>$sch_status
                );
            }
            $this->db->insert('rent_schedule', $data);
            $scid=$this->db->insert_id();
            if(count($sch_tax) > 0){
                $j=0;
                foreach($tax_detail['tax_detail'] as $row){
                    // print_r($tax_detail['tax_detail'][$j]);

                    //$tax_array=explode(',',$sch_tax[$j]);

                    $data = array(
                    'sch_id' => $scid,
                    // 'event_type' => $sch_type[$i],
                    'event_type' => $sch_event[$i],
                    'tax_master_id'=> $tax_detail['tax_detail'][$j]['tax_id'],
                    'tax_type' => $tax_detail['tax_detail'][$j]['tax_type'],
                    'tax_percent' => $tax_detail['tax_detail'][$j]['tax_percent'],
                    'tax_amount' => $tax_detail['tax_detail'][$j]['tax_amount'],
                    'rent_id' => $pid,
                    'status'=>$sch_status
                     );
                    $this->db->insert('rent_schedule_taxation', $data);  
                    $j++;
                }
            }
        }
    }

    function getTaxDetailsCalculation($tax_id,$sch_basiccost){
        //  print_r($tax_id);
        $tax_id=implode(',',$tax_id);
    	$this->db->select('tax_id,tax_name,tax_percent,tax_action');
    	$this->db->from('tax_master');
    	$this->db->where('tax_id in ('.$tax_id.') and status = "1" ');
    	$result=$this->db->get();
    	// echo $this->db->last_query();
    	$netamount=$sch_basiccost;
    	foreach ($result->result() as $row){
    		$tax_amount=round(($sch_basiccost * $row->tax_percent)/100);
    		if($row->tax_action==1){
    			$netamount=$netamount+$tax_amount;
    		}
    		else if($row->tax_action==0){
    			$netamount=$netamount-$tax_amount;
    		}
    		$tax_detail[]=array("tax_id"=>$row->tax_id,"tax_type"=>$row->tax_name,"tax_percent"=>$row->tax_percent,"tax_amount"=>$tax_amount);
    	}
    	//print_r($tax_detail);
    	$dataarray=array("netamount"=>$netamount,"tax_detail"=>$tax_detail);
        return $dataarray;
    }

	function getDistinctTaxDetail($pid, $txn_status){
		//echo $pid;
		$this->db->select('tax_type');
		$this->db->where('rent_id = "'.$pid.'" and status = "'.$txn_status.'" ');
		$this->db->from('rent_schedule_taxation');
		$this->db->group_by('tax_type');
        $this->db->order_by('tax_type','Asc');
		$result=$this->db->get();
		//echo $this->db->last_query();
		return $result->result();
	}

    function getPropertyDetails($txn_id='0') {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        if ($txn_id!='0') {
            $cond = " and txn_id<>'$txn_id'";
        } else {
            $cond = "";
        }

        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();
        if (count($result)>0) {
            $sql="select distinct txn_id, p_property_name, p_display_name from 
                (select G.txn_id, G.p_property_name, G.p_display_name, G.p_purchase_date, G.sp_id, G.sp_name, 
                    G.owner_name, G.sales_id, H.txn_id as rent_id from 
                (select E.txn_id, E.p_property_name, E.p_display_name, E.p_purchase_date, E.sp_id, E.sp_name, 
                    E.owner_name, F.txn_id as sales_id from 
                (select C.txn_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.sp_id, C.sp_name, D.owner_name from 
                (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, 
                    case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
                (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
                left join 
                (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved') B 
                on A.txn_id = B.property_id) C 
                left join 
                (select A.purchase_id, A.pr_client_id, 
                        case when B.ow_type = '0' then 
                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                where c_id = B.ow_ind_id) 
                            when B.ow_type = '1' then B.ow_huf_name 
                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                            else B.ow_proprietorship_comapny_name end as owner_name 
                from purchase_ownership_details A, owner_master B 
                where A.pr_client_id=B.ow_id and A.pr_client_id in (select min(pr_client_id) from purchase_ownership_details 
                where purchase_id=A.purchase_id and pr_client_id in (select distinct owner_id from user_role_owners 
                where user_id = '$session_id') group by purchase_id)) D 
                on C.txn_id = D.purchase_id where D.owner_name is not null and D.owner_name <> '') E 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from sales_txn where gp_id = '$gid' and txn_status <> 'Inactive') F 
                on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from rent_txn where gp_id = '$gid' and txn_status <> 'Inactive' and DATE(NOW()) > DATE(termination_date)" . $cond . ") H 
                on G.txn_id = H.property_id and G.sp_id = H.sub_property_id) I 
                where sales_id is null and rent_id is null";
        } else {
            $sql="select distinct txn_id, p_property_name, p_display_name from 
                (select G.txn_id, G.p_property_name, G.p_display_name, G.p_purchase_date, G.sp_id, G.sp_name, 
                    G.owner_name, G.sales_id, H.txn_id as rent_id from 
                (select E.txn_id, E.p_property_name, E.p_display_name, E.p_purchase_date, E.sp_id, E.sp_name, 
                    E.owner_name, F.txn_id as sales_id from 
                (select C.txn_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.sp_id, C.sp_name, D.owner_name from 
                (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, 
                    case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
                (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
                left join 
                (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved') B 
                on A.txn_id = B.property_id) C 
                left join 
                (select A.purchase_id, A.pr_client_id, 
                        case when B.ow_type = '0' then 
                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                where c_id = B.ow_ind_id) 
                            when B.ow_type = '1' then B.ow_huf_name 
                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                            else B.ow_proprietorship_comapny_name end as owner_name 
                from purchase_ownership_details A, owner_master B 
                where A.pr_client_id=B.ow_id and A.pr_client_id in (select min(pr_client_id) from purchase_ownership_details 
                where purchase_id=A.purchase_id group by purchase_id)) D 
                on C.txn_id = D.purchase_id) E 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from sales_txn where gp_id = '$gid' and txn_status <> 'Inactive') F 
                on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from rent_txn where gp_id = '$gid' and txn_status <> 'Inactive' and DATE(NOW()) > DATE(termination_date)" . $cond . ") H 
                on G.txn_id = H.property_id and G.sp_id = H.sub_property_id) I 
                where sales_id is null and rent_id is null";
        }

        $query=$this->db->query($sql);
        $result=$query->result();
        return $result;
    }

    function getSubPropertyDetails($txn_id='0', $property_id='0') {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        if ($txn_id!='0') {
            $cond = " and txn_id<>'$txn_id'";
        } else {
            $cond = "";
        }

        if ($property_id!='0') {
            $cond2 = " and property_id='$property_id'";
        } else {
            $cond2 = "";
        }

        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();
        if (count($result)>0) {
            $sql="select distinct sp_id, sp_name from 
                (select G.txn_id, G.p_property_name, G.p_display_name, G.p_purchase_date, G.sp_id, G.sp_name, 
                    G.owner_name, G.sales_id, H.txn_id as rent_id from 
                (select E.txn_id, E.p_property_name, E.p_display_name, E.p_purchase_date, E.sp_id, E.sp_name, 
                    E.owner_name, F.txn_id as sales_id from 
                (select C.txn_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.sp_id, C.sp_name, D.owner_name from 
                (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, 
                    case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
                (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
                left join 
                (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved'" . $cond2 . ") B 
                on A.txn_id = B.property_id) C 
                left join 
                (select A.purchase_id, A.pr_client_id, 
                        case when B.ow_type = '0' then 
                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                where c_id = B.ow_ind_id) 
                            when B.ow_type = '1' then B.ow_huf_name 
                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                            else B.ow_proprietorship_comapny_name end as owner_name 
                from purchase_ownership_details A, owner_master B 
                where A.pr_client_id=B.ow_id and A.pr_client_id in (select min(pr_client_id) from purchase_ownership_details 
                where purchase_id=A.purchase_id and pr_client_id in (select distinct owner_id from user_role_owners 
                where user_id = '$session_id') group by purchase_id)) D 
                on C.txn_id = D.purchase_id where D.owner_name is not null and D.owner_name <> '') E 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from sales_txn where gp_id = '$gid' and txn_status <> 'Inactive') F 
                on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from rent_txn where gp_id = '$gid' and txn_status <> 'Inactive' and DATE(NOW()) <= DATE(termination_date)" . $cond . ") H 
                on G.txn_id = H.property_id and G.sp_id = H.sub_property_id) I 
                where sales_id is null and rent_id is null and sp_id<>0";
        } else {
            $sql="select distinct sp_id, sp_name from 
                (select G.txn_id, G.p_property_name, G.p_display_name, G.p_purchase_date, G.sp_id, G.sp_name, 
                    G.owner_name, G.sales_id, H.txn_id as rent_id from 
                (select E.txn_id, E.p_property_name, E.p_display_name, E.p_purchase_date, E.sp_id, E.sp_name, 
                    E.owner_name, F.txn_id as sales_id from 
                (select C.txn_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.sp_id, C.sp_name, D.owner_name from 
                (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, 
                    case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
                (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
                left join 
                (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved'" . $cond2 . ") B 
                on A.txn_id = B.property_id) C 
                left join 
                (select A.purchase_id, A.pr_client_id, 
                        case when B.ow_type = '0' then 
                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                where c_id = B.ow_ind_id) 
                            when B.ow_type = '1' then B.ow_huf_name 
                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
                            when B.ow_type = '4' then B.ow_llp_comapny_name 
                            when B.ow_type = '5' then B.ow_prt_comapny_name 
                            when B.ow_type = '6' then B.ow_aop_comapny_name 
                            when B.ow_type = '7' then B.ow_trs_comapny_name 
                            else B.ow_proprietorship_comapny_name end as owner_name 
                from purchase_ownership_details A, owner_master B 
                where A.pr_client_id=B.ow_id and A.pr_client_id in (select min(pr_client_id) from purchase_ownership_details 
                where purchase_id=A.purchase_id group by purchase_id)) D 
                on C.txn_id = D.purchase_id) E 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from sales_txn where gp_id = '$gid' and txn_status <> 'Inactive') F 
                on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from rent_txn where gp_id = '$gid' and txn_status <> 'Inactive' and DATE(NOW()) <= DATE(termination_date)" . $cond . ") H 
                on G.txn_id = H.property_id and G.sp_id = H.sub_property_id) I 
                where sales_id is null and rent_id is null and sp_id<>0";
        }

        $query=$this->db->query($sql);
        $result=$query->result();
        return $result;
    }

    function getPropertyNotOnRent() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();
        if (count($result)>0) {
            $sql="select * from 
                    (select C.txn_id, C.gp_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.p_type, C.p_status, 
                            C.txn_status, C.purchase_price, D.purchase_id, D.pr_client_id, D.owner_name from 
                    (select A.txn_id, A.gp_id, A.p_property_name, A.p_display_name, A.p_purchase_date, A.p_type, A.p_status, 
                        A.txn_status, B.purchase_price from 
                    (select txn_id, gp_id, p_property_name, p_display_name, p_purchase_date, p_type, p_status, txn_status 
                    from purchase_txn where gp_id='$gid' and txn_id not in (select distinct property_id from sales_txn 
                            where property_id is not null and txn_status <> 'Inactive' 
                            union all select distinct property_id from rent_txn where property_id is not null and txn_status <> 'Inactive')) A 
                    left join 
                    (select purchase_id,sum(net_amount) as purchase_price from purchase_schedule where status = '1' group by purchase_id) B 
                    on A.txn_id = B.purchase_id) C 
                    left join 
                    (select A.purchase_id, A.pr_client_id, 
                            case when B.ow_type = '0' then 
                                    (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                    where c_id = B.ow_ind_id) 
                                when B.ow_type = '1' then B.ow_huf_name 
                                when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                when B.ow_type = '4' then B.ow_llp_comapny_name 
                                when B.ow_type = '5' then B.ow_prt_comapny_name 
                                when B.ow_type = '6' then B.ow_aop_comapny_name 
                                when B.ow_type = '7' then B.ow_trs_comapny_name 
                                else B.ow_proprietorship_comapny_name end as owner_name 
                    from purchase_ownership_details A, owner_master B 
                    where A.pr_client_id=B.ow_id and A.pr_client_id in (select min(pr_client_id) from purchase_ownership_details 
                    where purchase_id=A.purchase_id and pr_client_id in (select distinct owner_id from user_role_owners 
                    where user_id = '$session_id') group by purchase_id)) D 
                    on C.txn_id=D.purchase_id) E 
                    where E.owner_name is not null and E.owner_name<>'' and E.txn_status='Approved'";

            } else {
                $sql="select * from 
                    (select C.txn_id, C.gp_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.p_type, C.p_status, 
                            C.txn_status, C.purchase_price, D.purchase_id, D.pr_client_id, D.owner_name from 
                    (select A.txn_id, A.gp_id, A.p_property_name, A.p_display_name, A.p_purchase_date, A.p_type, A.p_status, 
                        A.txn_status, B.purchase_price from 
                    (select txn_id, gp_id, p_property_name, p_display_name, p_purchase_date, p_type, p_status, txn_status 
                    from purchase_txn where gp_id='$gid' and txn_id not in (select distinct property_id from sales_txn 
                            where property_id is not null and txn_status <> 'Inactive' 
                            union all select distinct property_id from rent_txn where property_id is not null and txn_status <> 'Inactive')) A 
                    left join 
                    (select purchase_id,sum(net_amount) as purchase_price from purchase_schedule where status = '1' group by purchase_id) B 
                    on A.txn_id = B.purchase_id) C 
                    left join 
                    (select A.purchase_id, A.pr_client_id, 
                            case when B.ow_type = '0' then 
                                    (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                                    where c_id = B.ow_ind_id) 
                                when B.ow_type = '1' then B.ow_huf_name 
                                when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                                when B.ow_type = '3' then B.ow_ltd_comapny_name 
                                when B.ow_type = '4' then B.ow_llp_comapny_name 
                                when B.ow_type = '5' then B.ow_prt_comapny_name 
                                when B.ow_type = '6' then B.ow_aop_comapny_name 
                                when B.ow_type = '7' then B.ow_trs_comapny_name 
                                else B.ow_proprietorship_comapny_name end as owner_name 
                    from purchase_ownership_details A, owner_master B 
                    where A.pr_client_id=B.ow_id and A.pr_client_id in (select min(pr_client_id) from purchase_ownership_details 
                    where purchase_id=A.purchase_id group by purchase_id)) D 
                    on C.txn_id=D.purchase_id) E 
                    where E.owner_name is not null and E.owner_name<>'' and E.txn_status='Approved'";
        }

        $query=$this->db->query($sql);
        $result=$query->result();
        return $result;
    }

    public function send_rent_intimation($r_id){
        $gid=$this->session->userdata('groupid');

        $sql = "select * from rent_txn where txn_id = '$r_id'";
        $query = $this->db->query($sql);
        $result = $query->result();

        if(count($result)){
            $property_id=$result[0]->property_id;
            $sub_property_id=$result[0]->sub_property_id;
        } else {
            $property_id='';
            $sub_property_id='';
        }

        $group_owners=$this->purchase_model->get_group_owners($gid);
        $property_owners=$this->purchase_model->get_property_owners($property_id);
        $prop_owners="";

        $table=$this->get_rent_list_table($r_id);

        if(count($property_owners)>0){
            for($i=0;$i<count($property_owners);$i++){
                $owner_name=$property_owners[$i]->owner_name;
                $to_email=$property_owners[$i]->ow_contact_email_id;

                $prop_owners=$prop_owners.$owner_name.', ';

                $this->send_rent_intimation_to_owner($table, $owner_name, $to_email);
            }

            if(strpos($prop_owners, ', ')>0){
                $prop_owners=substr($prop_owners,0,strripos($prop_owners, ', '));
            }

            // echo $prop_owners;
        }

        if(count($group_owners)>0){
            for($i=0;$i<count($group_owners);$i++){
                $owner_name="";
                if(isset($group_owners[$i]->c_name)){
                    $owner_name=$group_owners[$i]->c_name;
                }
                if(isset($group_owners[$i]->c_last_name)){
                    $owner_name=$owner_name.' '.$group_owners[$i]->c_last_name;
                }
                $to_email=$group_owners[$i]->c_emailid1;

                $this->send_rent_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners);
            }
        }
    }

    public function get_rent_list_table($r_id) {
        $rent = $this->rentData("All", '', $r_id);
        $table='';

        if(count($rent)>0) {
            $table='<div>
                    <table style="border-collapse: collapse; border: 1px solid black;">
                        <thead>
                            <tr>
                                <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Property Name</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Sub Property Name</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Tenant Name</th>
                                <th style="padding:5px; border: 1px solid black;" width="110">Rent Per Month</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Possession Date</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Termation Date</th>
                                <th style="padding:5px; border: 1px solid black;" width="50">Status</th>
                            </tr>
                        </thead>
                        <tbody>';

            for($i=0;$i<count($rent); $i++ ) {
                $table=$table.'<tr>
                                <td style="padding:5px; border: 1px solid black;">'.($i+1).'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$rent[$i]->p_property_name.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$rent[$i]->sp_name.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$rent[$i]->c_name.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.format_money($rent[$i]->rent_amount,2).'</td>
                                <td style="padding:5px; text-align:right; border: 1px solid black;">'.(($rent[$i]->possession_date!=null && $rent[$i]->possession_date!='')?date('d/m/Y',strtotime($rent[$i]->possession_date)):'').'</td>
                                <td style="padding:5px; border: 1px solid black;">'.(($rent[$i]->termination_date!=null && $rent[$i]->termination_date!='')?date('d/m/Y',strtotime($rent[$i]->termination_date)):'').'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$rent[$i]->txn_status.'</td>
                            </tr>';
            }

            $table=$table.'</tbody></table></div>';

            // echo $table;
            return $table;
        }
    }

    public function send_rent_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners) {
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Rent Intimation';

        $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                    We would like to bring to your notice that a New Rent Entry has been created for '.$prop_owners.'. 
                    The Rent details are as follows.<br /><br />' . $table . '<br /><br />
                    If the above Rent details are incorrect please reject the same immediately.<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

        // echo $owner_name . ' ';
    }

    public function send_rent_intimation_to_owner($table, $owner_name, $to_email) {
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Rent Intimation';
        
        $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                    We would like to bring to your notice that a New Rent Entry has been mapped to you. 
                    The Rent details are as follows.<br /><br />' . $table . '<br /><br />
                    If the above Property has not been put up for rent please reject the same immediately.<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

        // echo $owner_name . ' ';
    }
}
?>