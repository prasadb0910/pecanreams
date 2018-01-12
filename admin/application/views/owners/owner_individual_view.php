<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Pecan Reams</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="<?php echo base_url(); ?>image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>		
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-view.css"/>
        <!-- EOF CSS INCLUDE -->                                      
	<style type="text/css">
 
.address-remark{width: 12.8%;}
.address-container1{width:87.2%; display:flex;}


@media screen   and (max-width:720px)  {
.responsive-margin {
    width: 100%;
    background: #fff;
    padding: 6px 15px 3px;
    text-align: right;
}
.btn-top-margin {
    margin: 0px!important;
}
}     
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
                     <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/owners'; ?>" > Owner List</a>  &nbsp; &#10095; &nbsp; Owner Details - Individual View</div>
					   <div class="pull-right btn-top-margin responsive-margin">
                                  <!--   <h3 class="panel-title"><strong>Contact Details</strong></h3> -->                                
                                   
									<a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a>

                                    <?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?> <a  class="btn-margin"  href="<?php echo base_url().'index.php/Owners/edit_individual/'.$o_id; ?>" > <span class="btn btn-success pull-right btn-font"> Edit </span>  </a><?php } }  ?>

								 <a class="btn-margin"  href="<?php echo base_url()?>index.php/Owners" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a>
                             
                                </div>
					 
					 
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                       <div class="row main-wrapper">
                      <div class="main-container">           
                         <div class="box-shadow">   
                         	  <div class="box-shadow-inside custom-padding">
					
						 
						
                        <div class="col-md-12" style="padding:0;">
						   <div class="full-width">
						<div class="panel panel-default">
                            <form id="jvalidate" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">
                                
                                    <div id="pdiv">
                                <div class="panel-body individual-heading">
									
											<div class="form-group" style="border-top:0px dotted #ddd;">
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="">
														<label class="col-md-3 col-sm-5 col-xs-12 control-label"><strong>Owner Name:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 position">
														  <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($editcontact[0])){ echo $editcontact[0]->c_name; } else { echo ''; }?></label>
														</div>
													</div>
												</div>
												
											</div>
                                            
                                           <div class="form-group">
                                        	   <div class="col-md-6 col-sm-6 col-xs-12">
													<div class="">
													  <label class="col-md-3 col-sm-5 col-xs-12 control-label"><strong>Gender:</strong></label>
													  <div class="col-md-9 col-sm-7 col-xs-12 position">
														  <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($editcontact[0])){ echo $editcontact[0]->c_gender; } else { echo ''; }?></label>
														</div>
													</div>
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="">
														<label class="col-md-3 col-sm-5 col-xs-12 control-label"><strong>Designation:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 position">
														  <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($editcontact[0])){ echo $editcontact[0]->c_designation; } else { echo ''; }?></label>
														</div>
													</div>
												</div>
												
											</div>
                                            
                                           <div class="form-group">
                                          		 <div class="col-md-6 col-sm-6 col-xs-12">
													<div class="">
													  <label class="col-md-3 col-sm-5 col-xs-12 control-label"><strong>Email ID1:</strong></label>
													  <div class="col-md-9 col-sm-7 col-xs-12 position-email">
														  <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($editcontact[0])){ echo $editcontact[0]->c_emailid1; } else { echo ''; }?></label>
														</div>
													</div>
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="">
													  <label class="col-md-3 col-sm-5 col-xs-12 control-label"><strong>Email ID2:</strong></label>
													  <div class="col-md-9 col-sm-7 col-xs-12 position">
														  <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($editcontact[0])){ echo $editcontact[0]->c_emailid2; } else { echo ''; }?></label>
														</div>
													</div>
												</div>
												
											</div> 
                                            
                                            
                                            <div class="form-group print-border">
                                           		 <div class="col-md-6 col-sm-6 col-xs-12">
													<div class="">
													  <label class="col-md-3 col-sm-5 col-xs-12 control-label"><strong>Mobile No1:</strong></label>
													  <div class="col-md-9 col-sm-7 col-xs-12 position">
														  <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($editcontact[0])){ echo $editcontact[0]->c_mobile1; } else { echo ''; }?></label>
														</div>
													</div>
												</div>
                                            
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="">
													  <label class="col-md-3 col-sm-5 col-xs-12 control-label"><strong>Mobile No2:</strong></label>
													  <div class="col-md-9 col-sm-7 col-xs-12 position">
														  <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($editcontact[0])){ echo $editcontact[0]->c_mobile2; } else { echo ''; }?></label>
														</div>
													</div>
												</div>
											</div>


                                            <div class="form-group print-border ">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="">
                                                      <label class="col-md-3 col-sm-5 col-xs-12 remark-1 control-label  position-name-1" ><strong>Maker Remark:</strong></label>
                                                      <div class="col-md-9 col-sm-7 col-xs-12  position-view-1">
                                                          <label class="col-md-12 remark control-label contact-view" style="text-align:left;"> <?php if(isset($ow_maker_remark)){ echo $ow_maker_remark; } else { echo ''; }?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="">
                                                      <label class="col-md-3 col-sm-5 col-xs-12 remark-1 control-label  position-name-1" ><strong>Checker Remark:</strong></label>
                                                      <div class="col-md-9 col-sm-7 col-xs-12  position-view-1">
                                                          <label class="col-md-12 remark control-label contact-view" style="text-align:left;"> <?php if(isset($indi[0])){ echo $indi[0]->ow_txnremarks; } else { echo ''; }?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                </div>
							</div>	
							</form>
							

                            <?php if(isset($indi)) { ?>
                            <?php if($indi[0]->ow_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
                              
                                <form id="" method="post" action="<?php echo base_url().'index.php/Owners/updateindividualrecord/'.$o_id; ?>">
                                    <div class="panel-body" style="margin-top:10px;">
                                    <div class="row"  >
									  <div class="col-md-2 address-remark sr" id="" > <label >Remarks</label> </div>  
                                        <div class="col-md-10 address-container1">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($indi[0])){ echo $indi[0]->ow_txnremarks; } else { echo ''; }?></textarea>
                                        </div>
                                      
                                    </div>
                                    </div>
                                         
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Owners" class="btn btn-danger">Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                    </div> 
                                </form>

                            <?php } } } else if($indi[0]->ow_modified_by != '' && $indi[0]->ow_modified_by != null) { if($indi[0]->ow_modified_by!=$ownerby) { if($indi[0]->ow_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                              
                                <form id="" method="post" action="<?php echo base_url().'index.php/Owners/approverecord/'.$o_id; ?>">
                                    <div class="panel-body" style="margin-top:10px;">
                                    <div class="row"  >
									  <div class="col-md-2  addres-r_approvals sr" id=""  > <label >Remarks</label> </div>  
                                        <div class="col-md-10 address-container1"  >										
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($indi[0])){ echo $indi[0]->ow_txnremarks; } else { echo ''; }?></textarea>
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

                                <form id="" method="post" action="<?php echo base_url().'index.php/Owners/updateindividualrecord/'.$o_id; ?>">
                                    <div class="panel-body" style="margin-top:10px;">
                                    <div class="row"  >
									 <div class="col-md-2 address-remark sr" id=""   > <label >Remarks</label> </div> 
                                        <div class="col-md-10 address-container1"  >
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($indi[0])){ echo $indi[0]->ow_txnremarks; } else { echo ''; }?></textarea>
                                        </div>
                                        
                                    </div>
                                    </div>
                                         
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/Owners" class="btn btn-danger">Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                    </div> 
                                </form>

                            <?php } } else if($indi[0]->ow_create_by != '' && $indi[0]->ow_create_by != null) { if($indi[0]->ow_create_by!=$ownerby && $indi[0]->ow_status != 'In Process') { if($indi[0]->ow_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                              
                                <form id="" method="post" action="<?php echo base_url().'index.php/Owners/approverecord/'.$o_id; ?>">

                                    <div class="panel-body" style="margin-top:10px;">
                                    <div class="row"  >
									<div class="col-md-2 address-remark sr " id="" > <label >Remarks</label> </div>
                                        <div class="col-md-10 address-container1"  >
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($indi[0])){ echo $indi[0]->ow_txnremarks; } else { echo ''; }?></textarea>
                                        </div>
                                        
                                        
                                        </div>
                                        </div>
                                         
                                        <div class="panel-footer">
                                            <a href="<?php echo base_url(); ?>index.php/Owners" class="btn btn-danger">Cancel</a>
                                            <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit" style="margin-right:10px;"/>
                                            <input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                    
                                        </div> 
                                </form>

                            <?php } } } } else { ?>
                                
                                <form id="" method="post" action="<?php echo base_url().'index.php/Owners/updateindividualrecord/'.$o_id; ?>">
                                    <div class="panel-body" style="margin-top:10px;">
                                    <div class="row" >
									  <div class="col-md-2 address-remark  sr" id="" > <label >Remarks:</label> </div> 
                                        <div class="col-md-10 address-container1 " >
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($indi[0])){ echo $indi[0]->ow_txnremarks; } else { echo ''; }?></textarea>
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
    </body>
</html>