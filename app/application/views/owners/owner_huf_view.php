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
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-view.css"/>
        <!-- EOF CSS INCLUDE -->                                      
		<style type="text/css">
     .address-remark{width: 12.4%;}
.address-container1{width:87.6%; display:flex;}  
     
  	 @media screen and (min-width: 250px) and (max-width:1020px) 
	{

 .custom-padding .remark {padding:10px; }
  .custom-padding .position-view-2 {padding:0px; }
.address-remark {width:100%; text-align:left!important; margin-left:10px;}
.address-container1 {width:100%;}
.custom-padding .control-label { padding:0 3px!important;}
 .custom-padding .col-md-10  {padding:0px; }
  .custom-padding .address-container1 {  padding:10px; padding-top:0;}
 }
@media only screen and (max-width: 992px) { 
  .custom-padding .control-label{ padding:0;}  
.address-remark {width:100%; text-align:left!important; margin-left:10px;}
.address-container1 {width:100%;}
.address-remark { padding:0!important;}
	} 
        </style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">                
                <?php $this->load->view('templates/menus');?>                  
     
           <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/owners'; ?>" > Owner List</a>  &nbsp; &#10095; &nbsp;  HUF View</div>
                  <div class="pull-right btn-top-margin responsive-margin">
                                  <!--   <h3 class="panel-title"><strong>Contact Details</strong></h3> -->                                
                                   
									 <a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a> 

                                    <?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?>  
                                            <a class="btn-margin" href="<?php echo base_url().'index.php/Owners/edit_huf/'.$o_id; ?>" > 
                                                    <span class="btn btn-success pull-right btn-font"> Edit </span>  </a>
                                          
                                        <?php } }  ?>
									  
										 <a class="btn-margin" href="<?php echo base_url()?>index.php/Owners" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a> 
                             
                                </div>
                <!-- PAGE CONTENT WRAPPER -->
					<div class="page-content-wrap">
				     <div class="row main-wrapper">
					  <div class="main-container">           
					   <div class="box-shadow">   
					   <div class="box-shadow-inside custom-padding">	
					    <div class="col-md-12" style="padding:0;">	
							<div class="full-width" >							
                         
						<div class="panel panel-default " >
                            <form id="jvalidate" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">
                               
                          <div id="pdiv" >
                                <div class="panel-body individual-heading">
									<div class="form-group" style="border-top:0px dotted #ddd;">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-3 col-sm-5 col-xs-12  position-name control-label"><strong>HUF Name:</strong></label>
												<div class="col-md-9 col-sm-7 col-xs-12 position-view-1 ">
												    <label class="col-md-12   control-label contact-view" style="text-align:left;"> <?php if(isset($huf_record)) { echo  $huf_record[0]->ow_huf_name; } ?></label>
												</div>
											</div>
										</div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-3 col-sm-5 col-xs-12  position-name control-label"><strong>Registration No:</strong></label>
                                                <div class="col-md-9 col-sm-7 col-xs-12 position-view-1  ">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($huf_record)) { echo  $huf_record[0]->ow_reg_no; } ?></label>
                                                </div>
                                            </div>
                                        </div>
									</div>
                                    
                                   	<div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="">
                                              <label class="col-md-3 col-sm-5 col-xs-12  position-name control-label"><strong>Date of Incorp:</strong></label>
                                              <div class="col-md-9 col-sm-7 col-xs-12 position-view-1 ">
                                                    <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($huf_record)) { if($huf_record[0]->ow_huf_incorpdate!='' && $huf_record[0]->ow_huf_incorpdate!=null) echo date('d/m/Y', strtotime($huf_record[0]->ow_huf_incorpdate)); } ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
											  <label class="col-md-3 col-sm-5 col-xs-12  position-name control-label"><strong>Karta Name:</strong></label>
											  <div class="col-md-9 col-sm-7 col-xs-12 position-view-1">
												    <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($huf_record[0]->owner_name)){ echo $huf_record[0]->owner_name; } else { echo ''; }?></label>
												</div>
											</div>
										</div>
									</div>

                                    <div class="form-group print-border">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="">

                                                <label class="col-md-3 col-sm-5 col-xs-12   position-name control-label"><strong>Address:</strong></label>
                                                <div class="col-md-9 col-sm-7 col-xs-12 remark position-view-2">
                                                    <label class="col-md-12 remark control-label contact-view" style="text-align:left;"> <?php if(isset($huf_record)) { echo get_address($huf_record[0]->ow_huf_address, $huf_record[0]->ow_huf_landmark, $huf_record[0]->ow_huf_city, $huf_record[0]->ow_huf_pincode, $huf_record[0]->ow_huf_state, $huf_record[0]->ow_huf_country); } ?></label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    <?php if(isset($huf_family)) { if (count($huf_family)>0) { ?>
                                    <div class="panel-heading" style=" ">
                                        <h3 class="panel-title" style="padding:0px; "><strong>Partnership Details</strong></h3>
                                    </div>

                                    <div class="panel-body">
                                    <div class="row">
                              		<div class="table-responsive">
    								<table id="contacts" class="table table-bordered" style="margin:0px;">
    									<thead>
    										<tr>
    										  <th width="50%"> Family Details</th>
    											<th width="50%">Relation</th>
    										</tr>
    									</thead>
    									<tbody>
    										<?php for($l=0;$l<count($huf_family); $l++) { ?>
    										<tr>
    										  	<td class="Contact_name"><?php if(isset($huf_family[$l])){ echo $huf_family[$l]->owner_name; } else { echo ''; }?></td>
    											<td class="Contact_name"><?php if(isset($huf_family[$l])){ echo $huf_family[$l]->huf_ow_relation; } else { echo ''; }?></td>
    										</tr>
    										<?php } ?>
    									</tbody>
    								</table>
    					  			</div>
                                    </div>
                                    </div>
                                    <?php }} ?>

                                    <?php //if(isset($editcontdoc)) { if (count($editcontdoc)>0) { ?>
                                    <!-- <hr>  

									<div class="table-responsive">
										<table id="contacts" class="table table-bordered">
											<thead>
												<tr>
												  <th width="19%">Document Name</th>
													<th width="16%">ID Proof</th>
													<th width="16%">Reference No.</th>
													<th width="15%">Date of Issue</th>
													<th width="20%">Date of Expiry</th>
													<th width="14%" class="th">Download</th>
												</tr>
											</thead>
											<tbody>
												<?php //$this->load->view('owners/owner_document_view');?>
											</tbody>
										</table>
								  	</div> -->
								  	<?php //}} ?>

                                    <?php $this->load->view('templates/document_view');?>


                                    <div class="panel-heading" >
                                        <h3 class="panel-title"  ><strong>Remarks</strong></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group print-form-group" style="border-top:0px dotted #ddd;">
                                            <label class="col-md-2 remark  position-name control-label"><strong>Maker Remark:</strong></label>
                                            <div class="col-md-10 remark">
                                                <label class="col-md-12 remark control-label contact-view" style="text-align:left;"> <?php if(isset($huf_record)) { echo  $huf_record[0]->ow_maker_remark; } ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group print-form-group print-border">
                                            <label class="col-md-2 remark  position-name control-label"><strong>Checker Remark:</strong></label>
                                            <div class="col-md-10 remark">
                                                <label class="col-md-12 remark control-label contact-view" style="text-align:left;"> <?php if(isset($huf_record)) { echo  $huf_record[0]->ow_txnremarks; } ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>       
							</form>
							
                            <?php if(isset($huf_record)) { ?>
                            <?php if($huf_record[0]->ow_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
                              
                                <form id="" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/Owners/updatehufrecord/'.$o_id; ?>">
                                    <div class="panel-body" style="margin-top:10px;">
                                    <div class="row">
                                        <div class="col-md-2 sr" id=""> <label >Remarks</label> </div>  
                                        <div class="col-md-10">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($huf_record[0])){ echo $huf_record[0]->ow_txnremarks; } else { echo ''; }?></textarea>
                                        </div>
                                    </div>
                                    </div>
                                         
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Owners" class="btn btn-danger">Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                    </div> 
                                </form>

                            <?php } } } else if($huf_record[0]->ow_modified_by != '' && $huf_record[0]->ow_modified_by != null) { if($huf_record[0]->ow_modified_by!=$ownerby) { if($huf_record[0]->ow_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                              
                                <form id="" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/Owners/approvehuf/'.$o_id; ?>">
                                    <div class="panel-body" style="margin-top:10px;">
                                    <div class="row">
                                        <div class="col-md-2 sr" id=""> <label >Remarks</label> </div>  
                                        <div class="col-md-10">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($huf_record[0])){ echo $huf_record[0]->ow_txnremarks; } else { echo ''; }?></textarea>
                                        </div>
                                    </div>
                                    </div>
                                         
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Owners" class="btn btn-danger">Cancel</a>
                                        <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit"/>
                                        <input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                
                                    </div> 
                                    
                                </form>

                            <?php } } } } else { ?>

                                <form id="" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/Owners/updatehufrecord/'.$o_id; ?>">
                                    <div class="panel-body" style="margin-top:10px;">
                                    <div class="row">
                                        <div class="col-md-2  sr" id=""> <label >Remarks</label> </div>  
                                        <div class="col-md-10 ">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($huf_record[0])){ echo $huf_record[0]->ow_txnremarks; } else { echo ''; }?></textarea>
                                        </div>
                                    </div>
                                    </div>
                                         
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Owners" class="btn btn-danger">Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                    </div> 
                                </form>

                            <?php } } else if($huf_record[0]->ow_create_by != '' && $huf_record[0]->ow_create_by != null) { if($huf_record[0]->ow_create_by!=$ownerby && $huf_record[0]->ow_status != 'In Process') { if($huf_record[0]->ow_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                              
                                <form id="" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/Owners/approvehuf/'.$o_id; ?>">

                                    <div class="panel-body" style="margin-top:10px;">
                                    <div class="row">
                                        <div class="col-md-2 sr" id=""> <label >Remarks</label> </div>
                                        <div class="col-md-10">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($huf_record[0])){ echo $huf_record[0]->ow_txnremarks; } else { echo ''; }?></textarea>
                                        </div>
                                    </div>
                                    </div>
                                         
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Owners" class="btn btn-danger">Cancel</a>
                                        <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit"  />
                                        <input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                
                                    </div> 
                                </form>

                            <?php } } } } else { ?>
                                
                                <form id="" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/Owners/updatehufrecord/'.$o_id; ?>">
                                    <div class="panel-body" style="margin-top:10px;">
                                    <div class="row">
                                        <div class="col-md-2   sr" id=""> <label >Remarks</label> </div>  
                                        <div class="col-md-10  ">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($huf_record[0])){ echo $huf_record[0]->ow_txnremarks; } else { echo ''; }?></textarea>
                                        </div>
                                    </div>
                                    </div>
                                         
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Owners" class="btn btn-danger">Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
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
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>
		
            <script type="text/javascript">
            
