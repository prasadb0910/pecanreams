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
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css" media="all"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/user-view.css'; ?>"/>    
		
		<!-- EOF CSS INCLUDE -->             
	 
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
           <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                 <div class="heading-h2 responsive-heading"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/contacts'; ?>" > Contact List </a>  &nbsp; &#10095; &nbsp; Contact Details</div>
                  <div class="pull-right btn-top-margin responsive-margin">
                                  <!--   <h3 class="panel-title"><strong>Contact Details</strong></h3> -->                                
                                   
									 <a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a> 

                                      <?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?> <a class="btn-margin" href="<?php echo base_url().'index.php/Contacts/editRecord/'.$c_id; ?>" > <span class="btn btn-success pull-right btn-font"> Edit </span>  </a> <?php } }  ?>
										 <a class="btn-margin" href="<?php echo base_url()?>index.php/Contacts" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a> 
                             
                                </div>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
                      <div class="main-container">           
                         <div class="box-shadow">   
                         <div class="box-shadow-inside">	
                             <div class="col-md-12" style="padding:0;">
						<div class="full-width custom-padding">
						   <div class="panel panel-default">
                            <form id="form_contact_view" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">
                             
        					 <div id="pdiv" >
                                <div class="panel-body">
									
                                    
                                    <div class="form-group" style="border-top:0px dotted #eee;"  >
												<div class="col-md-4 f-div col-sm-6 col-xs-12">
													
													<label class="col-md-5 col-sm-5 col-xs-12 f-name control-label  print-left control-label"   ><strong><?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others') echo 'Non Legal Entity Name:'; else echo 'Full Name:'; } else echo 'Full Name:'; ?></strong></label>
														<div class="col-md-7 col-sm-7 col-xs-12  f-view ">
													<label class="col-md-12 control-label  contact-view" style="text-align:left; margin-left:3px;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_name; } ?></label>
														</div>
													
												</div>
												<div class="col-md-4 col-sm-6 col-xs-12 f-div" style="<?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others') echo ''; else echo 'display: none;'; } else echo 'display: none;'; ?>">
													
													<label class="col-md-12 control-label  contact-view" style="text-align:left; margin-left:3px;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_last_name; } ?></label>

													<!-- <label class="col-md-5 f-name control-label  print-left control-label" style="margin-left:-15px" ><strong>Owner Type:</strong></label>
														<div class="col-md-7 f-view">
													<label class="col-md-12 control-label  contact-view" style="text-align:left; margin-left:3px;"><?php //if (isset($editcontact)) { echo $editcontact[0]->c_last_name; } ?></label>
														</div> -->
													
												</div>
												<div class="col-md-4 col-sm-6 col-xs-12 m-div" style="<?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others') echo 'display: none;'; else echo ''; } else echo ''; ?>">
													
													<label class="col-md-5 col-sm-5 col-xs-12 m-name control-label" ><strong>Middle Name:</strong></label>
														<div class="col-md-7  col-sm-7 col-xs-12 ma-view">
													<label class="col-md-12 control-label  contact-view " style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_middle_name; } ?></label>
														</div>
													
												</div>
                                                
                                                <div class="col-md-4 col-sm-6 col-xs-12 l-div " style="<?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others') echo 'display: none;'; else echo ''; } else echo ''; ?>">
													
													<label class="col-md-4 col-sm-5 col-xs-12 l-name control-label" ><strong>Last Name:</strong></label>
														<div class="col-md-8 col-sm-7 col-xs-12 l-view">
													<label class="col-md-12  control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_last_name; } ?></label>
														</div>
												
												</div>
											</div>

											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12 ">
													<label class="col-md-3 col-sm-5 col-xs-12 col-devide-41 control-label"><strong>Type:</strong></label>
													<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">
				 										<label class="col-md-12 control-label contact-view" style="text-align:left;" ><?php if (isset($editcontact)) { echo $editcontact[0]->c_type; } ?></label>
													</div>
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<label class="col-md-3 col-sm-5 col-xs-12 col-devide-41 control-label"><strong>Concerned Person Name:</strong></label>
													<div class="col-md-9 col-sm-7  col-xs-12 col-devide-59">
				 										<label class="col-md-12 control-label contact-view" style="text-align:left;" ><?php if (isset($editcontact)) { echo $editcontact[0]->c_company; } ?></label>
													</div>
												</div>
											</div>

											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12">
													<label class="col-md-3 col-sm-5 col-xs-12 control-label"><strong>Related Party Type:</strong></label>
													<div class="col-md-9 col-sm-7 col-xs-12">
														<label class="col-md-12 control-label contact-view" style="text-align:left;">
															<?php if (isset($editcontact)) { 
	                                                                for ($j=0; $j < count($contact_type) ; $j++) { ?>
	                                                                    <?php if($contact_type[$j]->id==$editcontact[0]->c_contact_type) { echo $contact_type[$j]->contact_type; } ?>
	                                                        <?php }} ?>
                                                    	</label> 
													</div>
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<label class="col-md-3 col-sm-5 col-xs-12 control-label"><strong>PAN Card:</strong></label>
													<div class="col-md-9 col-sm-7 col-xs-12">
						  								<label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_pan_card; } ?></label> 
													</div>
												</div>
											</div>
									
											<div class="form-group" style="<?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others') echo 'display: none;'; else echo ''; } else echo ''; ?>">
												<div class="col-md-6 col-sm-6 col-xs-12" style="<?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others') echo 'display: none;'; else echo ''; } else echo ''; ?>">
													
														<label class="col-md-3 col-sm-5 col-xs-12 control-label col-devide-41"><strong>Date Of Birth:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">
														  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { if($editcontact[0]->c_dob!='') echo date('d/m/Y',strtotime($editcontact[0]->c_dob)); } ?></label>
														</div>
													
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12" style="<?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others') echo 'display: none;'; else echo ''; } else echo ''; ?>">
													
														<label class="col-md-3 col-sm-5 col-xs-12 control-label col-devide-41"  style="    padding-left: 0px;padding-right:-1px;"><strong>Anniversary Date:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">
														  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { if($editcontact[0]->c_anniversarydate!='') echo date('d/m/Y',strtotime($editcontact[0]->c_anniversarydate)); } ?></label>
														</div>
													
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12">
													
														<label class="col-md-3 col-sm-5 col-xs-12 col-devide-41 control-label"><strong>Gender:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">  

														<label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_gender; } ?></label>
														</div>
													
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													
														<label class="col-md-3  col-sm-5 col-xs-12 col-devide-41 control-label"><strong>Designation:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">
													   <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_designation; } ?></label>
														</div>
													
												</div>
											</div>
											<div class="form-group " style="<?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others') echo 'display: none;'; else echo ''; } else echo ''; ?>">
												<div class="col-md-6 col-sm-6 col-xs-12">
													
														<label class="col-md-3 col-sm-5 col-xs-12 col-devide-41 control-label"><strong>Guardian:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">
												 <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($guardian)) { echo $guardian; } ?></label>
														</div>
													
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													
														<label class="col-md-3 col-sm-5 col-xs-12 col-devide-41 control-label"><strong>Relation:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">
  															<label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_relation; } ?></label> </div>
													
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12">
													
														<label class="col-md-3 col-sm-5 col-xs-12 col-devide-41 control-label"><strong>Address:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">
								 <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_address; } ?></label> 
														</div>
													
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													
														<label class="col-md-3 col-sm-5 col-xs-12 col-devide-41 control-label"><strong>Landmark:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">
							  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_landmark; } ?></label> 
														</div>
													
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12">
													
														<label class="col-md-3 col-sm-5 col-xs-12 col-devide-41 control-label"><strong>City:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">   <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_city; } ?></label> 
														</div>
												
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													
														<label class="col-md-3  col-sm-5 col-xs-12 col-devide-41 control-label"><strong>Pincode:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">
							  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_pincode; } ?></label> 
														</div>
													
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12">
													
														<label class="col-md-3 col-sm-5 col-xs-12 col-devide-41 control-label"><strong>State:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">                      <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_state; } ?></label> 
														</div>
													
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													
														<label class="col-md-3 col-sm-5 col-xs-12 col-devide-41 control-label"><strong>Country:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">
							  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_country; } ?></label> 						</div>
												
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12">
													
														<label class="col-md-3 col-sm-5 col-xs-12 col-devide-41 control-label"><strong>Email ID1:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">
								  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_emailid1; } ?></label> 
														</div>
												
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
												<div class=" ">
													
														<label class="col-md-3 col-sm-5 col-xs-12 col-devide-41 control-label"><strong>Email ID2:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">
							 <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_emailid2; } ?></label> 
														</div>
													
												</div>
											</div>
										 </div>

										<div class="form-group print-border">
												<div class="col-md-6 col-sm-6 col-xs-12 rspns-pdng">
													
														<label class="col-md-3 col-sm-5 col-xs-12 col-devide-41 control-label"><strong>Mobile No1:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12col-devide-59">
						  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->c_mobile1; } ?></label> 
														</div>
													
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12 rspns-pdng">
													
												<label class="col-md-3 col-sm-5 col-xs-12 col-devide-41 control-label"><strong>Mobile No2:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 col-devide-59">
								  <label class="col-md-12 control-label contact-view" style="text-align:left;" ><?php if (isset($editcontact)) { echo $editcontact[0]->c_mobile2; } ?></label> 
														</div>
													
												</div>
											</div>

                               
						
                                
                                <?php $this->load->view('templates/document_view');?>

                                
                            	<!-- START DATATABLE -->
								<div class="panel-heading" style="border-top:1px solid #E5E5E5; ">
									<h3 class="panel-title"><strong>Nominee Details</strong></h3>
								</div>
								<div class="panel-body">
									<div class="row">
									<div class="panel-body">
										<div class="table-responsive">
										<table id="contacts" class="table datatable group table-bordered" >
											<thead>
												<tr>
												  	<th width="5%" align="center"> Sr. No.</th>
												  	<th > Name</th>
													<th width="20%">Relation</th>
												</tr>
											</thead>
											<tbody>
												<?php if(isset($editcontnom)) { for ($i=0; $i < count($editcontnom); $i++) { ?>
												<tr>
													<td align="center"><?php echo ($i+1); ?></td>
												  	<td class="Contact_name"><?php echo $editcontnom[$i]->c_name; ?></td>
													<td class="Contact_name"><?php echo $editcontnom[$i]->nm_relation; ?></td>
												</tr>
												<?php } } ?>
											</tbody>
										</table>
									  	</div>
									</div>
									</div>
								</div>

								<div class="panel-heading" style="border-top:1px solid #E5E5E5; ">
									<h3 class="panel-title"><strong>Related Properties</strong></h3>
								</div>
								<div class="panel-body">
									<div class="row">
									<div class="panel-body">
										<div class="table-responsive">
										<table id="contacts" class="table datatable group table-bordered"  >
											<thead>
												<tr>
													<th>Property Name</th>
												</tr>
											</thead>
											<tbody>
												<?php if(isset($related_properties)) { for ($i=0; $i < count($related_properties); $i++) { ?>
												<tr>
													<td class="Contact_name"><?php echo $related_properties[$i]->p_property_name; ?></td>
												</tr>
												<?php } } ?>
											</tbody>
										</table>
									  	</div>
									</div>
									</div>
								</div>

								<div class="panel-heading" style="border-top:1px solid #E5E5E5; ">
									<h3 class="panel-title"><strong> Remarks</strong></h3>
								</div>
								<div class="panel-body ">
									<div class="form-group row print-form-group" style="border-top: 1px dotted #ddd;">
										<label class="col-md-2 control-label"><strong>Maker Remarks:</strong></label>
										<div class="col-md-10 remark">
										  	<label class="col-md-12 remark control-label" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->maker_remark; } ?></label> 
										</div>
									</div>
									<div class="form-group row print-form-group print-border">
										<label class="col-md-2 control-label"><strong>Checker Remarks:</strong></label>
										<div class="col-md-10 remark">
										  	<label class="col-md-12 remark control-label" style="text-align:left;"><?php if (isset($editcontact)) { echo $editcontact[0]->txn_remarks; } ?></label> 
										</div>
									</div>
								</div>
								<!-- END DEFAULT DATATABLE -->
						     	</div> 	
							 </div>
							</form>
						 						

							<?php if(isset($editcontact)) { ?>
							<?php if($editcontact[0]->c_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
                              
                				<form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Contacts/updateRecord/'.$c_id; ?>">
	                                <div class="panel-body" style="padding:10px 0!important;">
	                                <div class="row" >
										<label class="col-md-2 control-label"><strong>Remarks:</strong></label>
                					    <div class="col-md-10"   >
                							<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($editcontact)) { echo $editcontact[0]->txn_remarks; } ?></textarea>
                						</div>
                                    </div>
                                    </div>
                                         
            						<div class="panel-footer">
                                        <a class="btn btn-danger" href="<?php echo base_url().'index.php/contacts'; ?>"> Cancel</a>
                                        <input  type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                    </div> 
                				</form>

							<?php } } } else if($editcontact[0]->c_modifiedby != '' && $editcontact[0]->c_modifiedby != null) { if($editcontact[0]->c_modifiedby!=$contactby) { if($editcontact[0]->c_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                              
                				<form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Contacts/approverecord/'.$c_id; ?>">
	                                <div class="panel-body"  style="padding:10px 0!important;" >
	                                <div class="row">
										<label class="col-md-2 control-label"><strong>Remarks:</strong></label>
                					    <div class="col-md-10">
                							<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($editcontact)) { echo $editcontact[0]->txn_remarks; } ?></textarea>
                						</div>
                                    </div>
                                    </div>
                                         
            						<div class="panel-footer">
                                        <a  class="btn btn-danger" href="<?php echo base_url().'index.php/contacts'; ?>" >Cancel</a>
                                        <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit"/>
										<input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                
                                    </div> 
                				</form>

							<?php } } } } else { ?>

                				<form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Contacts/updateRecord/'.$c_id; ?>">
	                                <div class="panel-body"  >
	                                <div class="row">
										<!--<label class="col-md-2 control-label"><strong>Remarks:</strong></label>-->
                					    <div class="col-md-12" style="padding:10px!important;">
                							<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($editcontact)) { echo $editcontact[0]->txn_remarks; } ?></textarea>
                						</div>
                                    </div>
                                    </div>
                                         
            						<div class="panel-footer">
                                        <a class="btn btn-danger" href="<?php echo base_url().'index.php/contacts'; ?>" >Cancel</a>
                                        <input type="submit"  class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');" />
                                    </div> 
                				</form>

							<?php } } else if($editcontact[0]->c_createdby != '' && $editcontact[0]->c_createdby != null) { if($editcontact[0]->c_createdby!=$contactby && $editcontact[0]->c_status != 'In Process') { if($editcontact[0]->c_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                              
                				<form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Contacts/approverecord/'.$c_id; ?>">

	                                <div class="panel-body"  style="padding:10px 0!important;" >
	                                <div class="row">
										<label class="col-md-2 control-label"><strong>Remarks:</strong></label>
                					    <div class="col-md-10">
                							<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($editcontact)) { echo $editcontact[0]->txn_remarks; } ?></textarea>
                						</div>
                                    </div>
                                    </div>
                                         
            						<div class="panel-footer">
                                        <a class="btn btn-danger" href="<?php echo base_url().'index.php/contacts'; ?>" >Cancel</a>
                                        <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit" style="margin-right:10px;"/>
										<input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                
                                    </div> 
                				</form>

							<?php } } } } else { ?>
								
                				<form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Contacts/updateRecord/'.$c_id; ?>">
	                                <div class="panel-body" style="padding:10px 0!important;" >
	                                <div class="row">
										<label class="col-md-2 control-label"><strong>Remarks:</strong></label>
                					    <div class="col-md-10">
                							<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($editcontact)) { echo $editcontact[0]->txn_remarks; } ?></textarea>
                						</div>
                                    </div>
                                    </div>
                                         
            						<div class="panel-footer">
                                        <a class="btn btn-danger" href="<?php echo base_url().'index.php/contacts'; ?>" >Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');" />
                                    </div> 
                				</form>  
 
							<?php } } } ?>

							 
							</div>
						</div>
						  </div>
						</div>
					 </div>
					</div>	
                    </div>
             
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
			</div>			
        <?php $this->load->view('templates/footer');?>

		

      <script type="text/javascript">
            
