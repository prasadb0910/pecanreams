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
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
        <!-- EOF CSS INCLUDE -->                                      
		
		<style>
 
			
			 .addkyc .row [class^='col-xs-'], .row [class^='col-sm-'], .row [class^='col-md-'], .row [class^='col-lg-']
            {
                padding-left: 2px;
                padding-right: 2px;
            }

		</style>
	        <style type="text/css">
.panel-body .form-group{ padding-right:10px;}
.file-input-wrapper .fileinput { overflow:hidden;}
 .padding-height {padding:6px 10px; overflow:hidden;}
        </style>	
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                
                     <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/owners'; ?>" > Owner List</a>  &nbsp; &#10095; &nbsp; Owner Details - HUF</div>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                     <div class="row main-wrapper">
				    	<div class="main-container">           
                          <div class="box-shadow custom-padding">  
							<form id="form_huf" role="form" class="form-horizontal" method="post" action="<?php if(isset($huf_record)) { echo base_url().'index.php/owners/updatehufrecord/'.$o_id; } else { echo base_url().'index.php/owners/savehufrecord'; } ?>" enctype="multipart/form-data" autocomplete="off">
							 <div class="box-shadow-inside">
                                <div class="col-md-12" style="padding:0;" >
                                 <div class="panel panel-default">
								<div class="panel-body box-padding" >
									<div class="form-group"  >
										<div class="col-md-6">											
												<label class="col-md-3 control-label">HUF Name <span class="asterisk_sign">*</span></label>
												<div class="col-md-9">
													<input type="hidden" class="form-control" id="o_id" name="o_id" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_id; } ?>"/>
													<input type="text" class="form-control" name="huf_name" placeholder="HUF Name" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_huf_name; } ?>"/>
												</div>
										</div>		
										<div class="col-md-6">		
												<label class="col-md-3 control-label">Registration No</label>
												<div class="col-md-9">
													<input type="text" class="form-control" name="ow_reg_no" placeholder="Registration No" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_reg_no; } ?>"/>
												</div>
										</div>
									</div>
									 
									<div class="form-group">
										<div class="col-md-6">											
												<label class="col-md-3 control-label">Date of Incorp <span class="asterisk_sign">*</span></label>
												<div class="col-md-9">
													<input type="text" class="form-control datepicker1"  name="huf_doi" placeholder="Date of Incorporation" value="<?php if(isset($huf_record)) { if($huf_record[0]->ow_huf_incorpdate!='' && $huf_record[0]->ow_huf_incorpdate!=null) echo date('d/m/Y', strtotime($huf_record[0]->ow_huf_incorpdate)); } ?>"/>
												</div>
										</div>
										<div class="col-md-6">	
												<label class="col-md-3 control-label">Karta Name <span class="asterisk_sign">*</span></label>
												<div class="col-md-9">
                                             		<input type="hidden" id="huf_karta_id" name="huf_karta_name" data-error="#huf_karta_name_error" class="form-control" value="<?php if (set_value('huf_karta_name')!=null) { echo set_value('huf_karta_name'); } else if(isset($huf_record[0]->ow_huf_karta_id)){ echo $huf_record[0]->ow_huf_karta_id; } else { echo ''; }?>" />
                                             		<input type="text" id="huf_karta" name="huf_karta" class="form-control auto_owner" value="<?php if (set_value('huf_karta')!=null) { echo set_value('huf_karta'); } else if(isset($huf_record[0]->owner_name)){ echo $huf_record[0]->owner_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />
                                             		<div id="huf_karta_name_error"></div>
											 	</div>
											 	<!-- <div class="col-md-1">

													<button class="btn btn-info mb-control sch" id="schedule_btn" data-box="#message-box-info" style="margin-left: 2px;">+</button>
												</div> -->
											</div>
									</div>
									<div class="form-group">
										<div class="col-md-6">
											
												<label class="col-md-3 control-label"> Address <span class="asterisk_sign">*</span></label>
												<div class="col-md-9">
													<input type="text" class="form-control"  name="huf_address" placeholder="Address" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_huf_address; } ?>"/>
												</div>
											</div>
									      <div class="col-md-6">
												<label class="col-md-3 control-label">Landmark</label>
												<div class="col-md-9">
													<input type="text" class="form-control"  name="huf_addr_landmark" placeholder="Landmark" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_huf_landmark; } ?>"/>
												</div>
											</div>										 
									</div>
									<div class="form-group">
										<div class="col-md-6">											
												<label class="col-md-3 control-label"> City <span class="asterisk_sign">*</span></label>
												<div class="col-md-9">
													<input type="hidden" name="huf_addr_city_id" id="huf_addr_city_id" />
													<input type="text" class="form-control autocompleteCity"  name="huf_addr_city" id ="huf_addr_city" placeholder="City" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_huf_city; } ?>"/>
												</div>
											</div>
											<div class="col-md-6">
												<label class="col-md-3 control-label"> Pincode <span class="asterisk_sign">*</span></label>
												<div class="col-md-9">
													<input type="text" class="form-control"  name="huf_addr_pincode" id="huf_addr_pincode" placeholder="Pincode" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_huf_pincode; } ?>"/>
												</div>
											</div>										
									</div>
									<div class="form-group">
										<div class="col-md-6">
											
												<label class="col-md-3 control-label">State <span class="asterisk_sign">*</span></label>
												<div class="col-md-9">
													<input type="hidden" name="huf_addr_state_id" id="huf_addr_state_id" />
													<input type="text" class="form-control loadstatedropdown"  name="huf_addr_state" id="huf_addr_state" placeholder="State" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_huf_state; } ?>"/>
												</div>
											</div>
											<div class="col-md-6">
												<label class="col-md-3 control-label">Country</label>
												<div class="col-md-9">
													<input type="hidden" name="huf_addr_country_id" id="huf_addr_country_id">
													<input type="text" class="form-control loadcountrydropdown"  name="huf_addr_country" id="huf_addr_country" placeholder="Country" value="<?php if(isset($huf_record)) { echo  $huf_record[0]->ow_huf_country; } ?>"/>
												</div>
											</div>
										
									</div>
								</div>
								

								<div class="panel-heading" >
									<h3 class="panel-title">Family Details</h3>
								</div>
								<div class="panel-body box-padding">
									<div class="huf">
										<?php $l=0; if(isset($huf_family)) {
											for($l=0;$l<count($huf_family); $l++) {
										?>
										<div class="form-group" id="repeat_huf_<?php echo ($l+1); ?>" style="<?php if($l==0) echo 'border-top: 1px dotted #ddd;'; ?>">
											<div class="col-md-6">											
													<label class="col-md-3 control-label">Name <span class="asterisk_sign">*</span></label>
													<div class="col-md-9">
                                                     	<input type="hidden" id="family_details_<?php echo ($l+1) .'_id'; ?>"  name="family_details[]" data-error="#family_details_<?php echo ($l+1); ?>_error" class="form-control family_details" value="<?php if(isset($huf_family[$l]->huf_ow_family_detail)){ echo $huf_family[$l]->huf_ow_family_detail; } else { echo ''; }?>" />
                                                     	<input type="text" id="family_details_<?php echo ($l+1); ?>" name="family_member_name[]" class="form-control auto_owner" value="<?php if(isset($huf_family[$l]->owner_name)){ echo $huf_family[$l]->owner_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />
                                                     	<div id="family_details_<?php echo ($l+1); ?>_error"></div>
													</div>
											
											</div>
											<div class="col-md-6">												
													<label class="col-md-3 control-label">Relation <span class="asterisk_sign">*</span></label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="relation[]" placeholder="Relation"  value="<?php echo $huf_family[$l]->huf_ow_relation; ?>" />
													</div>												
											</div>
										</div>
										<?php }} else { ?>

										<div class="form-group" id="repeat_huf_<?php echo ($l+1); ?>" style="border-top: 1px dotted #ddd;">

											<div class="col-md-6">
											
													<label class="col-md-3 control-label">Name <span class="asterisk_sign">*</span></label>
													<div class="col-md-9">
	                                                  	<input type="hidden" id="family_details_<?php echo ($l+1).'_id'; ?>"  name="family_details[]" data-error="#family_details_<?php echo ($l+1); ?>_error" class="form-control family_details" value="" />
	                                                    <input type="text" id="family_details_<?php echo ($l+1); ?>" name="family_member_name[]" class="form-control auto_owner" value="" placeholder="Type to choose owner from database..." />
													 	<div id="family_details_<?php echo ($l+1); ?>_error"></div>
													</div>											
											</div>
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Relation <span class="asterisk_sign">*</span></label>
													<div class="col-md-9">
														<input type="text" class="form-control"  name="relation[]" placeholder="Relation"/>
													</div>
												</div>
											</div>
										</div>
										<?php } ?>
									</div> 

									 
	                        	 
	                                 
	                                        <div class="col-md-12 btn-margin">                                                        
												<button class="btn btn-success repeat-huf"   name="addhufbtn">+</button>
												<button type="button" class="btn btn-success reverse-huf" style="margin-left: 10px;">-</button>
												<!-- <button type="button" class="btn btn-info mb-control sch" style="float:right;" data-box="#message-box-info"><span class="fa fa-plus"></span> Add Contact</button> -->
	                                        </div>
	                            
								 
								</div>
									
								
								<div class="panel-heading" >
									<h3 class="panel-title">Documents</h3>
								</div>
								<div class="panel-body">
									<!-- <div class="addkyc">
										<?php //$this->load->view('owners/owner_document');?>
									</div> -->
									
									<?php $this->load->view('templates/document');?>

								 
										 
										 
											   <div class="col-md-12 btn-margin">                                                         
													<!-- <button class="btn btn-success repeat-huf-doc" style="margin-left: 80px;" name="addhufbtn">+</button>
			                                        <button type="button" class="btn btn-success reverse" style="margin-left: 10px;">-</button> -->
                                                    <button type="button" class="btn btn-success" id="repeat-documents" >+</button>
                                                    <!-- <button type="button" class="btn btn-success" id="reverse-documents" style="margin-left: 10px;">-</button> -->
												</div>
											 
								 
								</div>

								<div class="panel-heading"  >
									<h3 class="panel-title">Remark</h3>
								</div>
								<div class="panel-body">
								  <div class="remark-container">
                                   <div class="form-group" style="background: none;border:none">
									<div class="col-md-12">
										<!--<label class="col-md-1 control-label">Remark</label>-->
										<div class="col-md-12">
											<textarea class="form-control" id="ow_maker_remark" name="ow_maker_remark" rows="2" placeholder="Remark"><?php if(isset($huf_record)){ echo $huf_record[0]->ow_maker_remark;}?></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
						</div>
					</div>
						</div>
								<div class="panel-footer">
									<input type="hidden" id="submitVal" value="1" />
									<a href="<?php echo base_url(); ?>index.php/owners" class="btn btn-danger" >Cancel</a>
                                    <input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>"   />
                                    <input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
							    </div>
						    </form>
									
							<!-- start contact popup -->
                        	<form id="contact_popup_form" role="form" class="form-horizontal" method ="post" enctype="multipart/form-data">
                                <div class="message-box message-box-info animated fadeIn" id="message-box-info" style="overflow:auto;">
                                    <div class="mb-container" style="background:#fff;">
                                        <div class="mb-middle">
											<div class="mb-title" style="color:#000;text-align:center;">Add Contact</div>
											<div class="mb-content">
												<div class="form-group" style="border-top: 1px dotted #ddd;">
													<label class="col-md-2 control-label" >Full Name <span class="asterisk_sign">*</span></label>
													<div class="col-md-4">
															<input type="text" id="con_first_name" class="form-control" name="con_first_name" placeholder="First Name"/>
													</div>
													<div class="col-md-3">
															<input type="text" id="con_middle_name" class="form-control" name="con_middle_name" placeholder="Middle Name"/>
													</div>
													<div class="col-md-3">
															<input type="text" id="con_last_name" class="form-control" name="con_last_name" placeholder="Last Name"/>
													</div>
												</div>
												<div class="form-group" style="border-top: 1px dotted #ddd;">
													<div class="col-md-12">
														<label class="col-md-2 control-label" >Email ID <span class="asterisk_sign">*</span></label>
														<div class="col-md-4">
																<input type="text" id="con_email_id1" class="form-control" name="con_email_id1" placeholder="Email ID"/>
														</div>
														<label class="col-md-2 control-label" s>Mobile No <span class="asterisk_sign">*</span></label>
														<div class="col-md-4">
																<input type="text" id="con_mobile_no1" class="form-control" name="con_mobile_no1" placeholder="Mobile No"/>
														</div>
													</div>
												</div>
											</div>

											<div class="mb-footer">
												<button class="btn btn-danger mb-control-close">Cancel</button>
												<button id="save_contact" type="button" class="btn btn-success pull-right" style="margin-right: 10px;">Save</button>
											</div>
                                        </div>
                                    </div>
                                </div>
							</form>
                            <!-- End contact popup -->
							
						

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
        	var BASE_URL="<?php echo base_url();?>";
        </script>

		<script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
    	<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
    	<script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>

    	<script type="text/javascript">
			$(function() {
			  	$(".datepicker1").datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0',
        		changeYear: true });
			});
    	</script>
		<script>
			jQuery(function(){
			    var counter = <?php if(isset($huf_family)) { echo count($huf_family); } else { echo '1'; } ?>;
			    $('.repeat-huf').click(function(event){
			        event.preventDefault();
			        counter++;
			        var newRow = jQuery('<div class="form-group" id="repeat_huf_'+counter+'" style="'+((counter==1)?'border-top:1px dotted #ddd;':'')+'"><div class="col-md-6"><div class=""><label class="col-md-3 control-label">Name <span class="asterisk_sign">*</span></label><div class="col-md-9"><input type="hidden" id="family_details_'+counter+'_id" name="family_details[]" data-error="#family_details_'+counter+'_error" class="form-control family_details" value="" /><input type="text" id="family_details_'+counter+'" name="family_member_name[]" class="form-control auto_owner ui-autocomplete-input" value="" placeholder="Type to choose owner from database..." autocomplete="off"/><div id="family_details_'+counter+'_error"></div></div></div></div><div class="col-md-6"><div class=""><label class="col-md-3 control-label">Relation <span class="asterisk_sign">*</span></label><div class="col-md-9"><input type="text" class="form-control" name="relation[]" placeholder="Relation"/></div></div></div></div>');
			        $('.auto_owner', newRow).autocomplete(autocomp_opt_owner);
			        $('.huf').append(newRow);
			        $("form :input").change(function() {
		                $(".save-form").prop("disabled",false);
		            });
			    });
	            $('.reverse-huf').click(function(event){
	            	if(counter!=1){
		                var id="#repeat_huf_"+(counter).toString();
		                if($(id).length>0){
		                    $(id).remove();
		                    counter--;
		                }
	            	}
	            });
			});

   //      	jQuery(function(){
			//     var counter = $('input.doc_file').length;
			//     $('.repeat-huf-doc').click(function(event){
			//         event.preventDefault();
			//         var newRow = jQuery('<div class="form-group" id="repeat_doc_'+counter+'" style="background:none;border:none;">' + 
			//         						'<div class="col-md-3" style="padding-left:1px; padding-right:1px;">' + 
			//         							'<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
			//         								'<input type="hidden" class="form-control" name="doc_type[]" id="doc_type_'+counter+'" value="Others" />' + 
			//         								'<input type="hidden" class="form-control" id="d_m_status_'+counter+'" value="Yes" />' + 
			//         								'<label style="float: left;margin-top: 5px;">Others <span class="asterisk_sign">*</span></label>' + 
		 //        								'</div>' + 
		 //        								'<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
		 //        									'<input type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_'+counter+'" style="float: left;" placeholder="Document Name"/>' + 
	  //       									'</div>' + 
   //      									'</div>' + 
   //      									'<div class="col-md-4" style="padding-left:1px; padding-right:1px;">' + 
	  //       									'<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
	  //       										'<input type="text" class="form-control" name="doc_desc[]" placeholder="Document Description" value="" />' + 
	  //       									'</div>' + 
	  //       									'<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
	  //       										'<input type="text" class="form-control" name="ref_no[]" id="ref_no_'+counter+'" placeholder="Reference No"/>' + 
   //      										'</div>' + 
   //  										'</div>' + 
   //  										'<div class="col-md-3" style="padding-left:1px; padding-right:1px;">' + 
   //  											'<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
   //  												'<input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue"/>' + 
			// 									'</div>' + 
			// 									'<div class="col-md-6" style="padding-left:1px; padding-right:1px;">' + 
			// 										'<input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry"/>' + 
			// 									'</div>' + 
			// 								'</div>' + 
			// 								'<div class="col-md-2" style="padding-left:1px; padding-right:1px;">' + 
			// 									'<div class="col-md-8" style="padding-left:1px; padding-right:1px;">' + 
			// 										'<a class="file-input-wrapper btn btn-default  fileinput btn-primary">' + 
			// 											'<span>Browse</span>' + 
			// 											'<input type="file" class="fileinput btn-primary doc_file" name="doc_'+counter+'" id="doc_file_'+counter+'" data-error="#doc_'+counter+'_error" style="width: 100%;height: 28px;">' + 
			// 										'</a>' + 
			// 										'<div id="doc_'+counter+'_error"></div>' + 
			// 									'</div>' + 
			// 						            '<div class="col-md-4" style="padding-left:1px; padding-right:1px;">' + 
			// 						                '<a id="repeat_doc_'+counter+'_delete" class="delete_row" href="#">Delete</a>' + 
			// 						            '</div>' + 
			// 								'</div>' + 
			// 							'</div>');
			//         $('.addkyc').append(newRow);
			//         $('.datepicker').datepicker();
			//         $('.datepicker1').datepicker({ maxDate:0,changeYear:true,changeMonth:true,yearRange:'-100:+0' });
	  //               $('.delete_row').click(function(event){
	  //                   delete_row($(this));
	  //               });
			//         $('input.doc_file').each(function() {
   //                  var id = $(this).attr('id');
   //                  var index = id.substr(id.lastIndexOf('_')+1);
   //                  if($('#d_m_status_'+index).val()=="Yes") {
	  //                       $(this).rules("add", { required: function(element) {
	  //                                                               if($("#submitVal").val()=="0"){
			// 									                            return true;
			// 									                        } else {
			// 									                            return false;
			// 									                        }
		 //                                                            }
	  //                                           });
	  //                   }
	  //               });
			//         $("form :input").change(function() {
		 //                $(".save-form").prop("disabled",false);
		 //            });
			//         counter++;
			//     });
	  //           $('.reverse').click(function(event){
	  //               var id="#repeat_doc_"+(counter-1).toString();
	  //               if($(id).length>0){
	  //                   $(id).remove();
	  //                   counter--;
	  //               }
	  //           });
			// });
		</script>
		<script>
	        $(document).ready(function() {
	            addMultiInputNamingRules('#form_huf', '.doc_name', { required:function(element) {
	                                                                                                if($("#submitVal").val()=="0"){
				                                                                                        return true;
				                                                                                    } else {
				                                                                                        return false;
				                                                                                    }
	                                                                                            }
	                                                                    }, "Document");

	            $('input.doc_file').each(function() {
	                var id = $(this).attr('id');
	                var index = id.substr(id.lastIndexOf('_')+1);
	                if($('#d_m_status_'+index).val()=="Yes") {
	                    $(this).rules("add", { required: function(element) {
	                                                            if($("#submitVal").val()=="0"){
                                                                    return true;
                                                                } else {
                                                                    return false;
                                                                }
	                                                        }
	                                        });
	                }
	            });

	            // addMultiInputNamingRules('#form_huf', 'input[name="family_details[]"]', { required: function(element) {
	            //                                                     if($("#submitVal").val()=="0"){
             //                                                            return true;
             //                                                        } else {
             //                                                            return false;
             //                                                        }
	            //                                                 }, 
             //                                                	messages: {required: "Select correct contact from list"}
	            //                                 }, "");
	            addMultiInputNamingRules('#form_huf', 'input[name="family_member_name[]"]', { required: function(element) {
	                                                                if($("#submitVal").val()=="0"){
                                                                        return true;
                                                                    } else {
                                                                        return false;
                                                                    }
	                                                            }, 
                                                            	messages: {required: "Select correct contact from list"}
	                                            }, "");
	            addMultiInputNamingRules('#form_huf', 'input[name="relation[]"]', { required: function(element) {
	                                                                if($("#submitVal").val()=="0"){
                                                                        return true;
                                                                    } else {
                                                                        return false;
                                                                    }
	                                                            }
	                                            }, "");
	        });
	    </script>
    </body>
</html>