$(document).ready(function(){
        $('.table').addClass('table-active table table-bordered');    
  });

      </script>

 <script>


       $('.printdiv').click(function(){

            $('th').css("border","1px solid #ddd !important");
            $('th').css("border-right","1px solid #ddd !important")


            


            var divToPrint=document.getElementById('pdiv');

              var newWin=window.open('','Print-Window');

              newWin.document.open();

                        newWin.document.write('<html>   <style> body{padding:0; margin:0; font-family: Montserrat-Black, muli, Open Sans, sans-serif; font-weight:400;} table{border-spacing:0; border-collapse:collapse; border:1px solid #ddd; text-align:left; width:100%; margin:10px 0; clear:both; } table tr td {border:1px solid #ddd; padding:5px;} .print-authorised tr th:first-child{width:40%;} table tr th {border:1px solid #ddd; text-align:left;  padding:5px; font-weight:400;}.download {display:none;} .form-group{display:flex; word-break: break-all; padding:10px; border:1px solid #ddd!important; border-bottom:0px solid #ddd!important;}.print-form-group {display:inline-block;     width: 97%;}.panel-heading { border:none!important; margin-top:20px;}.panel-heading .panel-title { margin-bottom:5px; padding:0; font-weight:400; font-size:20px;}   strong{  font-weight:400;  } .print-border{ border-bottom:1px solid #ddd!important;}.control-label{ float:left; padding-right:2px;}.print-form-group .col-md-2 { width:100%;}.col-md-4 {width:40%;}.col-md-6 {width:50%;}</style> <body onload="window.print()"> <div>'+divToPrint.innerHTML+'</body></html>');

              newWin.document.close();

              //setTimeout(function(){newWin.close();},10);
        });
        </script> 
    <!-- END SCRIPTS -->      
    </body>
</html>