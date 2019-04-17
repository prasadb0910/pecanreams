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
                <?php $this->load->view('templates/menus1');?>
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
                                                    <label class="col-md-4 control-label">Date Of Birth </label>
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
                                                       <input type="text" class="form-control" id="email_id1" name="email_id1" style="background-color: white; color: #245478;" placeholder="Email Id" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_emailid1; } ?>" readonly />
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
                                                    <label class="col-md-4 control-label">PAN No. </label>
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
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">GST No. </label>
                                                    <div class="col-md-6">
                                                       <input type="text" class="form-control" id="c_gst_no" name="c_gst_no" placeholder="GST No." value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_gst_no; } ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Group Name </label>
                                                    <div class="col-md-6">
                                                        <input type="hidden" id="group_id" name="group_id" value="<?php if(isset($group_details)){ echo $group_details[0]->g_id; } ?>" />
                                                        <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Group Name" value="<?php if(isset($group_name)){ echo $group_name; } ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">Do You want maker checker? *</label>
                                                    <div class="col-md-8">
                                                        <input type="radio" class="" name="maker_checker" value="yes" required <?php if(isset($group_details)){ if($group_details[0]->maker_checker=='yes') echo 'checked'; } ?> /> Yes &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" class="" name="maker_checker" value="no" required <?php if(isset($group_details)){ if($group_details[0]->maker_checker=='no') echo 'checked'; } ?> /> No
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="col-md-2 control-label">Address </label>
                                                    <div class="col-md-8">
                                                        <textarea class="form-control" id="c_address" name="c_address"><?php if (isset($editcontact)) { echo $editcontact[0]->c_address; } ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">KYC Required? <span class="asterisk_sign others-validation">*</span></label>
                                                    <div class="col-md-6" style="line-height:33px;">
                                                        <input type="radio" name="kyc" class="icheckbox" value="1" id="kyc_yes" data-error="#err_kyc" <?php //if (isset($editcontact)) { if($editcontact[0]->c_kyc_required=='1') echo 'checked'; } ?>/>&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" name="kyc" class="icheckbox" value="0" id="kyc_no" data-error="#err_kyc" <?php //if (isset($editcontact)) { if($editcontact[0]->c_kyc_required=='0') echo 'checked'; } ?>/>&nbsp;&nbsp;No
                                                        <div id="err_kyc"></div>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <!-- <div class="panel panel-primary" id="kyc-section" style="<?php //if (isset($editcontact)) { if($editcontact[0]->c_kyc_required!='1') echo 'display:none;'; } else echo 'display:none;'; ?>">
                                        <a href="#accOneColTwo">  
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <span class="fa fa-check-square-o"> </span>     KYC Details 
                                                </h4>
                                            </div>  
                                        </a>                              
                                        <div class="panel-body" id="accOneColTwo">
                                            <?php //$this->load->view('templates/document');?>
                                            

                                            <div class="col-md-12 btn-margin">
                                                <button type="button" class="btn btn-success" id="repeat-documents"  >+</button>
                                                <a href="#accOneColThree" >
                                                    <button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button>
                                                </a>
                                            </div>
                                        </div>                                
                                    </div> -->
                                    
                                    <!-- <div class="panel panel-primary" id="nominee-section" style="display:block;">
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
                                                    <?php 
                                                    // $j=0;
                                                    // if(isset($editcontnom)) {
                                                    // for($j=0;$j<count($editcontnom); $j++) { ?>
                                                    <tr id="repeat_nominee_<?php //echo $j+1; ?>">
                                                        <td  align="center"><?php //echo ($j+1); ?></td>
                                                        <td class="Contact_name">
                                                            <input type="hidden" id="txtname_<?php //echo '' . $j+1 . '_id"'; ?> name="nm_name[]" class="form-control" value="<?php //if (set_value('nm_name')!=null) { echo set_value('nm_name'); } else if(isset($editcontnom[$j]->nm_name)){ echo $editcontnom[$j]->nm_name; } else { echo ''; }?>" />
                                                            <input type="text" id="txtname_<?php //echo '' . $j+1 . '"'; ?> name="nm_contact_name[]" class="form-control auto_client nm_contact_name" value="<?php //if(isset($editcontnom[$j]->c_name)){ echo $editcontnom[$j]->c_name; } else { echo ''; }?>" placeholder="Type to choose contact from database..." />
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nm_relation[]" class="form-control" placeholder="Relation" value="<?php //if(isset($editcontnom[$j]->nm_relation)){ echo $editcontnom[$j]->nm_relation; } else { echo ''; }?>"/>
                                                        </td>
                                                    </tr>
                                                    <?php //} } else { ?>
                                                    <tr id="repeat_nominee_<?php //echo $j+1; ?>">
                                                        <td><?php //echo $j+1; ?></td>
                                                        <td class="Contact_name">
                                                            <input type="hidden" id="txtname_<?php //echo '' . $j+1 . '_id"'; ?> name="nm_name[]" class="form-control" />
                                                            <input type="text" id="txtname_<?php //echo '' . $j+1 . '"'; ?> name="nm_contact_name[]" class="form-control auto_client nm_contact_name" placeholder="Type to choose contact from database..." />
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nm_relation[]" class="form-control" placeholder="Relation"/>
                                                        </td>
                                                    </tr>
                                                    <?php //} ?>
                                                </tbody>
                                            </table>
                                            </div>
                                            <div class="col-md-12 btn-margin">
                                                <button type="button" class="btn btn-success repeat-nominee"> + </button>
                                                <button type="button" class="btn btn-success reverse-nominee" > - </button>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                </div>
                                </div>
                                <br clear="all"/>
                                </div>
			
                                <div class="panel-footer">
                                    <input type="hidden" id="submitVal" value="1" />
                                    <!-- <a href="<?php //echo base_url(); ?>index.php/contacts" class="btn btn-danger btn-danger" >Cancel</a> -->
                                    <div style="display: flow-root;">
                                        <input formnovalidate="formnovalidate" type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" />
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
            $(".datepicker1").datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0',
            changeYear: true });
        });
    </script>
    </body>
</html>
