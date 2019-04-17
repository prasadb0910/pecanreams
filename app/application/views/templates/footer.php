
<div id="confirm_content1" style="display:none">
	<div class="logout-containerr">
		<button type="button" class="close" data-confirmmodal-but="cancel">×</button>
		<div class="confirmModal_header"> <span class="fa fa-sign-out"></span> Log <strong>Out</strong> ? </div>
		<div class="confirmModal_content">
			<p>Are you sure you want to log out?</p>                    
			<p>Press No if you want to continue work. Press Yes to logout current user.</p>
		</div>
		<div class="confirmModal_footer">
			<a href="<?php echo base_url();?>index.php/login/logout" class="btn btn-success ">Yes</a>
			<button type="button" class="btn btn-danger " data-confirmmodal-but="cancel">No</button>
		</div>
	</div>
</div>



<!-- <div id="confirm_content" style="display:none">
	<button type="button" class="close" data-confirmmodal-but="cancel">×</button>
	<form id="form_change_password" role="form" class="form-horizontal" action="" method="post">
		<div class="confirmModal_header">  <span>  Change password </span>  </div>
		<div class="confirmModal_content">
				<div class=" ">
					<div class="col-md-12">
						<label class="control-label">Password *</label>
						<div class=" ">
							<input type="password" class="form-control" name="password" id="password" placeholder=" " value=""/>
						</div>
					</div>
					<div class="col-md-12 ">
						<label class="control-label">New Password *</label>
						<div class=" ">
							<input type="password" class="form-control" name="new_password" id="new_password" placeholder=" " value=""/>
						</div>
					</div>
					<div class="col-md-12 ">
						<label class=" control-label">Confirm Password *</label>
						<div class=" ">
							<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder=" " value=""/>
						</div>
					</div>
					<br clear="all"/>
				</div>
		</div>
		<div class="confirmModal_footer">
			<button type="button" class="btn btn-success " id="submit_form_change_password">Submit</button>
			<button type="button" class="btn btn-danger " data-confirmmodal-but="cancel">Cancel</button>
		</div>
	</form>
</div> -->


<!-- success -->
<div class="message-box message-box-success animated fadeIn" id="message-box-success">
	<form id="form_change_password" role="form" class="form-horizontal" method="post" action="">
    <div class="mb-container" style="background: rgb(255, 255, 255); /*left: 350px; top: 25%;*/ width: 50%;">
        <div class="mb-middle">
            <div class="mb-title" style="color: #4d4d4d;"><span class="fa fa-check"></span> Change password </div>
            <div class="mb-content">
            	 
                <div class="col-md-12" style="box-shadow: none;">
					<div class="col-md-12" style="box-shadow: none;">
						<label class="control-label">Password *</label>
						<div class=" ">
							<input type="password" class="form-control" name="old_password" id="old_password" placeholder="Old Password" value=""/>
						</div>
					</div>
					<div class="col-md-12" style="box-shadow: none;">
						<label class="control-label">New Password *</label>
						<div >
							<input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" value=""/>
						</div>
					</div>
					<div class="col-md-12" style="box-shadow: none;">
						<label class=" control-label">Confirm Password *</label>
						<div class="  ">
							<input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm New Password" value=""/>
						</div>
					</div>
				</div>
				 
            </div>
            <div class="mb-footer">
            	<a class="btn btn-success pull-left" id="btn_change_password" href="javascript:void(0);">Submit</a>
                <button class="btn btn-danger pull-right mb-control-close">Close</button>
            </div>
        </div>
    </div>
    </form>
</div>
<!-- end success -->
		
		

<!-- MESSAGE BOX-->
<div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
    <div class="mb-container">
        <div class="mb-middle" style="color: #fff;">
            <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
            <div class="mb-content">
                <p>Are you sure you want to log out?</p>                    
                <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <a href="<?php echo base_url();?>index.php/login/logout" class="btn btn-success btn-lg">Yes</a>
                    <button class="btn btn-default btn-lg mb-control-close">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MESSAGE BOX-->

<!-- START PRELOADS -->
<audio id="audio-alert" src="<?php echo base_url(); ?>audio/alert.mp3" preload="auto"></audio>
<audio id="audio-fail" src="<?php echo base_url(); ?>audio/fail.mp3" preload="auto"></audio>
<!-- END PRELOADS -->               

<!-- START SCRIPTS -->
<!-- START PLUGINS -->

<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap.min.js"></script>
<!-- END PLUGINS -->                

<!-- THIS PAGE PLUGINS -->
<script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/icheck/icheck.min.js'></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/demo_tables.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap-select.js"></script>
<script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/validationengine/languages/jquery.validationEngine-en.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/validationengine/jquery.validationEngine.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/jquery-validation/jquery.validate.js'></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tagsinput/jquery.tagsinput.min.js"></script>		               
<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap-file-input.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/datatables/jquery.dataTables.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/tableExport.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/jquery.base64.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/html2canvas.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/jspdf/libs/sprintf.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/jspdf/jspdf.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/jspdf/libs/base64.js"></script>
<!-- END PAGE PLUGINS -->

<!-- START TEMPLATE -->

<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/actions.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/moment.js"></script>
<!-- END TEMPLATE -->

<script src="<?php echo base_url('js/jquery-ui-1.11.2/jquery-ui.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'js/jquery.cookie.js';?>"></script>

<script src="<?php echo base_url(); ?>css/logout/popModal.js"></script>

<script type="text/javascript">
    var BASE_URL="<?php echo base_url()?>";
</script>

<script src="<?php echo base_url(); ?>js/footer.js"></script>