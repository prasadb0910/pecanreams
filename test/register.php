<!DOCTYPE html>

<html class="no-js  " lang="en-US">
 <?php
 session_start();
  if(isset($_POST["submit"]))
  {
  $host="localhost";
 $username="root";
 $password="";
 $dbname="prop_details";
$conn = mysqli_connect($host, $username, $password, $dbname);

 
 // Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
	
}

 
 
$name=$_POST["name"];
$email=$_POST["email"];
$mobile=$_POST["mobile"];
$password=$_POST["password"];

 $password=md5($password);
 
 $check=mysqli_query($conn,"select * from users where email='$email' and mobile='$mobile'");
    $checkrows=mysqli_num_rows($check);

   if($checkrows>0) {
      $msg="<h5 id='msg1'>Email id Or Mobile Number Are Already Exists!! </h5>";
   } else { 
$sql = "insert into users(name,email,mobile,password)values('".$name."','".$email."','".$mobile."','".$password."') ";
if (mysqli_query($conn, $sql)) {
	 header('Location: https://www.pecanreams.com/d3m/');
    $msg= "<h5 id='msg'>Done Registration successfully!!</h5>";
} else {
     mysqli_error($conn);
}
}
  }

?>

<head>


<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="format-detection" content="telephone=no">
<link href="assets/images/favicon.png" rel="icon">
<!--[if lt IE 9]>
<script src="http://prodo.create.rocks/wp-content/themes/prodo/assets/js/html5shiv.min.js"></script>
<script src="http://prodo.create.rocks/wp-content/themes/prodo/assets/js/respond.min.js"></script>
<![endif]-->
<title> Pecan REAMS</title>
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
</style>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel='stylesheet' id='roboto-css'  href='https://fonts.googleapis.com/css?family=Roboto%3A300%2C400%2C400italic%2C500%2C500italic&#038;ver=4.6.1' type='text/css' media='all' />
<link rel='stylesheet' id='open-sans-css'  href='https://fonts.googleapis.com/css?family=Open+Sans%3A300%2C300italic%2C400%2C400italic%2C600%2C600italic%2C700%2C700italic&#038;ver=4.6.1' type='text/css' media='all' />
<link rel='stylesheet' id='bootstrap-css'  href='assets/bootstrap/css/bootstrap.min.css?ver=4.6.1' type='text/css' media='all' />
<link rel='stylesheet' id='font-awesome-css'  href='assets/css/plugins/font-awesome.min.css?ver=4.6.1' type='text/css' media='all' />
<link rel='stylesheet' id='isotope-css'  href='assets/css/plugins/isotope.min.css?ver=4.6.1' type='text/css' media='all' />
<link rel='stylesheet' id='style-css'  href='assets/css/style.min.css?ver=2.1' type='text/css' media='all' />
<link rel='stylesheet' id='wp-style-css'  href='style.css?ver=4.6.1' type='text/css' media='all' />
<link rel='stylesheet' id='responsive-css'  href='assets/css/responsive.min.css?ver=4.6.1' type='text/css' media='all' />
   <link rel='stylesheet'   href='assets/css/login-min.css' type='text/css' media='all' />
 <link rel='stylesheet'   href='assets/css/login.css' type='text/css' media='all' />
<!--[if lt IE 9]>
<link rel='stylesheet' id='oldie-css'  href='assets/css/oldie.min.css?ver=4.6.1' type='text/css' media='all' />
<![endif]-->
 
 
 
 


<style type="text/css">

.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}
.services { display:flex;}
#benefits{  }
#benefits.container{ display:flex;}
#flip-key { padding:10px   20px;     min-height: 234px; border-right:1px dashed #ddd;  border-bottom:1px dashed #ddd;
  position:relative!important;       transform-style: flat!important;  background:#fff;    text-align: left!important; 
       z-index: 0!important;   flex:1; box-sizing:border-box;   
   font-size:14px;
}
#flip-key:nth-child(1) {  padding-left:0;}
#flip-key:nth-child(3) { border-right:0px dotted #ddd;}
#flip-key:nth-child(4) {   border-bottom:0px dotted #ddd; padding-left:0; padding-top:20px;}
#flip-key:nth-child(5) {   border-bottom:0px dotted #ddd;  padding-top:20px;}
#flip-key:nth-child(6) { border-right:0px dotted #ddd; border-bottom:0px dotted #ddd;  padding-top:20px;}
#flip-this {
  position:relative!important;       transform-style: flat!important;  background:none;    text-align: center!important; 
  padding-left:0!important;  padding-right:0!important;    z-index: 0!important;   flex:1; box-sizing:border-box;  
  border-right:1px dashed #ddd;  border-bottom:1px dashed #ddd;
}
#flip-this:nth-child(3) { border-right:0;}
.four-hover, .five-hover , .six-hover{ border-bottom:0!important;}
#features h2 {    text-align: center;     position: relative; color:#fff;  }
#flip-this p {  padding:15px 30px;  font-size:17px; color:#fff; }
#flip-this h4 {  color:#fff; font-weight:100!important; text-transform:capitalize; letter-spacing:.5px!important; text-shadow:3px 2px 3px rgba(0,0,0,.3); }
/*#flip-this:hover { background:#2185c5; color:#fff;}*/
#flip-this img {
 
}
.front {  }
#flip-this .back {
  
  
    text-align: center;
	 position:relative!important;
}
 
