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

        <style>
            .tile {padding: 0px;
                   min-height: 77px;}

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
.full-width  { padding: 15px; }
.page-overflow { overflow:auto; }
#approved{ font-weight: 800;/* border:1px solid #ccc; padding:2px 8px; border-radius:0px; background: #fff; */ color: #888;    }
.table thead tr th { padding:8px 5px!important; font-weight:600; }
b, strong { font-weight:500;}
.panel-body {padding: 0!important;}
.btn-container {  }
.btn-top { margin-top: 10px!important; }
.box-shadow-inside { padding:10px;     display: flex; }
.panel-footer { background: #f5f5f5!important; clear: both; margin-top:10px; }
.panel { margin: 0; border-radius: 0!important; box-shadow: none; border: 1px dotted #ddd!important }
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
.form-group:nth-child(even) { }
.form-group { padding: 10px 0; }
.panel-heading-bnt { margin: 10px!important; display: flex; }
.panel  span { margin:0!important; }
.btn-margin { margin-left: 5px!important; display: inline-block; }
.btn-top-margin {
    margin-top: -36px!important;
    margin-right: 15px;
}
#txtstatus { overflow: hidden; }
.btn-cntnr { margin-bottom:10px }
</style>
    </head>

    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Assign'; ?>" > User  List </a>  &nbsp; &#10095; &nbsp; User  View</div>
                   <div class="pull-right btn-top-margin">
                                  
                                      <a class="btn-margin" href="<?php echo base_url().'index.php/Assign/edit/'.$assignusr[0]->gu_id; ?>"><span class="btn btn-success pull-right btn-font"> Edit </span>  </a>

                                            <a  class="btn-margin"  href="<?php echo base_url()?>index.php/Assign" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a>
                             
                                </div>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row  main-wrapper">
                      <div class="main-container">           
                         <div class="box-shadow">   
                             
                        <div class="col-md-12 full-width" style="padding:0;">
                         <div class="box-shadow-inside">
						<div class="panel panel-default">
							
                            <form id="jvalidate" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/Assign'; ?>">
                                
								
								<div class="panel-body">
									<div class="form-group"  >
										<div class="col-md-5">
											<div class="">
												<label class="col-md-2 control-label"><strong>Contact:</strong></label>
												<div class="col-md-10">
                                                    <label class="control-label" style="text-align:left;" > <?php if(isset($assignusr[0]->gu_name)){ echo $assignusr[0]->gu_name; } else { echo ''; }?> </label>
												</div>
											</div>
										</div>
										<div class="col-md-7">
											<div class="">
												<label class="col-md-2 control-label"><strong>Status:</strong></label>
												<div class="col-md-10">
                                                    <label class=" control-label" style="text-align:left;" > <?php if(isset($assignusr[0]->assigned_status)){ if(($assignusr[0]->assigned_status)=='Approved' || ($assignusr[0]->assigned_status)=='Active') { echo 'Active'; } else { echo 'InActive'; } } else { echo ''; }?> </label>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-5">
											<div class="">
												<label class="col-md-2 control-label"><strong>Role:</strong></label>
												<div class="col-md-10">
                                                    <label class="control-label" style="text-align:left;"  > <?php if(isset($assignusr[0]->role_name)){ echo $assignusr[0]->role_name; } else { echo ''; }?> </label>   
												</div>
											</div>
										</div>
                                        <div class="col-md-7">
                                            <div class="">                                        
                                                <label class="col-md-2 control-label"><strong>Owner:</strong></label>
                                                <div class="col-md-10">
                                                    <label class=" control-label" style="text-align:left;" > <?php if(isset($owner_name)){ if(strlen($owner_name)>0) echo substr($owner_name,0,strlen($owner_name)-1); } else { echo ''; }?> </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group"  >
                                        <div class="col-md-5">
                                            <div class="">
                                                <label class="col-md-2 control-label">Email</label>
                                                <div class="col-md-10">
                                                    <label class=" control-label" style="text-align:left;" >
                                                    <?php if(isset($assignusr[0]->gu_email)){ echo $assignusr[0]->gu_email; } else { echo ''; }?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="">
                                                <label class="col-md-2 control-label">For Assure</label>
                                                <div class="col-md-10">
                                                    <label class=" control-label" style="text-align:left;">
                                                    <?php if(isset($assignusr[0]->assure)){ echo $assignusr[0]->assure=='1'?'yes':'no'; } else { echo 'No'; }?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group"  >
                                        <div class="col-md-5">
                                            <div class="">
                                                <label class="col-md-2 control-label">Maker Remark</label>
                                                <div class="col-md-10">
                                                    <label class=" control-label" style="text-align:left;">
                                                    <?php if(isset($assignusr[0]->maker_remark)){ echo $assignusr[0]->maker_remark; } else { echo ''; }?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="form_group ">
										<div class="col-md-12 " style="display:-webkit-box; padding:10px;">
                                            <div class="col-md-5">
                                                &nbsp;
                                            </div>
											<div class="col-md-2 ">
                                                <span id="reset_password" type="submit" class="btn btn-default btn-danger btn-font" style=" "><span class="fa fa-plus"></span> Reset Password</span>
											</div>
											<div class="col-md-6">
												&nbsp;
											</div>
										</div>
									</div>
								</div>
								
							</form>
							
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
            $("#reset_password").click(function(){
                var $result = 0;
                $.ajax({
                    url: "<?php echo base_url() . 'index.php/assign/updatepassword/' . $assignusr[0]->gu_id; ?>",
                    data: '',
                    cache: false,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                        if ($.isNumeric($.trim(data))) {
                            $result = 1;
                        } else {
                            $result = 0;
                        }
                    },
                    error: function (data) {
                        $result = 0;
                    }
                });

                if($result==1) {
                    alert("Password changed.");
                } else {
                    alert("Change password process failed.");
                }
            });
        </script>
    </body>
</html>