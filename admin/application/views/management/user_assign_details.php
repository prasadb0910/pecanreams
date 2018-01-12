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
background: #fff;

box-shadow: rgba(0, 0, 0, 0.2) 0px 6px 32px -4px; display: inline-block;}
.page-overflow { overflow:auto; }
#approved{ font-weight: 800;/* border:1px solid #ccc; padding:2px 8px; border-radius:0px; background: #fff; */ color: #888;    }
.table thead tr th { padding:8px 5px!important; font-weight:600; }
b, strong { font-weight:500;}
.panel-body {padding: 0!important; margin-bottom:0;}
.btn-container {  }
.btn-top { margin-top: 10px!important; }
.box-shadow-inside {  padding: 10px!important;     display: flex;   }
.panel-footer { background: #f5f5f5!important; clear: both; margin-top:10px; }
.panel { margin: 0; border-radius: 0!important; box-shadow: none; margin-top: 0;  margin-bottom: 0; border: 1px dotted #ddd; }
.panel-heading {border-radius: 0; }



.btn-primary { padding:6px 10px; }
.table-responsive {  min-height: .01%; overflow-x: auto;  margin: 15px;}
.remark-container {padding: 10px;}
.border-none { border: 1px dotted #ddd!important }
.btn-margin { margin: 10px 0; }
textarea { overflow: hidden; }
.btn-cntnr { margin-bottom:10px }
.bootstrap-select.btn-group .dropdown-menu li > a {
    cursor: pointer;
    width: 100%;
}
.panel-footer { padding:10px; }
        </style>		
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Assign'; ?>" > User  List </a>  &nbsp; &#10095; &nbsp; User  Details</div>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                
                    <div class="row main-wrapper">                  
                    <div class="main-container">           
                         <div class="box-shadow">
                            <form id="form_user_assign_details" role="form" class="form-horizontal" method="post" action="<?php if(isset($assignusr[0])) echo base_url().'index.php/Assign/editrecord/'.$assignusr[0]->gu_id; else echo base_url().'index.php/Assign/saverecord'; ?>">
                           
                        <div class="col-md-12" style="padding:0;">
                          <div class="box-shadow-inside">  
                        <div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group" style="border-top: 1px dotted #ddd;">
										<div class="col-md-6">
											<div class="">
												<label class="col-md-3 control-label">Contact</label>
												<div class="col-md-9">
                                                    <input type="hidden" id="contact_person_id" name="contact" class="form-control" value="<?php if(isset($assignusr[0]->gu_cid)){ echo $assignusr[0]->gu_cid; } else { echo ''; }?>" />
                                                    <input type="text" id="contact_person" name="contact_name" class="form-control auto_client" value="<?php if(isset($assignusr[0]->gu_name)){ echo $assignusr[0]->gu_name; } else { echo ''; }?>" placeholder="Type to choose contact from database..." style="color: #0b385f;" <?php if(isset($assignusr[0]->gu_name)) echo 'disabled';?> />
												</div>
											</div>
										</div>
                                        <div class="col-md-6" style="line-height:26px">
                                            <div class="">
                                                <label class="col-md-3 control-label">Email</label>
                                                <div class="col-md-9">
                                                    <label id="email"  >
                                                    <?php if(isset($assignusr[0]->gu_email)){ echo $assignusr[0]->gu_email; } else { echo ''; }?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
									</div>
									<div class="form-group">
										<div class="col-md-6">
											<div class="">
												<label class="col-md-3 control-label">Role</label>
												<div class="col-md-9">
													<select class="form-control" name="role" id="role">
														<option value="">Select</option>
                                                        <?php for ($i=0; $i < count($roles) ; $i++) { ?>
                                                            <option value="<?php echo $roles[$i]->rl_id; ?>" <?php if (set_value('role')!=null) { if (set_value('role')==$roles[$i]->rl_id) echo 'selected'; } else if(isset($assignusr[0]->assigned_role)){ if ($assignusr[0]->assigned_role==$roles[$i]->rl_id) echo 'selected'; } else { echo ''; }?>><?php echo $roles[$i]->role_name; ?></option>
                                                        <?php } ?>
													</select>
												</div>
											</div>
										</div>
                                        <div class="col-md-6">
                                            <div class="">
                                                <label class="col-md-3 control-label">Owner</label>
                                                <div class="col-md-9">
                                                    <select multiple="" name="owners[]" class="form-control select" style="display: none;">
                                                        <?php for ($i=0; $i < count($owner) ; $i++) { ?>
                                                            <option value="<?php echo $owner[$i]['id']; ?>" <?php if (isset($user_role_owners)) {echo in_array($owner[$i]['id'],$user_role_owners) ? "selected" : null;} ?>><?php echo $owner[$i]['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="">
                                                <label class="col-md-3 control-label">For Assure</label>
                                                <div class="col-md-9">
                                                    <input type="radio" name="assure" id="assure_yes" value="1" data-error="#assure_error" <?php if (isset($assignusr)) { if($assignusr[0]->assure=='1') echo 'checked'; } ?> /> Yes &nbsp; &nbsp; &nbsp; 
                                                    <input type="radio" name="assure" id="assure_no" value="0" data-error="#assure_error" <?php if (isset($assignusr)) { if($assignusr[0]->assure=='0') echo 'checked'; } ?> /> No
                                                    <div id="assure_error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="">
                                                <label class="col-md-3 control-label">Maker Remark</label>
                                                <div class="col-md-9">                                                        
                                                     <textarea  class="form-control" id="maker_remark" name="maker_remark" rows="2" ><?php if(isset($assignusr)){ echo $assignusr[0]->maker_remark;}?></textarea> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="<?php if(isset($assignusr)) echo ''; else echo 'display: none;';?>">
                                        <div class="col-md-6">
                                            <label class="col-md-3 control-label" style="">Status</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="assigned_status">
                                                    <option value="Active" <?php if(isset($assignusr)) {if ($assignusr[0]->assigned_status=='Active') echo 'selected';}?>>Active</option>
                                                    <option value="Inactive" <?php if(isset($assignusr)) {if ($assignusr[0]->assigned_status=='Inactive') echo 'selected';}?>>InActive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-md-3 control-label" style="">Remarks</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" name="txn_remarks"><?php if(isset($assignusr)) echo $assignusr[0]->txn_remarks;?></textarea>
                                            </div>
                                        </div>
                                    </div>
								</div>
								</div>
                        </div>
                           </div>
                                <div class="panel-footer">
                                    <a class="btn btn-danger" id="reset" href="<?php echo base_url(); ?>index.php/Assign" style="margin-right: 10px;">Cancel</a>
                                    <button class="btn btn-success pull-right">Save</button>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

        <script>
            $(function() {
                //autocomplete
                $(".auto_client").autocomplete({

                        source: "<?php echo base_url() . 'index.php/Assign/loadcontacts/';?>",
                        focus: function(event, ui) {
                                // prevent autocomplete from updating the textbox
                                event.preventDefault();
                                // manually update the textbox
                                $(this).val(ui.item.label);
                        },
                        select: function(event, ui) {
                                // prevent autocomplete from updating the textbox
                                event.preventDefault();
                                // manually update the textbox and hidden field
                                $(this).val(ui.item.label);

                                var id = this.id;

                                $("#" + id + "_id").val(ui.item.value);
                                var email=ui.item.email1;
                                $("#email").html(email);
                                //alert(email);
                                //console.log(email);
                        },
                        minLength: 1
                });
            });

            
        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>