/*.service-overlay { position:fixed; top:0; left:0; bottom:0; right:0; background:rgba(0,0,0,.6);display:none;  z-index:9999;}*/
.offsetTopSs { padding-top:45px;}

.offsetBottomSs { padding-bottom:55px;}
.frame-container-video{width:85%; margin:auto;}
.frame-container{width:85%; margin:auto;}
.embed-container {     position: absolute;     top: 109px;    /* width: 300px; */    left: 113px;    /* padding: 0; */ margin: 0;}
	
.image-slider p {
position: absolute;
bottom: -10px;
background: rgba(0,0,0,.5);
width: 100%;
padding: 10px;
color: #fff;
font-size: 18px;
text-align: center;}
.image-slider img{/* width:520px;  height:325px;*/ }	
@media only screen and (max-width:767px){ 
.width-large{display:none!important;}
#solution h4 { visibility:hidden; margin:0;}
.width-small { text-align:center;   display:block!important; clear:both;     padding: 30px 0 0;}
.width-small a { margin:5px;}
}
</style>

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
    font-weight:900; color:#fff; 
    letter-spacing:1px;
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
	height:250px!important
   
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
.btn-width {   margin: auto;  width: 132px; display:block;   padding-bottom: 16px;}

.text-center #share-title {
    text-align:center!important;
    color: #333!important;
    padding:0;
}

body {
    background-color:  #d4d4d4;
}

.para{
 margin-top: 80px;
  margin-bottom: 80px;
  margin-left: 130px;
 color:#fff;
}

.form-signin {
  max-width: 380px;
  padding: 15px 35px 18px;
  -webkit-box-shadow: 0 0 3px #fff;
        box-shadow: 0 0 3px #fff;
  margin-left:480px;
  margin-top:120px;
  margin-bottom:50px;
 align:center;
 background-color:#fff;
 
}
.form-signin .input-group
{
top:0px;
}

.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 30px;
	
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  font-size: 16px;
  height: auto;
  padding: 10px;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
#password  { -webkit-text-security: disc; }
#msg{
	color:green;
}
#msg1{
	color:red;
}

 </style>




  <link rel='stylesheet'   href='assets/css/custom.css' type='text/css' media='all' />
 <link rel="stylesheet" href="assets/css/flexslider.css" type="text/css" media="screen" />

 
</head>

<body class="single single-post postid-3434 single-format-image nav-sticky" style="background:#d4d4d4">
				
		<div class="navbar navbar-fixed-top floating positive two" role="navigation">
			<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">
				<img src="assets/images/main-logo.png" data-alt="assets/images/main-logo.png" alt="">
				</a>
			</div>
		 <div class="collapse navbar-collapse" id="navbar-collapse"> 
			 	<ul id="menu-primary" class="nav navbar-nav navbar-right">
						<li ><a class="jumper" href="index.php">Home</a></li>
	  
	   
	  
					
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" >Solutions
						<span class="caret"></span></a>
						<ul class="dropdown-menu" >
						  <li><a href="reams_features.html">REAMS</a></li>    <li class="divider"></li>
						  <li><a href="idata_register.php">iDATA</a></li>
					  
						</ul>
					</li>
	  
				
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" >Company
						<span class="caret"></span></a>
							<ul class="dropdown-menu ">
						  <li><a href="about.html">ABOUT US</a></li><li class="divider"></li>
						 <li><a href="http://www.pecanadvisors.com" target="_blank">PECAN ADVISORS</a></li>
					  
					  
						</ul>
					</li>
					
					
				<li  ><a class="jumper" href=" index.php#classroom">Classroom</a></li>
					<li ><a class="jumper" href="index.php#map">Contact Us</a></li>
					
						<li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" >Login
        <span class="caret"></span></a>
        	<ul class="dropdown-menu">
          <li><a href="https://www.pecanreams.com/app/" target="_blank">REAMS</a></li><li class="divider"></li>
          <li><a href="https://www.pecanreams.com/d3m/" target="_blank">iDATA</a></li>
      
        </ul>
      </li>
	  
  <li><a href="register.php">REGISTER</a></li>
                 </ul>
 
			</div>
	 </div>
	</div>


 
  <form id="rf" class="form-signin" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" >       
  <div style="font-size:24px; text-align:center" ><b>Register Now</b></div>
   <?php if (isset($_POST["submit"]) ){print $msg;}?>
	  <br>
				<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" name="name" placeholder="Name"  required/>
              </div><br>
				<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="text" class="form-control"  name="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required/>
              </div><br>
			  <div class="input-group" >
               <span class="input-group-addon" ><i class="fa fa-lock" ></i></span>
                <input id="password" type="text" name="password" class="form-control" placeholder="Password" pattern=".{8,}" title="Six or more characters" required/>

              </div><br>
			   <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control" name="mobile" placeholder="Mobile No."  required/>
              </div>
			  
   <p style="font-size:14px">By Signing Up, you agree to our <a href="https://www.pecanreams.com/d3m/index.php/terms">Terms & Conditions.</a></p>     
      <input style="margin-top:0px" type="submit" id="register" name="submit" class="btn btn-lg btn-primary btn-block"  value="Register"/> 
	 
    </form>
 

