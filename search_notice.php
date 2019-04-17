<!DOCTYPE html>
<html class="no-js  " lang="en-US">
<?php include_once('db.php'); ?>
<?php
    $newspapers=mysqli_query($conn,"select * from pn_newspapers where status='approved' order by paper_name");
    $notice_type_url = $_GET['type'];
    $notice_type_id = '0';
    $notice_type = 'All';
	$notice_title = 'All';
	$notice_description = 'All';

  //   $result=mysqli_query($conn,"select * from pn_notice_types where status='approved' and id = '$notice_type_id'");
  //   if(count($result)>0){
		// while ($row = mysqli_fetch_assoc($result)){
		// 	$notice_type = $row['notice_type'];
		// 	$notice_title = $row['title'];
		// 	$notice_description = $row['description'];
		// }
  //   }

    $result=mysqli_query($conn,"select * from pn_notice_types where status='approved' and url = '$notice_type_url'");
    if(count($result)>0){
		while ($row = mysqli_fetch_assoc($result)){
			$notice_type_id = $row['id'];
			$notice_type = $row['notice_type'];
			$notice_title = $row['title'];
			$notice_description = $row['description'];
		}
    }
?>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no">
	<meta name="Description" content="<?php echo $notice_description; ?>">

	<link href="<?php echo $base_url; ?>/assets/images/favicon.png" rel="icon">
	<!--[if lt IE 9]>
	<script src="http://prodo.create.rocks/wp-content/themes/prodo/assets/js/html5shiv.min.js"></script>
	<script src="http://prodo.create.rocks/wp-content/themes/prodo/assets/js/respond.min.js"></script>
	<![endif]-->
	<title> Pecan Reams - <?php echo $notice_title; ?></title>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>
	
	<link rel='dns-prefetch' href='https://maps.google.com' />
	<link rel='dns-prefetch' href='https://fonts.googleapis.com' />
	<link rel='dns-prefetch' href='https://s.w.org' />

	<style type="text/css">
		img.wp-smiley,
		img.emoji {
			display: inline !important;
			border: none !important;
			box-shadow: none !important;
			height: 1em !important;
			width: 1em !important;
			margin: 0 .07em !important;
			vertical-align: -0.1em !important;
			background: none !important;
			padding: 0 !important;
		}
		.xdebug-error {display: none;}
	</style>

	<link rel='stylesheet' id='roboto-css'  href='https://fonts.googleapis.com/css?family=Roboto%3A300%2C400%2C400italic%2C500%2C500italic&#038;ver=4.6.1' type='text/css' media='all' />
	<link rel='stylesheet' id='open-sans-css'  href='https://fonts.googleapis.com/css?family=Open+Sans%3A300%2C300italic%2C400%2C400italic%2C600%2C600italic%2C700%2C700italic&#038;ver=4.6.1' type='text/css' media='all' />
	<link rel='stylesheet' id='bootstrap-css'  href='<?php echo $base_url; ?>/assets/bootstrap/css/bootstrap.min.css?ver=4.6.1' type='text/css' media='all' />
	<link rel='stylesheet' id='font-awesome-css'  href='<?php echo $base_url; ?>/assets/css/plugins/font-awesome.min.css?ver=4.6.1' type='text/css' media='all' />
	<link rel='stylesheet' id='isotope-css'  href='<?php echo $base_url; ?>/assets/css/plugins/isotope.min.css?ver=4.6.1' type='text/css' media='all' />
	<link rel='stylesheet' id='style-css'  href='<?php echo $base_url; ?>/assets/css/style.min.css?ver=2.1' type='text/css' media='all' />
	<link rel='stylesheet' id='wp-style-css'  href='<?php echo $base_url; ?>/style.css?ver=4.6.1' type='text/css' media='all' />
	<link rel='stylesheet' id='responsive-css'  href='<?php echo $base_url; ?>/assets/css/responsive.min.css?ver=4.6.1' type='text/css' media='all' />
	<link rel='stylesheet' href='<?php echo $base_url; ?>/assets/css/login-min.css' type='text/css' media='all' />
	<link rel='stylesheet' href='<?php echo $base_url; ?>/assets/css/login.css' type='text/css' media='all' />
	<!--[if lt IE 9]>
	<link rel='stylesheet' id='oldie-css'  href='assets/css/oldie.min.css?ver=4.6.1' type='text/css' media='all' />
	<![endif]-->
	 
	<style>
		.footer-bottom {
		background-color: #191818; font-size:12px;
		width: 100%; padding:5px 0;
		}
		.copyright {
		color: #ccc;    text-align: right;
		}
		.design {
		color: #fff;


		text-align: left;
		}
		.design a {
		color: #fff;
		}

		/*------------------*/
		footer .housing-line {
		padding: 13px 0 0 0;
		display: inline-block;


		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
		}
		footer .housing-line img { height:88px;}
		.footer .footer-logo-coloured {
		/*  height: 87px;
		background-image: url(assets/images/main-logo.png); 
		width: 167px;*/
		display: inline-block;
		background-size: contain;
		background-position: left;
		background-repeat: no-repeat;
		margin-bottom: 4px;
		}

		.footer .desc {
		color: #7f7f7f;
		font-size: 11px;
		line-height: 22px;
		}
		.footer .footer-header {
		color: #000;
		height: 35px;  
		font-weight: 500;
		font-size: 16px;
		}



		.footer .footer-header .footer-text {
		display: inline-block; text-transform:uppercase;
		font-weight: 600; color:#fff; 
		letter-spacing:.5px;
		font-size: 12px;
		}
		#portfolio-details h4 { font-weight:400; font-size:25px; margin:5px 0;}
		#portfolio-details h5 { font-weight:400; font-size:20px; margin:5px 0; }
		.spacing-top1 { padding-top:80px;}
		.spacing-top { padding-top:50px;}
		.spacing-bottom { padding-bottom:50px;}
		@media only screen and (max-width:380px){
		.image-slider p { padding:5px; font-size:14px;}
		}
		.login-overlay { position:fixed; top:0; left:0; bottom:0; right:0; background:rgba(0,0,0,.6);display:none;  z-index:9999;}
		.login-box { background:#fff; width:100%; max-width:480px; min-height:250px; margin:auto; display:none;}
		.width-small { display:none;}
		.width-large {     padding: 69px 0 0; text-align:center;} 
		.width-large a {  font-size:17px; }
		/*--------------form style------------->

		</style>
		<style>
		#embed-video {
		position: fixed; overflow:hidden;	
		top: 0;
		left: 0;
		right: 0;
		bottom:0;
		z-index: 999999;
		}

		.close-video {
		position: fixed;
		z-index: 999999;
		color: #000;
		right: 60px;
		}
		/*----------------*/


		.single-about-detail {
		position: relative;
		margin-bottom: 50px;
		}	
		.about-img img {
		/* height: 206px;*/
		}
		.about-img img {
		width: 100%;
		}
		.about-img img {
		width: 100% !important;

		}

		.about-details {
		background: #eee;
		border-top:0px solid #fff;
		transition: all .7s ease 0s;
		-webkit-transition: all .7s ease 0s;
		-moz-transition: all .7s ease 0s;
		-o-transition: all .7s ease 0s;
		-ms-transition: all .7s ease 0s;
		}
		.about-details {
		/*min-height:260px;*/
		}
		body#home-page #main .container #where-to-buy-callout h3 {
		font-size: 20px;
		}
		body#home-page #main .container #where-to-buy-callout h3 {
		font-size: 15px;
		padding: 30px 0 10px 0;
		color: #7d4225;
		}
		.single-about-detail h3 {
		color: #000 !important;
		font-size:20px !important; padding:0 20px;
		line-height: 30px;
		text-transform: capitalize;
		font-weight: 400;
		}




		.single-about-detail p {
		color: #000 !important;  line-height:26px;

		}
		.about-details p {

		padding: 0 28px;
		padding-bottom: 30px;
		}


		.btn-read {
		/* position: absolute;
		bottom: 10px;  
		left:30%;  */

		display: block;
		margin: auto;
		/*  width: 132px;
		margin-top: -18px;*/
		}
		.btn-width {   margin: auto;  width: 132px; display:block;     padding-bottom: 16px;}
		.responsive-images h3 { text-align:left; margin:20px 0 10px; padding-bottom:0;}
		.responsive-images ul li { line-height:25px; padding-bottom:5px;   text-align:justify;}
		.responsive-images  p { margin:0 0 10px!important; text-align:justify;}
		.responsive-images  p b{ border-bottom:1px solid #999; font-weight:600; color:#555;}
		.responsive-images  p strong{   font-weight:700; color:#333;}
	</style>

  	<link rel='stylesheet'   href='<?php echo $base_url; ?>/assets/css/custom.css' type='text/css' media='all' />
 	<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/flexslider.css" type="text/css" media="screen" />

	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109726639-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-109726639-1');
	</script>

	<link href="<?php echo $base_url; ?>/js/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />

	<style>
		.form-control {border-radius: 4px;}
		input[readonly] {background-color: #fff !important;}
		.row {margin-bottom: 15px;}
		th {background-color: #fff !important; color: #696f6f !important; text-align: center;}
		td {background-color: #fff !important; border: none;}
		label {font-size: 15px;}
		.input-sm {margin-left: 8px;}
		.btn {padding: 10px 20px; border-radius: 15px; width: 80px;}
		#example_filter input {border-radius: 5px; padding: 5px;}
		.datepicker .active {
			color: #ffffff !important;
		    background: rgba(0,0,0,0.5) !important;
		    border-color: #285e8e !important;
		}
	</style>
</head>
<body class="single single-post postid-3434 single-format-image nav-sticky">
				
	<div class="navbar navbar-fixed-top floating positive two" role="navigation">
		<div class="container">

		<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo $base_url; ?>/index.php">
		<img src="<?php echo $base_url; ?>/assets/images/main-logo.png" data-alt="<?php echo $base_url; ?>/assets/images/main-logo.png" alt="">
		</a>
		</div>
		<span class="contacts">
		<a href="tel:022 6143 1712 " class="p-d-10"><i class="fa fa-phone" aria-hidden="true"></i>
		<small class="hidden-xs hidden-sm">022 6143 1712 </small> </a> &nbsp
		<a href="mailto:info@dentalhome.in" class="p-d-10"><i class="fa fa-envelope" aria-hidden="true"></i>
		<small class="hidden-xs hidden-sm">info@pecanreams.com</small></a>

		</span><br>

		<div class="collapse navbar-collapse" id="navbar-collapse"> 
		<ul id="menu-primary" class="nav navbar-nav navbar-right">



		<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo $base_url; ?>/index.php" >Home
		<span class="caret"></span></a>
		<ul class="dropdown-menu" >
		<li><a href="<?php echo $base_url; ?>/about.html#company">About Us</a></li>    <li class="divider"></li>
		<li><a href="<?php echo $base_url; ?>/about.html#team">Team</a></li>
		<li class="divider"></li>
		<li><a href="<?php echo $base_url; ?>/about.html#about">Pecan Group</a></li>


		</ul>

		</li>



		<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#" >Solutions
		<span class="caret"></span></a>
		<ul class="dropdown-menu" >
		<li><a href="<?php echo $base_url; ?>/property-management-service.html">REAMS</a></li>    <li class="divider"></li>
		<li><a href="<?php echo $base_url; ?>/online-real-estate-analytics-tool.php">iDATA</a></li>
		<li class="divider"></li>
		<li><a href="<?php echo $base_url; ?>/public-notice-online.php">Assure</a></li>

		<li class="divider"></li>
		<li><a href="<?php echo $base_url; ?>/real-estate-private-equity-advisor.html">Advisory</a></li>
		</ul>

		</li>



		<!--	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#" >Company
		<span class="caret"></span></a>
		<ul class="dropdown-menu ">
		<li><a href="about.html">ABOUT US</a></li><li class="divider"></li>
		<li><a href="http://pecanadvisors.com" target="_blank">PECAN ADVISORS</a></li>


		</ul>
		</li>-->


		<li  ><a class="jumper"  href="<?php echo $base_url; ?>/blog" target="_blank"> Blogs</a></li>

		<li ><a class="jumper" href="<?php echo $base_url; ?>/contact.php">Contact Us</a></li>

		<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#" >Login
		<span class="caret"></span></a>
		<ul class="dropdown-menu">
		<li><a href="https://www.pecanreams.com/app/" target="_blank">REAMS</a></li><li class="divider"></li>
		<li><a href="https://www.pecanreams.com/d3m/" target="_blank">iDATA / Assure</a></li>

		</ul>
		</li>

		<li><a href="<?php echo $base_url; ?>/register.php">REGISTER</a></li>
		<li><a href="<?php echo $base_url; ?>/notice_type.php">Search Notice</a></li>
		</ul>

		</div>
		</div>
	</div>

	<section class="section alt-background offsetTop blog-bg">
		<div class="container">
			<div class="row" style="margin-bottom: 0px;">
				<div class="col-md-12">
					<header>
						<h2 id="share-title" style="color:#fff;"> Search Notices </h2>
					 	<p class="info breadcrumbs" style="font-size:12px;"><span class="breadcrumbs_list" > <a href="<?php echo $base_url; ?>/index.php">Home ></a><a href="<?php echo $base_url; ?>/notice_type.php"> Notice Type ></a><a href="#"> Search Notices </a>  </span></p>
					 </header>
				</div>
			</div>
		</div>
	</section>

	<section id="" class="section offsetTop offsetBottom" style="padding-top: 0px;">
		<div class="container">
			<h2 style="text-align: center; color: #696f6f; margin-bottom:15px; font-weight: bold; font-size:25px;"><?php echo $notice_type; ?></h2>
			<div id="prodo-contact-form" class="field-action">
				<form id="form_search" action="<?php echo $base_url.'/search-notice/'.$notice_type_url; ?>" method="post">
					<div class="contact-form-area">

						<?php if (isset($_POST["submit"])) {echo $msg;}?>

						<div class="row">
							<div class="field col-md-6 col-sm-6">
								<label class="col-md-4 col-sm-4">Newspapers</label>
								<div class="col-md-8 col-sm-8">
									<input type="hidden" name="notice_type_id" id="notice_type_id" value="<?php if(isset($notice_type_id)) echo $notice_type_id; ?>" />
									<select class="form-control" name="newspaper" id="newspaper">
										<option value="">Select Newspaper</option>
										<option value="All" <?php if(isset($_POST["newspaper"])) if($_POST["newspaper"]=='All') echo 'selected'; ?>>All</option>
										<?php while ($row = mysqli_fetch_assoc($newspapers)) { ?>
											<option value="<?php echo $row['id']; ?>" <?php if(isset($_POST["newspaper"])) if($_POST["newspaper"]==$row['id']) echo 'selected'; ?>><?php echo $row['paper_name']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="field">
									&nbsp;
								</div>
							</div>
						</div>
						<div class="row">
							<div class="field col-md-6 col-sm-6">
								<label class="col-md-4 col-sm-4">From Date</label>
								<div class="col-md-8 col-sm-8">
									<input type="text" class="form-control datepicker" name="from_date" id="from_date" placeholder="  From Date" value="<?php if(isset($_POST["from_date"])) echo $_POST["from_date"]; ?>" readonly>
								</div>
							</div>
							<div class="field col-md-6 col-sm-6">
								<label class="col-md-4 col-sm-4">To Date</label>
								<div class="col-md-8 col-sm-8">
									<input type="text" class="form-control datepicker" name="to_date" id="to_date" placeholder="  To Date" value="<?php if(isset($_POST["to_date"])) echo $_POST["to_date"]; ?>" readonly>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="field col-md-6 col-sm-6">
								<label class="col-md-4 col-sm-4">Keyword</label>
								<div class="col-md-8 col-sm-8">
									<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Keyword" value="<?php if(isset($_POST["keyword"])) echo $_POST["keyword"]; ?>">
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="field">
									&nbsp;
								</div>
							</div>
						</div>
						<div class="row">
							<div class="field col-md-12 col-sm-12">
								<div class="col-md-3 col-sm-3 col-xs-12">
									<div class="field">
										&nbsp;
									</div>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-12">
									<input class="col-md-2 col-sm-2 col-xs-3" type="radio" name="match_word" id="match_word_any" value="any" style="width: auto; margin-top: 10px;" <?php if(isset($_POST["match_word"])) if($_POST["match_word"]=='any') echo 'checked'; ?>> 
									<label class="col-md-10 col-sm-10 col-xs-9">Matches on any word</label>
								</div>
								<div class="col-md-1 col-sm-1 col-xs-12" style="padding-left:0px;">
									<div class="field">
										OR 
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input class="col-md-2 col-sm-2 col-xs-3" type="radio" name="match_word" id="match_word_exact" value="exact" style="width: auto; margin-top: 10px;" <?php if(isset($_POST["match_word"])) if($_POST["match_word"]=='exact') echo 'checked'; ?>> 
									<label class="col-md-10 col-sm-10 col-xs-9">An exact phrase match</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<input type="submit" class="btn btn-default btn-md" name="submit" id="submit" value="Search" />
								<input type="button" class="btn btn-warning btn-md" name="clear" id="clear" value="Clear" onclick="clear_content();" />
								<a href="<?php echo $base_url; ?>/notice_type.php"><input type="button" class="btn btn-danger btn-md" name="cancel" id="cancel" value="Cancel" /></a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="container" style="margin-top: 10px; padding: 0px 175px;">
			<div id="prodo-contact-form" class="contact-form field-action">
				<table id="example" class="table datatable" style="background-color: #fff;">
                    <thead style="display: none;">
                        <th>Image</th>
                        <th>Title, Date Of Notice & Description </th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
			</div>
		</div>
	</section>

	<footer class="footer  no-border">
		<div class="container offsetBottomS offsetTopS">
			<div class="row">
			<div class="col-lg-4  col-md-4 col-sm-3 col-xs-12">
					<div class="housing-line">
			<div class="footer-logo-coloured"> <a href="<?php echo $base_url; ?>/index.php"><img src="<?php echo $base_url; ?>/assets/images/main-logo.png" style="background:#fff; padding:5px 10px;" /> </a></div>
			<!---<div class="desc">
			Copyright 2016. All rights reserved.
			</div>-->
			</div>
				</div>	
			<div class="col-lg-4  col-md-4 col-sm-5 col-xs-4 footer-clmn1">
			<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="footer-header">
			<span class="footer-text">Company</span>
			</div> 
			<ul class="list-unstyled clear-margins ">
						<li><a  href="<?php echo $base_url; ?>/about.html"> About Us</a></li>

						<li><a  href="<?php echo $base_url; ?>/contact.php"> Contact Us</a></li> 
			</ul>
			</div>

			<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="footer-header">
			<span class="footer-text">Help</span>
			</div> 
			<ul class="list-unstyled clear-margins  " >
						<li><a  href="<?php echo $base_url; ?>/privacy-policy.html">  Privacy Policy</a></li>
						<li><a  href="<?php echo $base_url; ?>/terms-and-conditions.html">  Terms & Condition</a></li>    
			</ul>
			</div> 
			</div>
			<div class="col-lg-2  col-md-2 col-sm-2 col-xs-4	footer-clmn2">
			<div class="footer-header">
			<span class="footer-text">Solutions</span>
			</div>
			 
			<ul class="list-unstyled clear-margins">
						<li><a  href="<?php echo $base_url; ?>/property-management-service.html"> REAMS</a></li>
						<li><a  href="<?php echo $base_url; ?>/online-real-estate-analytics-tool.php"> iDATA</a></li>
						<li><a  href="<?php echo $base_url; ?>/public-notice-online.php"> Assure</a></li>
									<li><a href="<?php echo $base_url; ?>/real-estate-private-equity-advisor.html">Advisory</a></li>
						                         
					
			</ul>
			</div>

			<div class="col-lg-2  col-md-2 col-sm-2 col-xs-4 footer-clmn3">
			<div class="footer-header">
			<span class="footer-text">Classroom</span>
			</div>
			 
			<ul class="list-unstyled clear-margins">
						<li><a  href="<?php echo $base_url; ?>/blog" target="_blank"> Blogs</a></li>
			</ul>
			</div>

			 
			                
				   </div>
				</div>

			<div class="footer-bottom"> 
				<div class="container  ">
					<div class="row">
							
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

							<div class="design">

								<a class="to-top"><i class="fa fa-angle-up"></i></a> 
							<!--	<a href="#">Privacy policy </a> |  
								<a target="_blank" href="#">Terms & Condition</a>-->

							</div>

						</div>
						
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

							<div class="copyright">	Copyright 2017.  All rights reserved.</div>

						</div>

							
					</div>
				</div>

			 </div>
	</footer>

	<script>
		var base_url = "<?php echo $base_url; ?>";
	</script>
	<script>
		var Prodo = {
			'loader': true,
			'animations': true,
			'navigation': 'sticky'
		};
	</script>
	<script src="<?php echo $base_url; ?>/js/jquery-2.1.4.min.js"></script>
	<script src="<?php echo $base_url; ?>/assets/bootstrap.min.js"></script>
	<script>
	    $(document).ready(function(){
	   
		    $('a[href^="#"]').click(function(e) {

		        jQuery('html,body').animate({ scrollTop: jQuery(this.hash).offset().top-80}, 1000);

		        return false;

		        e.preventDefault();

		    });

		});
	</script>
	<script src="https://www.jqueryscript.net/demo/jQuery-Plugin-For-One-Page-Navigation-Plugin-Page-Scroll-To-ID/jquery.malihu.PageScroll2id.js"></script> 
	<script>
		(function($){
			$(window).load(function(){
				
				/* Page Scroll to id fn call */
				$("#menu-primary a,a[href='#top'],a[rel='m_PageScroll2id']").mPageScroll2id({
					highlightSelector:"#menu-primary a"
				
				});
				
				/* demo functions */
				$("a[rel='next']").click(function(e){
					e.preventDefault();
					var to=$(this).parent().parent(" ").next().attr("id");
					$.mPageScroll2id("scrollTo",to);
					 
					 
					 
				});
				
				
			});
		})(jQuery);
	</script>
	<script defer src="<?php echo $base_url; ?>/assets/js/jquery.flexslider.js"></script> 
	<script type="text/javascript">
	    $(window).load(function(){
	      $('.flexslider').flexslider({
	        animation: "slide",
	        animationLoop: false,
	        itemWidth: 215,
			slideshow: false,
			 controlNav: false,
	        itemMargin: 0,
	        minItems:1,
	        maxItems: 5  
	      });
	    });
	</script>
	<script src="<?php echo $base_url; ?>/js/jquery.flip.min.js"></script>
	<script>
	    $(function(){
			$(".one-hover").hover(function(){
				if($('.service-overlay').is(":visible")){
					$('.service-overlay').hide();
					$('.one-hover').css("z-index","9999");
					 
				}
				else {
					$('.service-overlay').slideDown("fast");
					$('.one-hover').css("z-index","999999");
					$('.two-hover').css("z-index","9");
					$('.three-hover').css("z-index","9");
					$('.four-hover').css("z-index","9");
					$('.five-hover').css("z-index","9");
					$('.six-hover').css("z-index","9");
					//$('.one-hover').css("background","#fff");
					
				}
			});
			
			$(".two-hover").hover(function(){
				if($('.service-overlay').is(":visible")){
					$('.service-overlay').hide();
					$('.two-hover').css("z-index","9999");		 
				}
				else {
					$('.service-overlay').slideDown("fast");
					$('.two-hover').css("z-index","999999");
					$('.one-hover').css("z-index","9");
					$('.three-hover').css("z-index","9");
					$('.four-hover').css("z-index","9");
					$('.five-hover').css("z-index","9");
					$('.six-hover').css("z-index","9");
					
				}
			});
			
			$(".three-hover").hover(function(){
				if($('.service-overlay').is(":visible")){
					$('.service-overlay').hide();
					$('.three-hover').css("z-index","9999");
					 
				}
				else {
					$('.service-overlay').slideDown("fast");
					$('.three-hover').css("z-index","999999");
					$('.one-hover').css("z-index","9");
					$('.two-hover').css("z-index","9");
					$('.four-hover').css("z-index","9");
					$('.five-hover').css("z-index","9");
					$('.six-hover').css("z-index","9");				 
				}
			});
			
			$(".four-hover").hover(function(){
				if($('.service-overlay').is(":visible")){
					$('.service-overlay').hide();
					$('.four-hover').css("z-index","9999");
					 
				}
				else {
					$('.service-overlay').slideDown("fast");
					$('.four-hover').css("z-index","999999");	
					$('.one-hover').css("z-index","9");
					$('.three-hover').css("z-index","9");
					$('.two-hover').css("z-index","9");
					$('.five-hover').css("z-index","9");
					$('.six-hover').css("z-index","9");
				}
			});
			
				
			$(".five-hover").hover(function(){
				if($('.service-overlay').is(":visible")){
					$('.service-overlay').hide();
					$('.five-hover').css("z-index","9999");
					 
				}
				else {
					$('.service-overlay').slideDown("fast");
					$('.five-hover').css("z-index","999999");	
					$('.one-hover').css("z-index","9");
					$('.three-hover').css("z-index","9");
					$('.four-hover').css("z-index","9");
					$('.two-hover').css("z-index","9");
					$('.six-hover').css("z-index","9");
				}
			});
			$(".six-hover").hover(function(){
				if($('.service-overlay').is(":visible")){
					$('.service-overlay').hide();
					$('.six-hover').css("z-index","9999");
					 
				}
				else {
					$('.service-overlay').slideDown("fast");
					$('.six-hover').css("z-index","999999");	
					$('.one-hover').css("z-index","9");
					$('.three-hover').css("z-index","9");
					$('.four-hover').css("z-index","9");
					$('.five-hover').css("z-index","9");
					$('.two-hover').css("z-index","9");
				}
			});
			
			$("#loginclick").click(function(){
				 
					$('.login-overlay').show();
					$('.login-box').show();
				//	$('.one-hover').css("z-index","9999");
					 
				 
			});
			
			$(".btn-cls").click(function(){
				// $('#login-modal').attr("aria-hidden","true");
				// $('#login-modal').removeClass("in");
				//	$('#login-modal').hide();
					$('#login-modal').modal('toggle');
				 
				//	$('.one-hover').css("z-index","9999");
					 
				 
			});
	    });
  	</script>
		
	<script>
		$('.dropdown-toggle').click(function() {
		    var location = $(this).attr('href');
		    window.location.href = location;
		    return false;
		});

		$('.navbar-collapse ul li:not(.dropdown) a').click(function() {
		    $('.navbar-toggle:visible').click();
		})
	</script>
	<script type='text/javascript' src='<?php echo $base_url; ?>/assets/bootstrap/js/bootstrap.min.js?ver=4.6.1'></script>
	<script type='text/javascript' src='https://maps.google.com/maps/api/js?key=AIzaSyBQ9dVY1A4D4HbKBhh7HuXY3QRwLMWhg88'></script>
	<script type='text/javascript' src='<?php echo $base_url; ?>/assets/js/jquery.gmap.min.js?ver=4.6.1'></script>
	<script type='text/javascript' src='<?php echo $base_url; ?>/assets/js/retina.min.js?ver=1.3.0'></script>

	<script type='text/javascript' src='<?php echo $base_url; ?>/assets/js/jquery.mb.ytplayer.min.js?ver=25062016'></script>
	<script type='text/javascript' src='<?php echo $base_url; ?>/assets/js/jquery.parallax.min.js?ver=4.6.1'></script>
	<script type='text/javascript' src='<?php echo $base_url; ?>/assets/js/jquery.isotope.min.js?ver=4.6.1'></script>

	<script type='text/javascript' src='<?php echo $base_url; ?>/assets/js/jquery.scrollto.min.js?ver=2.1.3'></script>
	<script type='text/javascript' src='<?php echo $base_url; ?>/assets/js/jquery.knob.min.js?ver=4.6.1'></script>
	<script type='text/javascript' src='<?php echo $base_url; ?>/assets/js/prodo.min.js?ver=2.1'></script>
	<script type='text/javascript' src='<?php echo $base_url; ?>/js/comment-reply.min.js?ver=4.6.1'></script>
	<script type='text/javascript' src='<?php echo $base_url; ?>/js/wp-embed.min.js?ver=4.6.1'></script>

	<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>

	<script type="text/javascript" src="<?php echo $base_url; ?>/js/datepicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="<?php echo $base_url; ?>/js/search_notice.js"></script>
</body>
</html>