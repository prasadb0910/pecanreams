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
        <div class="page-container page-navigation-top">
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <?php $this->load->view('templates/menus');?>
                <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>">  Dashboard  </a> &nbsp; &#10095; &nbsp; Your Profile</div>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
					<div class="main-container">
                        <div class="box-shadow">
                            <form id="form_profile" role="form" class="form-horizontal" method ="post" action="<?php if(isset($editcontact)) { echo base_url().'index.php/profile/updateRecord/'.$c_id; } else { echo base_url().'index.php/profile/saveRecord'; } ?>" enctype="multipart/form-data" autocomplete="off">
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
                                                        <input type="text" class="form-control" name="c_middle_name" id="c_middle_name" placeholder="Middle Name" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_middle_name; } ?>" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" name="c_last_name" id="c_last_name" placeholder="Last Name" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_last_name; } ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group others-hide">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Date Of Birth <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control datepicker1" id="c_dob" name="c_dob" placeholder="Date Of Birth" value="<?php if (isset($editcontact)) { if($editcontact[0]->c_dob!='' && $editcontact[0]->c_dob!=null) echo date('d/m/Y',strtotime($editcontact[0]->c_dob)); } ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" >
                                                    <label class="col-md-4 control-label">Upload Image </label>
                                                    <div class="col-md-6">
                                                        <div class="col-md-9" >
                                                            <input type="hidden" class="form-control" name="c_image" value="<?php echo $editcontact[0]->c_image; ?>" />
                                                            <input type="hidden" class="form-control" name="c_image_name" value="<?php echo $editcontact[0]->c_image_name; ?>" />
                                                            <input type="file" class="fileinput btn btn-success doc_file padding-height" name="c_image_file" id="c_image_file" data-error="#c_image_file_error"/>
                                                            <div id="c_image_file_error"></div>
                                                        </div>
                                                        <div class="col-md-3 download-btn" >
                                                            <?php if($editcontact[0]->c_image!= '') { ?><a target="_blank" title="Download" id="doc_file_download" href="<?php echo base_url().$editcontact[0]->c_image; ?>"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Mobile No <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="mobile_no1" name="mobile_no1" placeholder="Mobile No" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_mobile1; } ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Landline </label>
                                                    <div class="col-md-6">
                                                      <input type="text" class="form-control" id="mobile_no2" name="mobile_no2" placeholder="Landline" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_mobile2; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Email ID <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-6">
                                                       <input type="text" class="form-control" id="email_id1" name="email_id1" placeholder="Email Id" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_emailid1; } ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Office </label>
                                                    <div class="col-md-6">
                                                       <input type="text" class="form-control" id="c_company" name="c_company" placeholder="Office" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_company; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">PAN No. <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-6">
                                                       <input type="text" class="form-control" id="c_pan_card" name="c_pan_card" placeholder="PAN No." value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_pan_card; } ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Aadhar </label>
                                                    <div class="col-md-6">
                                                       <input type="text" class="form-control" id="c_aadhar_card" name="c_aadhar_card" placeholder="Aadhar No" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_aadhar_card; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="col-md-2 control-label">Address <span class="asterisk_sign others-validation">*</span></label>
                                                    <div class="col-md-8">
                                                        <textarea class="form-control" id="c_address" name="c_address"><?php if (isset($editcontact)) { echo $editcontact[0]->c_address; } ?></textarea>
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
                                    <input formnovalidate="formnovalidate" type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" />
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
	<script type="text/javascript">
        $(function() {
            $(".datepicker1").datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0',
            changeYear: true });
        });
    </script>
    </body>
</html>