<footer class="footer  no-border">
	<div class="container offsetBottomS offsetTopS">
		<div class="row">
<div class="col-lg-4  col-md-4 col-sm-3 col-xs-12">
		<div class="housing-line">
<div class="footer-logo-coloured"> <a href="index.php"><img src="assets/images/main-logo.png" style="background:#fff; padding:5px 10px;" /> </a></div>
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
			<li><a  href="index.php#about-company"> About Us</a></li>
 <li><a href="http://www.pecanadvisors.com" target="_blank">Pecan Advisors</a></li>
			<li><a  href="index.php#map"> Contact Us</a></li> 
</ul>
</div>

<div class="col-md-6 col-sm-6 col-xs-12">
<div class="footer-header">
<span class="footer-text">Help</span>
</div> 
<ul class="list-unstyled clear-margins  " >
			<li><a  href="privacy-policy.html">  Privacy Policy</a></li>
			<li><a  href="terms-and-conditions.html">  Terms & Condition</a></li>    
</ul>
</div> 
</div>
<div class="col-lg-2  col-md-2 col-sm-2 col-xs-4	footer-clmn2">
<div class="footer-header">
<span class="footer-text">Solutions</span>
</div>
 
<ul class="list-unstyled clear-margins">
			<li><a  href="reams_features.html"> REAMS</a></li>
			<li><a  href="idata_register.php"> iDATA</a></li>
			                         
		
</ul>
</div>

<div class="col-lg-2  col-md-2 col-sm-2 col-xs-4 footer-clmn3">
<div class="footer-header">
<span class="footer-text">Classroom</span>
</div>
 
<ul class="list-unstyled clear-margins">
			<li><a  href="blog" target="_blank"> Blogs</a></li>
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
<!--footer-->
 
 


<script>
var Prodo = {
	'loader': true,
	'animations': true,
	'navigation': 'sticky'
};
</script>
 <script src="js/jquery-2.1.4.min.js"></script>
  <script src="assets/bootstrap.min.js"></script>
 
	<script>
    $(document).ready(function(){
		
	$('#register').click(function(e) {
		//form.submit();
		document.getElementById('rf').submit();
		alert('h');
	});
   
    $('a[href^="#"]').click(function(e) {

        jQuery('html,body').animate({ scrollTop: jQuery(this.hash).offset().top-80}, 1000);

      

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

  <script defer src="assets/js/jquery.flexslider.js"></script> 
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
<script src="js/jquery.flip.min.js"></script>
<script>
    $(function(){
    	$(".flip-horizontal").flip({
  			trigger: 'hover'
		});
		$(".flip-vertical").flip({
			axis: 'x',
  			trigger: 'hover'
		});
		
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
	$(document).ready(function(){
	 
		$('.video-control').click(function() {
			$('#embed-video').removeClass("hidden");
			$('.autocreate').removeClass("hidden");
			$('.video-section').attr("autoplay");
			var video = $(".video-section")[0]; // id or class of your <video> tag
if (video.paused) {
    video.play();
}    
			
		
		});
		
		$('.close-video').click(function() {
			$('#embed-video').addClass("hidden");
			$('.autocreate').addClass("hidden");
			var video = $(".video-section")[0]; // id or class of your <video> tag
if (video.play) {
    video.pause();
          video.currentTime = 0;
}    
		
		});
	});
	
	
	</script>
	
<script type='text/javascript' src='assets/bootstrap/js/bootstrap.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='https://maps.google.com/maps/api/js?key=AIzaSyBQ9dVY1A4D4HbKBhh7HuXY3QRwLMWhg88'></script>
<script type='text/javascript' src='assets/js/jquery.gmap.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='assets/js/retina.min.js?ver=1.3.0'></script>

<script type='text/javascript' src='assets/js/smoothscroll.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='assets/js/jquery.mb.ytplayer.min.js?ver=25062016'></script>
<script type='text/javascript' src='assets/js/jquery.parallax.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='assets/js/jquery.isotope.min.js?ver=4.6.1'></script>


<script type='text/javascript' src='assets/js/jquery.scrollto.min.js?ver=2.1.3'></script>
<script type='text/javascript' src='assets/js/jquery.knob.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='assets/js/prodo.min.js?ver=2.1'></script>
<script type='text/javascript' src='js/comment-reply.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='js/wp-embed.min.js?ver=4.6.1'></script>
 

  
</body>
</html>
