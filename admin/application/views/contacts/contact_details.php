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
		
		 
        
    </head>

    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
                   <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/contacts'; ?>" > Contact List </a>  &nbsp; &#10095; &nbsp; Contact Details</div>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row main-wrapper">
					<div class="main-container">           
                         <div class="box-shadow">   
                      
						
                        
                            <form id="form_contact" role="form" class="form-horizontal" method ="post" action="<?php if(isset($editcontact)) { echo base_url().'index.php/contacts/updateRecord/'.$c_id; } else { echo base_url().'index.php/contacts/saveRecord'; } ?>" enctype="multipart/form-data" autocomplete="off">
                               <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">

                               <!--  <div class="panel-heading">
                                    <h3 class="panel-title" style="text-align:center;float:initial;"><strong>Contact Master</strong></h3>
                                </div> -->
                                                
                                <div id="form_errors" style="display:none; color:#E04B4A;" class="error"></div>

                                <div class="panel-body panel-group accordion">
                                    <div class="panel  panel-primary" id="panel-personal-details">
                                        <a href="#accOneColOne">   
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                               <span class="fa fa-check-square-o"> </span>  Personal Details
                                            </h4>
                                        </div>   
                                        </a>

                                        <div class="panel-body panel-body-open text1" id="accOneColOne" style="width:100%; ">
                                            <div class="form-group" style="border-top:1px solid #ddd; padding-top:10px;">
                                                <div class="col-md-12">
                                                    <label class="col-md-2 control-label"><span id="full_name_label"><?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others') echo 'Name'; else echo 'Full Name'; } else echo 'Full Name'; ?></span> <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-3" >
                                                        <input type="hidden" class="form-control" name="c_id" id="c_id" value="<?php if (isset($c_id)) { echo $c_id; } ?>">
                                                        <input type="text" class="form-control" name="c_name" id="c_name" placeholder="First Name" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_name; } ?>"/>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" name="c_middle_name" id="c_middle_name" placeholder="Middle Name" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_middle_name; } ?>" style="<?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others') echo 'display: none;'; else echo ''; } else echo ''; ?>"/>
                                                        <select class="form-control" name="owner_type" id="owner_type" style="<?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others') echo ''; else echo 'display: none;'; } else echo 'display: none;'; ?>">
                                                            <option value="">Select</option>
                                                            <option value="Individual" <?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others' && $editcontact[0]->c_last_name=='Individual') echo 'selected'; } ?>>Individual</option>
                                                            <option value="HUF" <?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others' && $editcontact[0]->c_last_name=='HUF') echo 'selected'; } ?>>HUF</option>
                                                            <option value="Private Limited" <?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others' && $editcontact[0]->c_last_name=='Private Limited') echo 'selected'; } ?>>Private Limited</option>
                                                            <option value="Limited" <?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others' && $editcontact[0]->c_last_name=='Limited') echo 'selected'; } ?>>Limited</option>
                                                            <option value="LLP" <?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others' && $editcontact[0]->c_last_name=='LLP') echo 'selected'; } ?>>LLP</option>
                                                            <option value="Partnership" <?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others' && $editcontact[0]->c_last_name=='Partnership') echo 'selected'; } ?>>Partnership</option>
                                                            <option value="AOP" <?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others' && $editcontact[0]->c_last_name=='AOP') echo 'selected'; } ?>>AOP</option>
                                                            <option value="Trust" <?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others' && $editcontact[0]->c_last_name=='Trust') echo 'selected'; } ?>>Trust</option>
                                                            <option value="Proprietorship" <?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others' && $editcontact[0]->c_last_name=='Proprietorship') echo 'selected'; } ?>>Proprietorship</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                       <input type="text" class="form-control" name="c_last_name" id="c_last_name" placeholder="Last Name" value="<?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Legal Entity') echo $editcontact[0]->c_last_name; } ?>" style="<?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others') echo 'display: none;'; else echo ''; } else echo ''; ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Type <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-6">
                                                        <select class="form-control" name="type" id="type">
                                                            <option value="">Select</option>
                                                            <option value="Legal Entity" <?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Legal Entity') echo 'selected'; } ?>>Legal Entity</option>
                                                            <option value="Others" <?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others') echo 'selected'; } ?>>Others</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 company-hide" style="<?php if (isset($editcontact)) { if($editcontact[0]->c_type!='Others') echo 'display: none;'; } else echo 'display: none;'; ?>">
                                                    <label class="col-md-4 control-label">Concerned Person Name</label>
                                                    <div class="col-md-6">
                                                      <input type="text" class="form-control" name="company" id="company" placeholder="Company" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_company; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" id="contact_type_div" style="<?php if (isset($editcontact)) { if($editcontact[0]->c_type!='Others') echo 'display: none;'; } else echo 'display: none;'; ?>">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Related Party Type</label>
                                                    <div class="col-md-6">
                                                        <select name="contact_type" class="form-control" id="contact_type">
                                                            <option value="">Select</option>
                                                            <?php if (isset($editcontact)) { 
                                                                    for ($j=0; $j < count($contact_type) ; $j++) { ?>
                                                                        <option value="<?php echo $contact_type[$j]->id; ?>" <?php if($contact_type[$j]->id==$editcontact[0]->c_contact_type) { echo 'selected'; } ?>><?php echo $contact_type[$j]->contact_type; ?></option>
                                                            <?php }} else { 
                                                                    for ($j=0; $j < count($contact_type) ; $j++) { ?>
                                                                        <option value="<?php echo $contact_type[$j]->id; ?>"><?php echo $contact_type[$j]->contact_type; ?></option>
                                                            <?php }} ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">PAN Card No</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="pan_card" name="pan_card" placeholder="PAN Card No" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_pan_card; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group others-hide" style="<?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others') echo 'display: none;'; } ?>">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Date Of Birth <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control datepicker1" id="dob" name="date_of_birth" placeholder="Date Of Birth" value="<?php if (isset($editcontact)) { if($editcontact[0]->c_dob!='' && $editcontact[0]->c_dob!=null) echo date('d/m/Y',strtotime($editcontact[0]->c_dob)); } ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label" style="padding-left:0;">Anniversary Date</label>
                                                    <div class="col-md-6">
                                                      <input type="text" class="form-control datepicker1" id="date_of_anniversary" name="date_of_anniversary" placeholder="Date Of Anniversary" value="<?php if (isset($editcontact)) { if($editcontact[0]->c_anniversarydate!='' && $editcontact[0]->c_anniversarydate!=null) echo date('d/m/Y',strtotime($editcontact[0]->c_anniversarydate)); } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Gender <span class="asterisk_sign others-validation">*</span></label>
                                                    <div class="col-md-6">    
                                                        <select class="form-control" name="gender" id="gender">
                                                            <option value="">Select</option>
                                                            <option value="Male" <?php if (isset($editcontact)) { if($editcontact[0]->c_gender=='Male') echo 'selected'; } ?>>Male</option>
                                                            <option value="Female" <?php if (isset($editcontact)) { if($editcontact[0]->c_gender=='Female') echo 'selected'; } ?>>Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Designation</label>
                                                    <div class="col-md-6">
                                                       <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_designation; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group others-hide guardian" style="<?php if(isset($guardian)) echo 'display:block;'; else echo 'display:none;'; ?>">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Guardian <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-6">
                                                        <input type="hidden" id="guardian_id" name="guardian" class="form-control" value="<?php if (set_value('guardian')!=null) { echo set_value('guardian'); } else if(isset($editcontact[0]->c_guardian)){ echo $editcontact[0]->c_guardian; } else { echo ''; }?>" />
                                                        <input type="text" id="guardian" name="guardian_name" class="form-control auto_client" value="<?php if (set_value('guardian_name')!=null) { echo set_value('guardian_name'); } else if(isset($guardian)){ echo $guardian; } else { echo ''; }?>" placeholder="Type to choose contact from database..." />
                                                        <!-- <button class="btn btn-info mb-control sch" id="schedule_btn" data-box="#message-box-info" style="margin-left: 2px;">+</button> -->
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Relation <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="guardian_relation" name="guardian_relation" placeholder="Guardian Relation" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_relation; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Address <span class="asterisk_sign others-validation">*</span></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="address" placeholder="Address" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_address; } ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Landmark <span class="asterisk_sign others-validation">*</span></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="landmark" placeholder="Landmark" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_landmark; } ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">City <span class="asterisk_sign others-validation">*</span></label>
                                                    <div class="col-md-6">
                                                        <input type="hidden" name="city_id" id="con_add_city_id" />
                                                        <input type="text" class="form-control autocompleteCity" name="city" id ="con_add_city" placeholder="City" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_city; } ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Pincode</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="pincode" placeholder="Pincode" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_pincode; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">State <span class="asterisk_sign others-validation">*</span></label>
                                                    <div class="col-md-6">
                                                        <input type="hidden" name="state_id" id="con_add_state_id" />
                                                        <input type="text" class="form-control loadstatedropdown" name="state" id="con_add_state" placeholder="State" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_state; } ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Country <span class="asterisk_sign others-validation">*</span></label>
                                                    <div class="col-md-6">
                                                        <input type="hidden" name="country_id" id="con_add_country_id">
                                                        <input type="text" class="form-control loadcountrydropdown"  name="country" id="con_add_country" placeholder="Country" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_country; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Email ID - 1 <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-6">
                                                       <input type="text" class="form-control" id="email_id1" name="email_id1" placeholder="Email Id 1" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_emailid1; } ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Email ID - 2</label>
                                                    <div class="col-md-6">
                                                       <input type="text" class="form-control" id="email_id2" name="email_id2" placeholder="Email Id 2" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_emailid2; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Mobile No - 1<span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-6">
                                                     <input type="text" class="form-control" id="mobile_no1" name="mobile_no1" placeholder="Mobile No 1" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_mobile1; } ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Mobile No - 2</label>
                                                    <div class="col-md-6">
                                                      <input type="text" class="form-control" id="mobile_no2" name="mobile_no2" placeholder="Mobile No 2" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_mobile2; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">KYC Required? <span class="asterisk_sign others-validation">*</span></label>
                                                    <div class="col-md-6" style="line-height:33px;">
                                                        <input type="radio" name="kyc" class="icheckbox" value="1" id="kyc_yes" data-error="#err_kyc" <?php if (isset($editcontact)) { if($editcontact[0]->c_kyc_required=='1') echo 'checked'; } ?>/>&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" name="kyc" class="icheckbox" value="0" id="kyc_no" data-error="#err_kyc" <?php if (isset($editcontact)) { if($editcontact[0]->c_kyc_required=='0') echo 'checked'; } ?>/>&nbsp;&nbsp;No
                                                        <div id="err_kyc"></div>
                                                    </div>
                                                </div>
												  <div class="col-md-6 company-hide1" style="display:none !important;">
                                                    <label class="col-md-4 control-label">PAN No.</label>
                                                    <div class="col-md-6">
                                                      <input type="text" class="form-control" name="pancard" id="pancard" placeholder="PAN No." value="<?php if (isset($editpancard)) { echo $editpancard[0]->c_pancard; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                              <div class="col-md-12 btn-margin">
                                            <a href="#accOneColTwo" >
                                                <button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button>
                                            </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="panel panel-primary" id="kyc-section" style="<?php if (isset($editcontact)) { if($editcontact[0]->c_kyc_required!='1') echo 'display:none;'; } else echo 'display:none;'; ?>">
                                        <a href="#accOneColTwo">  
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <span class="fa fa-check-square-o"> </span>     KYC Details 
                                                </h4>
                                            </div>  
                                        </a>                              
                                        <div class="panel-body" id="accOneColTwo">
                                            <?php $this->load->view('templates/document');?>
                                            

                                            <div class="col-md-12 btn-margin">
                                                <button type="button" class="btn btn-success" id="repeat-documents"  >+</button>
                                                <!-- <button type="button" class="btn btn-success" id="reverse-documents" style="margin-left: 10px;">-</button> -->

                                                <a href="#accOneColThree" >
                                                    <button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button>
                                                </a>
                                            </div>
                                        </div>                                
                                    </div>
                                    
                                    <div class="panel panel-primary" id="nominee-section" style="display:block;">
                                        <a href="#accOneColThree"> 
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><span class="fa fa-check-square-o"> </span> Nominee Details </h4>
                                            </div>
                                        </a>                                 
                                        <div class="panel-body" id="accOneColThree">
                                            <div class="table-responsive">
                                            <table id="contacts" class="table group nominee table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="55" align="center">Sr. No.</th>
                                                        <th>Name </th>
                                                        <th>Relation </th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    <?php $j=0;
                                                    if(isset($editcontnom)) {
                                                    for($j=0;$j<count($editcontnom); $j++) { ?>
                                                    <tr id="repeat_nominee_<?php echo $j+1; ?>">
                                                        <td  align="center"><?php echo ($j+1); ?></td>
                                                        <td class="Contact_name">
                                                            <input type="hidden" id="txtname_<?php echo '' . $j+1 . '_id"'; ?> name="nm_name[]" class="form-control" value="<?php if (set_value('nm_name')!=null) { echo set_value('nm_name'); } else if(isset($editcontnom[$j]->nm_name)){ echo $editcontnom[$j]->nm_name; } else { echo ''; }?>" />
                                                            <input type="text" id="txtname_<?php echo '' . $j+1 . '"'; ?> name="nm_contact_name[]" class="form-control auto_client nm_contact_name" value="<?php if(isset($editcontnom[$j]->c_name)){ echo $editcontnom[$j]->c_name; } else { echo ''; }?>" placeholder="Type to choose contact from database..." />
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nm_relation[]" class="form-control" placeholder="Relation" value="<?php if(isset($editcontnom[$j]->nm_relation)){ echo $editcontnom[$j]->nm_relation; } else { echo ''; }?>"/>
                                                        </td>
                                                    </tr>
                                                    <?php } } else { ?>
                                                    <tr id="repeat_nominee_<?php echo $j+1; ?>">
                                                        <td><?php echo $j+1; ?></td>
                                                        <td class="Contact_name">
                                                            <input type="hidden" id="txtname_<?php echo '' . $j+1 . '_id"'; ?> name="nm_name[]" class="form-control" />
                                                            <input type="text" id="txtname_<?php echo '' . $j+1 . '"'; ?> name="nm_contact_name[]" class="form-control auto_client nm_contact_name" placeholder="Type to choose contact from database..." />
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nm_relation[]" class="form-control" placeholder="Relation"/>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            </div>
                                            <div class="col-md-12 btn-margin">
                                                <button type="button" class="btn btn-success repeat-nominee"> + </button>
                                                <button type="button" class="btn btn-success reverse-nominee" > - </button>
                                                <!-- <button type="button" class="btn btn-info mb-control sch" style="float:right;" data-box="#message-box-info"><span class="fa fa-plus"></span> Add Contact</button> -->
                                            </div>
                                        </div>
                                    </div>

                                     <div class="panel panel-primary" id="nominee-section" style="display:block;">
                                        <a href="#accOneColfour"> 
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><span class="fa fa-check-square-o"> </span> Remark </h4>
                                            </div>
                                        </a>                                 
                                        <div class="panel-body" id="accOneColfour">
                                            <div class="remark-container">
                                                <div class="form-group" style="background: none;border:none">
                                                <div class="col-md-12">
                                                    <div class="" ass="col-md-12">
                                                        <textarea  class="form-control" id="maker_remark" name="maker_remark" rows="2" ><?php if(isset($editcontact)){ echo $editcontact[0]->maker_remark;}?></textarea>
                                                        <!-- <label style="margin-top: 5px;">Remark </label> -->
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                </div>
                                    
                            
                                  </div>
                     
                    </div>
							   <br clear="all"/>
                       </div>
			
                          <div class="panel-footer">
                                    <input type="hidden" id="submitVal" value="1" />
                                    <a href="<?php echo base_url(); ?>index.php/contacts" class="btn btn-danger btn-danger" >Cancel</a>
                                    <input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="margin-right: 10px;" />
                                    <input formnovalidate="formnovalidate" type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
                                </div>
                            </form>

                                   <!-- End contact popup -->
                      
                            <!-- start contact popup -->
                     <form id="contact_popup_form" role="form" class="form-horizontal" method ="post" enctype="multipart/form-data">
                                   <div class="message-box message-box-info animated fadeIn" id="message-box-info" style="overflow:auto;">
                                    <div class="mb-container" style="background:#fff;">
                                        <div class="mb-middle">
                                            
                                                <div class="mb-title" style="color:#000;text-align:center;">Add Contact</div>
                                                <div class="mb-content">
                                                    <div class="form-group" style="border-top: 1px dotted #ddd;">
                                                        <label class="col-md-2 control-label" s>Full Name <span class="asterisk_sign">*</span></label>
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
                                                            <label class="col-md-2 control-label" >Mobile No <span class="asterisk_sign">*</span></label>
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
        var BASE_URL="<?php echo base_url()?>";
    </script>

    <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>

	<script>
        // function delete_row(elem){
        //     var id = elem.attr('id');
        //     id = '#'+id.substr(0,id.lastIndexOf('_'));
        //     if($(id).length>0){
        //         $(id).remove();
        //     }
        // }

        // jQuery(function(){
        //     $('.delete_row').click(function(event){
        //         delete_row($(this));
        //     });
        // });

        // jQuery(function(){
        //           var counter = $('input.doc_file').length;
        //           $('.repeat').click(function(event){
        //               event.preventDefault();
        //               var newRow = jQuery('<div class="form-group" id="repeat_doc_'+counter+'" style="background:none;border:none;"><div class="col-md-3"><div class="col-md-6"><input type="hidden" class="form-control" name="doc_type[]" id="doc_type_'+counter+'" value="Others" /><input type="hidden" class="form-control" id="d_m_status_'+counter+'" value="Yes" /><label style="margin-top: 5px;">Others <span class="asterisk_sign">*</span></label></div><div class="col-md-6"><input type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_'+counter+'" placeholder="Document Name"/></div></div><div class="col-md-4"><div class="col-md-6"><input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="" /></div><div class="col-md-6"><input type="text" class="form-control ref_no" name="ref_no[]" id="ref_no_'+counter+'" placeholder="Reference No"/></div></div><div class="col-md-3"><div class="col-md-6"><input type="text" class="form-control datepicker" name="date_issue[]" placeholder="Date of Issue"/></div><div class="col-md-6"><input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry"/></div></div><div class="col-md-2"><div class="col-md-8"><a class="file-input-wrapper btn btn-default fileinput btn-primary"><span>Browse</span><input type="file" class="fileinput btn-primary doc_file" name="doc_'+counter+'" id="doc_file_'+counter+'" data-error="#doc_'+counter+'_error" style="width: 100%;height: 28px;"></a><div id="doc_'+counter+'_error"></div></div><div class="col-md-4"><a id="repeat_doc_'+counter+'_delete" class="delete_row" href="#">Delete</a></div></div>');
        //               counter++;
        //               $('.addkyc').append(newRow);
        //               $('.datepicker').datepicker();
        //               $('input.doc_file').each(function() {
        //                   var id = $(this).attr('id');
        //                   var index = id.substr(id.lastIndexOf('_')+1);
        //                   if($('#d_m_status_'+index).val()=="Yes") {
        //                       $(this).rules("add", { required: function(element) {
        //                                                                   if($("#submitVal").val()=="0"){
        //                                                                           return $("#kyc_yes").is(":checked");
        //                                                                       } else {
        //                                                                           return false;
        //                                                                       }
        //                                                                   }
        //                                           }, "Document");
        //                   }
        //               });
        //               $('.delete_row').click(function(event){
        //                   delete_row($(this));
        //               });
        //               $("form :input").change(function() {
        //                   $(".save-form").prop("disabled",false);
        //               });
        //           });
        //           $('.reverse').click(function(event){
        //               var id="#repeat_doc_"+(counter-1).toString();
        //               if($(id).length>0){
        //                   $(id).remove();
        //                   counter--;
        //               }
        //           });
        //       });
	</script>

	<script>
		jQuery(function(){
            var counter = $('.nm_contact_name').length;
            $('.repeat-nominee').click(function(event){
                event.preventDefault();
                counter++;
                var newRow = jQuery('<tr id="repeat_nominee_'+counter+'"><td>'+counter+'</td><td class="Contact_name"><input type="hidden" id="txtname_'+counter+'_id" name="nm_name[]" class="form-control" /><input type="text" id="txtname_'+counter+'" name="nm_contact_name[]" class="form-control auto_client nm_contact_name" placeholder="Type to choose contact from database..." /></td><td><input type="text" name="nm_relation[]" class="form-control" placeholder="Relation"/></td></tr>');
                $('.auto_client', newRow).autocomplete(autocomp_opt);
                $('.nominee').append(newRow);
                $("form :input").change(function() {
                    $(".save-form").prop("disabled",false);
                });
            });
            $('.reverse-nominee').click(function(event){
                if(counter!=1){
                    var id="#repeat_nominee_"+(counter).toString();
                    if($(id).length>0){
                        $(id).remove();
                        counter--;
                    }
                }
            });
        });
	</script>

    <script type="text/javascript">
        function checkload(){
            var input=document.getElementById('uploader');
            for (var i = input.length - 1; i >= 0; i--) {
            	alert(input[i].files[i].name);
            }
        }
    </script>
    
    <script>
		$(function() {
			$('#type').change(function(){
				if($('#type').val() == 'Others') {
					$('.others-validation').hide();
					$('.others-hide').hide();
					$('.company-hide').show();
                    $('#contact_type_div').show();

                    $('#dob').val('');
                    $('#date_of_anniversary').val('');
                    checkdob();

                    $('#full_name_label').html('Name');
                    $('#c_middle_name').hide();
                    $('#c_last_name').hide();
                    $('#owner_type').show();
                    $('#c_name').attr("placeholder", "Name");

				} else {
					$('.others-validation').show();
					$('.others-hide').show();
                    $('.company-hide').hide();
                    $('#contact_type_div').hide();

                    $('#company').val('');
                    $('#contact_type').val('');
                    $('#pan_card').val('');
                    checkdob();

                    $('#full_name_label').html('Full Name');
                    $('#c_middle_name').show();
                    $('#c_last_name').show();
                    $('#owner_type').hide();
                    $('#c_name').attr("placeholder", "First Name");
				}
			});

            $('#dob').change(function(){
                checkdob();
            });
		});
    </script>

    <script type="text/javascript">
        function checkdob(){
            var age = getAge();
            if(age<18 && age !=null){
                $('.guardian').show();
            }
            else{
                $('.guardian').hide();
                $('#guardian').val('');
                $('#guardian_relation').val('');
            }
        }
        function getAge(){
            var age = null;

            if ($('#dob').val()!=""){
                var day = moment($('#dob').val(), "DD/MM/YYYY");
                var dob = new Date(day);
                var today = new Date();
                age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
            }
            
            return age;
        }
        // function getMStatus(element){
        //     var id = element.id;
        //     var doc_name = element.value;
        //     var index = id.substr(id.lastIndexOf('_')+1);

        //     var doc_type = $('#doc_type_'+index).val();

        //     $.ajax({
        //             url: "<?php echo base_url() . 'index.php/contacts/get_m_status' ?>",
        //             data: 'doc_name='+doc_name+'&doc_type='+doc_type,
        //             type: "POST",
        //             dataType: 'html',
        //             global: false,
        //             async: false,
        //             success: function (data) {
        //                 $('#d_m_status_'+index).val($.trim(data));
        //             },
        //           error: function (xhr, ajaxOptions, thrownError) {
        //                 $('#d_m_status_'+index).val("");
        //           }
        //         });
        // }
    </script>

    <script>
        $(document).ready(function() {
            $('input[type=radio][name=kyc]').on('ifClicked', function () {
                if (this.value == '1') {
                    $('#nominee-section').show();
                    $('#kyc-section').show();
                }
                else if (this.value == '0') {
                    $('#kyc-section').hide();
                    //$('#nominee-section').hide();
                }
            });

            addMultiInputNamingRules('#form_contact', '.doc_name', { required: function(element) {
                                                                                if($("#submitVal").val()=="0"){
                                                                                        return $("#kyc_yes").is(":checked");
                                                                                    } else {
                                                                                        return false;
                                                                                    }
                                                                                }
                                                                    }, "Document");
            // addMultiInputNamingRules('#form_contact', 'input[name="ref_no[]"]', { required:function(element) {
            //                                                                                     return $("#kyc_yes").is(":checked");
            //                                                                                 }
            //                                                                     }, "");

            $('input.doc_file').each(function() {
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                if($('#d_m_status_'+index).val()=="Yes") {
                    $(this).rules("add", { required: function(element) {
                                                                    if($("#submitVal").val()=="0"){
                                                                            return $("#kyc_yes").is(":checked");
                                                                        } else {
                                                                            return false;
                                                                        }
                                                                    }
                                        });
                }
            });

            // addMultiInputNamingRules('#form_contact', 'input[name="nm_contact_name[]"]', { required: function(element) {
            //                                                         if($("#submitVal").val()=="0"){
            //                                                                 return $("#kyc_yes").is(":checked");
            //                                                             } else {
            //                                                                 return false;
            //                                                             }
            //                                                         }
            //                                 }, "");
            // addMultiInputNamingRules('#form_contact', 'input[name="nm_relation[]"]', { required: function(element) {
            //                                                         if($("#submitVal").val()=="0"){
            //                                                                 return $("#kyc_yes").is(":checked");
            //                                                             } else {
            //                                                                 return false;
            //                                                             }
            //                                                         }
            //                                 }, "");
        });
    </script>
	<script type="text/javascript">
        $(function() {
            $(".datepicker1").datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
        });
    </script>
    </body>
</html>