$(document).ready(function(){
        $('.table').addClass('table-active table table-bordered');    
  });

      </script>

 <script>

       $('.printdiv').click(function(){

            var divToPrint=document.getElementById('pdiv');

              var newWin=window.open('','Print-Window');

              newWin.document.open();
                 $('th').css("border","1px solid #ddd !important");
            $('th').css("border-right","1px solid #ddd !important")

                newWin.document.write('<html>   <style> body{padding:0; margin:0; font-family: Montserrat-Black, muli, Open Sans, sans-serif; font-weight:400;} table{border-spacing:0; border-collapse:collapse; border:1px solid #ddd; text-align:left; width:100%; margin:10px 0; clear:both; } table tr td {border:1px solid #ddd; padding:5px;} .print-authorised tr th:first-child{width:40%;} table tr th {border:1px solid #ddd; text-align:left;  padding:5px; font-weight:400;}.download {display:none;} .form-group{display:flex; word-break: break-all; padding:10px; border:1px solid #ddd!important; border-bottom:0px solid #ddd!important;}.print-form-group {display:inline-block;     width: 97%;}.panel-heading { border:none!important; margin-top:20px;}.panel-heading .panel-title { margin-bottom:5px; padding:0; font-weight:400; font-size:20px;}   strong{  font-weight:400;  } .print-border{ border-bottom:1px solid #ddd!important;}.control-label{ float:left; padding-right:2px;}.print-form-group .col-md-2 { width:100%;}.col-md-4 {width:40%;}.col-md-6 {width:50%;}</style> <body onload="window.print()"> <div>'+divToPrint.innerHTML+'</body></html>');


              newWin.document.close();

              //setTimeout(function(){newWin.close();},10);
        });
        </script> 
    <!-- END SCRIPTS -->      
    </body>
</html>