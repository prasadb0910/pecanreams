<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Pecan Reams</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
        <!-- EOF CSS INCLUDE -->                                      
		
		<style>
			.faq .faq-item.active .faq-text {background:#FFFFFF;}
			hr{display: block;
			float: left;
			width: 100%;
			margin-top: 10px;
			margin-bottom: 10px;
			border-color: #BDBDBD;}
			th{text-align:center;}
			.center{text-align:center;}
			.form-group { border:1px dotted #ddd;  }
			.report-expand { display:none ; border:1px dotted #ddd; /*margin-top:-10px;*/ background:#fff; border-top:1px solid #fff; }
			.list-group-item-reports {
			    position: relative; text-decoration:none; color:#555;
			    display: block; font-size:12px; font-weight:600;
			    padding: 8px 15px; border-top:1px solid #eee;
			    margin-bottom: -1px;
			    background-color: #fff;
			}
			.ui-draggable-handle{padding: 15px 15px 20px 0!important;}
			.list-group-item-reports { font-size:13px;}
			.list-group-item-reports:hover { text-decoration:none; /* background-color: #2f3c48; color:#fff;*/}
			.btn-clr { background:#fff; color:#000; margin-top:-10px; }
			.push { margin-top:3px; margin-left:5px;}
			.selectAllLabel { font-size: larger; font-weight: bold; margin-bottom:-10px; }
		 	#checkboxes, #log { min-width: 250px;  vertical-align: middle; padding: 10px;  }
			#selectall-1, #selectall-2, #selectall-3, #selectall-4, #selectall-5, #selectall-6 { margin-top:4px; margin-left:6px;}
		</style>
	  <style type="text/css">
            
.page-container .page-content .page-content-wrap {  margin:0px; width: auto!important; float: none;   }
.dataTables_filter { border-bottom:0!important; }
.heading-h2 { background:#eee; line-height: 25px; padding:7px 22px;   text-transform: uppercase; font-weight: 600; display: flex;  margin-top: 61px; /*padding-bottom: 0;*/      border-bottom: 1px solid #ddd;}
.heading-h2 a{  color: #444;     }
/*.top-band { background:#eee; padding: 5px; clear: both; display: inline-table; 
font-family: Montserrat-Black; font-weight: 100;float: left;     width: 45%;  
  border-bottom: 1px solid rgba(0,0,0,0.1);                   }*/
.nav-contacts {/* float: right; width: 55%;*/ }
.main-wrapper { background: #E0E0E7; padding: 0; margin: 0; }
.main-container {margin:0 12px; margin-bottom: 20px; } 
h2 { font-weight:100!important;  font-size:18px!important; padding:0; }
.box-shadow {margin-top: 20px; width:100%;
background: #fff; box-shadow: rgba(0, 0, 0, 0.2) 0px 6px 32px -4px; display: inline-block;}
.page-overflow { overflow:auto; }
#approved{ font-weight: 800;/* border:1px solid #ccc; padding:2px 8px; border-radius:0px; background: #fff; */ color: #888;    }
.table thead tr th { padding:8px 5px!important; font-weight:600; }
b, strong { font-weight:500;}
.panel-body {padding: 0!important;}
.btn-container {  }
.btn-top { margin-top: 10px!important; }
.box-shadow-inside {  display: flex; }
.panel-footer { background: #f5f5f5!important; clear: both; margin-top:10px; }
.panel-margin { margin: 0; border-radius: 0!important; box-shadow: none;   }
.panel-success {     box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.2)!important; }
.panel {  box-shadow: none;  }
.panel-heading {border-radius: 0; }

.form-control {
    display: block;
    width: 100%;
    padding: 10px 6px!important;
    height: 35px;
    font-size: 12px;
    line-height: 1.42857143;
    font-weight: 500;
    color: #0b385f;
    background-color: white;
    background-image: none;
    border: 1px solid #cccccc;
    border-radius: 0px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.03);
    -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
    -o-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
    transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
}

.btn-primary { padding:6px 10px; }
.table-responsive {  min-height: .01%; overflow-x: auto;  margin: 15px;}
.remark-container {padding: 10px;}
.table { margin-bottom: 0!important; }
.table-responsive { margin:10px 0;   }
.panel-footer { margin-top: 0;  padding: 10px 10px; }
.btn-margin { margin-left: 5px!important; display: inline-block; }
.btn-top-margin { margin-top:-36px!important; margin-right: 15px; }
        </style>		
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>                

              <div class="heading-h2">
              <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/manage'; ?>" > User Role List  </a>  &nbsp; &#10095; &nbsp; User Role View </div>	
                      <div class="pull-right btn-top-margin">
                                  
                                   	<a class="btn-margin" href="<?php echo base_url()?>index.php/Manage" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a>
      
                                  	 	<a class="btn-margin" onclick="<?php if($edituser[0]->g_id==0 && $userdata['groupid']!=0) echo "return confirm('You cant edit global roles. Do you want to copy this role?')"?>" href="<?php if($edituser[0]->g_id==0 && $userdata['groupid']!=0) echo base_url().'index.php/Manage/copy/'.$edituser[0]->rl_id; else echo base_url().'index.php/Manage/edit/'.$edituser[0]->rl_id; ?>"><span class="btn btn-success pull-right btn-font"> Edit </span>  </a>                                  
                                   	<!-- <span class="btn btn-success pull-right btn-font" id="edit_role"> Edit </span> -->
                             
                                </div>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
                    <div class="main-container">  
						 <div class="box-shadow" style="padding-top:10px;"> 
							
                            <form id="jvalidate" role="form" class="form-horizontal" method="post" action="<?php if(isset($edituser)) { echo base_url().'index.php/Manage/updaterecord/'.$r_id; } else {echo base_url().'index.php/Manage/saverecord';} ?>">

                             <div class="box-shadow-inside">
                                  <div class="col-md-12">
					             	<div class="panel panel-default panel-margin">

                          
								
								<div class="panel-body">
									<div class="form-group">
										<div class="col-md-6" style="padding:0;">
										
												<label class="col-md-2 control-label">Role: </label>
												<div class="col-md-10">
													<label class="control-label"><?php if(isset($edituser)) { echo $edituser[0]->role_name; } ?></label>
												</div>
											
										</div>
										<!-- <div class="col-md-6">
											<div class="form-group">
												<label class="col-md-3 control-label">Status</label>
												<div class="col-md-9">
													<input type="text" class="form-control" name="status" placeholder="Status" value="<?php //if(isset($edituser)) { echo $edituser[0]->r_status; } ?>"/>
												</div>
											</div>
										</div> -->
										<div class="col-md-6" style="padding:0;">
										
												<label class="col-md-3 control-label">Role Description: </label>
												<div class="col-md-9">
													<label class="control-label"><?php if(isset($edituser)) { echo $edituser[0]->r_description; } ?></label>
												</div>
											
										</div>
									</div>

									<div class="panel-body">
										<div class="table-responsive">
											<table id="" class="table table-bordered">
												<thead>
													<tr>
														<th width="50">Module</th>
														<th width="50">View</th>
														<th width="50">Insert</th>
														<th width="50">Update</th>
														<th width="75">Delete</th>
														<th width="75">Approval</th>
														<th width="75">Download</th>
													</tr>
												</thead>
												<tbody>
													<!-- <tr id="trow_1">
														<td>Group Details</td>
														<td class="center"><input type="checkbox" id="grp_vw"  onchange="checkgroup(this);" name="view[]" value="0"  <?php //if(isset($editoptions)) { if($editoptions[0]->r_view == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="grp_ins" onchange="checkgroup(this);" name="insert[]" value="0"   <?php //if(isset($editoptions)) { if($editoptions[0]->r_insert == 1) { echo 'checked';} } ?>/></td>
														<td class="center"><input type="checkbox" id="grp_upd" onchange="checkgroup(this);" name="update[]" value="0"  <?php //if(isset($editoptions)) { if($editoptions[0]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="grp_del" onchange="checkgroup(this);" name="delete[]" value="0"  <?php //if(isset($editoptions)) { if($editoptions[0]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="grp_app" onchange="checkgroup(this);" name="approval[]" value="0"  <?php //if(isset($editoptions)) { if($editoptions[0]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="grp_exp" onchange="checkgroup(this);" name="export[]" value="0"  <?php //if(isset($editoptions)) { if($editoptions[0]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr> -->
													<tr id="trow_2">
														<td>Contact Details</td>
														<td class="center"><input type="checkbox" id="con_vw" disabled onchange="checkcontact(this);"  name="view[]" value="0"  <?php if(isset($editoptions[0])) { if($editoptions[0]->r_view == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="con_ins" disabled onchange="checkcontact(this);"  name="insert[]" value="0" <?php if(isset($editoptions[0])) { if($editoptions[0]->r_insert == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="con_upd" disabled onchange="checkcontact(this);"  name="update[]" value="0" <?php if(isset($editoptions[0])) { if($editoptions[0]->r_edit == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="con_del" disabled onchange="checkcontact(this);"  name="delete[]" value="0" <?php if(isset($editoptions[0])) { if($editoptions[0]->r_delete == 1) { echo 'checked';} } ?>  /></td> 
														<td class="center"><input type="checkbox" id="con_app" disabled onchange="checkcontact(this);"  name="approval[]" value="0"  <?php if(isset($editoptions[0])) { if($editoptions[0]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="con_exp" disabled onchange="checkcontact(this);" name="export[]" value="0"  <?php if(isset($editoptions[0])) { if($editoptions[0]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_3">
														<td>Bank Details</td>
														<td class="center"><input type="checkbox" id="bnk_vw" disabled onchange="checkbank(this);"  name="view[]" value="1" <?php if(isset($editoptions[1])) { if($editoptions[1]->r_view == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="bnk_ins" disabled onchange="checkbank(this);"  name="insert[]" value="1" <?php if(isset($editoptions[1])) { if($editoptions[1]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="bnk_upd" disabled onchange="checkbank(this);"  name="update[]" value="1"  <?php if(isset($editoptions[1])) { if($editoptions[1]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="bnk_del" disabled onchange="checkbank(this);"  name="delete[]" value="1" <?php if(isset($editoptions[1])) { if($editoptions[1]->r_delete == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="bnk_app" disabled onchange="checkbank(this);"  name="approval[]" value="1"  <?php if(isset($editoptions[1])) { if($editoptions[1]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="bnk_exp" disabled onchange="checkcontact(this);" name="export[]" value="1"  <?php if(isset($editoptions[1])) { if($editoptions[1]->r_export == 1) { echo 'checked';} } ?> /></td>
														</td>
													</tr>
													<tr id="trow_4">
														<td>Owner Details</td>
														<td class="center"><input type="checkbox" id="own_vw" disabled onchange="checkowner(this);"  name="view[]" value="2" <?php if(isset($editoptions[2])) { if($editoptions[2]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="own_ins" disabled onchange="checkowner(this);"  name="insert[]" value="2" <?php if(isset($editoptions[2])) { if($editoptions[2]->r_insert == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="own_upd" disabled onchange="checkowner(this);"  name="update[]" value="2"  <?php if(isset($editoptions[2])) { if($editoptions[2]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="own_del" disabled onchange="checkowner(this);"  name="delete[]" value="2" <?php if(isset($editoptions[2])) { if($editoptions[2]->r_delete == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="own_app" disabled onchange="checkowner(this);"  name="approval[]" value="2"  <?php if(isset($editoptions[2])) { if($editoptions[2]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="own_exp" disabled onchange="checkcontact(this);" name="export[]" value="2"  <?php if(isset($editoptions[2])) { if($editoptions[2]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_5">
														<td>Purchase Details</td>
														<td class="center"><input type="checkbox" id="pur_vw" disabled onchange="checkpurchase(this);"  name="view[]" value="3" <?php if(isset($editoptions[3])) { if($editoptions[3]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="pur_ins" disabled onchange="checkpurchase(this);"  name="insert[]" value="3" <?php if(isset($editoptions[3])) { if($editoptions[3]->r_insert == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="pur_upd" disabled onchange="checkpurchase(this);"  name="update[]" value="3" <?php if(isset($editoptions[3])) { if($editoptions[3]->r_edit == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="pur_del" disabled onchange="checkpurchase(this);"  name="delete[]" value="3" <?php if(isset($editoptions[3])) { if($editoptions[3]->r_delete == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="pur_app" disabled onchange="checkpurchase(this);"  name="approval[]" value="3"  <?php if(isset($editoptions[3])) { if($editoptions[3]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="pur_exp" disabled onchange="checkcontact(this);" name="export[]" value="3"  <?php if(isset($editoptions[3])) { if($editoptions[3]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_6">
														<td>Allocation Details</td>
														<td class="center"><input type="checkbox" id="alc_vw" disabled onchange="checksale(this);"  name="view[]" value="4"  <?php if(isset($editoptions[4])) { if($editoptions[4]->r_view == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="alc_ins" disabled onchange="checksale(this);"  name="insert[]" value="4"  <?php if(isset($editoptions[4])) { if($editoptions[4]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="alc_upd" disabled onchange="checksale(this);"  name="update[]" value="4" <?php if(isset($editoptions[4])) { if($editoptions[4]->r_edit == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="alc_del" disabled onchange="checksale(this);"  name="delete[]" value="4"  <?php if(isset($editoptions[4])) { if($editoptions[4]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="alc_app" disabled onchange="checksale(this);"  name="approval[]" value="4"  <?php if(isset($editoptions[4])) { if($editoptions[4]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="alc_exp" disabled onchange="checkcontact(this);" name="export[]" value="4"  <?php if(isset($editoptions[4])) { if($editoptions[4]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_7">
														<td>Sale Details</td>
														<td class="center"><input type="checkbox" id="sle_vw" disabled onchange="checksale(this);"  name="view[]" value="5"  <?php if(isset($editoptions[5])) { if($editoptions[5]->r_view == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="sle_ins" disabled onchange="checksale(this);"  name="insert[]" value="5"  <?php if(isset($editoptions[5])) { if($editoptions[5]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="sle_upd" disabled onchange="checksale(this);"  name="update[]" value="5" <?php if(isset($editoptions[5])) { if($editoptions[5]->r_edit == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="sle_del" disabled onchange="checksale(this);"  name="delete[]" value="5"  <?php if(isset($editoptions[5])) { if($editoptions[5]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="sle_app" disabled onchange="checksale(this);"  name="approval[]" value="5"  <?php if(isset($editoptions[5])) { if($editoptions[5]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="sle_exp" disabled onchange="checkcontact(this);" name="export[]" value="5"  <?php if(isset($editoptions[5])) { if($editoptions[5]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_8">
														<td>Rent Details</td>
														<td class="center"><input type="checkbox" id="rnt_vw" disabled onchange="checkrent(this);"  name="view[]" value="6" <?php if(isset($editoptions[6])) { if($editoptions[6]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="rnt_ins" disabled onchange="checkrent(this);"  name="insert[]" value="6" <?php if(isset($editoptions[6])) { if($editoptions[6]->r_insert == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="rnt_upd" disabled onchange="checkrent(this);"  name="update[]" value="6" <?php if(isset($editoptions[6])) { if($editoptions[6]->r_edit == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="rnt_del" disabled onchange="checkrent(this);"  name="delete[]" value="6"  <?php if(isset($editoptions[6])) { if($editoptions[6]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="rnt_app" disabled onchange="checkrent(this);"  name="approval[]" value="6"  <?php if(isset($editoptions[6])) { if($editoptions[6]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="rnt_exp" disabled onchange="checkcontact(this);" name="export[]" value="6"  <?php if(isset($editoptions[6])) { if($editoptions[6]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_9">
														<td>Bank Entry Details</td>
														<td class="center"><input type="checkbox" id="bank_entry_vw" disabled onchange="checkloan(this);"  name="view[]" value="7" <?php if(isset($editoptions[7])) { if($editoptions[7]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="bank_entry_ins" disabled onchange="checkloan(this);"  name="insert[]" value="7"  <?php if(isset($editoptions[7])) { if($editoptions[7]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="bank_entry_upd" disabled onchange="checkloan(this);"  name="update[]" value="7"  <?php if(isset($editoptions[7])) { if($editoptions[7]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="bank_entry_del" disabled onchange="checkloan(this);"  name="delete[]" value="7"  <?php if(isset($editoptions[7])) { if($editoptions[7]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="bank_entry_app" disabled onchange="checkloan(this);"  name="approval[]" value="7"  <?php if(isset($editoptions[7])) { if($editoptions[7]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="bank_entry_exp" disabled onchange="checkcontact(this);" name="export[]" value="7"  <?php if(isset($editoptions[7])) { if($editoptions[7]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_10">
														<td>Loan Details</td>
														<td class="center"><input type="checkbox" id="lon_vw" disabled onchange="checkloan(this);"  name="view[]" value="8" <?php if(isset($editoptions[8])) { if($editoptions[8]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="lon_ins" disabled onchange="checkloan(this);"  name="insert[]" value="8"  <?php if(isset($editoptions[8])) { if($editoptions[8]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="lon_upd" disabled onchange="checkloan(this);"  name="update[]" value="8"  <?php if(isset($editoptions[8])) { if($editoptions[8]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="lon_del" disabled onchange="checkloan(this);"  name="delete[]" value="8"  <?php if(isset($editoptions[8])) { if($editoptions[8]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="lon_app" disabled onchange="checkloan(this);"  name="approval[]" value="8"  <?php if(isset($editoptions[8])) { if($editoptions[8]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="lon_exp" disabled onchange="checkcontact(this);" name="export[]" value="8"  <?php if(isset($editoptions[8])) { if($editoptions[8]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_11">
														<td>Expense Details</td>
														<td class="center"><input type="checkbox" id="exp_vw" disabled onchange="checkloan(this);"  name="view[]" value="9" <?php if(isset($editoptions[9])) { if($editoptions[9]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="exp_ins" disabled onchange="checkloan(this);"  name="insert[]" value="9"  <?php if(isset($editoptions[9])) { if($editoptions[9]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="exp_upd" disabled onchange="checkloan(this);"  name="update[]" value="9"  <?php if(isset($editoptions[9])) { if($editoptions[9]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="exp_del" disabled onchange="checkloan(this);"  name="delete[]" value="9"  <?php if(isset($editoptions[9])) { if($editoptions[9]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="exp_app" disabled onchange="checkloan(this);"  name="approval[]" value="9"  <?php if(isset($editoptions[9])) { if($editoptions[9]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="exp_exp" disabled onchange="checkcontact(this);" name="export[]" value="9"  <?php if(isset($editoptions[9])) { if($editoptions[9]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_12">
														<td>Maintenance Details</td>
														<td class="center"><input type="checkbox" id="main_vw" disabled onchange="checkloan(this);"  name="view[]" value="10" <?php if(isset($editoptions[10])) { if($editoptions[10]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="main_ins" disabled onchange="checkloan(this);"  name="insert[]" value="10"  <?php if(isset($editoptions[10])) { if($editoptions[10]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="main_upd" disabled onchange="checkloan(this);"  name="update[]" value="10"  <?php if(isset($editoptions[10])) { if($editoptions[10]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="main_del" disabled onchange="checkloan(this);"  name="delete[]" value="10"  <?php if(isset($editoptions[10])) { if($editoptions[10]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="main_app" disabled onchange="checkloan(this);"  name="approval[]" value="10"  <?php if(isset($editoptions[10])) { if($editoptions[10]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="main_exp" disabled onchange="checkcontact(this);" name="export[]" value="10"  <?php if(isset($editoptions[10])) { if($editoptions[10]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_13">
														<td>Valuation</td>
														<td class="center"><input type="checkbox" id="val_vw" disabled onchange="checkloan(this);"  name="view[]" value="11" <?php if(isset($editoptions[11])) { if($editoptions[11]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" id="val_ins" disabled onchange="checkloan(this);"  name="insert[]" value="11"  <?php if(isset($editoptions[11])) { if($editoptions[11]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="val_upd" disabled onchange="checkloan(this);"  name="update[]" value="11"  <?php if(isset($editoptions[11])) { if($editoptions[11]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="val_del" disabled onchange="checkloan(this);"  name="delete[]" value="11"  <?php if(isset($editoptions[11])) { if($editoptions[11]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="val_app" disabled onchange="checkloan(this);"  name="approval[]" value="11"  <?php if(isset($editoptions[11])) { if($editoptions[11]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" id="val_exp" disabled onchange="checkcontact(this);" name="export[]" value="11"  <?php if(isset($editoptions[11])) { if($editoptions[11]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_14">
														<td>Tax Details</td>
														<td class="center"><input type="checkbox" id="tax_vw" disabled onchange="checkloan(this);"  name="view[]" value="12" <?php if(isset($editoptions[12])) { if($editoptions[12]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td colspan="5" class="center">&nbsp;</td>
													</tr>
													<tr id="trow_15">
														<td> <span class="">   Reports </span> <a class="reports" href="javascript:void(0);"><span class="badge badge-info pull-right"> View Reports</span></a></td>
														<td class="center"><input type="checkbox" id="rep_vw" disabled onchange="checkloan(this);"  name="view[]" value="13" <?php if(isset($editoptions[13])) { if($editoptions[13]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td colspan="5" class="center">&nbsp;</td>
													</tr>

												</tbody>
											</table>
										</div>
									</div>
								</div>
								
								<div class="panel report-expand selectreport">  
						            <div class="panel-heading ui-draggable-handle" style="padding:15px;">
							           	<a class="reports" href="javascript:void(0);" ><span class="badge  pull-right" style="margin-top:-5px;"> X </span></a>
						            </div> 
					               	<br clear="all">
									
									<div class="row push-up-10">
					                 	<div id="checkboxes">
											<div class="col-md-4" <?php if(isset($rep_grp_1)) {if($rep_grp_1==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					                        	<!-- CONTACTS WITH CONTROLS -->
					                          	<div class="">
					                          		<label class="selectAllLabel">
					                              	<h3 class=" pull-left">Group Level</h3>
					                                </label>
					                            </div> 
					                            <div class="panel panel-success">
					                                <div class="panel-body list-group" id="friendslist-1">
								                 		<label class="list-group-item-reports" <?php if(isset($rep_1_view)) {if($rep_1_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group1_a" disabled name="report[]" value="1" <?php if(isset($rep_1)) {if($rep_1==1) echo 'checked';} ?> /> Asset Allocation-Owner wise </label> 
									                 	<label class="list-group-item-reports" <?php if(isset($rep_2_view)) {if($rep_2_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group1_b" disabled name="report[]" value="2" <?php if(isset($rep_2)) {if($rep_2==1) echo 'checked';} ?> /> Asset Allocation-Usage wise </label>
									                 	<label class="list-group-item-reports" <?php if(isset($rep_3_view)) {if($rep_3_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group1_c" disabled name="report[]" value="3" <?php if(isset($rep_3)) {if($rep_3==1) echo 'checked';} ?> /> Loan Details </label>
									                 	<label class="list-group-item-reports" <?php if(isset($rep_4_view)) {if($rep_4_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group1_d" disabled name="report[]" value="4" <?php if(isset($rep_4)) {if($rep_4==1) echo 'checked';} ?> /> Maintenance Property Tax </label>
									                 	<label class="list-group-item-reports" <?php if(isset($rep_5_view)) {if($rep_5_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group1_e" disabled name="report[]" value="5" <?php if(isset($rep_5)) {if($rep_5==1) echo 'checked';} ?> /> Related Party </label>
									                 	<label class="list-group-item-reports" <?php if(isset($rep_6_view)) {if($rep_6_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group1_f" disabled name="report[]" value="6" <?php if(isset($rep_6)) {if($rep_6==1) echo 'checked';} ?> /> Rent Summary </label>
									                 	<label class="list-group-item-reports" <?php if(isset($rep_19_view)) {if($rep_19_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group1_g" disabled name="report[]" value="19" <?php if(isset($rep_19)) {if($rep_19==1) echo 'checked';} ?> /> Sale Details </label>
					                                </div>
					                            </div>
					                            <!-- END CONTACTS WITH CONTROLS -->
					                        </div>
											<div class="col-md-4" <?php if(isset($rep_grp_2)) {if($rep_grp_2==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					                        	<!-- CONTACTS WITH CONTROLS -->
					                          	<div class="">
					                              	<label class="selectAllLabel">
					                                    <h3 class="pull-left">Owner Level</h3>
					                               	</label>         
					                        	</div>
					                            <div class="panel panel-success">
					                                <div class="panel-body list-group" id="friendslist-2">
					                                	<label class="list-group-item-reports" <?php if(isset($rep_7_view)) {if($rep_7_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group2_a" disabled name="report[]" value="7" <?php if(isset($rep_7)) {if($rep_7==1) echo 'checked';} ?> /> Asset Allocation-Usage wise </label>
					                                	<label class="list-group-item-reports" <?php if(isset($rep_8_view)) {if($rep_8_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group2_b" disabled name="report[]" value="8" <?php if(isset($rep_8)) {if($rep_8==1) echo 'checked';} ?> /> Loan Details </label>
					                                	<label class="list-group-item-reports" <?php if(isset($rep_9_view)) {if($rep_9_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group2_c" disabled name="report[]" value="9" <?php if(isset($rep_9)) {if($rep_9==1) echo 'checked';} ?> /> Related Party </label>
					                                	<label class="list-group-item-reports" <?php if(isset($rep_10_view)) {if($rep_10_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group2_d" disabled name="report[]" value="10" <?php if(isset($rep_10)) {if($rep_10==1) echo 'checked';} ?> /> Rent Summary </label>
					                                	<label class="list-group-item-reports" <?php if(isset($rep_20_view)) {if($rep_20_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group2_e" disabled name="report[]" value="20" <?php if(isset($rep_20)) {if($rep_20==1) echo 'checked';} ?> /> Sale Details </label>
					                              	</div>
					                            </div>
					                            <!-- END CONTACTS WITH CONTROLS -->
					                        </div>
											<div class="col-md-4" <?php if(isset($rep_grp_3)) {if($rep_grp_3==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					                            <!-- CONTACTS WITH CONTROLS -->
					                          	<div class="">
					                            	<label class="selectAllLabel">
					                                    <h3 class="pull-left">Asset Level</h3>
					                              	</label>          
					                            </div> 
					                            <div class="panel panel-success">
					                                <div class="panel-body list-group" id="friendslist-3">
						                                <label class="list-group-item-reports" <?php if(isset($rep_11_view)) {if($rep_11_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group3_a" disabled name="report[]" value="11" <?php if(isset($rep_11)) {if($rep_11==1) echo 'checked';} ?> /> Profitability </label>
						                                <label class="list-group-item-reports" <?php if(isset($rep_12_view)) {if($rep_12_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group3_b" disabled name="report[]" value="12" <?php if(isset($rep_12)) {if($rep_12==1) echo 'checked';} ?> /> Purchase Variance </label>
						                                <label class="list-group-item-reports" <?php if(isset($rep_13_view)) {if($rep_13_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group3_c" disabled name="report[]" value="13" <?php if(isset($rep_13)) {if($rep_13==1) echo 'checked';} ?> /> Related Party </label>
						                                <label class="list-group-item-reports" <?php if(isset($rep_14_view)) {if($rep_14_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group3_d" disabled name="report[]" value="14" <?php if(isset($rep_14)) {if($rep_14==1) echo 'checked';} ?> /> Rent </label>
						                                <label class="list-group-item-reports" <?php if(isset($rep_15_view)) {if($rep_15_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group3_e" disabled name="report[]" value="15" <?php if(isset($rep_15)) {if($rep_15==1) echo 'checked';} ?> /> Sale </label>
						                                <label class="list-group-item-reports" <?php if(isset($rep_16_view)) {if($rep_16_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group3_f" disabled name="report[]" value="16" <?php if(isset($rep_16)) {if($rep_16==1) echo 'checked';} ?> /> Sale Variance </label>
						                                <label class="list-group-item-reports" <?php if(isset($rep_17_view)) {if($rep_17_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group3_g" disabled name="report[]" value="17" <?php if(isset($rep_17)) {if($rep_17==1) echo 'checked';} ?> /> Purchase </label>
						                                <label class="list-group-item-reports" <?php if(isset($rep_18_view)) {if($rep_18_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group3_h" disabled name="report[]" value="18" <?php if(isset($rep_18)) {if($rep_18==1) echo 'checked';} ?> /> Loan </label>
					                                </div>
					                            </div>
					                            <!-- END CONTACTS WITH CONTROLS -->
					                        </div>
										</div>
					                </div>
					                                
					                <!-- <div class="row push-up-10" <?php //if(isset($rep_grp_4)) {if($rep_grp_4==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
										<div class="col-md-4">
					                       	<div class="">
					                           	<label class="selectAllLabel">
					                                <h3 class="pull-left">Task Reports</h3>
					                          	</label>        
					                        </div> 
					                        <div class="panel panel-success">
					                            <div class="panel-body list-group" id="friendslist-4">
					                            <label class="list-group-item-reports" <?php //if(isset($rep_16_view)) {if($rep_16_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group4_a" disabled name="report[]" value="16" <?php //if(isset($rep_16)) {if($rep_16==1) echo 'checked';} ?> />  Accounting Policies  </label>
					                            <label class="list-group-item-reports" <?php //if(isset($rep_17_view)) {if($rep_17_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group4_b" disabled name="report[]" value="17" <?php //if(isset($rep_17)) {if($rep_17==1) echo 'checked';} ?> /> Depreciation Accounting   </label>
					                            <label class="list-group-item-reports" <?php //if(isset($rep_18_view)) {if($rep_18_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group4_c" disabled name="report[]" value="18" <?php //if(isset($rep_18)) {if($rep_18==1) echo 'checked';} ?> />  Accounting for Leases   </label>
					                            <label class="list-group-item-reports" <?php //if(isset($rep_19_view)) {if($rep_19_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group4_d" disabled name="report[]" value="19" <?php //if(isset($rep_19)) {if($rep_19==1) echo 'checked';} ?> />  Earnings per Share  </label>
					                            <label class="list-group-item-reports" <?php //if(isset($rep_20_view)) {if($rep_20_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group4_e" disabled name="report[]" value="20" <?php //if(isset($rep_20)) {if($rep_20==1) echo 'checked';} ?> />  Financial Instruments  </label>
					                            </div>
					                        </div>
					                    </div>
										<div class="col-md-4" <?php //if(isset($rep_grp_5)) {if($rep_grp_5==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					                        <div class="">
					                           	<label class="selectAllLabel">
					                                <h3 class="pull-left">Property Reports</h3>
					                          	</label>            
					                        </div>
					                        <div class="panel panel-success">
					                            <div class="panel-body list-group" id="friendslist-5">
					                                <label class="list-group-item-reports" <?php //if(isset($rep_21_view)) {if($rep_21_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group5_a" disabled name="report[]" value="21" <?php //if(isset($rep_21)) {if($rep_21==1) echo 'checked';} ?> />   Policies  </label>
					                                <label class="list-group-item-reports" <?php //if(isset($rep_22_view)) {if($rep_22_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group5_b" disabled name="report[]" value="22" <?php //if(isset($rep_22)) {if($rep_22==1) echo 'checked';} ?> />   Accounting  </label>
					                                <label class="list-group-item-reports" <?php //if(isset($rep_23_view)) {if($rep_23_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group5_c" disabled name="report[]" value="23" <?php //if(isset($rep_23)) {if($rep_23==1) echo 'checked';} ?> />   Leases  </label>
					                                <label class="list-group-item-reports" <?php //if(isset($rep_24_view)) {if($rep_24_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group5_d" disabled name="report[]" value="24" <?php //if(isset($rep_24)) {if($rep_24==1) echo 'checked';} ?> />  Revenue  </label>
					                                <label class="list-group-item-reports" <?php //if(isset($rep_25_view)) {if($rep_25_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group5_e" disabled name="report[]" value="25" <?php //if(isset($rep_25)) {if($rep_25==1) echo 'checked';} ?> />  Earnings  </label>
					                          	</div>
					                        </div>
					                    </div>
										<div class="col-md-4" <?php //if(isset($rep_grp_6)) {if($rep_grp_6==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					                       	<div class="">
					                            <label class="selectAllLabel">
					                                <h3 class="pull-left">Expense Reports</h3>
					                          	</label>             
					                        </div>
					                        <div class="panel panel-success">
					                            <div class="panel-body list-group" id="friendslist-6">
					                            <label class="list-group-item-reports" <?php //if(isset($rep_26_view)) {if($rep_26_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group6_a" disabled name="report[]" value="26" <?php //if(isset($rep_26)) {if($rep_26==1) echo 'checked';} ?> />  Accounting for Leases   </label>
					                            <label class="list-group-item-reports" <?php //if(isset($rep_27_view)) {if($rep_27_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group6_b" disabled name="report[]" value="27" <?php //if(isset($rep_27)) {if($rep_27==1) echo 'checked';} ?> />  Revenue Recognition  </label>
					                            <label class="list-group-item-reports" <?php //if(isset($rep_28_view)) {if($rep_28_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group6_c" disabled name="report[]" value="28" <?php //if(isset($rep_28)) {if($rep_28==1) echo 'checked';} ?> />  Share   </label>
					                            <label class="list-group-item-reports" <?php //if(isset($rep_29_view)) {if($rep_29_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group6_d" disabled name="report[]" value="29" <?php //if(isset($rep_29)) {if($rep_29==1) echo 'checked';} ?> />  Leases   </label>
					                            <label class="list-group-item-reports" <?php //if(isset($rep_30_view)) {if($rep_30_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group6_e" disabled name="report[]" value="30" <?php //if(isset($rep_30)) {if($rep_30==1) echo 'checked';} ?> />  Financial Instruments  </label>
					                            </div>
					                        </div>
					                    </div>
									</div> -->
									
								</div>
                               </div>
						</div>
							</div>
							</form>
							
						
						
					 </div>
						</div>
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>
        
		<script>
			$(document).ready(function(){
			    $(".reports").click(function(){
			        $(".report-expand").slideToggle();
			    });
			});
		</script>
    </body>
</html>