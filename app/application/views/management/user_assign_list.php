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
        <!-- EOF CSS INCLUDE -->                                      
		
		<style>
			.tile {padding: 0px;
				   min-height: 77px;}
		</style>

	<style>
			.tile {padding: 0px;
				   min-height: 77px;}

.page-container .page-content .page-content-wrap {  margin:0px; width: auto!important; float: none;  background: #E0E0E7;  }
.dataTables_filter {/* border-bottom:0!important;*/ }
.table tbody tr td:last-child  {border: 1px solid #eee!important;}
.heading-h2 { background:#eee; line-height: 25px; padding:7px 22px;   text-transform: uppercase; font-weight: 600; display: flex;  margin-top: 61px; /*padding-bottom: 0; */  } 
.heading-h2 a{  color: #444;     }
/*.top-band { background:#eee; padding: 5px; clear: both; display: inline-table; 
font-family: Montserrat-Black; font-weight: 100;float: left;     width: 45%;  
  border-bottom: 1px solid rgba(0,0,0,0.1);                   }*/
.nav-contacts {/* float: right; width: 55%;*/ }
.main-wrapper { background: #E0E0E7; padding: 0; margin: 0; }
.main-container {margin:0 12px; } 
h2 { font-weight:100!important;  font-size:18px!important; padding:0; }
.col-md-12 {/* margin:20px 0; display: flex;*/
background: #fff;
/*padding:10px!important;*/
box-shadow: rgba(0, 0, 0, 0.2) 0px 6px 32px -4px;}
.page-overflow { overflow:auto; }
#approved{ font-weight: 800;/* border:1px solid #ccc; padding:2px 8px; border-radius:0px; background: #fff; */ color: #888;    }
.table thead tr th { padding:8px 5px!important; font-weight:600; }
b, strong { font-weight:500;}
.panel-body {padding: 0!important;}
.panel { border: none; box-shadow: none; margin-top: 0;   margin-bottom: 0; padding: 0;}
.btn-container {  }
.btn-top-margin { margin-top:-36px!important; margin-right: 15px; }
.dataTables_empty { color:#e90404!important; font-size: 14px!important;  }
.btn-top {  background:#eee; line-height: 25px;  border-bottom: 1px solid #ddd;  padding:0px 22px 7px 0; }
.btn-cntnr { margin-bottom:10px }

 .row [class^='col-md-'], .row [class^='col-lg-'] {
    min-height: 1px;
    padding-left:0px;
    padding-right:0px;
}

		</style>

    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus1');?><br><Br><Br>
                    <div class="heading-h2" style="margin-top:10px;"> 
                 	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; User List
                 </div>  
                  


                   <div class="container btn-top" style="width: 100%;padding-left: 20px;">
                    	<div class="pull-left ">
					<a class="btn btn-default btn-block" href="<?php echo base_url() . 'index.php/Assign/addnew'; ?>">
					<span class="fa fa-plus"></span> Add User			</a>
				</div>	      
                </div>	 

                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row  main-wrapper">
						 <div class="main-container"> 
					
					 
						
                        <div class="col-md-12" style="margin-top:20px; padding:10px!important;">
						<div class="panel panel-default">
						 
						<!-- 	<div class="panel-body">                                                                        
								
								<div class="row">
									<div class="col-md-3">                        
										<a href="#" class="tile tile-success tile-valign">
											<span id="approved"><?php //echo count($approved); ?></span>
											<div class="informer informer-default">Approved</div>
											<div class="informer informer-default dir-br"><span class="fa fa-users"></span></div>
										</a>                            
									</div>
									<div class="col-md-3">                        
										<a href="#" class="tile tile-info tile-valign">
											<span id="approved"><?php //echo count($pending); ?></span>
											<div class="informer informer-default">Pending</div>
											<div class="informer informer-default dir-br"><span class="fa fa-users"></span></div>
										</a>                            
									</div>
									<div class="col-md-3">                        
										<a href="#" class="tile tile-danger tile-valign">
											<span id="approved"><?php //echo count($rejected); ?></span>
											<div class="informer informer-default">Rejected</div>
											<div class="informer informer-default dir-br"><span class="fa fa-users"></span></div>
										</a>                            
									</div>
									<div class="col-md-3">                        
										<a href="#" class="tile tile-default tile-valign">
											<span id="approved"><?php //echo count($inprocess); ?></span>
											<div class="informer informer-default">In Process</div>
											<div class="informer informer-default dir-br"><span class="fa fa-users"></span></div>
										</a>                            
									</div>
								</div> 
							
								
							</div>-->
								
								
							<!-- START DATATABLE EXPORT -->
						<?php $this->load->view('templates/download');?>

							<div class="panel-body">
								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered" style="border-top:none;">
									<thead>
										<tr>
											<th width="50">User</th>
											<th width="50">Role</th>
											<th width="50">Status</th>
											<th width="50">Created By</th>
											<!-- <th width="75">Actions</th> -->
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($user) ; $i++) { ?>
										<tr id="trow_1">
											<td><a href="<?php echo base_url().'index.php/Assign/view/'.$user[$i]->gu_id; ?>"><?php echo $user[$i]->gu_name; ?></a></td>
											<td><?php echo $user[$i]->role_name; ?></td>
											<td><?php if(($user[$i]->assigned_status)=='Approved' || ($user[$i]->assigned_status)=='Active') { echo 'Active'; } else { echo 'InActive'; }?></td>
											<td><?php echo $user[$i]->created_by; ?></td>
											<!-- <td>
												<a href="<?php //echo base_url().'index.php/Assign/edit/'.$user[$i]->gu_cid; ?>"><button class="btn btn-default btn-rounded btn-sm"><span class="fa fa-pencil"></span></button></a>
												<button class="btn btn-danger btn-rounded btn-sm" onClick="delete_row('trow_1');"><span class="fa fa-times"></span></button>
											</td> -->
										</tr>
										<?php } ?>
									</tbody>
								</table>
								</div>
							</div>
                            <!-- END DEFAULT DATATABLE -->
                            
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
		
    <!-- END SCRIPTS -->      
    </body>
</html>